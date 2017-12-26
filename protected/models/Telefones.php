<?php

/**
 * This is the model class for table "telefones".
 *
 * The followings are the available columns in table 'telefones':
 * @property integer $id
 * @property integer $idaluno
 * @property string $numero
 * @property integer $idoperadora
 *
 * The followings are the available model relations:
 * @property Alunos $idaluno0
 * @property Operadoras $id0
 */
class Telefones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'telefones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idaluno, numero, idoperadora', 'required'),
			array('idaluno, idoperadora', 'numerical', 'integerOnly'=>true),
			array('numero', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idaluno, numero, idoperadora', 'safe', 'on'=>'search'),
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
			'idaluno0' => array(self::BELONGS_TO, 'Alunos', 'idaluno'),
			'id0' => array(self::BELONGS_TO, 'Operadoras', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'idaluno' => 'Idaluno',
			'numero' => 'Numero',
			'idoperadora' => 'Idoperadora',
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
		$criteria->compare('idaluno',$this->idaluno);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('idoperadora',$this->idoperadora);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Telefones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
