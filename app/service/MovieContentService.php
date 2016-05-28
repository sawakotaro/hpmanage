<?php


class MovieContentService {
    
    
    
    /**
     * $movieContentIdのデータを削除します。
     * @param integer $movieContentId
     */
    public function delete($movieContentId) {
        $movieContent = MovieContent::find($movieContentId);
        if(!is_null($movieContent)) {
            $movieContent->delete();
        }
    }
    
    
    
    
    /**
     * 画像コンテンツを新規追加します。
     * @param array $inputs
     */
    public function add($inputs) {
        $movieContent = new MovieContent();
        $movieContent->title            =   $inputs['title'];
        $movieContent->description      =   $inputs['description'] ?: null;
        $movieContent->movie_script_tag =   $inputs['movieScriptTag'];
        $movieContent->posted_at        =   $inputs['posted_at'];
        $movieContent->suspended        =   $inputs['suspended'];
        
        $movieContent->save();
        return $movieContent->id;
    }
    
    
        
    /**
     * 記事サイト設定を更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $movieContent = MovieContent::find($inputs['id']);
        $movieContent->title            =   $inputs['title'];
        $movieContent->description      =   $inputs['description'] ?: null;
        $movieContent->movie_script_tag =   $inputs['movieScriptTag'];
        $movieContent->posted_at        =   $inputs['posted_at'];
        $movieContent->suspended        =   $inputs['suspended'];
        
        $movieContent->save();
    }
    
    
    /**
     * 画像コンテンツのリストを取得します。
     * @param String $order
     * @param int $limit
     * @return List<MovieContent>
     */
    public function findAllOrderById($order, $limit) {
        return MovieContent::orderBy("created_at", $order)->take($limit)->get();
    }
    
}
