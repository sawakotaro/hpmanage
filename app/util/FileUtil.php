<?php

class FileUtil {
    
    /**
     * MimeTypeを取得します。
     * ※ php.iniのextension=php_fileinfo.dllを有効にしてください。
     * @param String $path
     * @return MimeType
     */
    public static function getMimeType($path) {
        $contents = file_get_contents($path);
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $contents);
        finfo_close($finfo);
        
        return $mimeType;
    }
    
    
    
    
    /**
     * ファイルサイズを取得します。4GBを超えるものは正しく計測できない場合があります。
     * @param String $path
     * @return integer
     */
    public static function getFileSize($path) {
        return sprintf("%u", filesize($path));
    }
    
    
    /**
     * ファイル内容を取得します。
     * @param String $path
     * @return Contents Data
     */
    public static function getContents($path) {
        return file_get_contents($path);
    }
    
    
    /**
     * ファイルの拡張子を取得します。
     * @param String $path
     * @return 拡張子
     */
    public static function getExtension($path) {
        $info = pathinfo($path);
        return $info['extension'];
    }
    
    
    
    /**
     * ファイルの名前をsha1にかけ、キーに変換します。
     * @param String $path
     * @return ファイルキー
     */
    public static function getFileKey($path) {
        $info = pathinfo($path);
        return sha1($info['filename']);
    }
    
    
    
    /**
     * img src=""に埋め込むファイルパスを取得します。
     * @param String $key
     * @return img src=""に埋め込むファイルパス
     */
    public static function showFile($key) {
        return "/api/file/view/" . $key;
    }
    
    
    /**
     * img src=""に埋め込むリサイズしたファイルパスを取得します。
     * @param String $key
     * @param Array $options
     * @return img src=""に埋め込むファイルパス
     */
    public static function showResizeFile($key, Array $options = array()) {
        $array = array();
        if(count($options) > 0) {
            foreach($options as $_key => $_val) {
                $array[] = $_key . "=" . $_val;
            }
        }
        
        return "/api/file/resize/" . $key . "?" . implode("&", $array);
    }
    
    
    /**
     * 画像のリサイズ処理
     * @param String $path
     * @param Array $options [ "width", "height", "savepath" ]
     * @return boolean 
     */
    public static function resize($path, $options) {
        // GDライブラリのチェック
        if(!extension_loaded("gd"))  return false;
        
        $width      =   !empty($options['width']) ? $options['width'] : null;
        $height     =   !empty($options['height']) ? $options['height'] : null;
        $savepath   =   !empty($options['savepath']) ? $options['savepath'] : null;
        
        // 画像情報を取得
        $result = getimagesize($path);
        list($oldWidth, $oldHeight, $imageType) = $result;
        
        if(is_null($width)) $width = $oldWidth;
        if(is_null($height)) {
            $rate = $width / $oldWidth;	//圧縮比
            $height = intval($rate * $oldHeight);
        }
        
        // 画像のコピーを取得
        switch($imageType) {
            case 1: $im = imagecreatefromgif($path); break;
            case 2: $im = imagecreatefromjpeg($path); break;
            case 3: $im = imagecreatefrompng($path); break;
            default: return false;
        }
        if(!$im) return false;
        
        // コピー先となる空画像の作成
        $newImage = imagecreatetruecolor($width, $height);
        if(!$newImage) {
            imagedestroy($im);
            return false;
        }
        
        // GIF、PNGの場合、透過処理の対応を行う
        if(($imageType == 1) || ($imageType == 3)) {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $width, $height, $transparent);
        }
        
        // コピー画像を指定サイズで作成
        if (!imagecopyresampled($newImage, $im, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight)) {
            // エラー処理
            // 不要な画像リソースを保持するメモリを解放する
            imagedestroy($im);
            imagedestroy($newImage);
            return false;
        }
        
        
        // コピー画像を保存
	// $new_image : 画像データ
	// $new_fname : 保存先と画像名
        // クオリティ
        switch ($imageType) {
            case 1:
                header("Content-Type: image/gif");
                $result = imagegif($newImage, $savepath, 100); break;
            
            case 2:
                header("Content-Type: image/jpeg");
                $result = imagejpeg($newImage, $savepath, 100); break;
            
            case 3: 
                header("Content-Type: image/png");
                $result = imagepng($newImage, $savepath); break;
            default: return false;
        }

        if (!$result) {
            // エラー処理 
	    // 不要な画像リソースを保持するメモリを解放する
            imagedestroy($im);
            imagedestroy($newImage);
            return false;
        }

	// 不要になった画像データ削除
	imagedestroy($im);
        imagedestroy($newImage);
        
        return $result;
    }
    
}