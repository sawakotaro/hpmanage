<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace admin\user;

use View, App, Input, SearchFormLogic, Redirect, SearchFormService;
/**
 * Description of SearchController
 *
 * @author fid
 */
class SearchController extends \BaseController {
    
    const CSRF_FORM_KEY = "admin/user/search";
    
    
    /**
     * @var SearchFormLogic
     */
    private $searchFormLogic;
    
    /**
     * @var SearchFormService
     */
    private $searchFormService;
    
    public function __construct() {
        $this->searchFormLogic = App::make('SearchFormLogic');
        $this->searchFormService = App::make('SearchFormService');
    }
    
    /**
     * 検索フォームを表示します。
     * @return コンテンツ
     */
    public function getForm() {
        return View::make("admin.user.search.form", array(
            'datetimeList'  =>  $this->searchFormLogic->getSearchDatetimeList()
        ));
    }
    
    
    /**
     * 検索内容をPOSTし、SearchFormテーブルへデータを追加します。<br>
     * その後、検索結果ページへリダイレクトします。
     * @return 検索結果へリダイレクト
     */
    public function postSearch() {
        $errors = $this->searchFormLogic->validateSearchForm(Input::all());
        if(count($errors)) {
            print_r($errors);exit;
            return View::make("admin.user.search.form", array(
                'datetimeList'  =>  $this->searchFormLogic->getSearchDatetimeList(),
                'errors'        =>  $errors,
            ));
        }
        $search_form_id = $this->searchFormLogic->registerSearchForm(Input::all());
        return Redirect::to("/admin/user/search/result/" . $search_form_id);
    }
    
    /**
     * 検索値から会員情報を取得します。
     * @param Integer $id
     * @param Integer $page
     * @return コンテンツ
     */
    public function getResult($id, $page = 1) {
        if(empty($id) || is_null($this->searchFormService->findById($id))) {
            return Response::view('admin.errors.404', array(), 404);
        }
        $search_result = $this->searchFormLogic->search($id, $page);
        
        return View::make("admin.user.search.result", array("search_result" => $search_result));
    }
    
    
    
    public function getError($error_code = null) {
        
    }
}
