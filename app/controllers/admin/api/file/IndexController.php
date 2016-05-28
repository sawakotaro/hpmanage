<?php

namespace admin\api\file;

use \Input, \Response, \Session, \FileLogic, \FileService, \App, \FileData, \ImageContentLogic;

class IndexController extends \BaseController {
    
    /**
     * @var FileLogic
     */
    private $fileLogic;
    
    /**
     * @var FileService
     */
    private $fileService;
    
    
    /**
     * @var ImageContentLogic
     */
    private $imageContentLogic;
    
    public function __construct() {
        $this->fileLogic            =   App::make("FileLogic");
        $this->fileService          =   App::make("FileService");
        $this->imageContentLogic    =   App::make("ImageContentLogic");
    }
    
    public function postUpload() {
        set_time_limit(3600);
        $status = false;
        
        if(Input::file("image")) {
            $name = uniqid() . "." . Input::file('image')->getClientOriginalExtension();
            Input::file('image')->move(Input::get("tmpDir", "images/upload"), $name);
            $status = true;
        }
        return Response::json(array(
            "filename"  =>  $name,
            "filepath"  =>  "/" . Input::get("tmpDir", "images/upload") . "/" . $name,
            "status"    =>  $status,
        ));
    }
    
    
    
    public function postProgress() {
        $num = 0;
        if (Input::get("APC_UPLOAD_PROGRESS", false)) {
            $status = apc_fetch('upload_' . Input::get("APC_UPLOAD_PROGRESS"));
            if (isset($status['current'], $status['total'])) {
                // 進捗計算
                $num = strval(ceil($status['current'] / $status['total'] * 100));
            }
        }
        return $num;
    }
    
    /**
     * $idに紐付く画像ファイルの削除
     * @param type $id
     * @return boolean
     */
    public function postDelete($id = null) {
        $result = false;
        if(!is_null($id) && preg_match("/^\d+$/", $id)) {
            $file = FileData::find($id);
            if(!is_null($file)) {
                $this->imageContentLogic->deleteFileId($id);
                $this->fileLogic->deleteImage($file->key);
                $file->delete();
                $result = true;
            }
        }
        return Response::json(array(
            "result"    =>  $result
        ));
    }
    
}
