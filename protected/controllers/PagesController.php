<?php 
class PagesController extends Controller
{
    
    public function actionShow($id){
    
        //get page data 
        //$arrPage = ExtPageTrl::model()->getPageWithImages($id);
        $objPage = ExtPage::model()->findByPk($id);
        
        Debug::d($objPage->imagesOfPages[0]->image->trl);
        
        $this->title = $arrPage['title'];
                
        $content = $arrPage['content'];
        
        $ratingObj = RatingProduct::getInstance($id);
        
        //Debug::d($arrPage);
        
        $this->render('page',array('content' => $content, 'imgs' => $arrPage['images']));
   
    }//action show
    
}//class    