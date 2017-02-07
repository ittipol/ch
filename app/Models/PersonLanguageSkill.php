<?php

namespace App\Models;

class PersonLanguageSkill extends Model
{
  protected $table = 'person_language_skills';
  protected $fillable = ['person_id','language_skill_id','language_skill_level_id'];
  public $timestamps  = false;
}
