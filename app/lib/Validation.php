<?php

class Validation {
    
    // ユーザー名の入力制限
    const USERNAME_MAX_LENGTH = 50;
    
    // パスワードの入力制限
    const PASSWORD_MIN_LENGTH = 8;
    const PASSWORD_MAX_LENGTH = 16;
    
    // Eメールアドレスの入力制限
    const EMAIL_MAX_LENGTH = 100;
    
    
    // サイト名の入力制限
    const NAME_MAX_LENGTH = 85;
    
    // サイト設定 SEO関連の入力制限
    const TITLE_MAX_LENGTH = 85;
    const KEYWORD_MAX_LENGTH = 85;
    const DESC_MAX_LENGTH = 130;
    
    
    // 運営会社関連の入力制限
    const COMPANYNAME_MAX_LENGTH = 85;
    const COMPANYKANA_MAX_LENGTH = 85;
    const COMPANYDETAIL_MAX_LENGTH = 2000;
    
    // 住所フィールドの入力制限
    const ADDR_MAX_LENGTH = 85;
    
    // カテゴリフィールドの入力制限
    const CATEGORYNAME_MAX_LENGTH = 85;
    
    // 共通　メモの入力制限
    const MEMO_MAX_LENGTH = 3000;
    
    // 記事タイプの入力制限
    const ARTICLE_TYPE_MAX_LENGTH = 10;
    
    // 記事 取得用タグの入力制限
    const ARTICLE_ENTRY_TAG_MAX_LENGTH = 255;
    const ARTICLE_TITLE_TAG_MAX_LENGTH = 255;
    const ARTICLE_LINK_TAG_MAX_LENGTH = 255;
    const ARTICLE_DESCRIPTION_TAG_MAX_LENGTH = 255;
    const ARTICLE_TITLE_MAX_LENGTH = 80;
    const ARTICLE_DESCRIPTION_MAX_LENGTH = 2000;
    
    
    
    // URL 正規表現
    const REGEX_URL_PATTERN = "(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)";
    
    // Mail 正規表現
    const REGEX_MAIL_PATTERN = "[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?";
    
    
    
    public static function getAdminEntryUserValidationRules($parameters = array()) {
        $exclusion = "";
        $passwordValidate = array();
        if($parameters['id'] !== false) {
            $exclusion['id'] = "," . $parameters['id'];
        }
        
        if((($parameters['id'] !== false && $parameters['is_edit_password'])) || ($parameters['id'] === false || empty($parameters['id']))) {
            $passwordValidate = array('required', 'regex:/^\w{8,32}$/');
        }
        
        $rules = array(
            'first_name'        =>  array('required', 'max:' . self::NAME_MAX_LENGTH),
            'last_name'         =>  array('required', 'max:' . self::NAME_MAX_LENGTH),
            'first_kana'        =>  array('required', 'max:' . self::NAME_MAX_LENGTH, 'regex:/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6])+$/'),
            'last_kana'         =>  array('required', 'max:' . self::NAME_MAX_LENGTH, 'regex:/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6])+$/'),
            'email'             =>  array('required', 'max:' . self::EMAIL_MAX_LENGTH, 'email', 'unique:users,email' . $exclusion['id']),
            'tel'               =>  array('required', 'regex:/^\d{10,11}$/'),
            'password'          =>  $passwordValidate,
            'registered_status' =>  array('required'),
        );
        
        return $rules;
    }
    
    
}