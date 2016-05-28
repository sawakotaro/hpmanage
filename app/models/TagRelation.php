<?php


class TagRelation extends Eloquent  {

    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'tag_relations';
    

    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function tag() {
        return $this->hasOne('Tag', 'id', 'tag_id');
    }
    
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function movieContent() {
        return $this->hasOne('MovieContent', 'id', 'movie_contents_id');
    }
    
    /**
     * ジョインしたデータを取得します。
     * @return Joinしたデータ
     */
    public function imageContent() {
        return $this->hasOne('ImageContent', 'id', 'image_contents_id');
    }
}
