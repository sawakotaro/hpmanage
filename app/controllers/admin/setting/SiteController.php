<?php



namespace admin\setting;

use \View, \Response, \Session, \DB, \Redirect, \SiteService, \FileService, \App, \Input, \Company, \FormUtil, \FileData, \Site, \Validator, \ErrorMessage, \FileLogic, \Auth;

class SiteController extends \BaseController {
    
    const CSRF_LIST_KEY = "admin/setting/site/list";
    const CSRF_FORM_KEY = "admin/setting/site/form";
    
    
    /**
     *
     * @var SiteService
     */
    private $siteService;
    
    
    /**
     *
     * @var FileService
     */
    private $fileService;
    
    public function __construct() {
        $this->siteService = App::make('SiteService');
        $this->fileService = App::make('FileService');
    }
    
    /**
     * Sitesテーブルにデータがあるかどうかを確認する
     * なければ初期データ作成画面へ
     */
    public function getList() {
        // ひとつもサイト情報が登録されていなければ
        $sites = DB::table('sites')->get();
        if(count($sites) == 0) {
            return Redirect::to("/admin/setting/site/form");
        }

        // 処理されたあとであれば、siteStatusの値を取り出して削除
        $siteStatus = Session::get("siteStatus", null);
        Session::forget("siteStatus");
        
        Session::put(self::CSRF_LIST_KEY, Session::token());
        
        return View::make("admin.setting.site.list", array(
            'useSite'       =>  $this->siteService->fetchUseSite(),
            'siteList'      =>  $this->siteService->fetchNotUseSiteList(),
            'siteStatus'    =>  $siteStatus,
        ));
    }
    
    
    
    /**
     * 変更・削除・編集のコントロールアクション
     * @return Contents
     */
    public function postExecute() {
        
        // サイト情報適用時
        if(Input::get("apply")) {
            // CSRFトークン認証が通らない場合、リダイレクト
            if(Session::get(self::CSRF_LIST_KEY) != Input::get("_token")) {
                return Redirect::to("/admin/setting/site/list");
            }
            
            // ロジック側で適用サイトの変更処理
            $this->siteService->apply(Input::get("id"));
            Session::put("siteStatus", "apply");
            return Redirect::to("/admin/setting/site/list");
        }
        
        // サイト情報　削除
        if(Input::get("delete")) {
            // CSRFトークン認証が通らない場合、リダイレクト
            if(Session::get(self::CSRF_LIST_KEY) != Input::get("_token")) {
                return Redirect::to("/admin/setting/site/list");
            }
            // ロジック側で適用サイトの変更処理
            $this->siteService->delete(Input::get("id"));
            Session::put("siteStatus", "delete");
            return Redirect::to("/admin/setting/site/list");
        }
        
        if(Input::get("update")) {
            return Redirect::to("/admin/setting/site/form/" . Input::get('id'));
        }
    }
    
    
    
    /**
     * サイトの新規・編集フォーム
     * @return Contents
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        $companies = Company::get()->toArray();
        $companiesDropdown = FormUtil::generateDropdownList($companies, "id", "name", true);
        $logo = null;
        
        if(!is_null($id)) {
            $site = Site::find($id);
            if(!is_null($site->file)) $logo = $site->file->toArray();
            if(is_null($site)) return Response::view('admin.errors.403', array(), 403);
            $site['site_name'] = $site['name'];
            Input::merge($site->toArray());
        }
        
        return View::make("admin.setting.site.form", array("companies" => $companiesDropdown, "logo" => $logo));
    }
    
    
    
    /**
     * 確認画面の表示
     * @return Contents
     */
    public function postConfirm() {
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/setting/site/form");
        }
        
        // バリデート
        $rules = Site::getValidateRules(Input::get('id', false));
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        // 運営会社名を取得
        $company = Company::find(Input::get('company_id'));
        if(!is_null($company)) {
            $company = $company->toArray();
            Input::merge(array("company_name" => $company['name']));
        }
        
        // logo画像がアップロードされていない、もしくはファイルが存在しない場合はnullを代入
        if(!Input::get("filePath", false) || !file_exists(public_path() . Input::get("filePath"))) {
            Input::merge(array("filePath" => null));
        }
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make("admin.setting.site.confirm");
    }
    
    
    
    
    public function postRegister() {
        
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/setting/site/form" . $param);
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/setting/site/form" . $param)->withInput();
        }
        
        // バリデート
        $rules = Site::getValidateRules(Input::get('id', false));
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/setting/site/form" . $param)->withErrors($errors)->withInput();
        }
        
        // エラーがなければ登録
        $fileId = null;
        if(!Input::get('id')) {
            if(Input::get("filePath", false) && file_exists(public_path() . Input::get("filePath"))) {
                $lastInsertFileId = $this->fileService->add(public_path() . Input::get("filePath"));
                Input::merge(array("file_id" => $lastInsertFileId));
            }
            FileLogic::deleteTmpImage(sha1(Auth::user()->id));
            $this->siteService->add(Input::all());
        } else {
            $file_id = Input::get("file_id", false);
            if(Input::get("filePath", false) && file_exists(public_path() . Input::get("filePath"))) {
                if(empty($file_id)) {
                    $lastInsertFileId = $this->fileService->add(public_path() . Input::get("filePath"));
                } else {
                    $fileData = FileData::where("id", "=", $file_id)->get();
                    $file = $fileData->toArray()[0];
                    FileLogic::deleteImage($file['key']);
                    $this->fileService->update($file_id, public_path() . Input::get("filePath"));
                    $lastInsertFileId = $file_id;
                }
                Input::merge(array("file_id" => $lastInsertFileId));
            } else if(Input::get("remove") === "true" && !empty($file_id)) {
                $this->fileService->delete($file_id);
                Input::merge(array("file_id" => null));
            }
            
            FileLogic::deleteTmpImage(sha1(Auth::user()->id));
            $this->siteService->update(Input::all());
        }
        
        return Redirect::to("/admin/setting/site/complete/" . (Input::get('id') ? "update" : "insert"))->withInput();
    }
    
    
    
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.setting.site.complete", array("executeType" => $executeType));
    }
    
    
    
    /**
     * Sitesテーブルに新規登録します。
     */
    public function getCreate() {
        return "create";
    }
}
