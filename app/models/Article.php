<?php


class Article extends Eloquent  {

    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'articles';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
    
    public function articleSite() {
        return $this->hasOne('ArticleSite', 'id', 'article_site_id');
    }
    
    
    /**
     * Validationの定義をリターンします。
     * @return Array
     */
    public static function getAddValidateRules() {
        $rules = array(
            'article_site_id'   =>  array('required', 'max:' . Validation::SITENAME_MAX_LENGTH),
            'link'              =>  array('required', 'regex:/^[a-zA-Z0-9][a-zA-Z0-9\-\_\.]+\.[A-Za-z]+$/'),
            'title'             =>  array('required'),
            'description'       =>  array('max:' . Validation::ARTICLE_TYPE_MAX_LENGTH, 'regex:/^\w+$/'),
        );
       
       return $rules;
    }
    
    
    /**
     * Validationの定義をリターンします。
     * @return Array
     */
    public static function getEditValidateRules($id, $exclusion = false) {
       $rules = array(
               'username'          =>  array('required', 'max:' . Validation::USERNAME_MAX_LENGTH),
               'email'             =>  array('required', 'email', 'max:' . Validation::EMAIL_MAX_LENGTH , 'unique:auth_members,email,' . $id),
               'password'          =>  array('required', 'alpha_dash',  'min:' . Validation::PASSWORD_MIN_LENGTH, 'max:' . Validation::PASSWORD_MAX_LENGTH, 'confirmed'),
           );
       if($exclusion === true) {
           unset($rules['password']);
       }
       
       return $rules;
    }

}
