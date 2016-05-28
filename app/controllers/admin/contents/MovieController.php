<?php

namespace admin\contents;
use \TagLogic ,\Response, \TagRelationService, \DB, \TagService, \DateTime, \FileService, \DateUtil, \Auth, \MovieContent, \MovieContentService, \App, \View, \MovieContentLogic, \Session, \Input, \ErrorMessage, \Validator, \Redirect;

class MovieController extends \BaseController {
    /**
     * @var MovieContentService
     */
    private $movieContentService;
    
    /**
     * @var MovieContentLogic
     */
    private $movieContentLogic;
    
    /**
     * @var TagLogic
     */
    private $tagLogic;
    
    /**
     *
     * @var FileService
     */
    private $fileService;
    
    /**
     *
     * @var TagService
     */
    private $tagService;
    
    /**
     *
     * @var TagRelationService
     */
    private $tagRelationService;
    
    const CSRF_FORM_KEY = "contents/movie/form";
    
    public function __construct() {
        $this->movieContentService      =   App::make("MovieContentService");
        $this->movieContentLogic        =   App::make("MovieContentLogic");
        $this->tagLogic                 =   App::make("TagLogic");
        $this->fileService              =   App::make('FileService');
        $this->tagService               =   App::make('TagService');
        $this->tagRelationService       =   App::make('TagRelationService');
    }
    
    public function getForm() {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        $postedValueList    =   $this->getPostedAtList();
        $dateList           =   DateUtil::generateDateList();

        return View::make('admin.contents.movie.form', array(
            "image"             =>  null,
            "dateList"          =>  $dateList,
            "postedValueList"   =>  $postedValueList,
        ));
    }
    
    
    
    
    
    
    
    
    
        
    /**
     * 投稿日時の各値を配列として取得します。
     * @return Array
     */
    private function getPostedAtList($postedAt = null) {
        if(is_null($postedAt)) {
            $array = array(
                "year"      =>  Input::get("year", date("Y")),
                "month"     =>  Input::get("month", date("n")),
                "day"       =>  Input::get("day", date("j")),
                "hour"      =>  Input::get("hour", date("G")),
                "minute"    =>  Input::get("minute", intval(date("i")))
            );
        } else {
            $date = new DateTime($postedAt);
            $array = array(
                "year"      =>  $date->format("Y"),
                "month"     =>  $date->format("n"),
                "day"       =>  $date->format("j"),
                "hour"      =>  $date->format("G"),
                "minute"    =>  intval($date->format("i"))
            );
        }
        
        return $array;
    }
    
    
    public function postConfirm() {
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/contents/movie/form" . $param);
        }
        if(strlen(Input::get('id')) > 0) {
            $movieContent = MovieContent::find(Input::get('id'));
        }
        
        $rules = MovieContent::getAddValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        // タグの配列化
        $tagList = explode(",", Input::get("tag"));
        
        // 日時のコンバート
        $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
        
        // 一時的にSessionへ退避
        Input::flash();
        
        
        return View::make("admin.contents.movie.confirm", array(
            "tagList"       =>  $tagList,
            "postedAt"      =>  $datetime->format("Y-m-d H:i"),
        ));
    }
    
    
    
    public function postRegister() {
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/contents/movie/form" . $param);
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/contents/movie/form" . $param)->withInput();
        }
        
        
        $rules = MovieContent::getAddValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/contents/movie/form" . $param)->withErrors($errors)->withInput();
        }
        
        
        // 新規挿入処理
        if(!strlen(Input::get('id', null))) {
            DB::transaction(function() {
                // タグの登録
                $tagIdList = $this->addTags(explode(",", Input::get("tag")));
                Input::merge(array("tag_ids" => implode(",", $tagIdList)));
                
                $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
                Input::merge(array("posted_at" => $datetime->format("Y-m-d H:i:s")));
                
                $movieContentsId = $this->movieContentService->add(Input::all());
                foreach($tagIdList as $tagId) {
                    $this->tagRelationService->add(array("tag_id" => $tagId, "image_contents_id" => $movieContentsId));
                }
            });
        
        // 更新処理
        } else {
            DB::transaction(function() {
                $movieContent = MovieContent::find(Input::get('id'));
                
                // タグの登録
                $tagIdList = $this->addTags(explode(",", Input::get("tag")));
                Input::merge(array("tag_ids" => implode(",", $tagIdList)));
                
                $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
                Input::merge(array("posted_at" => $datetime->format("Y-m-d H:i:s")));
                
                $this->movieContentService->update(Input::all());
                $movieContentsId = Input::get("id");
                $this->tagRelationService->deleteByMovieContentsId($movieContentsId);
                foreach($tagIdList as $tagId) {
                    $this->tagRelationService->add(array("tag_id" => $tagId, "image_contents_id" => $movieContentsId));
                }
            });
        }
        
        return Redirect::to("/admin/contents/movie/complete/" . (Input::get('id') ? "update" : "insert"))->withInput();
    }
    
    
    
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.contents.movie.complete", array("executeType" => $executeType));
    }
    
    /**
     * 日時配列リストを取得します。
     * @return Array
     */
    private function generateDateList() {
        return array(
            "year"      =>  DateUtil::generateYearArray(date('Y'), 2),
            "month"     =>  DateUtil::generateMonthArray(),
            "day"       =>  DateUtil::generateDayArray(),
            "hour"      =>  DateUtil::generateHourArray(),
            "minute"    =>  DateUtil::generateMinuteArray(),
        );
    }
    
    
    
    /**
     * アップロードされた画像を登録します
     * @param array $tempPathList
     * @return Array
     */
    private function addImages(Array $tempPathList) {
        $fileIdList = array();
        foreach($tempPathList as $file) {
            if(file_exists(public_path() . $file)) {
                $lastInsertFileId = $this->fileService->add(public_path() . $file);
                $fileIdList[] = $lastInsertFileId;
            }
        }
        return $fileIdList;
    }
    
    
    /**
     * タグが登録されていれば、そのIDを取得し
     * 登録されていないタグであれば新規登録します。
     * @param array $tagList
     * @return Array
     */
    private function addTags(Array $tagList) {
        $tagIdList = array();
        foreach($tagList as $tag) {
            $tagData = $this->tagService->findByTagName($tag);
            
            if(!is_null($tagData))  $tagId  = $tagData->id;
            else                    $tagId  = $this->tagService->add($tag);
            $tagIdList[] = $tagId;
        }
        return $tagIdList;
    }

    
    /**
     * 画像配列の空文字を排除するためのメソッド
     * @param array $images
     * @return array
     */
    public function convertImages(Array $images) {
        $array = array();
        foreach($images as $value) {
            if(!empty($value)) $array[] = $value;
        }
        return $array;
    }
}
