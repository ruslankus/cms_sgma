<?php

/**
 * This is the model class for table "messages_trl".
 *
 * The followings are the available columns in table 'messages_trl':
 * @property integer $id
 * @property integer $lng_id
 * @property integer $translation_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property Messages $translation
 * @property Languages $lng
 */
class AdminMessagesTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lng_id, translation_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lng_id, translation_id, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'translation' => array(self::BELONGS_TO, 'AdminMessages', 'translation_id'),
			'lng' => array(self::BELONGS_TO, 'AdminLanguages', 'lng_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lng_id' => 'Lng',
			'translation_id' => 'Translation',
			'value' => 'Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('lng_id',$this->lng_id);
		$criteria->compare('translation_id',$this->translation_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getDbConnection()
    {
        $con = Yii::createComponent(array(
            'class' => 'CDbConnection',
            'connectionString' => 'sqlite:'.Yii::app()->getModule('admin')->getBasePath().'/data/translations.db',
            'initSQLs'=>array(
                'PRAGMA foreign_keys = ON',
            ),
        ));

        return $con;
    }
    
    
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdminMessagesTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
