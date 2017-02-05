<?php

namespace App\library;

use Input;

class Form {
  
  private $model;
  private $data = array();
  private $formData = array();

  public function __construct($model = null) {
    $this->model = $model;
  }
  
  public function loadData($options = array()) {

    if(empty($this->model)) {
      return false;
    }

    if(empty($options['json'])) {
      $options['json'] = array();
    }

    if(empty($options['models'])) {
      $options['models'] = array();
    }

    $modeldNames = $this->model->getModelRelations();

    foreach ($modeldNames as $key => $modelName) {

      if($this->model->modelName == $modelName) {
        continue;
      }

      if(!empty($options['models']) && !in_array($modelName, $options['models'])) {
        continue;
      }

      $json = in_array($modelName, $options['json']);

      $this->_getRelatedModelData($modelName,$json);

    }

  }

  private function _getRelatedModelData($modelName,$json = false) {

    $data = array();
    switch ($modelName) {
      case 'Address':
        $data = $this->loadAddress();
        break;

      case 'Image':
        $data = $this->loadImage();
        break;

      case 'Tagging':
        $data = $this->loadTagging();
        break;

      case 'Contact':
        $data = $this->loadContact();
        break;
    }

    if($json) {
      $data = json_encode($data);
    }

    $this->formData[$modelName] = $data; 

  }

  public function loadAddress() {

    $address = $this->model->getModelRelationData('Address',
      array(
        'first' => true,
        'fields' => array('address','province_id','district_id','sub_district_id','description','latitude','longitude'),
        'order' => array('id','DESC')
      )
    );

    if(empty($address)){
      return array();
    }

    return $address->buildFormData();

  }

  public function loadImage() {

    $images = $this->model->getModelRelationData('Image',array(
      'fields' => array('id','model','model_id','filename','description','image_type_id')
    ));

    if(empty($images)){
      return array();
    }

    $_images = array();
    foreach ($images as $image) {
      $_images[] = $image->buildFormData();
    }

    return $_images;

  }

  public function loadTagging() {
    $taggings = $this->model->getModelRelationData('Tagging',
      array(
        'fields' => array('word_id')
      )
    );

    if(empty($taggings)) {
      return array();
    }

    $words = array();
    foreach ($taggings as $tagging) {
      $words[] = $tagging->buildFormData();
    }

    return $words;

  }

  public function loadContact() {
    $contact = $this->model->getModelRelationData('Contact',array(
      'first' => true,
      'fields' => array('phone_number','email','line')
    ));

    if(empty($contact)) {
      return array();
    }

    return $contact->getAttributes();

  }

  // public function loadBranches() {dd($this->model);
  //   $jobToBranch = $this->model->getRalatedData('JobToBranch',array(
  //     'fields' => array('branch_id')
  //   ));

  //   $branches = array();
  //   foreach ($jobToBranch as $value) {
  //     $branches['branch_id'][] = $value->branch->id;
  //   }

  //   return $branches;
  // }

  public function loadFieldData($modelName,$options = array()) {
    $model = Service::loadModel($modelName);

    if(!empty($options['conditions'])){
      $model = $model->where($options['conditions']);
    }

    if(!empty($options['order'])){
      $model = $model->orderBy(current($options['order']),next($options['order']));
    }

    $records = $model->get();

    $data = array();
    foreach ($records as $record) {
      $data[$record->{$options['key']}] = $record->{$options['field']};
    }
    $this->data[$options['index']] = $data;
  }

  // public function shopTo($options = array()) {

  //   $records = Service::loadModel('shopTo')->getData(array(
  //     'conditions' => array(
  //       ['shop_id','=',$options['shopId']],
  //       ['model','=',$options['model']]
  //     ),
  //     'fields' => array('model_id')
  //   ));

  //   $index = lcfirst($options['model']);

  //   $data = array();
  //   foreach ($records as $record) {
  //     $data[$record->{$index}->id] = $record->{$index}->name;
  //   }

  //   if(!empty($options['index'])) {
  //     $index = $options['index'];
  //   }

  //   $this->data[$index] = $data;
  // }

  public function setData($index,$value) {
    $this->data[$index] = $value;
  }

  public function getFieldData() {
    return $this->data;
  }

  public function setFormData($index,$value) {
    $this->formData[$index] = $value;
  }

  public function getFormModel() {
    return array(
      'id' => $this->model->id,
      'modelName' => $this->model->modelName
    );
  }

  public function getFormData() {
    return array_merge(
      $this->model->buildFormData(),
      $this->formData
    );
  }

  public function getOldInput() {

    $oldInput =  array();

    if(!empty(Input::old('Tagging'))) {
      $oldInput['Tagging'] = json_encode(Input::old('Tagging'));
    }

    if(!empty(Input::old('Image'))) {

      foreach (Input::old('Image') as $token => $value) {
        $temporaryFile = Service::loadModel('TemporaryFile');
        $temporaryFile->deleteTemporaryDirectory(Input::old('model').'_'.$token);
        // $temporaryFile->deleteTemporaryRecords($oldInput['model'],$token);
      }

    }

    return $oldInput;
  }

  public function build() {

    return array(
      '_formModel' => $this->getFormModel(),
      '_fieldData' => $this->getFieldData(),
      '_formData' => $this->getFormData(),
      '_oldInput' => $this->getOldInput()
    );

  }

}

?>