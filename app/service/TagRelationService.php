<?php

class TagRelationService {
    
    
    /**
     * TAG_RELATIONSテーブルの新規データ挿入
     * @param Array $inputs
     */
    public function add($input) {
        $tagRelation = new TagRelation();
        $tagRelation->tag_id              =   $input["tag_id"];
        $tagRelation->image_contents_id   =   empty($input["image_contents_id"]) ? null : $input["image_contents_id"];
        $tagRelation->movie_contents_id   =   empty($input["movie_contents_id"]) ? null : $input["movie_contents_id"];
        $tagRelation->save();
    }
    
    
    
    /**
     * $tagIdのTAG_RELATIONSテーブルの情報を１件取得します。
     * @param type $tagId
     * @return TagRelation Entity
     */
    public function findByTagId($tagId) {
        return TagRelation::where("tag_id", "=", trim($tagId))->get();
    }
    
    
    
    
    /**
     * 画像コンテンツIDに紐付くタグリレーションを削除します。
     * @param Integer $imageContentsId
     */
    public function deleteByImageContentsId($imageContentsId) {
        TagRelation::where("image_contents_id", "=", $imageContentsId)->delete();
    }
}
