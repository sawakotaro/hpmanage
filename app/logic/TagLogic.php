<?php

class TagLogic {
    
    /**
     * カンマ区切りタグIDを、カンマ区切りのタグ名に変換します。
     * @param type $tagIds
     * @return type
     */
    public function convertTagData($tagIds) {
        $tagIdArray = explode(",", $tagIds);
        $tagNameArray = array();
        if(count($tagIdArray) > 0) {
            foreach($tagIdArray as $value) {
                $tagObj = Tag::find($value);
                if(!is_null($tagObj)) {
                    $tagNameArray[] = $tagObj->name;
                }
            }
        }
        return implode(",", $tagNameArray);
    }
}
