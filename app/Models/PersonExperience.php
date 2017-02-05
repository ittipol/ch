<?php

namespace App\Models;

use App\library\date;

class PersonExperience extends Model
{
  protected $table = 'person_experiences';
  protected $fillable = ['person_id','name','gender','birth_date','private_websites','active'];
  protected $modelRelated = array('Image','Address','Contact');
  protected $directory = true;
  protected $imageCache = array('profile-image-xs');

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      'birth_date' => 'required|date_format:Y-m-d'
    )
  ); 

  public function getByPersonId() {
    return $this->where('person_id','=',session()->get('Person.id'))->first();
  }

  public function checkExistByPersonId() {
    return $this->where('person_id','=',session()->get('Person.id'))->exists();
  }

  public function fill(array $attributes) {

    if(!empty($attributes)) {
      $attributes['private_websites'] = json_encode($attributes['private_websites']);
    }

    return parent::fill($attributes);

  }

  public function buildModelData() {

    $date = new Date;

    $gender = '-';
    if(!empty($this->gender)) {

    }

    $birthDate = '-';
    if(!empty($this->birth_date)) {
      $date->covertDateToSting($this->birth_date);
    }

    return array(
      'id' => $this->id,
      'name' => $this->name,
      'gender' => $gender,
      'birthDate' => $birthDate
    );

  }

}
