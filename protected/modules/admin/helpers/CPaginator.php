<?php

class CPaginator
{
    private $_array = array(); //array of items
    private $_limit = 0; //on one page
    private $_total_pages = 0; //count of pages
    private $_current_page = 0; //selected page
    
    private static $_instance = false;
    
    public static function getInstance($arr = null,$on_page = 3,$current_page = 1){
        if(!self::$_instance && $arr !== null){
            self::$_instance = new self($arr,$on_page,$current_page);
        }
        return self::$_instance;
    }

    /**
     * Constructor for pager
     * @param array $arr
     * @param int $on_page
     * @param int $current_page
     */
    private function __construct($arr,$on_page,$current_page)
    {
        $this->_array = $arr;
        $this->_limit = $on_page;
        $this->_total_pages = (int)ceil(count($this->_array)/$this->_limit);
        $this->_current_page = $current_page;
      
    }
    
    private function __clone(){}
    
    public function getPreparedArray($preserve_keys = true)
    {
        $offset = (int)($this->_limit * ($this->_current_page - 1));
        return array_slice($this->_array,$offset,$this->_limit,$preserve_keys);
    }
    
    public function getTotalPages(){
        return $this->_total_pages;
    }
    
    public function getPerPage(){
        return $this->_limit;
    }

    public function getCurrentPage()
    {
        return $this->_current_page;
    }

    public function getNextPage(){
        return $this->_current_page + 1;
    }
    
    Public function getPreviousPage(){
        return $this->_current_page - 1;
    }
    
    public function hasNextPage(){
        return ($this->getNextPage() <= $this->_total_pages)? true : false;
    }
    
    public function hasPreviousPage(){
        return ($this->getPreviousPage() >= 1) ? true : false;
    }
    
  
    
}//Cpagenator