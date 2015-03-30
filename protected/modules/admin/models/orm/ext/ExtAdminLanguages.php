<?php
Class ExtAdminLanguages extends AdminLanguages
{

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
    	return parent::model($className);
    }
    
    public function selectArray(){
        $sql = "SELECT t1.prefix,t1.name FROM languages t1";
        
        $con = $this->dbConnection;
        $arrData = $con->createCommand($sql)->queryAll();
        //$retData[''] = Trl::t()->getLabel('Select language');
       
        foreach($arrData as $item){
            $retData[$item['prefix']] = $item['name'];       
        }
        
        return $retData;       
    }//selectArray
    
    public function getAllLang(){
       $sql = "SELECT * FROM languages";
       
       $con = $this->dbConnection;
       $retData = $con->createCommand($sql)->queryAll();
       
       return $retData;
    } 
    
    public function writeTrl($new_lang_name,$new_lang_prefix)
    {
        $con = $this->dbConnection;
        
        $transaction = $con->beginTransaction();
        try{
        
            /*
            $model = new AdminLanguages();
            $model->name =  $new_lang_name;
            $model->prefix =  $new_lang_prefix;
            $save = $model->save();
            $lang_id=$model->id;
            */

            $sql_lang = "INSERT INTO languages (`name`, `prefix`) VALUES ('{$new_lang_name}', '{$new_lang_prefix}')";
            $con->createCommand($sql_lang)->execute();
            $lang_id = $con->getLastInsertID('languages');

            $arrLabels = AdminLabels::model()->findAll();
            $arrMessages = ExtAdminMessages::model()->findAll();

            foreach($arrLabels as $label):
                $label_id = $label->id;
                $sql_labels  = "INSERT INTO labels_trl (`lng_id`, `translation_id`) VALUES ({$lang_id}, {$label_id})";
                $con->createCommand($sql_labels)->execute();
            endforeach;

            /*
            $sql_labels  = "INSERT INTO labels_trl (`lng_id`, `translation_id`) ";
            $sql_labels .= "VALUES ";       
            $i=0;
            foreach($arrLabels as $label):
                //$label_id .= "id=".$label->id." | label".$label->label."<br>";
                $label_id = $label->id;
                if($i == 0){
                    $sql_labels .= "({$lang_id}, {$label_id}) ";
                }else{
                     $sql_labels .= ",({$lang_id}, {$label_id}) ";
                } 
                $i++;
            endforeach;
            $con->createCommand($sql_labels)->execute();
            */

            foreach($arrMessages as $message):
                $message_id = $message->id;
                $sql_messages  = "INSERT INTO messages_trl (`lng_id`, `translation_id`) VALUES ({$lang_id}, {$message_id})";
                $con->createCommand($sql_messages)->execute();
            endforeach;

            /*
            $sql_messages  = "INSERT INTO messages_trl (`lng_id`, `translation_id`) ";
            $sql_messages .= "VALUES ";       
            $i=0;
            foreach($arrMessages as $message):
                $message_id = $message->id;
                if($i == 0){
                    $sql_messages .= "({$lang_id}, {$message_id}) ";
                }else{
                     $sql_messages .= ",({$lang_id}, {$message_id}) ";
                } 
                $i++;
            endforeach;
            $con->createCommand($sql_messages)->execute();
            */
        
            $transaction->commit();
            return true; 
        }catch(Exception $e){
            $transaction->rollback();
            return false;
        }
        
    }
}    