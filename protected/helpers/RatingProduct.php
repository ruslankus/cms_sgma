<?php
/*
 * Class Rating product
 */
class RatingProduct
{   
    
    private $_total = 0;
    private $_marks_qnt = 0;
    
    public function __construct($id){
        
        $arrData = ExtRating::model()->getProductMarks($id);
        
        if(!empty($arrData)){
            foreach($arrData as $mark => $qnt){
                $this->_total += $mark * $qnt;
                $this->_marks_qnt += $qnt; 
            }
        }      
    }
    
    
    public static function getInstance($id){
        return new self($id);    
    }
    
    
    public function getRating() {
        if($this->_marks_qnt > 0){
            return round($this->_total / $this->_marks_qnt);
        }else{
            return 0;
        }
    }
    
    
    public function getMarksQnt(){
        return $this->_marks_qnt;
    }
    
}    
    
    
    