<?php
class ContactsController extends Controller
{
    public function actionShow($id)
    {
        $objCurrLng = SiteLng::lng()->getCurrLng();
        
        //$arrData = ExtContactsPage::model()->getContactFull($id, $objCurrLng->prefix);
        $objData = ContactsPage::model()->findByPk($id);
        
        
        Debug::d($objData->contactsBlocks[1]->contactsFields[0]->contactsBlockTrls);
        //Debug::d($arrData);
        $title = ($arrData['content']['title'])? $arrData['content']['title'] : "";  
        if(!empty($title)){
            $this->title = $title;
        }
        
        
           
        $description  = ($arrData['content']['description'])? $arrData['content']['description'] : "";  
        //need meta
        //need meta description 
        
        $this->render('contact_page', array('description' => $description, 'title' => $title, 'imgs' => $arrData['images']));   
    }
    
}//    