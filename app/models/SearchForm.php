<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SearchForm
 *
 * @author fid
 */
class SearchForm extends Eloquent {
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'search_forms';

    public $timestamps = false;
}
