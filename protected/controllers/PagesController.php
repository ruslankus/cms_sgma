<?php 
class PagesController extends Controller
{
    
    public function actionShow($id){
    
        //get page data 
        $arrPage = ExtPageTrl::model()->getPageWithImages($id);
        
        $this->title = $arrPage['title'];
                
        $content = $arrPage['content'];
        foreach($arrPage['images'] as $item){
            $arrImg[] = "<img src='/uploads/images/".$item['filename']."' alt='".$item['caption']."' />"; 
        }
        
        $ratingObj = RatingProduct::getInstance(1);
        
        
        
        $this->render('page',array('content' => $content, 'images' => $arrImg, 'imgs' => $arrPage['images']));
   
    }//action show
    
}//class    