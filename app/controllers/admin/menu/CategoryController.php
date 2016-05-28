<?php
namespace admin\menu;

use \View, \Session, \Redirect, \CategoryService, \FileLogic, \App, \Input, \Category, \Validator, \ErrorMessage, \FileData;

class CategoryController extends \BaseController {
    
    const CSRF_LIST_KEY = "admin/menu/category/list";
    const CSRF_FORM_KEY = "admin/menu/category/form";
    
    
    /**
     *
     * @var CategoryService
     */
    private $categoryService;
    
    
    /**
     *
     * @var FileLogic
     */
    private $fileLogic;
    
    
    public function __construct() {
        $this->categoryService = App::make('CategoryService');
        $this->fileLogic = App::make('FileLogic');
    }
    
    
    
    /**
     * 新規登録・編集フォームを表示します
     * @return Contents
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        $parent_id = null;
        $category = null;
        $image = null;
        if(!is_null($id)) {
            $category = Category::find($id);
            if(!is_null($category->file)) $image = $category->file->toArray();
            $merge["category_name"] =   $category['name'];
            $merge["memo"]          =   $category['memo'];
            $merge['id']            =   $category['id'];
            $merge['parent_id']     =   $category['parent_id'];
            Input::merge($merge);
        } else {
            // 戻るボタンを押したときの対処
            $_old_input = Session::get('_old_input', array());
            if(count($_old_input)) {
                $parent_id = ($_old_input['parent_id'] === "") ? null :  $_old_input['parent_id'];
            }
        }
        
        
        // カテゴリのセレクトボックスデータを取得
        $categories = array();
        if(!is_null($parent_id)) {
            $categories = $this->categoryService->getCategoryRoots($parent_id, array(), null, $id);
        }
        
        return View::make('admin.menu.category.form', array(
            "image"         =>  $image,
            "categories"    =>  array_reverse($categories),
        ));
    }
    
    
    
    
    /**
     * 確認画面の表示
     * @return Contents
     */
    public function postConfirm() {
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/menu/category/form");
        }
        
        // バリデート
        $rules = Category::getValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        // logo画像がアップロードされていない、もしくはファイルが存在しない場合はnullを代入
        if(!Input::get("filePath", false) || !file_exists(public_path() . Input::get("filePath"))) {
            Input::merge(array("filePath" => null));
        }
        
        // 親カテゴリ名を取得します。
        $parent_category_name = null;
        $parent_id = Input::get("parent_id", "");
        if(!empty($parent_id)) {
            $parent_category_name = Category::find($parent_id)->name;
        }
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make("admin.menu.category.confirm", array("parent_category_name" => $parent_category_name));
    }
    
    
    
    
    
    
    /**
     * 登録・編集内容の処理
     * @return Content
     */
    public function postRegister() {
        Input::merge(Input::old());
        $param = Input::get('id', "") !== "" ? "/" . Input::get('id') : "";
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) 
            return Redirect::to("/admin/menu/category/form" . $param);
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) 
            return Redirect::to("/admin/menu/category/form" . $param)->withInput();
        
        // バリデート
        $rules = Category::getValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/menu/category/form" . $param)->withErrors($errors)->withInput();
        }
        
        // エラーがなければ登録
        $fileId = null;
        if(Input::get('id', "") === "") {
            $this->fileLogic->register();
            $this->categoryService->add(Input::all());
        } else {
            $this->fileLogic->update();
            $this->categoryService->update(Input::all());
        }
        
        return Redirect::to("/admin/menu/category/complete/" . (Input::get('id', "") !== "" ? "update" : "insert"))->withInput();
    }
    
    
    /**
     * 完了画面の表示
     * @param type $executeType
     * @return Content
     */
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.menu.category.complete", array("executeType" => $executeType));
    }
    
    
    
    /**
     * カテゴリ一覧の表示
     * @return Content
     */
    public function getList() {
        $status = false;
        if(Session::get("category/list/remove", false)) {
            Session::forget("category/list/remove");
            $status = "remove";
        }
        return View::make("admin.menu.category.list", array("status" => $status)); 
    }
    
    
    /**
     * カテゴリの削除
     * @param integer $category_id
     * @return Content
     */
    public function getRemove($category_id) {
        $category = Category::find($category_id);
        
        // 画像ファイルがあれば、それも一緒に削除
        if(!is_null($category["file_id"])) {
            $file = FileData::find($category["file_id"]);
            $file->delete();
        }
        
        $row = $category->delete();
        if($row) Session::put("category/list/remove", true);
        return Redirect::to("/admin/menu/category/list");
    }
}