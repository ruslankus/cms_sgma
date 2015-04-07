<?php

class MailController extends Controller
{

    public function actionTest()
    {
        if($_POST['send'])
        {
            $to = "maxim@inlu.net";
            $sb = "test mail";
            $text = "this is mail text!";
            mail($to,$sb,$text);
        }
        $this->render('test');
        
    }
}