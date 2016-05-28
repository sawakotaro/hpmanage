<?php

class TagService {
    
    
    /**
     * Tagsテーブルの新規データ挿入
     * @param Array $inputs
     */
    public function add($tagName) {
        $tag = new Tag();
        $tag->name    =   $tagName;
        $tag->save();
        return $tag->id;
    }
    
    
    /**
     * $nameのTAGテーブルの情報を１件取得します。
     * @param type $name
     * @return Tag Entity
     */
    public function findByTagName($name) {
        $tag = Tag::where("name", "=", trim($name))->take(1)->get();
        return (count($tag)) ? $tag[0] : null;
    }
    
}
