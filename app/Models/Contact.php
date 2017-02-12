<?php

namespace App\Models;

class Contact extends Model
{
  public $table = 'contacts';
  protected $fillable = ['model','model_id','phone_number','fax','email','website','line','person_id'];
  public $timestamps  = false;

  public function fill(array $attributes) {

    if(!empty($attributes)) {

      if(!empty($attributes['phone_number'])) {
        $attributes['phone_number'] = json_encode($attributes['phone_number']);        
      }

      if(!empty($attributes['fax'])) {
        $attributes['fax'] = json_encode($attributes['fax']);        
      }

      if(!empty($attributes['email'])) {
        $attributes['email'] = json_encode($attributes['email']);        
      }

      if(!empty($attributes['website'])) {
        $attributes['website'] = json_encode($attributes['website']);        
      }

      if(!empty($attributes['line'])) {
        $attributes['line'] = json_encode($attributes['line']);        
      }

    }

    return parent::fill($attributes);

  }

  public function __saveRelatedData($model,$options = array()) {

    $contact = $model->getModelRelationData($this->modelName,
      array(
        'first' => true
      )
    );

    if(($model->state == 'update') && !empty($contact)){
      return $contact
      ->fill($options['value'])
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($options['value']))->save();
    }
    
  }

  public function buildModelData() {

    $phoneNumber = '';
    $fax = '';
    $email = '';
    $website = '';
    $line = '';

    if(!empty($this->phone_number)) {
      $phoneNumber = json_decode($this->phone_number);        
    }

    if(!empty($this->['fax'])) {
      $fax = json_decode($this->fax);        
    }

    if(!empty($this->['email'])) {
      $email = json_decode($this->email);        
    }

    if(!empty($this->['website'])) {
      $website = json_decode($this->website);        
    }

    if(!empty($this->['line'])) {
      $line = json_decode($this->line);        
    }

    return array(
      'phone_number' => $phoneNumber,
      'fax' => $fax,
      'email' => $email,
      'website' => $website,
      'line' => $line
    );
  }
  
}
