<?php

namespace admin\api\menu\article;

use \App, \ArticleLogic, \Response, \Input, \Article;

class IndexController extends \BaseController {
    
    /**
     *
     * @var ArticleLogic
     */
    private $articleLogic;
    
    public function __construct() {
        $this->articleLogic = App::make("ArticleLogic");
    }
    
    /**
     * 手動更新用RSS記事取得
     */
    public function getRegister() {
        $result = true;
        try {
            $this->articleLogic->registerArticleRss();
        } catch(Exception $e) {
            $result = false;
        }
        
        return Response::json(array("result" => $result));
    }
    
    
    
    public function postDelete() {
        $result = false;
        $id = Input::get("id");
        $article = Article::find($id);
        if(!is_null($article)) {
            $article->delete();
            $result = true;
        }
        
        return Response::json(array("status" => $result));
    }
}