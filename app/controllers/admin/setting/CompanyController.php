<?php



namespace admin\setting;

use \View, \Response, \Session, \Company, \Site, \DB, \Validator, \Redirect, \Input, \ErrorMessage, \App;

class CompanyController extends \BaseController {
    
    
    const CSRF_FORM_KEY = "admin/setting/company/form";
    const CSRF_LIST_KEY = "admin/setting/company/list";
    
    /**
     *
     * @var \CompanyService
     */
    private $companyService;
    
    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->companyService = App::make("CompanyService");
    }
    
    /**
     * 
     * @param integer $id
     * @return Contents
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        if(!is_null($id)) {
            $company = Company::find($id);
            if(is_null($company)) {
                return Response::view('admin.errors.403', array(), 403);
            }
            $company['company_name'] = $company['name'];
            $company['company_kana'] = $company['kana'];
            Input::merge($company->toArray());
        }
        
        return View::make('admin.setting.company.form');
    }
    
    
    
    
    public function postConfirm() {
        $id = Input::get("id", null);
        $param = !is_null($id) ? "/" . $id : "";
        if(Session::get(self::CSRF_FORM_KEY) != Input::get('_token')) {
            return Redirect::to("/admin/setting/company/form" . $param);
        }
        
        $rules = Company::getValidateRules();
        $inputs = $this->changeToValidate(Input::all());
        $errors = Validator::make($inputs, $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withErrors($errors)->withInput();
        }
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make('admin.setting.company.confirm');
    }
    
    
    
    
    
    /**
     * 確認画面からの遷移　登録・編集処理
     * @return type
     */
    public function postRegister() {
        Input::merge(Input::old());
        $id = Input::get("id", null);
        $param = !is_null($id) ? "/" . $id : "";
        
        if(Session::get(self::CSRF_FORM_KEY) != Input::get('_token')) {
            return Redirect::to("/admin/setting/company/form" . $param);
        }
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/setting/company/form" . $param)->withInput();
        }
        
        $rules = Company::getValidateRules();
        $inputs = $this->changeToValidate(Input::all());
        $errors = Validator::make($inputs, $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to('/admin/setting/company/form' . $param)->withErrors($errors)->withInput();
        }
        
        // エラーがなければ登録
        if(!Input::get('id')) {
            $this->companyService->add(Input::all());
        } else {
            $this->companyService->update(Input::all());
        }
        return Redirect::to("/admin/setting/company/complete/" . (Input::get('id') ? "update" : "insert"))->withInput();
    }
    
    
    
    /**
     * 完了ページの表示
     * @return Contents
     */
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.setting.company.complete", array("executeType" => $executeType));
    }
    
    
    
    public function getList() {
        Session::put(self::CSRF_LIST_KEY, Session::token());
        $companyList = Company::get()->toArray();
        
        // 処理されたあとであれば、companyStatusの値を取り出して削除
        $companyStatus = Session::get("companyStatus", null);
        Session::forget("companyStatus");
        
        return View::make('admin.setting.company.list', array("companyList" => $companyList, "companyStatus" => $companyStatus));
    }
    
        
    
    /**
     * 変更・削除・編集のコントロールアクション
     * @return Contents
     */
    public function postExecute() {
        
        // 運営会社　削除
        if(Input::get("delete")) {
            // CSRFトークン認証が通らない場合、リダイレクト
            if(Session::get(self::CSRF_LIST_KEY) != Input::get("_token")) {
                return Redirect::to("/admin/setting/company/list");
            }
            // ロジック側で適用サイトの変更処理
            $this->companyService->delete(Input::get("id"));
            Session::put("companyStatus", "delete");
            return Redirect::to("/admin/setting/company/list");
        }
        
        if(Input::get("update")) {
            return Redirect::to("/admin/setting/company/form/" . Input::get('id'));
        }
    }
    /**
     * バリデートするために、変数を加工します。
     * @return バリデート用配列
     */
    private function changeToValidate($inputs) {
        $inputs['tel'] = str_replace("-", "", $inputs['tel']);
        $inputs['zipcode'] = str_replace("-", "", $inputs['zipcode']);
        return $inputs;
    }
}
