<?php

namespace admin\contents;

use \TagLogic ,\Response, \TagRelationService, \DB, \TagService, \DateTime, \FileService, \DateUtil, \Auth, \ImageContent, \ImageContentService, \App, \View, \ImageContentLogic, \Session, \Input, \ErrorMessage, \Validator, \Redirect;

class ImageController extends \BaseController {
    
    /**
     * @var ImageContentService
     */
    private $imageContentService;
    
    /**
     * @var ImageContentLogic
     */
    private $imageContentLogic;
    
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
    
    const CSRF_FORM_KEY = "contents/image/form";
    
    public function __construct() {
        $this->imageContentService      =   App::make("ImageContentService");
        $this->imageContentLogic        =   App::make("ImageContentLogic");
        $this->tagLogic                 =   App::make("TagLogic");
        $this->fileService              =   App::make('FileService');
        $this->tagService               =   App::make('TagService');
        $this->tagRelationService       =   App::make('TagRelationService');
    }
    
    
    public function getList() {
        $imageContentList = $this->imageContentService->findAllOrderById("desc", 10);
        if(count($imageContentList) > 0) {
            $imageContentList = $this->imageContentLogic->getFileOfImageContentList($imageContentList);
        }
        return View::make('admin.contents.image.list', array(
            "imageContentList" =>  $imageContentList
        ));
    }
    
    
    
    /**
     * 画像コンテンツ 入力フォーム
     * @param Integer $id
     * @return View
     */
    public function getForm($id = null) {
        Session::put(self::CSRF_FORM_KEY, Session::token());
        $image = null;
        $executeType = "add";
        Input::merge(array("suspended" => 0));
        if(!is_null($id) && preg_match("/^\d+$/", $id)) {
            $imageContent = ImageContent::find($id);
            
            if(is_null($imageContent) || count($imageContent) == 0) 
                 return Response::view('admin.errors.403', array(), 403);
            $imageContent = $imageContent->toArray();
            if(count($imageContent) > 0) {
                $imageContent           =   $this->imageContentLogic->getFileOfImageContent($imageContent);
                $postedValueList        =   $this->getPostedAtList($imageContent['posted_at']);
                $imageContent['tag']    =   $this->tagLogic->convertTagData($imageContent['tag_ids']);
                Input::merge($imageContent);
                $executeType = "update";
            }
        } else {
            $postedValueList    =   $this->getPostedAtList();
        }
        
        $dateList           =   $this->generateDateList();
        return View::make("admin.contents.image.form", array(
            "image"             =>  null,
            "dateList"          =>  $dateList,
            "postedValueList"   =>  $postedValueList,
            "files"             =>  !empty($imageContent['file']) ? $imageContent['file'] : array()
        ));
    }
    
    
    
    public function postConfirm() {
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/contents/image/form" . $param);
        }
        
        Input::merge(array('image' => $this->convertImages(Input::get("image", array()))));
        if(strlen(Input::get('id')) > 0) {
            $imageContent = ImageContent::find(Input::get('id'));
            $imageContent = $this->imageContentLogic->getFileOfImageContent($imageContent);
        }
        
