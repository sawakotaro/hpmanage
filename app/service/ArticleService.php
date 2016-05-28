<?php


class ArticleService {
    
    
    
    /**
     * $articleIdのデータを削除します。
     * @param integer $siteId
     */
    public function delete($articleId) {
        $article = Article::find($articleId);
        if(!is_null($article)) {
            $article->delete();
        }
    }
    
    
    
    
    /**
     * 記事サイト設定を新規追加します。
     * @param array $inputs
     */
    public function add(Array $inputs) {
        $article = new Article();
        $article->article_site_id  =   $inputs['article_site_id'];
        $article->category_id      =   $inputs['category_id'] ?: null;
        $article->title            =   $inputs['title'];
        $article->link             =   $inputs['link'];
        $article->description      =   $inputs['description'] ?: null;
        
        $article->save();
    }
    
    
        
    /**
     * 記事サイト設定を更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $article = Article::find($inputs['id']);
        $article->article_site_id  =   $inputs['article_site_id'];
        $article->category_id      =   $inputs['category_id'] ?: null;
        $article->title            =   $inputs['title'];
        $article->link             =   $inputs['link'];
        $article->description      =   $inputs['description'] ?: null;
        
        $article->save();
    }
    
    
    
    /**
     * 記事サイトIDと記事リンクから、データを1件取得します。
     * @param int $article_id
     * @param String $link
     * @return Article
     */
    public function findByArticleSiteIdAndLink($article_site_id, $link) {
        return Article::whereRaw('article_site_id = ? and link = ?', array($article_site_id, $link))->first();
    }
    
    
    
    
    /**
     * 記事サイトIDに紐付いた記事データを取得します。
     * @param int $article_site_id
     * @return Article
     */
    public function findByArticleSiteId($article_site_id) {
        return Article::where("article_site_id", "=", $article_site_id)->orderBy("id", "desc")->orderBy("created_at", "desc")->get();
    }
}
