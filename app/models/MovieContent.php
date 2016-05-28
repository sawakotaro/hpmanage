<?php


class MovieContent extends Eloquent  {

    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'movie_contents';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
    
    /**
     * Validationの定義をリターンします。
     * @return Array
     */
    public static function getAddValidateRules() {
        $rules = array(
            'title'             =>  array('required', 'max:' . Validation::TITLE_MAX_LENGTH),
            'tag'               =>  array('required'),
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
