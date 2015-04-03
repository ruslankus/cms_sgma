<?php

/**
 * This is the model class for table "news_trl".
 *
 * The followings are the available columns in table 'news_trl':
 * @property integer $id
 * @property string $title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $text
 * @property string $summary
 * @property integer $news_id
 * @property integer $lng_id
 *
 * The followings are the available model relations:
 * @property Languages $lng
 * @property News $news
 */
class NewsTrl extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'news_trl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('news_id, lng_id', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>512),
			array('meta_description, meta_keywords', 'length', 'max'=>256),
			array('text, summary', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, meta_description, meta_keywords, text, summary, news_id, lng_id', 'safe', 'on'=>'search'),
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
			'news' => array(self::BELONGS_TO, 'News', 'news_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'meta_description' => 'Meta Description',
			'meta_keywords' => 'Meta Keywords',
			'text' => 'Text',
			'summary' => 'Summary',
			'news_id' => 'News',
			'lng_id' => 'Lng',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('news_id',$this->news_id);
		$criteria->compare('lng_id',$this->lng_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewsTrl the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
