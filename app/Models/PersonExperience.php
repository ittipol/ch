<?php

namespace App\Models;

use Session;

class PersonExperience extends Model
{
  public $table = 'person_experiences';
  protected $fillable = ['person_id','name','active'];
  protected $directory = true;

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
    return $this->where('person_id','=',Session::get('Person.id'))->first();
  }

  public function checkExistByPersonId() {
    return $this->where('person_id','=',Session::get('Person.id'))->exists();
  }

}
