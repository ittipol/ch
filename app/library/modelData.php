<?php

namespace App\library;

class ModelData {

	private $model;
	private $data = array();

	public function __construct($model = null) {
	  $this->model = $model;
	}

	// public function setModel($model = null) {
	//   $this->model = $model;
	// }

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

    $modeldNames = $this->model->getModelRelated();

    if(!empty($modeldNames)){

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
        $data = $this->loadContact();
        break;

    }

    if($json) {
      $data = json_encode($data);
    }

    $this->data[$modelName] = $data; 

  }

  public function loadAddress() {

    $address = $this->model->getRalatedModelData('Address',
      array(
        'first' => true,
        'fields' => array('address','province_id','district_id','sub_district_id','description','latitude','longitude'),
        'order' => array('id','DESC')
      )
    );

    if(empty($address)){
      return array();
    }

    return $address->buildModelData();

  }

  public function loadImage() {

    $imageStyle = Service::loadModel('ImageStyle');

    $images = $this->model->getRalatedModelData('Image',array(
      'conditions' => array(
        'in' => array(
          array('image_style_id',array(
            $imageStyle->getIdByalias('original'),
            $imageStyle->getIdByalias('xs')
          ))
        )
      ),
      'fields' => array('id','original_image_id','model','model_id','filename','description','image_style_id'),
      'first' => false
    ));

    if(empty($images)){
      return array();
    }

    $_images = array();
    foreach ($images as $image) {

      $id = $image->original_image_id;
      if(empty($id)) {
        $id = $image->id;
      }

      if(!empty($image->original_image_id)) {
        $_image = $image->buildModelData();
        $_images[$id] = array_merge($_images[$id],array(
          '_'.$image->imageStyle->alias.'_url' => $_image['_url']
        ));

      }else{
        $_images[$id] = $image->buildModelData();
      }

    }

    $images = array();
    foreach ($_images as $image) {
      $images[] = $image;
    }

    return $images;

  }

  public function loadTagging() {
    $taggings = $this->model->getRalatedModelData('Tagging',
      array(
        'fields' => array('word_id'),
        'first' => false
      )
    );

    if(empty($taggings)) {
      return array();
    }

    $words = array();
    foreach ($taggings as $tagging) {
      $words[] = $tagging->buildModelData();
    }

    return $words;

  }

  public function loadContact() {
    $contact = $this->model->getRalatedModelData('Contact',array(
      'first' => true,
      'fields' => array('phone_number','email','line')
    ));

    if(empty($contact)) {
      return array();
    }

    return $contact->getAttributes();

  }

  // public function shopTo($options = array()) {
  //   $shopTo = $this->model->getRalatedModelData('ShopTo',array(
  //     'first' => true,
  //   ));

  //   $shopTo = new ModelData($shopTo->shop);
  //   $shopTo->loadData(array(
  //     'models' => array('Address')
  //   ));
  //   dd($shopTo->build(true));
  // }

  public function set($index,$value) {
    $this->data[$index] = $value;
  }

  public function getModelData() {
    return array_merge(
      $this->model->buildModelData(),
      $this->data
    );
  }

  public function build($onlyData = false) {

    // if(empty($this->model)) {
    //   return false;
    // }

    if($onlyData) {
      return $this->getModelData();
    }

    return array(
      '_modelData' => $this->getModelData()
    );

  }

}