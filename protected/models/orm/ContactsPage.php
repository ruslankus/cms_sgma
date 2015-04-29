<?php

/**
 * This is the model class for table "contacts_page".
 *
 * The followings are the available columns in table 'contacts_page':
 * @property integer $id
 * @property string $label
 * @property integer $status_id
 * @property integer $priority
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 * @property string $template_name
 * @property integer $save_form
 *
 * The followings are the available model relations:
 * @property ContactsBlock[] $contactsBlocks
 * @property ContactsPageTrl[] $contactsPageTrls
 * @property ImagesOfContacts[] $imagesOfContacts
 * @property Letters[] $letters
 */
class ContactsPage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts_page';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_id, priority, time_created, time_updated, last_change_by, save_form', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, status_id, priority, time_created, time_updated, last_change_by, template_name, save_form', 'safe', 'on'=>'search'),
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
			'contactsBlocks' => array(self::HAS_MANY, 'ContactsBlock', 'page_id'),
			'contactsPageTrls' => array(self::HAS_MANY, 'ContactsPageTrl', 'page_id'),
			'imagesOfContacts' => array(self::HAS_MANY, 'ImagesOfContacts', 'contact_page_id'),
			'letters' => array(self::HAS_MANY, 'Letters', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'label' => 'Label',
			'status_id' => 'Status',
			'priority' => 'Priority',
			'time_created' => 'Time Created',
			'time_updated' => 'Time Updated',
			'last_change_by' => 'Last Change By',
			'template_name' => 'Template Name',
			'save_form' => 'Save Form',
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
		$criteria->compare('label',$this->label,true);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('last_change_by',$this->last_change_by);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('save_form',$this->save_form);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsPage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
