<?php

/**
 * This is the model class for table "contacts_fields".
 *
 * The followings are the available columns in table 'contacts_fields':
 * @property integer $id
 * @property integer $contacts_id
 * @property integer $label
 *
 * The followings are the available model relations:
 * @property Contacts $contacts
 * @property ContactsFieldsTrl[] $contactsFieldsTrls
 */
class ContactsFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contacts_id, label', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contacts_id, label', 'safe', 'on'=>'search'),
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
			'contacts' => array(self::BELONGS_TO, 'Contacts', 'contacts_id'),
			'contactsFieldsTrls' => array(self::HAS_MANY, 'ContactsFieldsTrl', 'contacts_field_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contacts_id' => 'Contacts',
			'label' => 'Label',
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
		$criteria->compare('contacts_id',$this->contacts_id);
		$criteria->compare('label',$this->label);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}