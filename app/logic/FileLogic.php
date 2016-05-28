<?php

class FileLogic {
    
    
    
    /**
     * @var FileService
     */
    private $fileService;
    
    
    public function __construct() {
        $this->fileService          =   App::make("FileService");
    }
    
    
    
    /**
     * Fileテーブルに紐付く画像関連の登録処理
     */
    public function register() {
        if(Input::get("filePath", false) && file_exists(public_path() . Input::get("filePath"))) {
            $lastInsertFileId = $this->fileService->add(public_path() . Input::get("filePath"));
            Input::merge(array("file_id" => $lastInsertFileId));
        }
    }
    
    
    /**
     * Fileテーブルに紐付く画像関連の更新処理
     */
    public function update() {
        $file_id = Input::get("file_id", false);
        if(Input::get("filePath", false) && file_exists(public_path() . Input::get("filePath"))) {
            if(empty($file_id)) {
                $lastInsertFileId = $this->fileService->add(public_path() . Input::get("filePath"));
            } else {
                $this->fileService->update($file_id, public_path() . Input::get("filePath"));
                $lastInsertFileId = $file_id;
            }
            Input::merge(array("file_id" => $lastInsertFileId));
        } else if(Input::get("remove") === "true" && !empty($file_id)) {
            $this->fileService->delete($file_id);
            Input::merge(array("file_id" => null));
        }
    }
    
    /**
     * 生成された画像ファイルを $key に紐付くものは全て削除
     * @param type $key
     */
    public static function deleteImage($key) {
        $dir = glob(public_path() . "/images/upload/" . $key . "*");
        foreach($dir as $val) {
            unlink($val);
        }
    }
    
    /**
     * 生成された画像ファイルを $key に紐付くものは全て削除
     * @param type $key
     */
    public static function deleteTmpImage($key) {
        $dir = glob(public_path() . "/images/tmp/" . $key . "/*");
        foreach($dir as $val) {
            unlink($val);
        }
    }
}
