<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $id
 * @property string $label
 * @property string $filename
 * @property string $original_filename
 * @property string $mime_type
 * @property integer $size
 * @property integer $status_id
 *
 * The followings are the available model relations:
 * @property Status $status
 * @property ImagesOfComplexPage[] $imagesOfComplexPages
 * @property ImagesOfComplexPageFieldValues[] $imagesOfComplexPageFieldValues
 * @property ImagesOfContacts[] $imagesOfContacts
 * @property ImagesOfNews[] $imagesOfNews
 * @property ImagesOfPage[] $imagesOfPages
 * @property ImagesOfProduct[] $imagesOfProducts
 * @property ImagesOfProductFieldsValues[] $imagesOfProductFieldsValues
 * @property ImagesOfTags[] $imagesOfTags
 * @property ImagesOfWidget[] $imagesOfWidgets
 * @property ImagesTrl[] $imagesTrls
 */
class Images extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('size, status_id', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('filename, original_filename', 'length', 'max'=>1024),
			array('mime_type', 'length', 'max'=>64),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, label, filename, original_filename, mime_type, size, status_id', 'safe', 'on'=>'search'),
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
			'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
			'imagesOfComplexPages' => array(self::HAS_MANY, 'ImagesOfComplexPage', 'image_id'),
			'imagesOfComplexPageFieldValues' => array(self::HAS_MANY, 'ImagesOfComplexPageFieldValues', 'image_id'),
			'imagesOfContacts' => array(self::HAS_MANY, 'ImagesOfContacts', 'image_id'),
			'imagesOfNews' => array(self::HAS_MANY, 'ImagesOfNews', 'image_id'),
			'imagesOfPages' => array(self::HAS_MANY, 'ImagesOfPage', 'image_id'),
			'imagesOfProducts' => array(self::HAS_MANY, 'ImagesOfProduct', 'image_id'),
			'imagesOfProductFieldsValues' => array(self::HAS_MANY, 'ImagesOfProductFieldsValues', 'image_id'),
			'imagesOfTags' => array(self::HAS_MANY, 'ImagesOfTags', 'image_id'),
			'imagesOfWidgets' => array(self::HAS_MANY, 'ImagesOfWidget', 'image_id'),
			'imagesTrls' => array(self::HAS_MANY, 'ImagesTrl', 'image_id'),
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
			'filename' => 'Filename',
			'original_filename' => 'Original Filename',
			'mime_type' => 'Mime Type',
			'size' => 'Size',
			'status_id' => 'Status',
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
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('original_filename',$this->original_filename,true);
		$criteria->compare('mime_type',$this->mime_type,true);
		$criteria->compare('size',$this->size);
		$criteria->compare('status_id',$this->status_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
