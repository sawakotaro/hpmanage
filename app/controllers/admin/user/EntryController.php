<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace admin\user;
use \View, \Session, \Validation, \Input, Validator, ErrorMessage, Redirect, \UserLogic, App, Response;
/**
 * Description of EntryController
 *
 * @author fid
 */
class EntryController extends \BaseController {
    
    const CSRF_FORM_KEY = "admin/user/entry/form";
    
    /**
     *
     * @var UserLogic
     */
    private $userLogic;
    
    public function __construct() {
        $this->userLogic = App::make('UserLogic');
    }
    
    /**
     * 会員登録フォームを表示します。
     * @return 登録フォームのコンテンツ
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        if(!is_null($id)) {
            $array = $this->userLogic->loadUserData($id);
            if(!count($array)) {
                return Response::view('admin.errors.404', array(), 404);
            }
            Input::merge($array);
        }
        return View::make('admin.user.entry.form');
    }
    
    
    /**
     * 入力した内容の確認画面を表示します。
     * @return 確認画面のコンテンツ
     */
    public function postConfirm() {
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/user/entry/form");
        }
        
        $rules = Validation::getAdminEntryUserValidationRules(array('id' => Input::get('id', false), 'is_edit_password' => Input::get('is_edit_password')));
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make("admin.user.entry.confirm");
    }
    
    /**
     * 会員登録フォームデータをデータベースに登録し、完了ページへリダイレクトします。
     * @return コンテンツ
     */
    public function postRegister() {
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/user/entry/form" . $param);
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/user/entry/form" . $param)->withInput();
        }
        
        // バリデート
        Input::merge(array('is_edit_password' => Input::get('is_edit_password', false)));
        $rules = Validation::getAdminEntryUserValidationRules(array('id' => Input::get('id', false), 'is_edit_password' => Input::get('is_edit_password', false)));
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/user/entry/form" . $param)->withInput()->withErrors($errors);
        }
        
        // エラーがなければ登録
        $this->userLogic->registerUser(Input::all(), Input::get('id', null));
        
        return Redirect::to("/admin/user/entry/complete/" . (Input::get('id') ? "update" : "insert") . $param)->withInput();
    }
    
    
    
    
    public function getComplete($executeType, $id = null) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.user.entry.complete", array("executeType" => $executeType, "id" => $id));
    }

}
