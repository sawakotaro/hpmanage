<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConvertUtil
 *
 * @author fid
 */
class ConvertUtil {
    public static function stdClassToArray($obj) {
      if (!is_object($obj) && !is_array($obj)) {
        return $obj;
      }
      $arr = (array)$obj;
      foreach ($arr as $key => $value) {
        unset($arr[$key]);
        $key = str_replace('@', '', $key);
        $arr[$key] = self::stdClassToArray($value);
      }
      return $arr;
    }
}
