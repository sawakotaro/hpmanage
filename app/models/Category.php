<?php

class Category extends Eloquent {
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'categories';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function file() {
        return $this->hasOne('FileData', 'id', 'file_id');
    }
    
    

    
    
    /**
     * バリデーションの取得
     * @return type
     */
    public static function getValidateRules() {
       return array(
            'category_name'     =>  array('required', 'max:' . Validation::COMPANYNAME_MAX_LENGTH),
            'memo'              =>  array('max:' . Validation::MEMO_MAX_LENGTH),
        );
    }
}