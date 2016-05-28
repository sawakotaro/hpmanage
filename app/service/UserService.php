<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserService
 *
 * @author fid
 */
class UserService {
    
    
    /**
     * 1件のIDに紐づくデータを返却します。
     * @param Integer $id
     * @return Entity
     */
    public function findById($id) {
        return User::find($id);
    }
    
    
    /**
     * １件のデータを挿入します。
     * @param array $inputs
     * @return プライマリID
     */
    public function insert(Array $inputs) {
        $user = new User();
        $user->first_name = $inputs['first_name'];
        $user->last_name = $inputs['last_name'];
        $user->first_kana = $inputs['first_kana'];
        $user->last_kana = $inputs['last_kana'];
        $user->gender = $inputs['gender'];
        $user->blood_type = $inputs['blood_type'];
        $user->birth_year = $inputs['birth_year'];
        $user->birth_month = $inputs['birth_month'];
        $user->birth_day = $inputs['birth_day'];
        $user->registered_status = $inputs['registered_status'];
        $user->email = $inputs['email'];
        $user->tel = $inputs['tel'];
        $user->manager_note = $inputs['manager_note'];
        $user->last_session = $inputs['last_session'];
        $user->interim_at = $inputs['interim_at'];
        $user->registered_at = $inputs['registered_at'];
        $user->withdrew_at = $inputs['withdrew_at'];
        
        $user->save();
        return $user->id;
    }
    
    /**
     * 1件のデータを更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $user = User::find($inputs['id']);
        $user->first_name = $inputs['first_name'];
        $user->last_name = $inputs['last_name'];
        $user->first_kana = $inputs['first_kana'];
        $user->last_kana = $inputs['last_kana'];
        $user->gender = $inputs['gender'];
        $user->blood_type = $inputs['blood_type'];
        $user->birth_year = $inputs['birth_year'];
        $user->birth_month = $inputs['birth_month'];
        $user->birth_day = $inputs['birth_day'];
        $user->registered_status = $inputs['registered_status'];
        $user->email = $inputs['email'];
        $user->tel = $inputs['tel'];
        $user->manager_note = $inputs['manager_note'];
        $user->last_session = $inputs['last_session'];
        if(array_search('interim_at', $inputs) !== false) $user->interim_at = $inputs['interim_at'];
        if(array_search('registered_at', $inputs) !== false) $user->registered_at = $inputs['registered_at'];
        if(array_search('withdrew_at', $inputs) !== false) $user->withdrew_at = $inputs['withdrew_at'];
        
        //$datetime = new DateTime();
        //$user->updated_at = $datetime->format("Y-m-d H:i:s");
        $user->save();
    }
    
    
    
    public function findByQuery($where, Array $params) {
        return DB::table("users as u")
                ->join("users_authorizations as ua", "u.id", "=", "ua.user_id")
                ->join("users_scores as s", "u.id", "=", "s.user_id")
                ->whereRaw($where, $params)
                ->get();
    }
    
}
