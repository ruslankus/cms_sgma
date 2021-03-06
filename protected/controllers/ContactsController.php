<?php
class ContactsController extends Controller
{
    public function actions()
    {
        return array(
        // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
             'class'=>'CCaptchaAction',
             'backColor'=>0xFFFFFF,
             'testLimit'=>1
            ),
        );
    }
    
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
        

        $model = new SendContactPageForm();

        $objContactPage = ContactsPage::model()->findByPk($id);

        // check mail form, send mail
        $model->attributes = $_POST['SendContactPageForm'];
        if ($_POST['SendContactPageForm']) {
            // send mail or write db
            if (($model->validate())) {
                // is write to db checked
                if ($objContactPage->save_form) {
                    // is write to db checkeds
                    $objLetter = new Letters();
                    $objLetter->page_id = $id;
                    $objLetter->email = $arrData['content']['email'];
                    $objLetter->email_from = $_POST['SendContactPageForm']['email_from'];
                    $objLetter->name = $_POST['SendContactPageForm']['name'];
                    $objLetter->content = $_POST['SendContactPageForm']['content'];
                    $objLetter->ip = CHttpRequest::getUserHostAddress();
                    $objLetter->created_at = date('Y-m-d H:i:s');
                    if ($objLetter->save()) {
                        Yii::app()->user->setFlash('success', Trl::t()->getLabel('Your message send'));
                    }
                } 
                if($arrData['content']['email']) {
                    // send mail
                    $data = Mailer::sendMail(array($_POST['SendContactPageForm']['name'],'mail_to'=>$arrData['content']['email'], 'name' => $_POST['SendContactPageForm']['name'],'mail_from'=>$_POST['SendContactPageForm']['email_from'],'subject' => Trl::t()->getLabel('New message from page form'),'body' => $_POST['SendContactPageForm']['content']));
                    Yii::app()->user->setFlash('success', $data);

                }
            }
        }

        $this->render('contact_page', array('description' => $description, 'title' => $title,
        'imgs' => $arrData['images'], 'arrBlocks' => $arrBlocks, 'model'=>$model));   
    }
    
}//    