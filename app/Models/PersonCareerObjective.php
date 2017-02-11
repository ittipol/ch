<?php

namespace App\Models;

class PersonCareerObjective extends Model
{
  protected $table = 'person_career_objectives';
  protected $fillable = ['person_id','career_objective'];
}
