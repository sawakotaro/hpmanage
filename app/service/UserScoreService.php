<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserScoreService
 *
 * @author fid
 */
class UserScoreService {
    
    
    /**
     * １件のデータを挿入します。
     * @param array $inputs
     * @return プライマリID
     */
    public function insert(Array $inputs) {
        $score = new UserScore();
        $score->user_id = $inputs['user_id'];
        $score->first_logged_in_at = $inputs['first_logged_in_at'];
        $score->last_logged_in_at = $inputs['last_logged_in_at'];
        $score->logged_in_count = $inputs['logged_in_count'];
        $score->first_reserved_at = $inputs['first_reserved_at'];
        $score->last_reserved_at = $inputs['last_reserved_at'];
        $score->reserved_count = $inputs['reserved_count'];
        $score->save();
        return $score->id;
    }
    
    /**
     * 1件のデータを更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $score = UserScore::find($inputs['id']);
        $score->user_id = $inputs['user_id'];
        $score->first_logged_in_at = $inputs['first_logged_in_at'];
        $score->last_logged_in_at = $inputs['last_logged_in_at'];
        $score->logged_in_count = $inputs['logged_in_count'];
        $score->first_reserved_at = $inputs['first_reserved_at'];
        $score->last_reserved_at = $inputs['last_reserved_at'];
        $score->reserved_count = $inputs['reserved_count'];
        $score->save();
        //$datetime = new DateTime();
        //$user->updated_at = $datetime->format("Y-m-d H:i:s");
    }
    
}
