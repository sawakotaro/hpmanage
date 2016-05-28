<?php

class AuthMemberService {
    
    
    /**
     * 認証ユーザー 新規DB登録
     * @param array $inputs
     */
    public function add(Array $inputs) {
        $authMember = new AuthMember();
        $authMember->username  =   $inputs['username'];
        $authMember->email     =   $inputs['email'];
        $authMember->password  =   Hash::make($inputs['password']);
        $authMember->save();
    }
    
    /**
     * 認証ユーザー DB更新
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $authMember = AuthMember::find($inputs['id']);
        $authMember->username  =   $inputs['username'];
        $authMember->email     =   $inputs['email'];
        if($inputs['password']) {
            $authMember->password  =   Hash::make($inputs['password']);
        }
        
        $authMember->save();
    }
}