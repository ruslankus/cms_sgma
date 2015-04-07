<?php 
class PagesController extends Controller
{
    
    public function actionShow($id){
        
        $this->renderText($id);
        
    }//action show
    
}//class    