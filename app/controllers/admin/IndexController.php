<?php

namespace admin;

use \Session,
    \Validator,
    \Input,
    \View,
    \ErrorMessage,
    \Redirect,
    \Auth,
    AuthMember;

class IndexController extends \BaseController {
    
    
    const CSRF_KEY = "admin/signin";
    
    /**
     * ログインフォームの表示
     */
    public function getSignin() {
        
        Session::put(self::CSRF_KEY, Session::token());
        return View::make('admin.signin');
    }

    
    public function getIndex() {
        return Redirect::to('/admin/home');
    }
    

    /**
     * ログイン認証処理
     * @return String
     */
    public function postSignin() {
        // CSRFチェック
        if(\Session::get(self::CSRF_KEY) != \Input::get('_token')) {
            return Redirect::to("/admin/signin");
        }
        
        // バリデート
        $val = Validator::make(Input::all(), AuthMember::getSigninValidateRules(), ErrorMessage::getErrorMessages());
        if($val->fails()) {
            return Redirect::to("/admin/signin")->withErrors($val)->withInput();
        }
        
        // 認証
        if(!Auth::attempt(Input::only('email', 'password', 'suspended'))) {
            return Redirect::back()->withErrors(array('signin' => ErrorMessage::getErrorMessages("signin.authenticate")))->withInput();
        }
        
        return Redirect::intended('/admin');
    }
    
    
    
    public function getSignout() {
        Auth::logout();
        return Redirect::to("/admin/signin");
    }
}
