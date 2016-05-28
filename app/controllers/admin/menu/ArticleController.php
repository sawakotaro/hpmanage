<?php

namespace admin\menu;
use \ArticleSite, \ArticleLogic, \App;

class ArticleController extends \BaseController {
    
    /**
     * @var ArticleLogic
     */
    private $articleLogic;
    
    public function __construct() {
        $this->articleLogic = App::make("ArticleLogic");
    }
            
    public function getList() {
        $this->articleLogic->fetchArticleByRss();
    }
    
    
    
    public function getRegister() {
        $this->articleLogic->registerArticleRss();
    }

}
