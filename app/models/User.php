<?php


class User extends Eloquent{


    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'users';

    

    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
}
