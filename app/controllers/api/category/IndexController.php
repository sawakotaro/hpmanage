<?php

namespace api\category;

use \Input, \Response, \Session, \CategoryService, \App, \Category, \FileData;

class IndexController extends \BaseController {
    
    
    /**
     * @var CategoryService
     */
    private $categoryService;
    
    
    public function __construct() {
        $this->categoryService = App::make("CategoryService");
    }
    
    /**
     * category_idに紐付くカテゴリを取得します。
     * @return JSON
     */
    public function getFetch() {
        $category_id = Input::get("category_id", null);
        if($category_id === "") $category_id = null;
        $categoryObj = Category::find($category_id);
        $category = $categoryObj->toArray();
        if(!is_null($categoryObj['file_id'])) {
            $file = $categoryObj->file->toArray();
            $category['file']['key'] = $file['key'];
        }
        
        if(!is_null($categoryObj)) {
            // 親カテゴリの取得
            if($categoryObj['parent_id'] !== null) $category["parent_category"] = Category::find($categoryObj['parent_id']);
            return Response::json($category);
        } else {
            return null;
        }
    }
}
