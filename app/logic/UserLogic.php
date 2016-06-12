<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserLogic
 *
 * @author fid
 */
class UserLogic {
    
    /**
     * @var UserService
     */
    private $userService;
    
    /**
     * @var UserAuthorizationService
     */
    private $userAuthorizationService;
    
    /**
     * @var UserScoreService
     */
    private $userScoreService;
    
    
    
    
    public function __construct() {
        $this->userService              =   App::make("UserService");
        $this->userAuthorizationService =   App::make("UserAuthorizationService");
        $this->userScoreService         =   App::make("UserScoreService");
    }
    
    /**
     * 会員データを登録します。
     * @param array $inputs
     * @param type $id
     */
    public function registerUser(Array $inputs, $id = null) {
        DB::transaction(function() use($inputs, $id) {
            if(is_null($id) || empty($id)) {
                $id = $this->userService->insert($this->createUserParameter($inputs));
                $this->userAuthorizationService->insert($this->createUserAuthorizationParameter(array_merge($inputs, array("user_id" => $id))));
                $this->userScoreService->insert($this->createUserScoreParameter(array(
                    "user_id"   =>  $id,
                    'first_logged_in_at' => null,
                    'last_logged_in_at' => null,
                    'logged_in_count' => 0,
                    'first_reserved_at' => null,
                    'last_reserved_at' => null,
                    'reserved_count' => 0,
                )));
            } else {
                $this->userService->update($this->createUserParameterForUpdate($id, $inputs));
                $this->userAuthorizationService->update($this->createUserAuthorizationParameterForUpdate(array_merge($inputs, array("user_id" => $id))));
            }
        });
    }
    
    
    
    /**
     * DBinsert用の配列を生成します。
     * @param Array $inputs
     * @return DBinsert用配列
     */
    private function createUserParameter($inputs) {
        $datetime = new \DateTime();
        return array(
            'first_name' => StringUtil::replaceSpace($inputs['first_name']),
            'last_name' => StringUtil::replaceSpace($inputs['last_name']),
            'first_kana' => StringUtil::replaceSpace($inputs['first_kana']),
            'last_kana' => StringUtil::replaceSpace($inputs['last_kana']),
            'gender' => array_key_exists('gender', $inputs) !== false ? $inputs['gender'] : 0,
            'blood_type' => array_key_exists('blood_type', $inputs) !== false ? $inputs['blood_type'] : null,
            'birth_year' => intval($inputs['birth_year']),
            'birth_month' => intval($inputs['birth_month']),
            'birth_day' => intval($inputs['birth_day']),
            'registered_status' => $inputs['registered_status'],
            'email' => StringUtil::replaceSpace($inputs['email']),
            'tel' => StringUtil::replaceSpace($inputs['tel']),
            'manager_note' => $inputs['manager_note'],
            'last_session' => null,
            'interim_at' => $datetime->format("Y-m-d H:i:s"),
            'registered_at' => $inputs['registered_status'] !== "interim" ? $datetime->format("Y-m-d H:i:s") : null,
            'withdrew_at' => $inputs['registered_status'] === "withdraw" ? $datetime->format("Y-m-d H:i:s") : null,
        );
    }
    /**
     * DBupdate用の配列を生成します。
     * @param Array $inputs
     * @return DBupdate用配列
     */
    private function createUserParameterForUpdate($id, $inputs) {
        $parameters = array(
            'id' => $id,
            'first_name' => StringUtil::replaceSpace($inputs['first_name']),
            'last_name' => StringUtil::replaceSpace($inputs['last_name']),
            'first_kana' => StringUtil::replaceSpace($inputs['first_kana']),
            'last_kana' => StringUtil::replaceSpace($inputs['last_kana']),
            'gender' => $inputs['gender'] ?: 0,
            'blood_type' => $inputs['blood_type'] ?: null,
            'birth_year' => intval($inputs['birth_year']),
            'birth_month' => intval($inputs['birth_month']),
            'birth_day' => intval($inputs['birth_day']),
            'registered_status' => $inputs['registered_status'],
            'email' => StringUtil::replaceSpace($inputs['email']),
            'tel' => StringUtil::replaceSpace($inputs['tel']),
            'manager_note' => $inputs['manager_note'],
            'last_session' => null,
        );
        
        $user = $this->userService->findById($inputs['id']);
        if($user['registered_status'] !== $inputs['registered_status']) {
            $datetime = new \DateTime();
            switch($inputs['registered_status']) {
                case 'interim':
                    if(is_null($user['interim_at'])) $parameters['interim_at'] = $datetime->format("Y-m-d H:i:s");
                    $user['registered_at'] = null;
                    $parameters['withdrew_at'] = null;
                    break;
                    
                case 'formal':
                    if(is_null($user['registered_at'])) $parameters['registered_at'] = $datetime->format("Y-m-d H:i:s");
                    $parameters['withdrew_at'] = null;
                    break;
                    
                default:
                    if(is_null($user['withdrew_at'])) $parameters['withdrew_at'] = $datetime->format("Y-m-d H:i:s");
                    break;
            }
        }
        return $parameters;
    }
    
    /**
     * DBinsert用の配列を生成します。
     * @param Array $inputs
     * @return DBinsert用配列
     */
    private function createUserAuthorizationParameter($inputs) {
        return array(
            'user_id' => $inputs['user_id'],
            'login_id' => StringUtil::replaceSpace($inputs['email']),
            'password' => Hash::make(StringUtil::replaceSpace($inputs['password'])),
        );
    }
    
    /**
     * DBupdate用の配列を生成します。
     * @param Array $inputs
     * @return DBupdate用配列
     */
    private function createUserAuthorizationParameterForUpdate($inputs) {
        $auth = $this->userAuthorizationService->findByUserId($inputs['user_id']);
        $password = $inputs['is_edit_password'] ? Hash::make(StringUtil::replaceSpace($inputs['password'])) : $auth['password'];
        return array(
            'id' => $auth['id'],
            'user_id' => $inputs['user_id'],
            'login_id' => StringUtil::replaceSpace($inputs['email']),
            'password' => $password,
        );
    }
    
    
    /**
     * DBinsert用の配列を生成します。
     * @param Array $inputs
     * @return DBinsert用配列
     */
    private function createUserScoreParameter($inputs) {
        return array(
            'user_id' => $inputs['user_id'],
            'first_logged_in_at' => $inputs['first_logged_in_at'],
            'last_logged_in_at' => $inputs['last_logged_in_at'],
            'logged_in_count' => $inputs['logged_in_count'],
            'first_reserved_at' => $inputs['first_reserved_at'],
            'last_reserved_at' => $inputs['last_reserved_at'],
            'reserved_count' => $inputs['reserved_count'],
        );
    }
    
    
    
    /**
     * 編集用ユーザーデータをロードします。
     * @param integer $id
     * @return Array
     */
    public function loadUserData($id) {
        $array = array();
        $user = $this->userService->findById($id);
        if(!is_null($user)) {
            $array = $user->toArray();
            $userAuthorization = $this->userAuthorizationService->findByUserId($array['id']);
            $array = array_merge($array, $userAuthorization->toArray());
        }
        return $array;
    }
}
