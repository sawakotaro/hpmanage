<?php
/**
 * Description of UserAuthorizationService
 *
 * @author fid
 */
class UserAuthorizationService {
    
    
    /**
     * １件のデータを挿入します。
     * @param array $inputs
     * @return プライマリID
     */
    public function insert(Array $inputs) {
        $authorization = new UserAuthorization();
        $authorization->user_id = $inputs['user_id'];
        $authorization->login_id = $inputs['login_id'];
        $authorization->password = Hash::make($inputs['password']);
        $authorization->save();
        return $authorization->id;
    }
    
    /**
     * 1件のデータを更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $authorization = UserAuthorization::find($inputs['id']);
        $authorization->user_id = $inputs['user_id'];
        $authorization->login_id = $inputs['login_id'];
        $authorization->password = $inputs['password'];
        //$datetime = new DateTime();
        //$user->updated_at = $datetime->format("Y-m-d H:i:s");
        $authorization->save();
    }
    
    
    public function findByUserId($user_id) {
        return UserAuthorization::where('user_id', '=', $user_id)->first();
    }
}
