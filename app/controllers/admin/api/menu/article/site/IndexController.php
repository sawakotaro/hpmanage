<?php

namespace admin\api\menu\article\site;

use \Input, \Response, \ArticleSite;

class IndexController extends \BaseController {
    
    
    
    /**
     * 記事サイトのRSS状態を切り替えます。
     * @return json
     */
    public function postSuspended() {
        $result = false;
        
        $posts = Input::all();
        $articleSite = ArticleSite::find($posts['articleSiteId']);
        if($articleSite != null) {
            $articleSite->rss_suspended = $posts['rssSuspended'];
            $articleSite->save();
            $result = true;
        }
        
        return Response::json(array("result" => $result, "rssSuspended" => $posts['rssSuspended']));
    }
}