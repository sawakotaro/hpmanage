<?php

/**
 * {@link SearchForm} のサービスクラスです。
 *
 * @author fid
 * @version 1.0
 */
class SearchFormService  {
    
    /**
     * 1件のIDに紐づくデータを返却します。
     * @param Integer $id プライマリID
     * @return Entity
     */
    public function findById($id) {
        return SearchForm::find($id);
    }
    
    /**
     * 1件のデータを挿入します。
     * @param String $data
     * @return プライマリID
     */
    public function insert($data) {
        $form = new SearchForm();
        $form->data = $data;
        $form->created_at = (new DateTime())->format("Y-m-d H:i:s");
        $form->save();
        return $form->id;
    }

    /**
     * 1件のデータを更新します。
     * @param Integer $id
     * @param String $data
     * @return プライマリID
     */
    public function update($id, $data) {
        $form = SearchForm::find($id);
        $form->data = $data;
        $form->created_at = (new DateTime())->format("Y-m-d H:i:s");
        $form->save();
        return $form->id;
    }

}
