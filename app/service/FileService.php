<?php


class FileService {
    
    
    /**
     * $idのデータを削除します。
     * @param integer $id
     */
    public function delete($id) {
        $file = FileData::find($id);
        if(!is_null($file)) {
            $this->deleteImage($file->key);
            $file->delete();
        }
    }
    
    /**
     * 生成された画像ファイルを $key に紐付くものは全て削除
     * @param type $key
     */
    public function deleteImage($key) {
        $dir = glob(public_path() . "/images/upload/" . $key . "*");
        foreach($dir as $val) {
            unlink($val);
        }
    }
    
    
    
    /**
     * ファイルデータを新規追加します。
     * @param array $inputs
     * @return FileテーブルID
     */
    public function add($filepath) {
        if(!file_exists($filepath)) return false;
        
        $file = new FileData();
        $file->mime_type    =   FileUtil::getMimeType($filepath);
        $file->size         =   FileUtil::getFileSize($filepath);
        $file->data         =   FileUtil::getContents($filepath);
        $file->extension    =   FileUtil::getExtension($filepath);
        $file->key          =   FileUtil::getFileKey($filepath);
        $file->save();
        return $file->id;
    }
    
    
        
    /**
     * ファイルデータを更新します。
     * @param array $inputs
     * @return FileテーブルID
     */
    public function update($file_id, $filepath) {
        $file = FileData::find($file_id);
        $file->mime_type    =   FileUtil::getMimeType($filepath);
        $file->size         =   FileUtil::getFileSize($filepath);
        $file->data         =   FileUtil::getContents($filepath);
        $file->extension    =   FileUtil::getExtension($filepath);
        $file->key          =   FileUtil::getFileKey($filepath);
        $file->save();
    }
    
}
