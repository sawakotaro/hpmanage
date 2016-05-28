<?php

class ErrorMessage {
    
    /**
     * $keyがあれば個別、なければ配列をそのままリターンします。
     * @param String $key
     * @return Array or String
     */
    public static function getErrorMessages($key = '') {
        $errorMessages = array(
            "username.required"         =>  "ユーザー名を入力してください",
            "username.max"              =>  "ユーザー名は、" . Validation::USERNAME_MAX_LENGTH . "文字以内で入力してください",
            "username.unique"           =>  "そのユーザー名はすでに登録されています",
            "email.required"            =>  "Eメールアドレスを入力してください",
            "email.email"               =>  "Eメールアドレスの形式が正しくありません",
            "email.max"                 =>  "Eメールアドレスは、" . Validation::EMAIL_MAX_LENGTH . "文字以内で入力してください",
            "email.unique"              =>  "そのEメールアドレスはすでに登録されています",
            "login_id.required"         =>  "ログインIDを入力してください",
            "login_id.regex"            =>  "ログインIDは半角英数字・アンダースコアで5～32文字以内で入力してください",
            "login_id.unique"           =>  "そのログインIDはすでに登録されています",
            "password.required"         =>  "パスワードを入力してください",
            "password.min"              =>  "パスワードは、" . Validation::PASSWORD_MIN_LENGTH . "文字以上で入力してください",
            "password.max"              =>  "パスワードは、" . Validation::PASSWORD_MAX_LENGTH . "文字以内で入力してください",
            "password.alpha_dash"       =>  "パスワードは半角英数字・ハイフン・アンダースコアで入力してください",
            "password.regex"            =>  "パスワードは半角英数字・アンダースコアで8～32文字以内で入力してください",
            "password.confirmed"        =>  "パスワードと確認フィールドが、一致していません",
            "company_id.required"       =>  "運営会社を選択してください",
            "signin.authenticate"       =>  "Eメールアドレス・もしくはパスワードが違います",
            "site_name.required"        =>  "サイト名を入力してください",
            "site_name.max"             =>  "サイト名は、" . Validation::NAME_MAX_LENGTH . "文字以内で入力してください",
            "domain.required"           =>  "ドメインを入力してください",
            "domain.unique"             =>  "そのドメインはすでに登録されています",
            "domain.regex"              =>  "ドメインの形式が正しくありません",
            "site_url.required"         =>  "URLを入力してください",
            "site_url.unique"           =>  "そのURLはすでに登録されています",
            "site_url.regex"            =>  "URLの形式が正しくありません",
            "rss_url.required"          =>  "URLを入力してください",
            "rss_url.unique"            =>  "そのURLはすでに登録されています",
            "rss_url.regex"             =>  "URLの形式が正しくありません",
            "title.required"            =>  "タイトルを入力してください",
            "title.max"                 =>  "タイトルは、" . Validation::TITLE_MAX_LENGTH . "文字以内で入力してください",
            "keyword.required"          =>  "キーワードを入力してください",
            "keyword.max"               =>  "キーワードは、" . Validation::KEYWORD_MAX_LENGTH . "文字以内で入力してください",
            "description.required"      =>  "ディスクリプションを入力してください",
            "description.max"           =>  "ディスクリプションは、" . Validation::DESC_MAX_LENGTH . "文字以内で入力してください",
            "company_name.required"     =>  "運営会社名を入力してください",
            "company_name.max"          =>  "運営会社名は、" . Validation::COMPANYNAME_MAX_LENGTH . "文字以内で入力してください",
            "company_kana.required"     =>  "運営会社名 (フリガナ) を入力してください",
            "company_kana.max"          =>  "運営会社名 (フリガナ) は、" . Validation::COMPANYKANA_MAX_LENGTH . "文字以内で入力してください",
            "zipcode.digits"            =>  "郵便番号は、数字7桁で入力してください",
            "tel.regex"                 =>  "電話番号の形式が正しくありません",
            "addr1.max"                 =>  "住所は、" . Validation::ADDR_MAX_LENGTH . "文字以内で入力してください",
            "addr2.max"                 =>  "住所は、" . Validation::ADDR_MAX_LENGTH . "文字以内で入力してください",
            "detail.max"                =>  "会社詳細は、" . Validation::COMPANYDETAIL_MAX_LENGTH . "文字以内で入力してください",
            "category_name.required"    =>  "カテゴリ名を入力してください",
            "category_name.max"         =>  "カテゴリ名は、" . Validation::CATEGORYNAME_MAX_LENGTH . "文字以内で入力してください",
            "memo.max"                  =>  "メモは、" . Validation::MEMO_MAX_LENGTH . "文字以内で入力してください",
            "changeId.different"        =>  "同じ項目は指定できません",
            "tag.required"              =>  "タグを入力してください",
            "uploaded_file_length"      =>  "ファイルがアップロードされていません",
            "first_name.required"       =>  "氏名 (名) を入力してください",
            "last_name.required"        =>  "氏名 (姓) を入力してください",
            "first_kana.required"       =>  "フリガナ (名) を入力してください",
            "last_kana.required"        =>  "フリガナ (姓) を入力してください",
            "first_name.max"            =>  "氏名 (名) は、" . Validation::NAME_MAX_LENGTH . "文字以内で入力してください",
            "last_name.max"             =>  "氏名 (姓) は、" . Validation::NAME_MAX_LENGTH . "文字以内で入力してください",
            "first_kana.max"            =>  "フリガナ (名) は、" . Validation::NAME_MAX_LENGTH . "文字以内で入力してください",
            "last_kana.max"             =>  "フリガナ (姓) は、" . Validation::NAME_MAX_LENGTH . "文字以内で入力してください",
            "first_kana.regex"          =>  "フリガナ (名) は、全て全角カナで入力してください",
            "last_kana.regex"           =>  "フリガナ (姓) は、全て全角カナで入力してください",
            "tel.required"              =>  "電話番号を入力してください",
            "tel.regex"                 =>  "電話番号は、ハイフンを含めず半角数字10文字、または11文字で入力してください",
            "registered_status.required"=>  "登録ステータスは必ず選択してください",
            "datetime.invalid"          =>  "日時指定に誤りがあります (yyyy-mm-dd hh:ii-ssの形式)",
            "batch.invalid"             =>  "バッチ検索の値は、半角数字のみで入力してください",
            "number.invalid"            =>  "半角数字のみで入力してください",
            "user_id.invalid"           =>  "会員IDは半角数字のみで入力してください",
        );
        
        if($key && array_key_exists($key, $errorMessages)) {
            return $errorMessages[$key];
        } else {
            return $errorMessages;
        }
    }
}
