<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\library\token;
use App\library\service;
use Auth;
use Session;
use Schema;

class Model extends BaseModel
{
  // public $formToken;
  // public $disk;
  public $modelName;
  public $modelAlias;
  protected $storagePath = 'app/public/';
  protected $state = 'create';
  protected $formModelData;
  protected $relatedModel;
  protected $sortingFields;
  protected $behavior;
  protected $validation;
  protected $directory = false;
  protected $directoryPath;
  
  public function __construct(array $attributes = []) { 

    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    // $this->modelAlias = $this->disk = Service::generateModelDir($this->modelName);
    $this->modelAlias = Service::generateModelDir($this->modelName);
    $this->directoryPath = $this->storagePath.$this->modelAlias.'/';

  }

  public static function boot() {

    parent::boot();

    // before saving
    parent::saving(function($model){

      if(!$model->exists){ // Create new record

        $model->state = 'create';

        if(Schema::hasColumn($model->getTable(), 'ip_address')) {
          $model->ip_address = Service::ipAddress();
        }

        if(Schema::hasColumn($model->getTable(), 'created_by')) {
          $model->created_by = Session::get('Person.id');
        }

      }else{
        $model->state = 'update';
      }

    });

    // after saving
    parent::saved(function($model){

      if(($model->state == 'create') && $model->exists) {
        $model->createDirectory();  

        if($model->behavior['Slug']) {
          $slug = new Slug;
          $slug->__saveRelatedData($model);
        }

      }

      // if($this->behavior['Wiki']){
      //   $wiki = new Wiki;
      //   $wiki->__saveRelatedData($this);
      // }

      $model->saveRelatedData();
   
    });

  }

  protected function filling(array $attributes) {

    if(!empty($attributes) && !empty($this->modelRelated)){
      foreach ($this->modelRelated as $key => $modelName) {

        if(is_array($modelName)){
          $modelName = $key;
        }

        if(empty($attributes[$modelName])) {
          continue;
        }

        $this->formModelData[$modelName] = $attributes[$modelName];
        unset($attributes[$modelName]);
      }
    }

    $attributes = array_map('trim', $attributes);
    
    return $attributes;
  }

  public function fill(array $attributes) {

    // if(!empty($attributes['__token'])) {
    //   $this->formToken = $attributes['__token'];
    //   unset($attributes['__token']);
    // }

    // if(!empty($attributes['wiki'])) {
    //   $this->createWiki = true;
    //   unset($attributes['wiki']);
    // }

    $attributes = $this->filling($attributes);

    return parent::fill($attributes);

  }

  public function saveRelatedData() {

    if (!$this->exists) {
      return false;
    }

    if(!empty($this->formModelData)) {
      
      foreach ($this->formModelData as $modelName => $value) {

        // $options = array_merge($options,array(
        //   'value' => $this->formModelData[$modelName]
        // ));

        $options = array(
          'value' => $value
        );

        $this->_saveRelatedData($modelName,$options);

      }
    }
    
  }

  private function _saveRelatedData($modelName,$options = array()) {

    $model = Service::loadModel($modelName);

    if(!method_exists($model,'__saveRelatedData') || !$model->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $model->__saveRelatedData($this,$options);
    
  }

  public function createDirectory() {

    if(empty($this->directory) || empty($this->directoryPath)) {
      return false;
    }

    $path = storage_path($this->directoryPath).'/'.$this->id;
    if(!is_dir($path)){
      mkdir($path,0777,true);
    }

  }

  public function getDirectory() {

    if(empty($this->directoryPath)) {
      return false;
    }

    return storage_path($this->directoryPath).$this->id.'/';
  }

  public function checkExistById($id) {
    return $this->find($id)->exists();
  }

  public function getIdByalias($alias) {
    
    if(!Schema::hasColumn($this->getTable(), 'alias')){
      return false;
    }

    $record = $this->getData(array(
      'conditions' => array(
        ['alias','like',$alias]
      ),
      'fields' => array('id')
    ));

    return $record->id;
  }

  public function getData($options = array()) {
    $model = $this;

    if(!empty($options['conditions'])){
      $model = $model->where($options['conditions']);
    }

    if(empty($model->count())) {
      return null;
    }

    if(!empty($options['fields'])){
      $model = $model->select($options['fields']);
    }

    if(isset($options['first'])) {
      if($options['first']) {
        return $model->first();
      }
      return $model->get();
    }elseif($model->count() == 1) {
      return $model->first();
    }

    return $model->get();

  }

  public function getRalatedModelData($modelName,$options = array()) {

    $model = Service::loadModel($modelName);

    if(!$model->checkHasFieldModelAndModelId()) {
      return false;
    }

    $conditions = array(
      ['model','like',$this->modelName],
      ['model_id','=',$this->id],
    );

    if(!empty($options['conditions'])){
      $options['conditions'] = array_merge($options['conditions'],$conditions);
    }else{
      $options['conditions'] = $conditions;
    }

    return $model->getData($options);

  }

  public function deleteByModelNameAndModelId($model,$modelId) {

    if(!$this->checkHasFieldModelAndModelId()) {
      return false;
    }

    return $this->where([
      ['model','=',$model],
      ['model_id','=',$modelId],
    ])->delete();

  }

  public function checkHasFieldModelAndModelId() {
    if(Schema::hasColumn($this->getTable(), 'model') && Schema::hasColumn($this->getTable(), 'model_id')) {
      return true;
    }
    return false;
  }

  public function includeModelAndModelId($value) {

    if(empty($this->modelName) || empty($this->id)){
      return false;
    }

    if(!is_array($value)) {
      $value = array($value);
    }

    return array_merge($value,array(
      'model' => $this->modelName,
      'model_id' => $this->id
    ));

  }

  public function getModelRelated() {
    return $this->modelRelated;
  }

  public function getBehavior($modelName) {

    if(empty($this->behavior[$modelName])) {
      return false;
    }

    return $this->behavior[$modelName];
  }

  public function getValidation() {

    if(empty($this->validation)) {
      return false;
    }
    
    return $this->validation;
  }

}
