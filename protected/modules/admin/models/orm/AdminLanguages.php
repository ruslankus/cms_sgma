<?php

/**
 * This is the model class for table "languages".
 *
 * The followings are the available columns in table 'languages':
 * @property integer $id
 * @property string $prefix
 * @property string $name
 * @property string $icon
 * @property integer $priority
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property LabelsTrl[] $labelsTrls
 * @property MessagesTrl[] $messagesTrls
 */
class AdminLanguages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'languages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('priority, status', 'numerical', 'integerOnly'=>true),
			array('prefix, name, icon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, prefix, name, icon, priority, status', 'safe', 'on'=>'search'),
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
			'labelsTrls' => array(self::HAS_MANY, 'AdminLabelsTrl', 'lng_id'),
			'messagesTrls' => array(self::HAS_MANY, 'AdminMessagesTrl', 'lng_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'prefix' => 'Prefix',
			'name' => 'Name',
			'icon' => 'Icon',
			'priority' => 'Priority',
			'status' => 'Status',
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
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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
        ));

        self::$db=$con;
        if(self::$db instanceof CDbConnection)
            return self::$db;
        else
            throw new CDbException('Admin-translation connection is null or initialized with error');
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdminLanguages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
