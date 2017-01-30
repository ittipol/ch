<?php

namespace App\Models;

use Session;

class WorkingExperience extends Model
{
  public $table = 'working_experiences';
  protected $fillable = ['person_id','active'];

  public function getByPersonId() {
    return $this->where('person_id','=',Session::get('Person.id'))->first();
  }

  public function checkExistByPersonId() {
    return $this->where('person_id','=',Session::get('Person.id'))->exists();
  }

}
