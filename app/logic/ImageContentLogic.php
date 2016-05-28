<?php

class ImageContentLogic {
    
    private $tempFilePath = array();
    
    /**
     * 画像コンテンツリストからファイルとファイル数を取得する
     * @param List $imageContentList
     * @return List
     */
    public function getFileOfImageContentList($imageContentList) {
        foreach($imageContentList as $key => $value) {
            $filesArray = explode(",", $value['file_ids']);
            $imageContentList[$key]["fileNum"] = count($filesArray);
            $imageContentList[$key]["file"]    = !empty($filesArray[0]) ? FileData::find($filesArray[0]) : null;
        }
        
        return $imageContentList;
    }
    
    
    /**
     * 関連付けられている画像ファイルを全て取得します。
     * @param ImageContent $imageContent
     */
    public function getFileOfImageContent($imageContent) {
        $filesArray = explode(",", $imageContent['file_ids']);
        $imageContent['fileNum'] = count($filesArray);
        $files = array();
        foreach($filesArray as $value) {
            $file = FileData::find($value);
            if(!is_null($file)) {
                $files[] = $file;
            }
        }
        
        $imageContent["file"] = $files;
        
        return $imageContent;
    }
    
    /**
     * 画像コンテンツの一時ファイルアップロード
     * @param type $images
     * @param type $tmpDir
     * @return array or boolean
     */
    public function moveTempDirectoryByUploadImage($images, $tmpDir) {
        if(empty($images) || !count($images)) return false;
        $this->tempFilePath = array();
        foreach($images as $image) {
            if(is_null($image)) continue;
            $extension = $image->getClientOriginalExtension();
            if(strtolower($extension) === 'bmp') continue;
            $uniqid = uniqid();
            try {
                $image->move($tmpDir, $uniqid . "." . $extension);
                $this->tempFilePath[] = str_replace(public_path(), "", $tmpDir . "/" . $uniqid . "." . $extension);
            } catch(Exception $e) {}
        }
        
        return true;
    }
    
    /**
     * 最後に移動したファイルパスを取得
     * @return Array
     */
    public function getPathOfLastMoveTempfile() {
        return $this->tempFilePath;
    }
    
    
    
    
    /**
     * 画像がひとつでもアップロードされているかどうかチェックします。
     * @param array $images
     * @return boolean
     */
    public function isUploadImages(Array $images) {
        $isUploaded = false;
        foreach($images as $value) {
            if(!empty($value)) {
                $isUploaded = true;
                break;
            }
        }
        return $isUploaded;
    }
    
    
    /**
     * ファイル削除に伴い、ファイルIDをカラムから除外します。
     * @param type $fileId
     * @return void
     */
    public function deleteFileId($fileId) {
        $data = DB::select("select * from image_contents where find_in_set(?, file_ids)", array($fileId));
        if(count($data) > 0) {
            foreach($data as $value) {
                $array = explode(",", $value->file_ids);
                if(($key = array_search($fileId, $array)) !== false) {
                    unset($array[$key]);
                    $value->file_ids = implode(",", $array);
                    DB::update("update image_contents set file_ids = ? where id = ?", array($value->file_ids, $value->id));
                }
            }
        }
    }
}