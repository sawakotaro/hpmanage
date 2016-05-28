<?php


class ArticleLogic {
    
    /**
     * @var ArticleSiteService
     */
    private $articleSiteService;
    
    /**
     * @var ArticleService
     */
    private $articleService;
    
    public function __construct() {
        $this->articleSiteService   =   App::make("ArticleSiteService");
        $this->articleService       =   App::make("ArticleService");
    }
    
    
    /**
     * ArticleSitesに登録されている記事サイトから
     * 記事情報を全て取得します。
     */
    public function registerArticleRss() {
        $articleSiteList = $this->articleSiteService->findAllByRssSuspended(0);
        
        if(!is_null($articleSiteList) && count($articleSiteList) > 0) {
            foreach($articleSiteList as $articleSite) {
                $xml = simplexml_load_file ( $articleSite->rss_url );
                $objectArray = array();
                foreach ($xml->{$articleSite->entry_tag} as $value ) {
                    $article = new Article();
                    $article->link              =   $value->{$articleSite->link_tag};
                    $article->title             =   $value->{$articleSite->title_tag};
                    $article->description       =   $value->{$articleSite->description_tag};
                    $article->article_site_id   =   $articleSite->id;

                    if(is_null($this->articleService->findByArticleSiteIdAndLink($article->article_site_id, $article->link))) {
                        array_unshift($objectArray, $article);
                    }
                }
                
                if(count($objectArray) > 0) {
                    foreach($objectArray as $object) $object->save();
                }
            }
        }
    }
    
    
    /**
     * 
     */
    public function findAllArticles() {
        $articleSites = $this->articleSiteService->findAllByRssSuspended(0)->toArray();
        if(count($articleSites) > 0) {
            foreach($articleSites as $key => $sites) {
                $articles = $this->articleService->findByArticleSiteId($sites['id'])->toArray();
                $articleSites[$key]["articles"][] = (count($articles) > 0) ? $articles : array();
            }
        }
        
        return $articleSites;
    }
    
}
