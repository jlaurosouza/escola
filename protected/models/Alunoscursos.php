<?php

/**
 * This is the model class for table "alunoscursos".
 *
 * The followings are the available columns in table 'alunoscursos':
 * @property integer $id
 * @property integer $idaluno
 * @property integer $idcurso
 * @property string $periodo
 * @property integer $idoperador
 * @property string $datahoracriacao
 * @property string $datahoraalteracao
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Usuarios $idoperador0
 * @property Cursos $idcurso0
 * @property Alunos $idaluno0
 */
class Alunoscursos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alunoscursos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('idaluno, idcurso, periodo, idoperador, datahoracriacao, datahoraalteracao', 'required'),
			array('idaluno, idcurso, idoperador', 'numerical', 'integerOnly'=>true),
			array('periodo, status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, idaluno, idcurso, periodo, idoperador, datahoracriacao, datahoraalteracao, status', 'safe', 'on'=>'search'),
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
			'idoperador0' => array(self::BELONGS_TO, 'Usuarios', 'idoperador'),
			'idcurso0' => array(self::BELONGS_TO, 'Cursos', 'idcurso'),
			'idaluno0' => array(self::BELONGS_TO, 'Alunos', 'idaluno'),
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
			'idcurso' => 'Idcurso',
			'periodo' => 'Periodo',
			'idoperador' => 'Idoperador',
			'datahoracriacao' => 'Datahoracriacao',
			'datahoraalteracao' => 'Datahoraalteracao',
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
		$criteria->compare('idaluno',$this->idaluno);
		$criteria->compare('idcurso',$this->idcurso);
		$criteria->compare('periodo',$this->periodo,true);
		$criteria->compare('idoperador',$this->idoperador);
		$criteria->compare('datahoracriacao',$this->datahoracriacao,true);
		$criteria->compare('datahoraalteracao',$this->datahoraalteracao,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Alunoscursos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
