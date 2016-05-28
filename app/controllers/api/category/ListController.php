<?php

namespace api\category;

use \Input, \Response, \Session, \CategoryService, \App, \Category;

class ListController extends \BaseController {
    
    
    /**
     * @var CategoryService
     */
    private $categoryService;
    
    
    public function __construct() {
        $this->categoryService = App::make("CategoryService");
    }
    
    /**
     * parent_idに紐付くカテゴリリストを取得します。
     * @return JSON
     */
    public function getFetch() {
        $parent_id = Input::get("parent_id", null);
        if($parent_id === "") $parent_id = null;
        $categories = $this->categoryService->fetchByParentId($parent_id);
        return Response::json($categories);
    }
    
    
    
    
    /**
     * カテゴリのソート順をひとつ上げます
     * @param Integer $id
     * @return JSON
     */
    public function getUp($id) {
        $category = Category::find($id);
        if(is_null($category)) return array("status" => false);
        $categories = $this->categoryService->fetchByParentId($category->parent_id);
        
        $before = null;
        $result = array("status" => false);
        foreach($categories as $value) {
            if(is_null($before) && $value->id === $category->id) {
                break;
            } else if(!is_null($before) && $value->id === $category->id) {
                $temp_index = $before->sort_index;
                $before->sort_index = $category->sort_index;
                $category->sort_index = $temp_index;
                $before->save();
                $category->save();
                $result["status"] = true;
                break;
            }
            
            $before = $value;
        }
        
        return Response::json($result);
    }
    
    /**
     * カテゴリのソート順をひとつ下げます
     * @param Integer $id
     * @return JSON
     */
    public function getDown($id) {
        $category = Category::find($id);
        if(is_null($category)) return array("status" => false);
        $categories = $this->categoryService->fetchByParentId($category->parent_id);
        
        $nextFlag = false;
        $result = array("status" => false);
        foreach($categories as $value) {
            if($value->id === $category->id) {
                $nextFlag = true;
                continue;
            }
            
            if($nextFlag === true) {
                $temp_index = $value->sort_index;
                $value->sort_index = $category->sort_index;
                $category->sort_index = $temp_index;
                $value->save();
                $category->save();
                $result["status"] = true;
                break;
            }
        }
        
        return Response::json($result);
    }
}
