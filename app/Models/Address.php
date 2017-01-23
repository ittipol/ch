<?php

namespace App\Models;

class Address extends Model
{
  protected $table = 'addresses';
  protected $fillable = ['model','model_id','address','province_id','district_id','sub_district_id','description','latitude','longitude'];

  public function __construct() {  
    parent::__construct();
  }

  public function province() {
    return $this->hasOne('App\Models\Province','id','province_id');
  }

  public function district() {
    return $this->hasOne('App\Models\District','id','district_id');
  }

  public function subDistrict() {
    return $this->hasOne('App\Models\SubDistrict','id','sub_district_id');
  }

  public function __saveRelatedData($model,$options = array()) {

    $address = $model->getRalatedModelData($this->modelName,
      array(
        'first' => true
      )
    );

    $options['value'] = array_merge($options['value'],array(
      'province_id' => 9
    ));

    if(($model->state == 'update') && !empty($address)){
      return $address
      ->fill($options['value'])
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($options['value']))->save();
    }
    
  }

  public function buildModelData() {

    if(empty($this)) {
      return null;
    }
    
    $geographic = array();
    if(!empty($this->latitude) && !empty($this->latitude)) {
      $geographic['latitude'] = $this->latitude;
      $geographic['longitude'] = $this->longitude;
    }

    $fullAddress = '';
    if(!empty($this->subDistrict->name)) {
      $fullAddress .= ' ต.'.$this->subDistrict->name;
    }

    if(!empty($this->district->name)) {
      $fullAddress .= ' อ.'.$this->district->name;
    }

    if(!empty($this->province->name)) {
      $fullAddress .= ' จ.'.$this->province->name;
    }

    return array(
      'address' => $this->address,
      'description' => $this->description,
      '_province_name' => $this->province->name,
      '_district_name' => $this->district->name,
      '_sub_district_name' => $this->subDistrict->name,
      '_full_address' => trim($fullAddress),
      '_geographic' => json_encode($geographic)
    );
    
  }

}
