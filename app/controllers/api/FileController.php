<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace api;

use \FileData, \Response, \Request, \FileUtil, \Input, \ServerUtil;

class FileController extends \BaseController {
    
    
    const IMAGE_DIRECTORY = "/images/upload";
    
    
    public function getView($key = null) {
        $fileData = FileData::where("key", "=", $key)->get();
        if(is_null($fileData)) {
            return null;
        }
        $file = $fileData->toArray()[0];
        
        $response = Response::make($file['data'], 200);
        $response->header('Content-Type', $file['mime_type']);
        
        return $response;
    }
    
    
    /**
     * 画像のリサイズを行い、表示します。
     * Extensionが渡されたら、その画像がなければファイルに書き出し、静的に表示します。
     * @param type $key
     * @return null
     */
    public function getResize($key) {
        $width      = Input::get("width", null);
        $height     = Input::get("height", null);
        $extension  = Input::get("extension", null);
        $savepath   = Input::get("savepath", null);
        
        // 画像ファイルが存在すれば、それを表示する
        if(!is_null($extension) && strlen($extension) > 0) {
            $fileName = $this->makeFilePath($key, $width, $height, $extension);
            if(file_exists($fileName)) {
                $this->display($fileName);
            }
            if(empty($savepath)) { $savepath = $fileName; }
        }
        
        // データベースに保存されていれば取得
        $fileData = FileData::where("key", "=", $key)->get();
        if(is_null($fileData)) {
            return null;
        }
        $file = $fileData->toArray()[0];
        
        
        FileUtil::resize(Request::root() . FileUtil::showFile($file['key']), array(
            "width"     =>  $width,
            "height"    =>  $height,
            "savepath"  =>  $savepath,
        ));
        
        if(!empty($savepath)) {
            $this->display($savepath);
        }
        exit;
    }
    
    
    /**
     * 画像ファイル名を取得します。
     * @param String $key
     * @param int $width
     * @param int $height
     * @param String $extension
     * @return String
     */
    private function makeFilePath($key, $width, $height, $extension) {
        $dataDir = public_path() . self::IMAGE_DIRECTORY;
        if(!file_exists($dataDir)) {
            mkdir($dataDir, '0777', true);
        }
        return $dataDir . "/" . $key . "_" . $width . "_" . $height . "." . $extension;
    }
    
    
    
    /**
     * 存在する画像ファイルを表示します。
     * @param String $fileName
     */
    private function display($fileName) {
        $extension = substr($fileName, strrpos($fileName, ".") + 1);
        switch ($extension) {
            case "gif":
                header("Content-Type: image/gif");
                break;

            case "jpg":
            case "jpeg":
                header("Content-Type: image/jpeg");
                break;

            case "png": 
                header("Content-Type: image/png");
                break;

            default:
                header("Content-Type: application/octet-stream");
                break;
        }
        echo file_get_contents($fileName);
        exit;
    }
    
}