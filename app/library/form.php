<?php

namespace App\library;

class Form {
  
  private $model;
  private $data = array();

  public function __construct($model = null) {
    $this->model = $model;
  }

  public function setModel($model = null) {
    $this->model = $model;
  }

  public function loadFieldData($modelName,$options = array()) {
    // $records = Service::loadModel($modelName)->all();
    // $data = array();
    // foreach ($records as $record) {
    //   $data[$options['key']] = $record->{$options['field']};
    // }
    // $this->data[$options['index']] = $data;
  }

  public function district() {
    $records = Service::loadModel('District')->all();
    $districts = array();
    foreach ($records as $district) {
      $districts[$district->id] = $district->name;
    }
    $this->data['districts'] = $districts;
  }

  public function businessEntity() {
    $records = Service::loadModel('BusinessEntity')->all();
    $businessEntities = array();
    foreach ($records as $businessEntity) {
      $businessEntities[$businessEntity->id] = $businessEntity->name;
    }
    $this->data['businessEntities'] = $businessEntities;
  }

    public function employmentType() {
    $employmentTypes = Service::loadModel('EmploymentType')->all();
    $_employmentTypes = array();
    foreach ($employmentTypes as $employmentType) {
      $_employmentTypes[$employmentType->id] = $employmentType->name;
    }
    $this->data['employmentTypes'] = $_employmentTypes;
  }

  public function itemCategory() {
    $records = Service::loadModel('ItemCategory')->all();
    $itemCategories = array();
    foreach ($records as $itemCategory) {
      $itemCategories[$itemCategory->id] = $itemCategory->name;
    }
    $this->data['itemCategories'] = $itemCategories;
  }

  public function realEstateType() {
    $records = Service::loadModel('RealEstateType')->all();
    $realEstateTypes = array();
    foreach ($records as $realEstateType) {
      $realEstateTypes[$realEstateType->id] = $realEstateType->name;
    }
    $this->data['realEstateTypes'] = $realEstateTypes;
  }

  public function announcementType() {
    $records = Service::loadModel('AnnouncementType')->all();
    $realEstateTypes = array();
    foreach ($records as $announcementType) {
      $announcementTypes[$announcementType->id] = $announcementType->name;
    }
    $this->data['announcementTypes'] = $announcementTypes;
  }

  public function set($index,$value) {
    $this->data[$index] = $value;
  }

  public function get($index = '') {

    if(!empty($index) && !empty($this->data[$index])){
      return $this->data[$index];
    }

    return $this->data;
  }

  public function build() {

    if(empty($this->model)) {
      return false;
    }

    $data = array(
      'formModel' => array(
        'id' => $this->model->id,
        'modelName' => $this->model->modelName
      ),
      'fieldData' => $this->data
    );

    return $data;
  }

}

?>