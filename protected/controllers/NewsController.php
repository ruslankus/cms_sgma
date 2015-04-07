<?php 
class NewsController extends Controller
{
    
    public function actionShow($id){
        
        $this->renderText($id);
        
    }//action show
    
}//class    