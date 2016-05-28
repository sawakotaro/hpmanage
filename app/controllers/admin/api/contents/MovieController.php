<?php

namespace admin\api\contents;
use \Input, \MovieContent, \Response;
class MovieController extends \BaseController {
    
    /**
     * 動画コンテンツの状態を切り替えます。
     * @return json
     */
    public function postSuspended() {
        $result = false;
        $id = Input::get("id");
        $suspended = Input::get("suspended");
        $movieContents = MovieContent::find($id);
        if($movieContents != null) {
            $movieContents->suspended = $suspended;
            $movieContents->save();
            $result = true;
        }
        
        return Response::json(array("result" => $result, "suspended" => $suspended));
    }
    
}
