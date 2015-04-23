<?php
class ContactsController extends Controller
{
    public function actionShow($id)
    {
        $objCurrLng = SiteLng::lng()->getCurrLng();
        
        $arrData = ExtContactsPage::model()->getContactFull($id, $objCurrLng->prefix);
        Debug::d($arrData);
        $title = ($arrData['content']['title'])? $arrData['content']['title'] : "";  
        if(!empty($title)){
            $this->title = $title;
        }
           
        $description  = ($arrData['content']['description'])? $arrData['content']['description'] : "";  
        //need meta
        //need meta description 
        
        $this->render('contact_page', array('description' => $description, 'title' => $title));   
    }
    
}//    