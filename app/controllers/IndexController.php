<?php

class IndexController extends BaseController {
    
    
    
    
    public function __construct() {
        $this->movieContentService      =   App::make("MovieContentService");
        $this->movieContentLogic        =   App::make("MovieContentLogic");
        $this->tagLogic                 =   App::make("TagLogic");
        $this->fileService              =   App::make('FileService');
        $this->tagService               =   App::make('TagService');
        $this->tagRelationService       =   App::make('TagRelationService');
    }
    
    public function getIndex() {
        return View::make('index');
    }
    
    
    
    public function getTest() {
        $s = "";
        $arr = explode(",", $s);
        echo count($arr);
        exit;
    }
    
}
