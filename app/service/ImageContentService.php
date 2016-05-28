<?php


class ImageContentService {
    
    
    
    /**
     * $imageContentIdのデータを削除します。
     * @param integer $siteId
     */
    public function delete($imageContentId) {
        $imageContent = ImageContent::find($imageContentId);
        if(!is_null($imageContent)) {
            $imageContent->delete();
        }
    }
    
    
    
    
    /**
     * 画像コンテンツを新規追加します。
     * @param array $inputs
     */
    public function add($inputs) {
        $imageContent = new ImageContent();
        $imageContent->title            =   $inputs['title'];
        $imageContent->description      =   $inputs['description'] ?: null;
        $imageContent->file_ids         =   $inputs['file_ids'];
        $imageContent->tag_ids          =   $inputs['tag_ids'];
        $imageContent->posted_at        =   $inputs['posted_at'];
        $imageContent->suspended        =   $inputs['suspended'];
        
        $imageContent->save();
        return $imageContent->id;
    }
    
    
        
    /**
     * 記事サイト設定を更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $imageContent = ImageContent::find($inputs['id']);
        $imageContent->title            =   $inputs['title'];
        $imageContent->description      =   $inputs['description'] ?: null;
        $imageContent->file_ids         =   $inputs['file_ids'];
        $imageContent->tag_ids          =   $inputs['tag_ids'];
        $imageContent->posted_at        =   $inputs['posted_at'];
        $imageContent->suspended        =   $inputs['suspended'];
        
        $imageContent->save();
    }
    
    
    /**
     * 画像コンテンツのリストを取得します。
     * @param String $order
     * @param int $limit
     * @return List<ImageContent>
     */
    public function findAllOrderById($order, $limit) {
        return ImageContent::orderBy("created_at", $order)->take($limit)->get();
    }
    
}
