<?php

namespace admin\menu\article;
use \ArticleSite, \ArticleLogic, \App, \View, \Session, \Input, \ArticleSiteLogic, \ArticleSiteService, \FormUtil, \Validator, \ErrorMessage, \Redirect;

class SiteController extends \BaseController {
    
    /**
     * @var ArticleLogic
     */
    private $articleLogic;
    
    
    /**
     * @var ArticleSiteLogic
     */
    private $articleSiteLogic;
    
    
    /**
     * @var ArticleSiteService
     */
    private $articleSiteService;
    
    
    const CSRF_FORM_KEY = "admin/menu/article/site/form";
    
    public function __construct() {
        $this->articleLogic = App::make("ArticleLogic");
        $this->articleSiteLogic = App::make("ArticleSiteLogic");
        $this->articleSiteService = App::make("ArticleSiteService");
    }
            
    /**
     * 登録されている記事サイト一覧
     * @return View
     */
    public function getList() {
        $this->articleSiteService->fetchMaxCount();
        $articleSites = $this->articleSiteService->findAllOrderBySortIndx();
        $dropdownSelect = FormUtil::generateDropdownList($articleSites->toArray(), "id", "name", false);
        
        $changeStatus = Session::get("changeResult", false);
        Session::forget("changeResult");
        return View::make('admin.menu.article.site.list', array(
            "articleSites"      =>  $articleSites,
            "dropdownSelect"    =>  $dropdownSelect,
            "changeStatus"      =>  $changeStatus,
        ));
    }
    
    
    
    /**
     * 記事サイト情報 入力フォーム
     * @param Integer $id
     * @return View
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        $image = null;
        $executeType = "add";
        Input::merge(array("rss_suspended" => 0));
        
        if(!is_null($id) && preg_match("/^\d+$/", $id)) {
            $articleSite = ArticleSite::find($id);
            if(!is_null($articleSite->file)) $image = $articleSite->file->toArray();
            if(count($articleSite) > 0) {
                $articleSite = $articleSite->toArray();
                $articleSite["site_name"] = $articleSite['name'];
                $articleSite['blog_type'] = $articleSite['type'];
                Input::merge($articleSite);
                
                $executeType = "update";
            }
        }
        
        if(is_null(Input::get("blog_type"))) {
            Input::merge(array("blog_type" => "blog"));
        }
        
        return View::make("admin.menu.article.site.form", array(
            "image"         =>  $image,
            "executeType"   =>  $executeType,
        ));
    }
    
    
    
    public function postConfirm($executeType = null) {
        $result = null;
        switch($executeType) {
            case 'add':
            case 'update':
                $result = $this->articleSiteLogic->formConfirm();
                break;
            
            case 'remove':
                $result = $this->articleSiteLogic->removeConfirm();
                break;
            
            default:
                $result = Redirect::to("/admin/menu/article/site/list");
                break;
        }
        
        return $result;
    }
    
    public function getRemove($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        Input::merge(array("id" => $id));
        return $this->postConfirm("remove");
    }
    
    
    public function postRegister($executeType = null) {
        $result = null;
        switch($executeType) {
            case 'add':
            case 'update':
                $result = $this->articleSiteLogic->formRegister();
                break;
            
            case 'remove':
                $result = $this->articleSiteLogic->remove();
                break;
            
            default:
                $result = Redirect::to("/admin/menu/article/site/list");
                break;
        }
        
        return $result;
    }
    
    
    /**
     * 完了ページを表示します。
     * @param String $executeType
     * @return Contents
     */
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.menu.article.site.complete", array("executeType" => $executeType));
    }
    
    
    /**
     * Sort順番を変更します
     * @return Redirect
     */
    public function postSort() {
        $posts = Input::all();
        if($posts['targetId'] === $posts['changeId']) {
            $errors = Validator::make($posts, array("changeId" => array("different:targetId")), ErrorMessage::getErrorMessages());
            if($errors->fails()) {
                return Redirect::to("/admin/menu/article/site/list")->withErrors($errors)->withInput();
            }
            
        }
        return $this->articleSiteLogic->changeSort(intval($posts['changeId']), intval($posts['targetId']), $posts['option']);
    }


}
