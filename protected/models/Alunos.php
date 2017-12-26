<?php

/**
 * This is the model class for table "alunos".
 *
 * The followings are the available columns in table 'alunos':
 * @property integer $id
 * @property string $nome
 * @property string $cpf
 * @property integer $estado
 * @property integer $cidade
 * @property string $bairro
 * @property string $cep
 * @property string $rua
 * @property string $numero
 * @property string $complemento
 * @property string $email
 * @property integer $idoperador
 * @property string $datahoracriacao
 * @property string $datahoraalteracao
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Estado $estado0
 * @property Usuarios $idoperador0
 * @property Cidade $cidade0
 * @property Alunoscursos[] $alunoscursoses
 * @property Financeiro[] $financeiros
 * @property Telefones[] $telefones
 */
class Alunos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alunos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, cpf, estado, cidade, bairro, cep, rua, numero, idoperador, datahoracriacao, datahoraalteracao', 'required'),
			array('estado, cidade, idoperador', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>100),
			array('cpf', 'length', 'max'=>18),
			array('bairro, rua, complemento', 'length', 'max'=>255),
			array('cep, numero', 'length', 'max'=>10),
			array('email', 'length', 'max'=>50),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, cpf, estado, cidade, bairro, cep, rua, numero, complemento, email, idoperador, datahoracriacao, datahoraalteracao, status', 'safe', 'on'=>'search'),
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
			'estado0' => array(self::BELONGS_TO, 'Estado', 'estado'),
			'idoperador0' => array(self::BELONGS_TO, 'Usuarios', 'idoperador'),
			'cidade0' => array(self::BELONGS_TO, 'Cidade', 'cidade'),
			'alunoscursoses' => array(self::HAS_MANY, 'Alunoscursos', 'idaluno'),
			'financeiros' => array(self::HAS_MANY, 'Financeiro', 'idaluno'),
			'telefones' => array(self::HAS_MANY, 'Telefones', 'idaluno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'cpf' => 'CPF',
			'estado' => 'Estado',
			'cidade' => 'Cidade',
			'bairro' => 'Bairro',
			'cep' => 'Cep',
			'rua' => 'Rua',
			'numero' => 'Número',
			'complemento' => 'Complemento',
			'email' => 'E-mail',
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('cpf',$this->cpf,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('cidade',$this->cidade);
		$criteria->compare('bairro',$this->bairro,true);
		$criteria->compare('cep',$this->cep,true);
		$criteria->compare('rua',$this->rua,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('complemento',$this->complemento,true);
		$criteria->compare('email',$this->email,true);
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
	 * @return Alunos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
