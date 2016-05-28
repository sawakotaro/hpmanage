<?php


class SiteService {
    
    
    /**
     * 現在設定中のサイト情報を取得します。
     * @return Site entity or null
     */
    public function fetchUseSite() {
        $useSite = Site::where("use", "=", 1)->get()->toArray();
        if(count($useSite) > 0) {
            $site = Site::find($useSite[0]['id']);
            $company    =   $site->company;
            $file       =   $site->file;
            $useSite[0]['company']  =   is_null($company)   ? null : $company->toArray();
            $useSite[0]['file']     =   is_null($file)      ? null : $file->toArray();
            return $useSite[0];
        } else {
            return null;
        }
    }
    
    
    /**
     * 現在設定中ではないサイト情報の一覧を取得します。
     * @return Site entity list
     */
    public function fetchNotUseSiteList() {
        $siteList = Site::where("use", "=", 0)->get()->toArray();
        return $siteList;
    }
    
    
    
    
    /**
     * $siteIdを現在適用中のサイト情報とします。
     * @param integer $siteId
     * @return void
     */
    public function apply($siteId) {
        Site::where("id", "=", $siteId)->update(array("use" => 1));
        Site::where("id", "!=", $siteId)->update(array("use" => 0));
    }
    
    
    /**
     * $siteIdのデータを削除します。
     * @param integer $siteId
     */
    public function delete($siteId) {
        $site = Site::find($siteId);
        if(!is_null($site)) {
            $site->delete();
        }
    }
    
    
    
    
    /**
     * サイト設定を新規追加します。
     * @param array $inputs
     */
    public function add(Array $inputs) {
        $site = new Site();
        $site->name         =   $inputs['site_name'];
        $site->company_id   =   $inputs['company_id'] ?: null;
        $site->domain       =   $inputs['domain'];
        $site->title        =   $inputs['title'];
        $site->keyword      =   $inputs['keyword'];
        $site->description  =   $inputs['description'];
        
        if(!empty($inputs['file_id'])) $site->file_id = $inputs['file_id'];
        
        $site->save();
    }
    
    
        
    /**
     * サイト設定を更新します。
     * @param array $inputs
     */
    public function update(Array $inputs) {
        $site = Site::find($inputs['id']);
        $site->name         =       $inputs['site_name'];
        $site->domain       =       $inputs['domain'];
        $site->company_id   =       $inputs['company_id'] ?: null;
        if($inputs['title'])        $site->title = $inputs['title'];
        if($inputs['keyword'])      $site->keyword = $inputs['keyword'];
        if($inputs['description'])  $site->description = $inputs['description'];
        
        if(!empty($inputs['file_id'])) $site->file_id = $inputs['file_id'];
        
        $site->save();
    }
    
}
