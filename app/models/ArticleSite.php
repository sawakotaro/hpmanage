<?php


class ArticleSite extends Eloquent  {

    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'article_sites';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
        
    
    public function file() {
        return $this->hasOne('FileData', 'id', 'file_id');
    }
    
    /**
     * Validationの定義をリターンします。
     * @return Array
     */
    public static function getValidateRules() {
        $rules = array(
            'site_name'         =>  array('required', 'max:' . Validation::SITENAME_MAX_LENGTH),
            'site_url'          =>  array('required', 'regex:/' . Validation::REGEX_URL_PATTERN . '/'),
            'rss_url'           =>  array('required', 'regex:/' . Validation::REGEX_URL_PATTERN . '/'),
            'blog_type'         =>  array('max:' . Validation::ARTICLE_TYPE_MAX_LENGTH, 'regex:/^\w+$/'),
            'entry_tag'         =>  array('max:' . Validation::ARTICLE_ENTRY_TAG_MAX_LENGTH),
            'title_tag'         =>  array('max:' . Validation::ARTICLE_TITLE_TAG_MAX_LENGTH),
            'link_tag'          =>  array('max:' . Validation::ARTICLE_LINK_TAG_MAX_LENGTH),
            'description_tag'   =>  array('max:' . Validation::ARTICLE_DESCRIPTION_TAG_MAX_LENGTH),
        );
       
       return $rules;
    }
    
}
