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
    
    public function getSettings($all = false){
        
        $sql  = "SELECT * FROM ".$this->tableName();
        if(!$all){
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