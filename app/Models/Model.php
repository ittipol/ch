<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\library\service;
use App\library\currency;
use App\library\string;
use App\library\form;
use App\library\modelData;
use App\library\paginator;
// use Auth;
use Session;
use Schema;

class Model extends BaseModel
{
  public $modelName;
  public $modelAlias;
  protected $storagePath = 'app/public/';
  protected $state = 'create';
  protected $formModelData = array();
  protected $relatedModel = array();
  protected $sortingFields;
  protected $behavior;
  protected $validation;
  protected $directory = false;
  protected $directoryPath;

  public $form;
  public $modelData;
  public $paginator;

  // protected $imageCache;
  
  public function __construct(array $attributes = []) { 

    parent::__construct($attributes);
    
    $this->modelName = class_basename(get_class($this));
    $this->modelAlias = Service::generateUnderscoreName($this->modelName);
    $this->directoryPath = $this->storagePath.$this->modelAlias.'/';

    $this->form = new Form($this);
    $this->modelData = new ModelData($this);
    $this->paginator = new Paginator($this);

  }

  public static function boot() {

    parent::boot();

    // before saving
    parent::saving(function($model){

      if(!$model->exists){

        $model->state = 'create';

        if((Schema::hasColumn($model->getTable(), 'ip_address')) && (empty($model->ip_address))) {
          $model->ip_address = Service::ipAddress();
        }

        if((Schema::hasColumn($model->getTable(), 'created_by')) && (empty($model->created_by))) {
          $model->created_by = Session::get('Person.id');
        }

        if((Schema::hasColumn($model->getTable(), 'person_id')) && (empty($model->person_id))) {
          $model->person_id = Session::get('Person.id');
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

      $model->saveRelatedData();
   
    });

  }

  // protected function filling(array $attributes) {

  //   if(!empty($attributes) && !empty($this->modelRelated)){
  //     foreach ($this->modelRelated as $key => $modelName) {

  //       if(is_array($modelName)){
  //         $modelName = $key;
  //       }

  //       if(empty($attributes[$modelName])) {
  //         continue;
  //       }

  //       $this->formModelData[$modelName] = $attributes[$modelName];
  //       unset($attributes[$modelName]);
  //     }
  //   }

  //   if(!empty($attributes)) {
  //     foreach ($this->fillable as $field) {

  //       if(empty($attributes[$field]) || is_array($attributes[$field])) {
  //         continue;
  //       }

  //       $attributes[$field] = trim($attributes[$field]);
  //     }
  //   }
    
  //   return $attributes;
  // }

  public function fill(array $attributes) {

    if(!empty($attributes) && !empty($this->modelRelated)){
      foreach ($this->modelRelated as $key => $modelName) {

        // if(is_array($modelName)){
        //   $modelName = $key;
        // }

        if(empty($attributes[$modelName])) {
          continue;
        }

        $this->formModelData[$modelName] = $attributes[$modelName];
        unset($attributes[$modelName]);
      }
    }

    if(!empty($attributes)) {
      foreach ($this->fillable as $field) {

        if(empty($attributes[$field]) || is_array($attributes[$field])) {
          continue;
        }

        $attributes[$field] = trim($attributes[$field]);
      }
    }
    
    return parent::fill($attributes);
  }

  public function saveRelatedData() {

    if (!$this->exists) {
      return false;
    }

    if(!empty($this->formModelData)) {
      
      foreach ($this->formModelData as $modelName => $value) {

        $options = array(
          'value' => $value
        );

        $this->_saveRelatedData($modelName,$options);

      }
    }
    
  }

  private function _saveRelatedData($modelName,$options = array()) {

    $model = Service::loadModel($modelName);

    if(!method_exists($model,'__saveRelatedData')) {
      return false;
    }

    return $model->__saveRelatedData($this,$options);
    
  }

  public function createDirectory() {

    if(empty($this->directory) || empty($this->directoryPath)) {
      return false;
    }

    $path = $this->getDirectoryPath().$this->id;
    if(!is_dir($path)){
      mkdir($path,0777,true);
    }

  }

  public function getDirectoryPath() {

    if(empty($this->directoryPath)) {
      return false;
    }

    return storage_path($this->directoryPath);
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

      if(!empty($options['conditions']['in'])) {

        foreach ($options['conditions']['in'] as $condition) {
          $model = $model->whereIn($condition[0],$condition[1]);
        }

        unset($options['conditions']['in']);

      }

      if(!empty($options['conditions']['or'])) {

        $arrLen = count($options['conditions']['or']);
        for ($i=0; $i < $arrLen; $i++) {
          $images->orWhere(
            $options['conditions']['or'][$i][0],
            $options['conditions']['or'][$i][1],
            $options['conditions']['or'][$i][2]
          );
        }

        unset($options['conditions']['or']);

      }

      if(!empty($options['conditions'])){
        $model = $model->where($options['conditions']);
      }

    }

    if(empty($model->count())) {
      return null;
    }

    if(!empty($options['fields'])){
      $model = $model->select($options['fields']);
    }

    if(!empty($options['order'])){
      $model->orderBy(current($options['order']),next($options['order']));
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

  public function getRalatedData($modelName,$options = array()) {

    $model = Service::loadModel($modelName);
    $field = $this->modelAlias.'_id';

    if(!Schema::hasColumn($model->getTable(), $field)) {
      return false;
    }

    $conditions = array(
      [$field,'=',$this->id],
    );

    if(!empty($options['conditions'])){
      $options['conditions'] = array_merge($options['conditions'],$conditions);
    }else{
      $options['conditions'] = $conditions;
    }

    return $model->getData($options);

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

    if(empty($this->modelRelated)) {
      return null;
    }

    return $this->modelRelated;
  }

  public function getBehavior($modelName) {

    if(empty($this->behavior[$modelName])) {
      return null;
    }

    return $this->behavior[$modelName];
  }

  public function getValidation() {

    if(empty($this->validation)) {
      return null;
    }
    
    return $this->validation;
  }

  public function getFillable() {
    return $this->fillable;
  }

  public function buildModelData() {
    return $this->getAttributes();
  }

  public function paginationData() {
    
    $imageStyle = new ImageStyle;
    $string = new String;

    $image = $this->getRalatedModelData('Image',array(
      'conditions' => array(
        array('image_style_id','=',$imageStyle->getIdByalias('list'))
      ),
      'first' => true
    ));

    $imageUrl = '/images/common/no-img.png';
    if(!empty($image)) {
      $image = $image->buildModelData();
      $imageUrl = $image['_url'];
    }

    return array(
      'id' => $this->id,
      'name' => $this->name,
      '_name_short' => $string->subString($this->name,45),
      '_imageUrl' => $imageUrl
    );
  }

  public function buildFormData() {
    return $this->getAttributes();
  }

  // public function getImageCache() {

  //   if(empty($this->imageCache)) {
  //     return null;
  //   }
    
  //   return $this->imageCache;
  // }

}
