<?php

class CategoryService {
    
    
    /**
     * 新しく登録されるデータが、parent_idカラム別で何番目の登録のものかをチェックします。
     * @param Integer $parent_id
     * @return Integer
     */
    public function getNextSortIndex($parent_id = null) {
        $max = DB::table('categories')->where("parent_id", "=", $parent_id)->max("sort_index");
        return $max + 1;
    }
    
    
    
    /**
     * $parent_idに紐付くカテゴリリストを返却します。
     * @return Array
     */
    public function fetchByParentId($parent_id = null) {
        $categories = array();
        if(is_null($parent_id)) {
            $categories = Category::whereNull("parent_id")->orderBy("sort_index", "ASC")->get();
        } else {
            $categories = Category::where("parent_id", "=", $parent_id)->orderBy("sort_index", "asc")->get();
        }
        return $categories;
    }
    
    
    /**
     * Categoriesテーブルの新規データ挿入
     * @param Array $inputs
     */
    public function add($inputs) {
        $category = new Category();
        if(empty($inputs['parent_id'])) $inputs['parent_id'] = null;
        $category['parent_id']  =   $inputs['parent_id'];
        $category['name']       =   $inputs['category_name'];
        $category['memo']       =   $inputs['memo'];
        $category['sort_index'] =   $this->getNextSortIndex($category['parent_id']);
        if(!empty($inputs['file_id'])) $category->file_id = $inputs['file_id'];
        
        $category->save();
    }
    
    /**
     * Categoriesテーブルのデータアップデート
     * @param Array $inputs
     */
    public function update($inputs) {
        $category = Category::find($inputs['id']);
        $category['name']           =   $inputs['category_name'];
        if($inputs['memo'])             $category['memo']   =   $inputs['memo'];
        if(!empty($inputs['file_id']))  $category->file_id  =   $inputs['file_id'];
        
        $category->save();
    }
    
    
    
    /**
     * $idのデータを削除します。
     * @param integer $id
     */
    public function delete($id) {
        $category = Category::find($id);
        if(!is_null($category)) {
            $category->delete();
        }
    }
    
    
    /**
     * セレクトボックス形式で、カテゴリデータのリストを再帰的に取得します。
     * @param int $parent_id
     * @param array $list
     * @param int $count
     * @param int $roots_selected
     * @return Array
     */
    public function getCategoryRoots($parent_id = null, $list = array(), $count = null, $roots_selected = null) {
        $categories = $this->fetchByParentId($parent_id);
        if(is_null($count)) $count = 0;
        else                $count++;
        foreach($categories as $category) {
            // デフォルト選択項目の設定
            $category['selected'] = false;
            if(!is_null($roots_selected) && $category['id'] == $roots_selected) $category['selected'] = true;
            $list[$count][] = $category;
        }
        // さらに上階層のカテゴリがあれば、取得します。
        $parent_category = Category::find($parent_id);
        if(!empty($parent_category)) {
            $list = $this->getCategoryRoots($parent_category->parent_id, $list, $count, $parent_id);
        }
        
        return $list;
    }
    
    
}
