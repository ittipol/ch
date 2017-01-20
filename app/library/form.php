<?php

namespace App\library;

class Form {
  
  private $model;
  private $data = array();
  private $formData = array();

  public function __construct($model = null) {
    $this->model = $model;
  }

  public function setModel($model = null) {
    $this->model = $model;
  }

  public function loadFormData() {

    if(empty($this->model)) {
      return false;
    }

    $modeldNames = $this->model->getModelRelated();

    foreach ($modeldNames as $key => $modelName) {

      if(is_array($modelName)){
        $modelName = $key;
      }

      $this->_getRelatedData($modelName);

    }
  }

  private function _getRelatedData($modelName,$options = array()) {

    switch ($modelName) {
      case 'Address':
        $this->loadAddress();
        break;

      case 'Image':
        $this->loadImage(true);
        break;

      case 'Tagging':
        $this->loadTagging();
        break;

      // case 'OfficeHour':

      //   $officeHour = $this->model->getRalatedModelData('OfficeHour',array(
      //     'first' => true,
      //     'fields' => array('same_time','time')
      //   ));

      //   if(empty($officeHour)){
      //     $this->data['officeHour'] = array();
      //     break;
      //   }

      //   $this->data['sameTime'] = $officeHour->same_time;

      //   $time = json_decode($officeHour->time,true);
      //   $officeHour = array();
      //   foreach ($time as $day => $value) {

      //     $startTime = explode(':', $value['start_time']);
      //     $endTime = explode(':', $value['end_time']);

      //     $officeHour[$day] = array(
      //       'open' => $value['open'],
      //       'start_time' => array(
      //         'hour' => (int)$startTime[0],
      //         'min' => (int)$startTime[1]
      //       ),
      //       'end_time' => array(
      //         'hour' => (int)$endTime[0],
      //         'min' => (int)$endTime[1]
      //       )
      //     );
      //   }

      //   $this->data['officeHour'] = json_encode($officeHour);

      //   break;

      case 'Contact':
        $this->loadContact();
        break;
    }

  }

  public function loadAddress($json = false) {
    $address = $this->model->getRalatedModelData('Address',
      array(
        'first' => true,
        'fields' => array('address','district_id','sub_district_id','description','latitude','longitude')
      )
    );

    if(empty($address)) {
      $address = array();
    }else{

      $geographic['latitude'] = $address->latitude;
      $geographic['longitude'] = $address->longitude;

      $address = array_merge($address->getAttributes(),array(
        'district_name' => $address->district->name,
        'sub_district_name' => $address->subDistrict->name,
        'geographic' => json_encode($geographic)
      ));
    }

    if($json) {
      $address = json_encode($address);
    }

    $this->formData['Address'] = $address;

  }

  public function loadImage($json = false) {

    $images = $this->model->getRalatedModelData('Image',array(
      'fields' => array('model','model_id','filename','description'),
      'first' => false
    ));

    $_images = array();
    if(!empty($images)){
      foreach ($images as $image) {
        $_images[] = array(
          'filename' => $image->filename,
          'description' => $image->description,
          'url' => $image->getImageUrl()
        );
      }
    }

    if($json) {
      $_images = json_encode($_images);
    }

    $this->formData['Image'] = $_images;

  }

  public function loadTagging($json = false) {
    $taggings = $this->model->getRalatedModelData('Tagging',
      array(
        'fields' => array('word_id'),
        'first' => false
      )
    );

    $word = array();
    if(!empty($taggings)) {

      foreach ($taggings as $tagging) {
        $word[] = array(
          'id' =>  $tagging->word->id,
          'name' =>  $tagging->word->word
        );
      }

    }

    if($json) {
      $word = json_encode($word);
    }

    $this->formData['Tagging'] = $word;
  }

  public function loadContact($json = false) {
    $contact = $this->model->getRalatedModelData('Contact',array(
      'first' => true,
      'fields' => array('phone_number','email','website')
    ));

    if(!empty($contact)) {
      $contact = $contact->getAttributes();
    }else{
      $contact = array();
    }

    if($json) {
      $contact = json_encode($contact);
    }

    $this->data['contact'] = $contact;

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
      'fieldData' => $this->data,
      'formData' => array_merge(
        $this->model->getAttributes(),
        $this->formData
      )
    );

    return $data;
  }

}

?>