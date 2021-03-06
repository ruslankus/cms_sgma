<?php

/**
 * This is the model class for table "contacts_block_trl".
 *
 * The followings are the available columns in table 'contacts_block_trl':
 * @property integer $id
 * @property integer $lng_id
 * @property integer $block_id
 * @property string $text
 * @property string $title
 * @property string $meta_description
 *
 * The followings are the available model relations:
 * @property Languages $lng
 * @property ContactsBlock $block
 */
class ContactsBlockTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contacts_block_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lng_id, block_id', 'numerical', 'integerOnly'=>true),
			array('text, title, meta_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lng_id, block_id, text, title, meta_description', 'safe', 'on'=>'search'),
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
			'lng' => array(self::BELONGS_TO, 'Languages', 'lng_id'),
			'block' => array(self::BELONGS_TO, 'ContactsBlock', 'block_id'),
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
			'block_id' => 'Block',
			'text' => 'Text',
			'title' => 'Title',
			'meta_description' => 'Meta Description',
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
		$criteria->compare('block_id',$this->block_id);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('meta_description',$this->meta_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContactsBlockTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
