<?php

namespace App\Models;

class PersonToEntity extends Model
{
  public $table = 'person_to_entities';
  protected $fillable = ['person_id','entity_id','role_id'];

  public function role() {
    return $this->hasOne('App\Models\Role','id','role_id');
  }

  public function entity() {
    return $this->hasOne('App\Models\entity','id','entity_id');
  }

  public function person() {
    return $this->hasOne('App\Models\person','id','person_id');
  }

  public function saveSpecial($value) {

    $record = $this->getData(array(
      'conditions' => array(
        ['person_id','=',$value['person_id']],
        ['entity_id','=',$value['entity_id']],
        ['role_id','=',$value['role_id']]
      )
    ));

    if(empty($record)){
      return $this->fill($value)->save();
    }

    return true;

  }

  public function setUpdatedAt($value) {}

}
