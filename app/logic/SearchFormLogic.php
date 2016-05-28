<?php

/**
 * 検索フォームに関するロジックをまとめたクラスです。
 * @author fid
 * @version 1.0
 */
class SearchFormLogic {
    
    /**
     * @var SearchFormService
     */
    private $searchFormService;
    
    /**
     * @var UserService
     */
    private $userService;
    
    /**
     * @var Array 検索クエリのWhere句生成用変数
     */
    private $search_where = " 1 = 1 and ";
    
    /**
     * @var Array 検索クエリのバインドパラメータ配列
     */
    private $search_param = array();
    
    public function __construct() {
        $this->searchFormService = App::make('SearchFormService');
        $this->userService = App::make('UserService');
    }
    
    /**
     * 検索フォームで表示する日時検索の項目リストを取得します。
     * @return 検索フォームで表示する日時検索の項目リスト
     */
    public function getSearchDatetimeList() {
        return array(
            'registered_at' => '本登録日時',
            'first_logged_in_at' => "初回ログイン日時",
            'logged_in_at' => "最終ログイン日時",
            'first_reserved_at' => "初回予約日時",
            'reserved_at' => "最終予約日時",
            'interim_at' => '仮登録日時',
            'withdrew_at' => '退会日時',
        );
    }
    
    
    
