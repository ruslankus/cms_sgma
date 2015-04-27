<?php
class ExtSettings extends Settings
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns setting value
     * @param $settingName
     * @return string
     */
    public function getSetting($settingName)
    {
        $setting = self::model()->findByAttributes(array('value_name' => $settingName));
        return $setting->setting;
    }

    /**
     * Returns array of settings
     * @param bool $all
     * @return array
     */
    public function getSettings($all = false){

        $arrSettings = array();
        $sql  = "SELECT * FROM ".$this->tableName();
        if(!$all)
        {
            $sql .= " WHERE `editable`=1";
        }

        $con = $this->dbConnection;
        $data=$con->createCommand($sql)->queryAll();

        foreach($data as $row){
            $arrSettings[$row['value_name']] = $row['setting'];
        }

        return $arrSettings;
    }

}//ExtSettings
?>