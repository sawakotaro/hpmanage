<?php

class Company extends Eloquent {
    
    
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'companies';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
    
    
    public static function getValidateRules() {
       return array(
            'company_name'      =>  array('required', 'max:' . Validation::COMPANYNAME_MAX_LENGTH),
            'company_kana'      =>  array('required', 'max:' . Validation::COMPANYKANA_MAX_LENGTH),
            'email'             =>  array('email', 'max:' . Validation::EMAIL_MAX_LENGTH),
            'addr1'             =>  array('max:' . Validation::ADDR_MAX_LENGTH),
            'addr2'             =>  array('max:' . Validation::ADDR_MAX_LENGTH),
            'zipcode'           =>  array('digits:7'),
            'tel'               =>  array('regex:/^\d{10,11}$/'),
            'detail'            =>  array('max:' . Validation::COMPANYDETAIL_MAX_LENGTH),
        );
    }
    
}
