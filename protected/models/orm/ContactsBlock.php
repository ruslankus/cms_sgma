<?php

/**
 * This is the model class for table "contacts_block".
 *
 * The followings are the available columns in table 'contacts_block':
 * @property integer $id
 * @property integer $page_id
 * @property string $label
 * @property string $template_name
 * @property string $map_url
 * @property string $map_code
 * @property integer $priority
 * @property integer $time_updated
 * @property integer $time_created
 * @property integer $last_change_by
 *
 * The followings are the available model relations:
 * @property ContactsPage $page
 * @property ContactsBlockTrl[] $contactsBlockTrls
 * @property ContactsFields[] $contactsFields
 */
class ContactsBlock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts_block';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, priority, time_updated, time_created, last_change_by', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('template_name', 'length', 'max'=>256),
			array('map_url', 'length', 'max'=>1024),
			array('map_code', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, page_id, label, template_name, map_url, map_code, priority, time_updated, time_created, last_change_by', 'safe', 'on'=>'search'),
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
			'page' => array(self::BELONGS_TO, 'ContactsPage', 'page_id'),
			'contactsBlockTrls' => array(self::HAS_MANY, 'ContactsBlockTrl', 'block_id'),
			'contactsFields' => array(self::HAS_MANY, 'ContactsFields', 'contacts_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'page_id' => 'Page',
			'label' => 'Label',
			'template_name' => 'Template Name',
			'map_url' => 'Map Url',
			'map_code' => 'Map Code',
			'priority' => 'Priority',
			'time_updated' => 'Time Updated',
			'time_created' => 'Time Created',
			'last_change_by' => 'Last Change By',
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
		$criteria->compare('page_id',$this->page_id);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('template_name',$this->template_name,true);
		$criteria->compare('map_url',$this->map_url,true);
		$criteria->compare('map_code',$this->map_code,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('last_change_by',$this->last_change_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsBlock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