    /**
     * 検索フォームで入力された値を、必要な項目のみバリデーションします。
     * @param Array $inputs 検索フォーム入力値
     * @return エラーメッセージ格納配列
     */
    public function validateSearchForm($inputs) {
        $errors = array();
        // DateTime Validation
        if(!empty($inputs['datetime1_unit'])) {
            if(!$inputs['is_batch1_begin'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime1_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch1_begin'] && !preg_match("/^\d+$/", $inputs['batch1_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
            if(!$inputs['is_batch1_end'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime1_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch1_end'] && !preg_match("/^\d+$/", $inputs['batch1_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
        }
        if(!empty($inputs['datetime2_unit'])) {
            if(!$inputs['is_batch2_begin'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime2_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch2_begin'] && !preg_match("/^\d+$/", $inputs['batch2_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
            if(!$inputs['is_batch2_end'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime2_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch2_end'] && !preg_match("/^\d+$/", $inputs['batch2_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
        }
        if(!empty($inputs['datetime3_unit'])) {
            if(!$inputs['is_batch3_begin'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime3_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch3_begin'] && !preg_match("/^\d+$/", $inputs['batch3_begin'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
            if(!$inputs['is_batch3_end'] && !preg_match("/^\d{4}\-\d{2}\-\d{2}\s\d{2}\:\d{2}\:\d{2}$/", $inputs['datetime3_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("datetime.invalid");
            } else if($inputs['is_batch3_end'] && !preg_match("/^\d+$/", $inputs['batch3_end'])) {
                $errors[] = ErrorMessage::getErrorMessages("batch.invalid");
            }
        }
        
        // 表示件数
        if(!preg_match("/^\d+$/", $inputs['limit'])) {
            $errors[] = ErrorMessage::getErrorMessages("number.invalid");
        }
        
        // 会員ID
        if(strlen(StringUtil::replaceSpace($inputs['user_id']))) {
            foreach(explode("\n", $inputs['user_id']) as $value) {
                if(empty($value) || !strlen(StringUtil::replaceSpace($value))) continue;
                if(!preg_match("/^\d+$/", $value)) {
                    $errors[] = ErrorMessage::getErrorMessages("user_id.invalid");
                    break;
                }
            }
        }
        
        return $errors;
    }
    
    
    
    
    
    /**
     * SEARCH_FORMテーブルに、検索されたフォームデータを格納し
     * 新規登録されたプライマリIDを返却します。
     * @param array $data POSTされた検索フォームデータ
     * @return プライマリID
     */
    public function registerSearchForm(Array $data) {
        // チェックボックスが空の場合、空の配列を挿入
        if(array_key_exists("gender", $data) === false) $data['gender'] = array();
        if(array_key_exists("registered_status", $data) === false) $data['registered_status'] = array();
        if(array_key_exists("blood_type", $data) === false) $data['blood_type'] = array();
        if(array_key_exists("is_batch1_begin", $data) === false) $data['is_batch1_begin'] = false;
        if(array_key_exists("is_batch2_begin", $data) === false) $data['is_batch2_begin'] = false;
        if(array_key_exists("is_batch3_begin", $data) === false) $data['is_batch3_begin'] = false;
        if(array_key_exists("is_batch1_end", $data) === false) $data['is_batch1_end'] = false;
        if(array_key_exists("is_batch2_end", $data) === false) $data['is_batch2_end'] = false;
        if(array_key_exists("is_batch3_end", $data) === false) $data['is_batch3_end'] = false;
        return $this->searchFormService->insert(json_encode($this->replaceLine($data)));
    }
    
    
    
    /**
     * SEARCH_FORMに格納する前に、一度改行コードを全て統一します。
     * @param Array $data SEARCH_FORMに格納するデータ配列
     * @return 置換後のデータ配列
     */
    private function replaceLine(Array $data) {
        $data['user_id'] = str_replace(array("\r\n", "\r", "\n"), "\n", $data['user_id']);
        $data['login_id'] = str_replace(array("\r\n", "\r", "\n"), "\n", $data['login_id']);
        $data['email'] = str_replace(array("\r\n", "\r", "\n"), "\n", $data['email']);
        $data['manager_note'] = str_replace(array("\r\n", "\r", "\n"), "\n", $data['manager_note']);
        return $data;
    }
    
    
    public function search($id, $page) {
        $search_form = $this->searchFormService->findById($id);
        $decode_data = ConvertUtil::stdClassToArray(json_decode($search_form->data));
        $this->makeWhereParameter($decode_data);
        $data = $this->userService->findByQuery($this->search_where, $this->search_param);
        echo $this->search_where . PHP_EOL;
        var_dump($decode_data);
        print_r($this->search_param);
        print_r($data);
        exit;
    }
    
    
    
    /**
     * SQL問い合わせ用のパラメータ配列とクエリ変数を作成します。
     * @param Array $decode_data 検索フォームの値を保持した配列
     */
    private function makeWhereParameter($decode_data) {
        // User ID
        $this->makeWhereUserIdParameter($decode_data['user_id']);
        // Login ID
        $this->makeWhereLoginIdParameter($decode_data['login_id']);
        // E-Mail
        $this->makeWhereEmailParameter($decode_data['email']);
        // Last name
        $this->makeWhereLastNameParameter($decode_data['last_name']);
        // First name
        $this->makeWhereFirstNameParameter($decode_data['first_name']);
        // Tel
        $this->makeWhereTelParameter($decode_data['tel']);
        // Gender
        $this->makeWhereGenderParameter($decode_data['gender']);
        // Registered status
        $this->makeWhereRegisteredStatusParameter($decode_data['registered_status']);
        // Blood type
        $this->makeWhereBloodTypeParameter($decode_data['blood_type']);
        
        // Date time
        $this->makeWhereDatetimeParameter($decode_data['datetime1_unit'], $decode_data['datetime1_category'], $decode_data['is_batch1_begin'], $decode_data['datetime1_begin'], $decode_data['batch1_begin'], $decode_data['batch1_unit_begin'], $decode_data['is_batch1_end'], $decode_data['datetime1_end'], $decode_data['batch1_end'], $decode_data['batch1_unit_end']);
        $this->makeWhereDatetimeParameter($decode_data['datetime2_unit'], $decode_data['datetime2_category'], $decode_data['is_batch2_begin'], $decode_data['datetime2_begin'], $decode_data['batch2_begin'], $decode_data['batch2_unit_begin'], $decode_data['is_batch2_end'], $decode_data['datetime2_end'], $decode_data['batch2_end'], $decode_data['batch2_unit_end']);
        $this->makeWhereDatetimeParameter($decode_data['datetime3_unit'], $decode_data['datetime3_category'], $decode_data['is_batch3_begin'], $decode_data['datetime3_begin'], $decode_data['batch3_begin'], $decode_data['batch3_unit_begin'], $decode_data['is_batch3_end'], $decode_data['datetime3_end'], $decode_data['batch3_end'], $decode_data['batch3_unit_end']);

        // Birthday
        $this->makeWhereBirthdayParameter($decode_data['birth_year'], $decode_data['birth_month'], $decode_data['birth_day']);
        // Manager note
        $this->makeWhereManagerNoteParameter($decode_data['manager_note']);
        
        $this->search_where = StringUtil::deleteLastString($this->search_where, "and");
    }
    
    
    /**
     * 会員IDに関するSQLパラメータを生成します。
     * @param Integer $user_id 会員ID
     * @return void
     */
    private function makeWhereUserIdParameter($user_id) {
        if(empty($user_id) || !strlen(StringUtil::replaceSpace($user_id))) {
            return;
        }
        
        $this->search_where .= " u.id in (";
        foreach(explode("\n", $user_id) as $value) {
            if(empty($value) || !strlen(StringUtil::replaceSpace($value))) continue;
            $this->search_where .= "?,";
            $this->search_param[] = trim($value);
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    /**
     * ログインIDに関するSQLパラメータを生成します。
     * @param Integer $login_id ログインID
     * @return void
     */
    private function makeWhereLoginIdParameter($login_id) {
        if(empty($login_id) || !strlen(StringUtil::replaceSpace($login_id))) {
            return;
        }
        
        $this->search_where .= " ua.login_id in (";
        foreach(explode("\n", $login_id) as $value) {
            if(empty($value) || !strlen(StringUtil::replaceSpace($value))) continue;
            $this->search_where .= "?,";
            $this->search_param[] = trim($value);
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    /**
     * emailアドレスに関するSQLパラメータを生成します。
     * @param Integer $email E-Mailアドレス
     * @return void
     */
    private function makeWhereEmailParameter($email) {
        if(empty($email) || !strlen(StringUtil::replaceSpace($email))) {
            return;
        }
        
        $this->search_where .= " u.email in (";
        foreach(explode("\n", $email) as $value) {
            if(empty($value) || !strlen(StringUtil::replaceSpace($value))) continue;
            $this->search_where .= "?,";
            $this->search_param[] = trim($value);
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    /**
     * 氏名 (姓) に関するSQLパラメータを生成します。
     * @param Integer $last_name 氏名 (姓)
     * @return void
     */
    private function makeWhereLastNameParameter($last_name) {
        if(empty($last_name)) {
            return;
        }
        $this->search_where .= " u.last_name = ? and ";
        $this->search_param[] = $last_name;
    }
    
    
    
    /**
     * 氏名 (名) に関するSQLパラメータを生成します。
     * @param Integer $first_name 氏名 (名)
     * @return void
     */
    private function makeWhereFirstNameParameter($first_name) {
        if(empty($first_name)) {
            return;
        }
        $this->search_where .= " u.first_name = ? and ";
        $this->search_param[] = $first_name;
    }
    
    
    
    /**
     * 電話番号に関するSQLパラメータを生成します。
     * @param Integer $tel 電話番号
     * @return void
     */
    private function makeWhereTelParameter($tel) {
        if(empty($tel)) {
            return;
        }
        $this->search_where .= " u.tel = ? and ";
        $this->search_param[] = $tel;
    }
    
    
    
    /**
     * 性別に関するSQLパラメータを生成します。
     * @param Array $gender 性別配列
     * @return void
     */
    private function makeWhereGenderParameter(Array $gender) {
        if(!count($gender)) {
            return;
        }
        $this->search_where .= " u.gender in (";
        foreach($gender as $value) {
            $this->search_where .= "?,";
            $this->search_param[] = $value;
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    /**
     * 登録状況ステータスに関するSQLパラメータを生成します。
     * @param Array $registeredStatus 登録状況ステータス配列
     * @return void
     */
    private function makeWhereRegisteredStatusParameter(Array $registeredStatus) {
        if(!count($registeredStatus)) {
            return;
        }
        $this->search_where .= " u.registered_status in (";
        foreach($registeredStatus as $value) {
            $this->search_where .= "?,";
            $this->search_param[] = $value;
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    /**
     * 血液型に関するSQLパラメータを生成します。
     * @param Array $bloodType 血液型配列
     * @return void
     */
    private function makeWhereBloodTypeParameter(Array $bloodType) {
        if(!count($bloodType)) {
            return;
        }
        $this->search_where .= " u.blood_type in (";
        foreach($bloodType as $value) {
            $this->search_where .= "?,";
            $this->search_param[] = $value;
        }
        $this->search_where = rtrim($this->search_where, ",") . ") and ";
    }
    
    
    
    
    /**
     * 日時検索に関するSQLパラメータを生成します。
     * @param Boolean $is_begin trueなら開始日時、それ以外なら終了日時
     * @param String $datetime_unit 利用しない・絞り込み・除外の設定
     * @param String $datetime_category 検索するカラム項目の選択
     * @param Boolean $is_batch_begin trueならバッチ検索・そうじゃなければ通常検索
     * @param DateTime $datetime_begin 通常検索時の日時の値
     * @param Integer $batch_begin バッチ検索時の値
     * @param String $batch_unit_begin バッチ検索のmodifyに対応するカテゴリ
     * @param Boolean $is_batch_end trueならバッチ検索・そうじゃなければ通常検索
     * @param DateTime $datetime_end 通常検索時の日時の値
     * @param Integer $batch_end バッチ検索時の値
     * @param String $batch_unit_end バッチ検索のmodifyに対応するカテゴリ
     * @return void
     */
    private function makeWhereDatetimeParameter($datetime_unit, $datetime_category, $is_batch_begin, $datetime_begin, $batch_begin, $batch_unit_begin, $is_batch_end, $datetime_end, $batch_end, $batch_unit_end) {
        // 利用しない、もしくは絞り込み、もしくは除外の項目
        switch($datetime_unit) {
            case 'in': $sign = "between"; break;
            case 'not_in': $sign = "not between"; break;
            default: return;
        }
        // 検索項目の確定
        switch($datetime_category) {
            case 'registered_at': $category = "u.registered_at"; break;
            case 'first_logged_in_at': $category = "s.first_logged_in_at"; break;
            case 'logged_in_at': $category = "s.last_logged_in_at"; break;
            case 'first_reserved_at': $category = "s.first_reserved_at"; break;
            case 'reserved_at': $category = "s.last_reserved_at"; break;
            case 'interim_at': $category = "u.interim_at"; break;
            case 'withdrew_at': $category = "u.withdrew_at"; break;
            default: return;
        }
        
        $result_datetime_begin = ($is_batch_begin ? $this->getBatchDatetime(true, $batch_begin, $batch_unit_begin) : $this->formatDatetime(true, $datetime_begin));
        $result_datetime_end = ($is_batch_end ? $this->getBatchDatetime(false, $batch_end, $batch_unit_end) : $this->formatDatetime(false, $datetime_end));
        $this->search_where .= " ( ". $category ." ". $sign . " ? and ? ) and ";
        $this->search_param[] = $result_datetime_begin;
        $this->search_param[] = $result_datetime_end;
    }
    
    
    /**
     * 検索フォームでは秒が設定されない項目があるので
     * そのDateTimeに秒数を設定します。
     * @param Boolean $is_begin
     * @param DateTime $datetime
     * @return フォーマット済みのDateTime
     */
    private function formatDatetime($is_begin, $datetime) {
        $dto = new DateTime($datetime);
        $hour = $dto->format("H");
        $minute = $dto->format("i");
        $second = $is_begin ? 0 : 59;
        $dto->setTime($hour, $minute, $second);
        return $dto->format("Y-m-d H:i:s");
    }
    
    
    /**
     * バッチ検索の値から算出したDateTimeを取得します。
     * @param Boolean $is_begin trueなら開始日時、それ以外なら終了日時
     * @param Integer $batch バッチ検索時の値
     * @param  String $batch_unit バッチ検索のmodifyに対応するカテゴリ
     * @return バッチ検索の値から算出したDateTime
     */
    private function getBatchDatetime($is_begin, $batch, $batch_unit) {
        $date = new DateTime();
        switch($batch_unit) {
            case 'minutes': $date->modify("-" . $batch . " minutes"); break;
            case 'hours': $date->modify("-" . $batch . " hours"); break;
            
            case 'days': 
                $date->modify("-" . $batch . " days"); 
                $is_begin ? $date->setTime(0, 0, 0) : $date->setTime(23, 59, 59);
                break;
            
            case 'weeks': 
                $date->modify("-" . $batch . " weeks"); 
                $is_begin ? $date->setTime(0, 0, 0) : $date->setTime(23, 59, 59);
                break;
            
            case 'months': 
                $date->modify("-" . $batch . " months"); 
                $is_begin ? $date->setTime(0, 0, 0) : $date->setTime(23, 59, 59);
                break;
            default: $date->modify("-" . $batch . " minutes"); break;
        }
        
        return $date->format("Y-m-d H:i:s");
    }
    
    
    /**
     * 生年月日に関するSQLパラメータを生成します。
     * @param Integer $birth_year 生年月日 (西暦)
     * @param Integer $birth_month 生年月日 (月)
     * @param Integer $birth_day 生年月日 (日)
     */
    private function makeWhereBirthdayParameter($birth_year, $birth_month, $birth_day) {
        if(!empty($birth_year)) {
            $this->search_where .= " u.birth_year = ? and ";
            $this->search_param[] = intval($birth_year);
        }
        if(!empty($birth_month)) {
            $this->search_where .= " u.birth_month = ? and ";
            $this->search_param[] = intval($birth_month);
        }
        if(!empty($birth_day)) {
            $this->search_where .= " u.birth_day = ? and ";
            $this->search_param[] = intval($birth_day);
        }
    }
    
    
    /**
     * 管理者メモに関するSQLパラメータを生成します。
     * @param String $manager_note 管理者メモ
     * @return void
     */
    private function makeWhereManagerNoteParameter($manager_note) {
        if(empty($manager_note) || !strlen(StringUtil::replaceSpace($manager_note))) {
            return;
        }
        
        $this->search_where .= "(";
        foreach(explode("\n", $manager_note) as $value) {
            if(empty($value) || !strlen(StringUtil::replaceSpace($value))) continue;
            $this->search_where .= " u.manager_note like ? or ";
            $this->search_param[] = "%" . trim($value) . "%";
        }
        $this->search_where = StringUtil::deleteLastString($this->search_where, "or") . ") and ";
    }
}
