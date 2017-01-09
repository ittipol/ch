<?php

namespace App\Models;

class Role extends Model
{
  protected $table = 'roles';
  protected $fillable = ['name','alias'];

  public function getIdByalias($alias) {
    $record = $this->where('alias','=',$alias)->first();
    return $record['attributes']['id'];
  }

}
