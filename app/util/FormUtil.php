<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormUtil
 *
 * @author fid
 */
class FormUtil {
    
    
    /**
     * DBから取得したデータ $fetchData からLaravel4 Formクラスに準拠したドロップダウン値の配列を取得します。
     * キーのキー、値のキーの両方が配列に含まれていないと取得しません。
     * @param array $fetchData
     * @param String $keyKey
     * @param String $valueKey
     * @return Dropdown Array Value
     */
    public static function generateDropdownList(Array $fetchData, $keyKey, $valueKey, $firstEmpty = true, $firstEmptyKey = null, $firstEmptyValue = "選択してください") {
        $resultArray = array();
        
        if($firstEmpty === true) {
            $resultArray[$firstEmptyKey] = $firstEmptyValue;
        }
        
        foreach($fetchData as $value) {
            if(array_key_exists($keyKey, $value) && array_key_exists($valueKey, $value)) {
                $resultArray[$value[$keyKey]] = $value[$valueKey];
            }
        }
        
        return $resultArray;
    }
    
    
    
    /**
     * ソートの順番を交換します。
     * @param Object $objectList
     * @param Object $changeObj
     * @param Object $targetObj
     * @param Integer $changeId
     * @param Integer $targetId
     * @param String $type
     */
    public static function changeSortIndex($objectList, $changeObj, $targetObj, $changeId, $targetId, $type, $options = array()) {
        $sort = 0;
        if($type !== "change") {
            foreach($objectList as $value) {
                if($changeId === $value->id) {
                    continue;
                } else if($targetId === $value->id) {
                    switch($type) {
                        case 'before':
                            $changeObj->sort_index = $sort;
                            $changeObj->save();
                            $sort++;
                            $value->sort_index = $sort;
                            $value->save();
                            break;
                        
                        case 'after':
                            $value->sort_index = $sort;
                            $value->save();
                            $sort++;
                            $changeObj->sort_index = $sort;
                            $changeObj->save();
                            break;
                        
                        default: break;
                    }
                } else {
                    $value->sort_index = $sort;
                    $value->save();
                }
                $sort++;
            }
            
        // 順番の交換時
        } else {
            $temporary = $changeObj->sort_index;
            $changeObj->sort_index = $targetObj->sort_index;
            $targetObj->sort_index = $temporary;
            $changeObj->save();
            $targetObj->save();
        }
    }
    
}
