<?php

namespace admin\api\auth;

use \Input, \Response, \AuthMember;

class IndexController extends \BaseController {
    
    
    
    /**
     * 管理アカウントの状態を切り替えます。
     * @param memberId is database table id, suspended is 0 or 1.
     * @return json
     */
    public function postSuspended() {
        $result = false;
        $posts = Input::all();
        $authMember = AuthMember::find($posts['memberId']);
        if($authMember != null) {
            $authMember->suspended = $posts['suspended'];
            $authMember->save();
            $result = true;
        }
        
        return Response::json(array("result" => $result, "suspended" => $posts["suspended"]));
    }
}