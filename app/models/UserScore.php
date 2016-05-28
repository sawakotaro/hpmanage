<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserScore
 *
 * @author fid
 */
class UserScore extends Eloquent {
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'users_scores';

    public $timestamps = false;
}
