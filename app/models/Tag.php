<?php


class Tag extends Eloquent  {

    /**
     * モデルで使用されるデータベース
     *
     * @var string
     */
    protected $table = 'tags';


    /**
     * ソフトデリート
     * @var boolean
     */
    protected $softDelete = true; 
    
    
}
