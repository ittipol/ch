<?php

namespace App\Models;

class PersonSkill extends Model
{
  protected $table = 'person_skills';
  protected $fillable = ['person_id','skill'];
  public $timestamps  = false;

  public function checkExistBySkill($skill) {
    return $this->where('skill','like',$skill)->exists();
  }
}
