<?php

/**
 * This is the model class for table "pages".
 *
 * The followings are the available columns in table 'pages':
 * @property integer $id
 * @property string $label
 * @property integer $status_id
 * @property integer $type_id
 * @property integer $parent_id
 * @property string $branch
 * @property integer $time_created
 * @property integer $time_updated
 * @property integer $last_change_by
 * @property integer $priority
 *
 * The followings are the available model relations:
 * @property Faq[] $faqs
 * @property MenuToPage[] $menuToPages
 * @property News[] $news
 * @property ContentTypes $type
 * @property PagesTrl[] $pagesTrls
 * @property Products[] $products
 */
class Pages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status_id, type_id, parent_id, time_created, time_updated, last_change_by, priority', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('branch', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, status_id, type_id, parent_id, branch, time_created, time_updated, last_change_by, priority', 'safe', 'on'=>'search'),
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
			'faqs' => array(self::HAS_MANY, 'Faq', 'page_id'),
			'menuToPages' => array(self::HAS_MANY, 'MenuToPage', 'page_id'),
			'news' => array(self::HAS_MANY, 'News', 'page_id'),
			'type' => array(self::BELONGS_TO, 'ContentTypes', 'type_id'),
			'pagesTrls' => array(self::HAS_MANY, 'PagesTrl', 'page_id'),
			'products' => array(self::HAS_MANY, 'Products', 'page_id'),
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
			'type_id' => 'Type',
			'parent_id' => 'Parent',
			'branch' => 'Branch',
			'time_created' => 'Time Created',
			'time_updated' => 'Time Updated',
			'last_change_by' => 'Last Change By',
			'priority' => 'Priority',
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
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('branch',$this->branch,true);
		$criteria->compare('time_created',$this->time_created);
		$criteria->compare('time_updated',$this->time_updated);
		$criteria->compare('last_change_by',$this->last_change_by);
		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
