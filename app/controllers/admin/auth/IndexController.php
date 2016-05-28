<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IndexController
 *
 * @author fid
 */

namespace admin\auth;

use \View,
    \Session,
    \App,
    \Redirect,
    \Validator,
    \Input,
    \AuthMember,
    \DB,
    \Response,
    \ErrorMessage;

class IndexController extends \BaseController {
    
    
    const CSRF_FORM_KEY = "admin/auth/form";
    const CSRF_DELETE_KEY = "admin/auth/delete";
    
    /**
     * @var \AuthMemberService
     */
    private $authMemberService;
    
    public function __construct() {
        $this->authMemberService = App::make('AuthMemberService');
    }
    
    
    /**
     * 新規登録・編集フォーム
     * @return String
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        if(preg_match("/^\d+$/", $id) && !is_null($id)) {
            $authMember = AuthMember::find($id);
            if(is_null($authMember)) {
                return Response::view('admin.errors.403', array(), 403);
            }
            unset($authMember->password);
            Input::merge($authMember->toArray());
        }
        return View::make('admin.auth.form');
    }
    
    
    /**
     * 認証ユーザーフォームの入力内容確認ページを表示します。
     * @return 確認ページ
     */
    public function postConfirm() {
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        if (Session::token() != Input::get('_token')) {
            return Redirect::to("/admin/auth/form" . $param);
        }
        
        $inputs = Input::all();
        $rules = (!$inputs['id']) ? AuthMember::getAddValidateRules() : AuthMember::getEditValidateRules($inputs['id'], ($inputs['password'] || $inputs['password_confirmation']) ? false : true);
        
        $val = Validator::make($inputs, $rules, ErrorMessage::getErrorMessages());
        
        if($val->fails()) {
            return Redirect::back()->withErrors($val)->withInput();
        }
        
        // 一時的に入力値を退避します。
        Input::flash();
        
        return View::make('admin.auth.confirm');
    }
    
    
    
    /**
     * 認証ユーザーフォームの完了ページを表示します。
     * @return 完了ページ
     */
    public function postExecute() {
        // 退避していた値をセットします。
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        if(Session::get(self::CSRF_FORM_KEY) != Input::get('_token')) {
            return Redirect::to("/admin/auth/form" . $param);
        }
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/auth/form" . $param)->withInput();
        }
        
        $inputs = Input::all();
        $rules = (!$inputs['id']) ? AuthMember::getAddValidateRules() : AuthMember::getEditValidateRules($inputs['id'], ($inputs['password'] || $inputs['password_confirmation']) ? false : true);
        $val = Validator::make($inputs, $rules, ErrorMessage::getErrorMessages());
        if($val->fails()) {
            return Redirect::to("/admin/auth/form" . $param)->withErrors($val)->withInput();
        }
        
        // DBにユーザーの追加
        if($inputs['id']) {
            $this->authMemberService->update($inputs);
        } else {
            $this->authMemberService->add($inputs);
        }
        return Redirect::to('/admin/auth/complete/' . ($inputs['id'] ? "update" : "insert"))->withInput();
    }
    
    /**
     * 更新・新規作成完了ページを表示します。
     * @return 完了ページ
     */
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make('admin.auth.complete', array('id' => Input::get('id'), "executeType" => $executeType));
    }
    
    
    /**
     * 削除確認用ページの表示
     * @param int $id
     * @return String
     */
    public function getDelete($id) {
        Session::put(self::CSRF_DELETE_KEY, Session::token());
        if(!preg_match("/^\d+$/", $id) || is_null(($authMember = AuthMember::find($id)))) {
            return Response::view('admin.errors.403', array(), 403);
        }
        
        return View::make('admin.auth.delete', array(
            "id"        =>  $authMember->id,
            "username"  =>  $authMember->username,
            "email"     =>  $authMember->email,
            "executeType"   =>  "delete",
        ));
    }
    
    
    /**
     * 削除の実行
     * @return String
     */
    public function postRemove() {
        if(Session::get(self::CSRF_DELETE_KEY) != Input::get('_token')) {
            return Redirect::to("/admin/auth/list");
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/auth/list");
        }
        
        $id = Input::get("id");
        if(!preg_match("/^\d+$/", $id) || is_null(($authMember = AuthMember::find($id)))) {
            return Response::view('admin.errors.403', array(), 403);
        }
        
        // ソフトデリート
        $authMember->delete();
        
        return Redirect::to('/admin/auth/complete/delete')->withInput();
    }
    
    
    
    
    /**
     * 登録した認証ユーザーの一覧を表示
     */
    public function getList() {
        $authMembers = AuthMember::all();
        return View::make('admin.auth.list', array('authMembers' => $authMembers));
    }
    
}
