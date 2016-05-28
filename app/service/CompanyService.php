<?php



class CompanyService {
    
    /**
     * Companiesテーブルの新規データ挿入
     * @param Array $inputs
     */
    public function add($inputs) {
        $company = new Company();
        $company['name']    =   $inputs['company_name'];
        $company['kana']    =   $inputs['company_kana'];
        $company['zipcode'] =   str_replace("-", "", $inputs['zipcode']);
        $company['addr1']   =   $inputs['addr1'];
        $company['addr2']   =   $inputs['addr2'];
        $company['email']   =   $inputs['email'];
        $company['tel']     =   $inputs['tel'];
        $company['detail']  =   $inputs['detail'];
        
        $company->save();
    }
    
    /**
     * Companiesテーブルのデータアップデート
     * @param Array $inputs
     */
    public function update($inputs) {
        $company = Company::find($inputs['id']);
        $company['name']    =   $inputs['company_name'];
        $company['kana']    =   $inputs['company_kana'];
        $company['zipcode'] =   $inputs['zipcode'] ? str_replace("-", "", $inputs['zipcode']) : null;
        $company['addr1']   =   $inputs['addr1'] ?: null;
        $company['addr2']   =   $inputs['addr2'] ?: null;
        $company['email']   =   $inputs['email'] ?: null;
        $company['tel']     =   $inputs['tel'] ?: null;
        $company['detail']  =   $inputs['detail'] ?: null;
        
        $company->save();
    }
    
    
    
    /**
     * $idのデータを削除します。
     * @param integer $id
     */
    public function delete($id) {
        $company = Company::find($id);
        if(!is_null($company)) {
            $company->delete();
        }
    }
}