        $rules = ImageContent::getAddValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::back()->withInput()->withErrors($errors);
        }
        
        $tmpDir = public_path() . "/" . "images/tmp/" . sha1(Auth::user()->id);
        $images = Input::file('image', null);
        $tempPathList = array();
        if(!file_exists($tmpDir)) mkdir($tmpDir, '0777', true);
        if($this->imageContentLogic->isUploadImages($images)) {
            $result = $this->imageContentLogic->moveTempDirectoryByUploadImage($images, $tmpDir);
            $tempPathList = $this->imageContentLogic->getPathOfLastMoveTempfile();
            if($result === false || !count($tempPathList)) {
                return Response::view('admin.errors.403', array(), 403);
            }
        }
        
        // タグの配列化
        $tagList = explode(",", Input::get("tag"));
        
        // 日時のコンバート
        $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
        
        Input::merge(array("tempPathList" => $tempPathList));
        
        // 一時的にSessionへ退避
        Input::flash();
        
        return View::make("admin.contents.image.confirm", array(
            "tempPathList"  =>  $tempPathList,
            "tagList"       =>  $tagList,
            "postedAt"      =>  $datetime->format("Y-m-d H:i"),
        ));
    }
    
    
    
    public function postRegister() {
        Input::merge(Input::old());
        $param = Input::get('id') ? "/" . Input::get('id') : "";
        
        if(Session::get(self::CSRF_FORM_KEY) !== Input::get("_token")) {
            return Redirect::to("/admin/contents/image/form" . $param);
        }
        
        // 戻るボタンが押された際はリダイレクト
        if(Input::get("cancel")) {
            return Redirect::to("/admin/contents/image/form" . $param)->withInput();
        }
        
        // バリデート
        $imageLength = 0;
        if(strlen(Input::get('id', "")) > 0) {
            $imageContent = ImageContent::find(Input::get('id'));
            if(!is_null($imageContent)) $imageLength += count(explode(",", $imageContent->file_ids));
        }
        $imageLength += count(Input::get("tempPathList", array()));
        Input::merge(array("imageLength" => $imageLength));
        
        $rules = ImageContent::getAddValidateRules();
        $errors = Validator::make(Input::all(), $rules, ErrorMessage::getErrorMessages());
        if($errors->fails()) {
            return Redirect::to("/admin/contents/image/form" . $param)->withErrors($errors)->withInput();
        }
        
        
        // 新規挿入処理
        if(!strlen(Input::get('id', null))) {
            DB::transaction(function() {
                // 画像ファイルの登録
                $fileIdList = $this->addImages(Input::get("tempPathList", array()));
                Input::merge(array("file_ids" => implode(",", $fileIdList)));
                
                // タグの登録
                $tagIdList = $this->addTags(explode(",", Input::get("tag")));
                Input::merge(array("tag_ids" => implode(",", $tagIdList)));
                
                $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
                Input::merge(array("posted_at" => $datetime->format("Y-m-d H:i:s")));
                
                $imageContentsId = $this->imageContentService->add(Input::all());
                foreach($tagIdList as $tagId) {
                    $this->tagRelationService->add(array("tag_id" => $tagId, "image_contents_id" => $imageContentsId));
                }
            });
        
        // 更新処理
        } else {
            DB::transaction(function() {
                $imageContent = ImageContent::find(Input::get('id'));
                // 画像ファイルの登録
                $fileIdList = $this->addImages(Input::get("tempPathList", array()));
                $registeredFileIdList = array();
                if(!empty($imageContent->file_ids)) $registeredFileIdList = explode(",", $imageContent->file_ids);
                Input::merge(array("file_ids" => implode(",", array_merge($registeredFileIdList, $fileIdList))));
                
                // タグの登録
                $tagIdList = $this->addTags(explode(",", Input::get("tag")));
                Input::merge(array("tag_ids" => implode(",", $tagIdList)));
                
                $datetime = new DateTime(Input::get("year") . "-" . Input::get("month") . "-" . Input::get("day") . " " . Input::get("hour") . ":" . Input::get("minute"));
                Input::merge(array("posted_at" => $datetime->format("Y-m-d H:i:s")));
                
                $this->imageContentService->update(Input::all());
                $imageContentsId = Input::get("id");
                $this->tagRelationService->deleteByImageContentsId($imageContentsId);
                foreach($tagIdList as $tagId) {
                    $this->tagRelationService->add(array("tag_id" => $tagId, "image_contents_id" => $imageContentsId));
                }
            });
        }
        
        return Redirect::to("/admin/contents/image/complete/" . (Input::get('id') ? "update" : "insert"))->withInput();
    }
    
    
    
    public function getComplete($executeType) {
        Session::forget(self::CSRF_FORM_KEY);
        return View::make("admin.contents.image.complete", array("executeType" => $executeType));
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
