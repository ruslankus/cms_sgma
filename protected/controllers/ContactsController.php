<?php
class ContactsController extends Controller
{
    public function actionShow($id)
    {
        $arrBlocks = array();
            
        $objCurrLng = SiteLng::lng()->getCurrLng();
        
        $arrData = ExtContactsPage::model()->getContactFull($id, $objCurrLng->prefix);
        //$objData = ExtContactsPage::model()->findByPk($id);
        
        
        //contacts block
        foreach($arrData['blocks'] as $items){
            $arrBlocks[$items['block_id']][] = $items; 
        }
     
        
        $title = ($arrData['content']['title'])? $arrData['content']['title'] : "";  
        if(!empty($title)){
            $this->title = $title;
        }
        
        //Debug::d($arrBlocks);
        
        $description  = ($arrData['content']['description'])? $arrData['content']['description'] : "";  
        //need meta
        //need meta description 
        
        $this->render('contact_page', array('description' => $description, 'title' => $title,
        'imgs' => $arrData['images'], 'arrBlocks' => $arrBlocks));   
    }
    
}//    