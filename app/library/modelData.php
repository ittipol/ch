<?php

namespace App\library;

class ModelData {

	private $model;
	private $data = array();

	public function __construct($model = null) {
	  $this->model = $model;
	}

	public function setModel($model = null) {
	  $this->model = $model;
	}

	  public function loadData() {

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
        'fields' => array('address','province_id','district_id','sub_district_id','description','latitude','longitude')
      )
    );

    if(empty($address)) {
      $address = array();
    }else{

      $geographic['latitude'] = $address->latitude;
      $geographic['longitude'] = $address->longitude;

      $address = array_merge($address->getAttributes(),array(
        'province_name' => $address->province->name,
        'district_name' => $address->district->name,
        'sub_district_name' => $address->subDistrict->name,
        'geographic' => json_encode($geographic)
      ));
    }

    if($json) {
      $address = json_encode($address);
    }

    $this->data['Address'] = $address;

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

    $this->data['Image'] = $_images;

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

    $this->data['Tagging'] = $word;
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

    $this->data['Contact'] = $contact;

  }

  public function set($index,$value) {
    $this->data[$index] = $value;
  }

  public function build() {

    if(empty($this->model)) {
      return false;
    }

    $data = array(
      'modelData' => array_merge(
        $this->model->getAttributes(),
        $this->data
      )
    );

    return $data;
  }

}