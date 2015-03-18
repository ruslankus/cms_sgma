<?php
Class AdminLabels extends ExtLabels
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
     * Override default connection
     * @return CDbConnection|null
     * @throws CDbException
     */
    public function getDbConnection()
    {
        $con = Yii::createComponent(array(
            'class' => 'CDbConnection',
            'connectionString' => 'sqlite:'.Yii::app()->getModule('admin')->getBasePath().'/data/translations.db',
//            'connectionString' => 'sqlite:/protected/modules/admin/data/translations.db',
        ));

        self::$db=$con;
        if(self::$db instanceof CDbConnection)
            return self::$db;
        else
            throw new CDbException('Admin-translation connection is null or initialized with error');
    }
}