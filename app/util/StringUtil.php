<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StringUtil
 *
 * @author fid
 */
class StringUtil {
    
    
    /**
     * $stringの文字列全てを$replaceで変換する
     * @param String $string
     * @param String $replace
     * @return $result
     */
    public static function changeAllForString($string, $replace) {
        $result = "";
        for($i = 0; $i < strlen($string); $i++) {
            $result .= $replace;
        }
        return $result;
    }
    
    /**
     * 空白や改行コードなどを全て削除します。
     * @param string $value
     * @return 置換後の文字列
     */
    public static function replaceSpace($value) {
        return str_replace(array(" ", "　", "\r", "\n", "\r\n"), "", $value);
    }
    
    
    /**
     * 引数で渡された$stringの文字列を$lengthの数だけ末尾を削除します。
     * @param String $string 対象文字列
     * @param integer $length 削除する末尾からの文字数
     * @return String 末尾を削除した文字列
     */
    public static function deleteLastChar($string, $length = 1) {
        return substr($string, 0, -$length);
    }
    
    
    /**
     * 引数で渡された$stringの文字列の末尾 $remove の文字列を削除します。
     * @param type $string 対象文字列
     * @param String $remove 削除対象文字列
     * @return String 末尾を削除した文字列
     */
    public static function deleteLastString($string, $remove) {
        $pos = strrpos($string, $remove);
        if($pos === false) {
            return $string;
        }
        return substr($string, 0, $pos);
    }
}
