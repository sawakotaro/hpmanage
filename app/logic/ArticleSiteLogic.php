<?php

use admin\menu\article\SiteController;

class ArticleSiteLogic {
    
    /**
     * @var ArticleSiteService
     */
    private $articleSiteService;
    
    /**
     * @var ArticleService
     */
    private $articleService;
    
    
    /**
     * @var FileLogic
     */
    private $fileLogic;
    
    public function __construct() {
        $this->articleSiteService   =   App::make("ArticleSiteService");
        $this->articleService       =   App::make("ArticleService");
        $this->fileLogic            =   App::make("FileLogic");
    }
    
    
    /**
     * 入力フォームの内容をチェックし、確認画面に飛ばします。
     * @return View
     */
    public function formConfirm() {
        $rules = ArticleSite::getValidateRules();
        $image = null;
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        // logo画像がアップロードされていない、もしくはファイルが存在しない場合はnullを代入
        if(!Input::get("filePath", false) || !file_exists(public_path() . Input::get("filePath"))) {
            Input::merge(array("filePath" => null));
        }
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make("admin.menu.article.site.confirm", array(
            "executeType"   =>  (Input::get('id') !== "" ? "update" : "add"),
            "image"         =>  $image,
        ));
    }
    
    
    public function removeConfirm() {
        $id = Input::get("id");
        $image = null;
        if(!is_null($id) && preg_match("/^\d+$/", $id)) {
            $articleSite = ArticleSite::find($id);
            if(!is_null($articleSite)) {
                $articleSite = ArticleSite::find($id);
                
                if(!is_null($articleSite->file)) $image = $articleSite->file->toArray();
                if(count($articleSite) > 0) {
                    $articleSite = $articleSite->toArray();
                    $articleSite["site_name"] = $articleSite['name'];
                    $articleSite['blog_type'] = $articleSite['type'];
                    $articleSite["file"] = array();
                    Input::merge($articleSite);
                }
                
                return View::make("admin.menu.article.site.confirm", array(
                    "executeType"   =>  "remove",
                    "image"         =>  $image,
                ));
            }
        }
        
        return Redirect::to("/admin/menu/article/site/list");
    }
    
    public function remove() {
        $id = Input::get("removeId");
        
        if(Session::get(SiteController::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/menu/article/site/list");
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/menu/article/site/list");
        }
        
        if(!is_null($id) && preg_match("/^\d+$/", $id)) {
            $this->articleSiteService->delete($id);
        }
        
        return Redirect::to("/admin/menu/article/site/complete/remove");
    }
    
    
    /**
     * 入力フォームの内容を登録します。
     * @return Redirect Contents
     */
    public function formRegister() {
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        
        if(Session::get(SiteController::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/menu/article/site/form" . $param);
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/menu/article/site/form" . $param)->withInput();
        }
        
        // バリデート
        $rules = ArticleSite::getValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/menu/article/site/form" . $param)->withErrors($errors)->withInput();
        }
        
        // エラーがなければ登録
        if(!Input::get('id')) {
            $this->fileLogic->register();
            $this->articleSiteService->add(Input::all());
        } else {
            $this->fileLogic->update();
            $this->articleSiteService->update(Input::all());
        }
        
        return Redirect::to("/admin/menu/article/site/complete/" . (Input::get('id') ? "update" : "add"))->withInput();
    }
    
    
    
    /**
     * 記事サイトの表示順番を変更します。
     * @param Integer $changeId
     * @param Integer $targetId
     * @param String $option
     * @return Redirect
     */
    public function changeSort($changeId, $targetId, $option) {
        $articleSiteList = $this->articleSiteService->findAllOrderBySortIndx();
        $changeSite = ArticleSite::find($changeId);
        $targetSite = ArticleSite::find($targetId);
        
        // どちらかデータがなければリストにリダイレクト
        if($changeSite === null && $targetSite === null) {
            return Redirect::to("/admin/menu/article/site/list");
        }
        // ソート順変更の実行
        FormUtil::changeSortIndex($articleSiteList, $changeSite, $targetSite, $changeId, $targetId, $option);
        
        Session::put("changeResult", true);
        return Redirect::to("/admin/menu/article/site/list");
    }
    
}
