<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Site
 *
 * @author fid
 */


class Site extends Eloquent {
    
    
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'sites';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function company() {
        return $this->hasOne('Company', 'id', 'company_id');
    }
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function file() {
        return $this->hasOne('FileData', 'id', 'file_id');
    }
    
    public static function getValidateRules($id = false) {
        $exclusion = "";
        if($id !== false) $exclusion = "," . $id;
        return array(
            'site_name'     =>  array('required', 'max:' . Validation::NAME_MAX_LENGTH),
            'domain'        =>  array('required', 'unique:sites,domain' . $exclusion, 'regex:/^[a-zA-Z0-9][a-zA-Z0-9\-\_\.]+\.[A-Za-z]+$/'),
            'title'         =>  array('max:' . Validation::TITLE_MAX_LENGTH),
            'keyword'       =>  array('max:' . Validation::KEYWORD_MAX_LENGTH),
            'description'   =>  array('max:' . Validation::DESC_MAX_LENGTH),
        );
    }
    
    
    
}
