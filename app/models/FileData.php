<?php

/**
 * FILEテーブルのModel
 * ※ FILEだとクラス名がバッティングするため
 * namespaceが指定できない
 */

class FileData extends Eloquent {
    
    
    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'files';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
}
