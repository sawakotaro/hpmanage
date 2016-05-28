<?php


class ArticleSiteService {
    
    
    
    /**
     * $articleSiteIdのデータを削除します。
     * @param integer $siteId
     * @return integer 削除した件数
     */
    public function delete($articleSiteId) {
        $article_site = ArticleSite::find($articleSiteId);
        $row = 0;
        if(!is_null($article_site)) {
            $row = $article_site->delete();
            if(!is_null($article_site->file_id)) {
                FileData::find($article_site->file_id)->delete();
            }
        }
        return $row;
    }
    
    
    
    /**
     * sort_index順にソートしたリストを返却します。
     * @return ArticleSites
     */
    public function findAllOrderBySortIndx() {
        return ArticleSite::orderBy("sort_index", "asc")->get();
    }
    
    
    
    /**
     * 記事サイト設定を新規追加します。
     * @param array $inputs
     */
    public function add($inputs) {
        $article_site = new ArticleSite();
        $article_site->name             =       $inputs['site_name'];
        $article_site->site_url         =       $inputs['site_url'];
        $article_site->rss_url          =       $inputs['rss_url'] ?: null;
        $article_site->type             =       $inputs['blog_type'];
        $article_site->entry_tag        =       $inputs['entry_tag'] ?: null;
        $article_site->title_tag        =       $inputs['title_tag'] ?: null;
        $article_site->link_tag         =       $inputs['link_tag'] ?: null;
        $article_site->description_tag  =       $inputs['description_tag'] ?: null;
        $article_site->rss_suspended    =       $inputs['rss_suspended'];
        $article_site->sort_index       =       $this->getNextSortIndex();
        if(!empty($inputs['file_id']))  $article_site->file_id = $inputs['file_id'];
        
        $article_site->save();
    }
    
    
        
    /**
     * 記事サイト設定を更新します。
     * @param array $inputs
     */
    public function update($inputs) {
        $article_site = ArticleSite::find($inputs['id']);
        $article_site->name             =       $inputs['site_name'];
        $article_site->site_url         =       $inputs['site_url'];
        $article_site->rss_url          =       $inputs['rss_url'] ?: null;
        $article_site->type             =       $inputs['blog_type'];
        $article_site->entry_tag        =       $inputs['entry_tag'] ?: null;
        $article_site->title_tag        =       $inputs['title_tag'] ?: null;
        $article_site->link_tag         =       $inputs['link_tag'] ?: null;
        $article_site->description_tag  =       $inputs['description_tag'] ?: null;
        $article_site->rss_suspended    =       $inputs['rss_suspended'];
        if(!empty($inputs['file_id']))  $article_site->file_id = $inputs['file_id'];
        
        $article_site->save();
    }
    
    
    
    
    /**
     * $rssSuspendedに紐付く記事サイト情報を全て取得します。
     * @param Integer $suspended
     * @return ArticleSite List
     */
    public function findAllByRssSuspended($rssSuspended) {
        return ArticleSite::where('rss_suspended', '=', $rssSuspended)->orderBy("sort_index", "asc")->get();
    }
    
    
    /**
     * ソート順を変更します。
     * @param Integer $id
     * @param Integer $sortIndex
     */
    public function updateSortIndex($id, $sortIndex) {
        $articleSite = ArticleSite::find($id);
        $articleSite->sort_index = $sortIndex;
        $articleSite->save();
    }
    
    
    
    
    /**
     * 新しく登録されるデータが、何番目の登録のものかをチェックします。
     * @return Integer
     */
    public function getNextSortIndex() {
        $max = $this->fetchMaxCount();
        return is_null($max) ? 0 : $max + 1;
    }
    
    
    /**
     * ソートの現在設定されているMAX値を返却します。
     * @return Integer
     */
    public function fetchMaxCount() {
        return DB::table('article_sites')->max("sort_index");
    }
}
