<?php

namespace admin\menu\article;
use \ArticleSite, \ArticleService, \ArticleLogic, \ArticleSiteService, \App, \View, \Redirect;

class IndexController extends \BaseController {
    
    /**
     * @var ArticleLogic
     */
    private $articleLogic;
    
    /**
     * @var ArticleSiteService
     */
    private $articleSiteService;
    
    /**
     * @var ArticleService
     */
    private $articleService;
    
    public function __construct() {
        $this->articleLogic         =   App::make("ArticleLogic");
        $this->articleSiteService   =   App::make("ArticleSiteService");
        $this->articleService       =   App::make("ArticleService");
    }
    
    /**
     * サイト一覧
     * @return Contents
     */
    public function getIndex() {
        $articleSites = $this->articleSiteService->findAllOrderBySortIndx();
        return View::make('admin.menu.article.index', array(
            "articleSites"      =>  $articleSites
        ));
    }
    
    
    /**
     * 登録記事サイト別の記事リスト表示
     * @param Integer $siteId
     * @return Contents
     */
    public function getList($siteId = null) {
        if(is_null($siteId) || !preg_match("/^\d+$/", $siteId)) {
            return Redirect::to("/admin/menu/article");
        }
        
        $articleSite = ArticleSite::find($siteId);
        $articles = $this->articleService->findByArticleSiteId($siteId);
        
        
        return View::make("admin.menu.article.list", array(
            "articles"      =>  $articles,
            "articleSite"   =>  $articleSite,
        ));
    }
    
}
