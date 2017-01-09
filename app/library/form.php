<?php

namespace App\library;

class Form {
  
  private $model;
  private $data;

  public function __construct($model = null) {
    $this->model = $model;
    // $this->data[lcfirst($this->model->modelName)] = $this->model->getAttributes();
  }

  public function setModel($model = null) {
    $this->model = $model;
  }

  public function getRelatedData($relatedModel = array()) {
    foreach ($relatedModel as $key => $modelName) {

      if(is_array($modelName)){
        $modelName = $key;
      }

      $this->_getRelatedData($modelName);

    }
  }

  private function _getRelatedData($modelName,$options = array()) {

    switch ($modelName) {
      case 'Address':
        $address = $this->model->getRalatedModelData('Address',
          array(
            'first' => true,
            'fields' => array('address','district_id','sub_district_id','description','lat','lng')
          )
        );

        if(empty($address)) {
          $this->data['address'] = array();
          $this->data['geographic'] = json_encode(array());
          break;
        }

        $geographic = array();
        if(!empty($address['lat']) && !empty($address['lng'])) {
          $geographic['lat'] = $address['lat'];
          $geographic['lng'] = $address['lng'];
        }

        $this->data['address'] = $address->getAttributes();
        $this->data['geographic'] = json_encode($geographic);

        break;

      case 'Tagging':
        $taggings = $this->model->getRalatedModelData('Tagging',
          array(
            'fields' => array('word_id')
          )
        );

        if(empty($taggings)){
          $this->data['taggings'] = json_encode(array());
          break;
        }

        $word = array();
        foreach ($taggings as $tagging) {
          $word[] = array(
            'id' =>  $tagging->word->id,
            'name' =>  $tagging->word->word
          );
        }
        
        $this->data['taggings'] = json_encode($word);

        break;

      case 'OfficeHour':

        $officeHour = $this->model->getRalatedModelData('OfficeHour',array(
          'first' => true,
          'fields' => array('same_time','time')
        ));

        if(empty($officeHour)){
          $this->data['officeHour'] = array();
          break;
        }

        $this->data['sameTime'] = $officeHour->same_time;

        $time = json_decode($officeHour->time,true);
        $officeHour = array();
        foreach ($time as $day => $value) {

          $startTime = explode(':', $value['start_time']);
          $endTime = explode(':', $value['end_time']);

          $officeHour[$day] = array(
            'open' => $value['open'],
            'start_time' => array(
              'hour' => (int)$startTime[0],
              'min' => (int)$startTime[1]
            ),
            'end_time' => array(
              'hour' => (int)$endTime[0],
              'min' => (int)$endTime[1]
            )
          );
        }

        $this->data['officeHour'] = json_encode($officeHour);

        break;

      case 'Contact':

        $contact = $this->model->getRalatedModelData('Contact',array(
          'first' => true,
          'fields' => array('phone_number','email','website','facebook','instagram','line')
        ));

        if(empty($contact)) {
          $this->data['contact'] = array();
          break;
        }

        $this->data['contact'] = $contact->getAttributes();

        break;

    }

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
    $records = BusinessEntity::all();
    $businessEntities = array();
    foreach ($$records as $businessEntity) {
      $businessEntities[$businessEntity->id] = $businessEntity->name;
    }
    $this->data['businessEntities'] = $businessEntities;
  }

  public function set($index,$value) {
    $this->data[$index] = $value;
  }

  public function get() {
    return $this->data;
  }

  public function clear() {
    $this->data = null;
  }

}

?>