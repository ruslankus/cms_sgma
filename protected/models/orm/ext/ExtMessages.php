<?php

Class ExtMessages extends Messages
{
    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns array of labels
     * @param $currLng
     * @return array
     */
    public function getLabels($currLng) {

        $arrLabels = array();
        $sql = "SELECT t1.label , t2.value FROM messages t1 JOIN messages_trl t2 ON t2.translation_id = t1.id
        JOIN languages t3 ON t2.lng_id = t3.id WHERE t3.prefix = :prefix";
        $params[':prefix'] = $currLng;
        $con = $this->dbConnection;
        $data=$con->createCommand($sql)->queryAll(true,$params);

        foreach($data as $row){
            $arrLabels[$row['label']] = $row['value'];
        }

        return $arrLabels;
    }

    /**
     * Adds label
     * @param $label
     * @param $arrLng
     * @return bool
     */
    public function addMessage($label,$arrLng){

        $sql = "INSERT INTO messages ('label') VALUES (:label)";

        $sql_param[':label'] = $label;

        $con = $this->dbConnection;
        $con->createCommand($sql)->execute($sql_param);
        $labelId = $con->getLastInsertID('messages');

        $sql = "INSERT INTO messages_trl ('translation_id', 'lng_id', 'value') VALUES ";

        foreach($arrLng as $key => $lng){
            if($key == 0){
                $sql .= "($labelId, {$lng['id']}, '')";
            }else{
                $sql .= ",($labelId, {$lng['id']}, '')";
            }
        }

        $con->createCommand($sql)->execute();
        $labelTrl[] = $con->getLastInsertID('messages_trl');

        return true;
    }

    /**
     * Deletes message
     * @param $id
     * @return bool
     */
    public function deleteMessage($id){
        $sql = "PRAGMA foreign_keys = ON";

        $con = $this->dbConnection;
        $con->createCommand($sql)->execute();

        $sql = "DELETE FROM messages
                WHERE id = ".(int)$id;

        $con->createCommand($sql)->execute();

        return true;
    }
}