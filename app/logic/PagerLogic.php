<?php

class PagerLogic {
    
    protected $pager;
    protected $url;
    protected $class_name = null;
    protected $id_name    = null;
    protected $carrier;
    
    protected $page_parameter_name = 'page';
    protected $page;
    protected $link1;
    protected $link2;
    protected $next_name;
    protected $prev_name;
    private $onlyNumFlag = false; # trueであれば次へ、前へのリンクを表示させない
    
    const DELTA = 3;
    const LIMIT = 12;
    
    
    
    public static function generatePager($all_count, $page = null , $link1 = null , $link2 = null , $next_name = null , $prev_name = null, $edit=null, $delta=null, $limit = null, $return = true) {
        $pager = new PagerUtil($page, $link1, $link2, $next_name, $prev_name);
        return $pager->makePager($all_count, $edit = null ,$delta = null, $limit = null, $return = true);
    }
    
    /*
     * コンストラクタ
     * ページ数を初期化
     */
    public function __construct($page = null , $link1 = null , $link2 = null , $next_name = null , $prev_name = null)
    {

        if(!empty($link1)){
            $this->link1 = $link1;
        }else{
            $this->link1 = "";
        }
        
        if(!empty($link2)){
            $this->link2 = $link2;
        }else{
            $this->link2 = "";
        }
        
        if(!empty($next_name)){
            $this->next_name = $next_name;
        }else{
            $this->next_name = "次へ";
        }
        
        if(!empty($prev_name)){
            $this->prev_name = $prev_name;
        }else{
            $this->prev_name = "前へ";
        }
        
        if(!empty($page)) {
            $this->page = $page;
            
        } else if(!empty($_GET[$this->page_parameter_name])) {
            $this->page = $_GET[$this->page_parameter_name];

        } else {
            $this->page = 1;
        }
    }
    
    
    


    /*
     * URLのセット
     */
    public function setUrl($url = null){
        
        if(!is_null($url)) {
            $this->url = $url;
        }
    }

    
    public function getUrl()
    {
        return $this->url;
    }
    
    
    
    
    /*
     * スタイルシート　クラスのセット
     */
    public function setCssClass($class_name = null){
        $this->class_name = $class_name;
    }
    
    
    /*
     * スタイルシート　クラス名の取得
     */
    public function getCssClass()
    {
        return $this->class_name;
    }

    
    /*
     * スタイルシート　IDのセット
     */
    public function setCssId($id_name = null){
        $this->id_name = $id_name;
    }
    
    
    
    
    /*
     * スタイルシート　ID名の取得
     */
    public function getCssId()
    {
        return $this->id_name;
    }

    
    
    public function onlyNum()
    {
        $this->onlyNumFlag = true;
    }
    
    //現在のページ番号の取得
    public function getPage(){
        return $this->page;
    }
    

    /*
     * ページャー作成
     * 
     */
    public function makePager($all_count, $edit = null ,$delta = null, $limit = null, $return = true)
    {   
        // URLの取得
        $url = $this->getUrl();
        
        if(!isset($all_count)){
            throw new ItemCountException();
        }
        
        $delta      = (!is_null($delta))? $delta: self::DELTA;	// 現在から前(後)に？個表示するか？
        $perPage    = (!is_null($limit))? $limit: self::LIMIT;	// 1ページ表示件数（前に？件のみで使用）
        $totalPage  = ceil($all_count/$perPage);                // 合計ページ数 $totalPage = ceil($total/$perPage); 
        $page       = $this->page;                              // 最初はページ1
        
        $link1      = $this->link1;
        $link2      = $this->link2;
        $next_name  = $this->next_name;
        $prev_name  = $this->prev_name;
        
        
        if ($page > 1) {
          $this->page = $page - 1;
          $url = $this->url."/".$link1.$this->page.$link2.$edit;
          if($this->onlyNumFlag === false) {
            $this->pager .= "<a href=".$url.">&lt;&lt;{$prev_name}</a> ";
          }
        }
        for ($i = $page - $delta; ($i <= $page + $delta) && ($i <= $totalPage); $i++) {
          if ($i < 1) continue;
          if ($i == $page) {
            $url = $this->url."/".$link1.$page.$link2.$edit;
            $preTag = "<a href='".$url."' class='current' style='pointer-events:none; text-decoration:none;'>";
            $aftTag = "</a> ";
          } else {	
            $this->page = $i;
            $url = $this->url."/".$link1.$this->page.$link2.$edit;
            $preTag = "<a href='".$url."'>";
            $aftTag = "</a> ";
          }
          $this->pager .= $preTag.$i.$aftTag;
        }
        if ($page < $totalPage) {
          $this->page = $page + 1;
          $url = $this->url."/".$link1.$this->page.$link2.$edit;
          
          if($this->onlyNumFlag === false) {
            $this->pager .= "<a href=".$url.">{$next_name}&gt;&gt;</a> ";
          }
        }
        
        
        
        
        //CSSのIDを読み込み -------------------------------------------------------------------------- **
        $id_name    = $this->getCssId();
        $class_name = $this->getCssClass();
        
        $css_id     = '';
        $css_class  = '';
        if(!is_null($id_name) && $id_name) {
            $css_id = 'id="' . $id_name . '"';
        }
        
        if(!is_null($class_name) && $class_name) {
            $css_class = 'class="' . $class_name . '"';
        }
        
        $this->pager = '<div ' . $css_id . ' ' . $css_class . '><p>' . $this->pager . '</p></div>' .PHP_EOL;
        // ------------------------------------------------------------------------------------------ **
        
        
        
        /*
         * $returnがtrueであれば、ページャーを返す
         */
        if($return) {
            return $this->getPager();
        }
        
    }
    
    
  
    
    //ページャー取得
    public function getPager(){ return $this->pager; }
    
    
}



class ItemCountException extends Exception{
    
}