<?php

namespace App\Models;

class PersonProject extends Model
{
  protected $table = 'person_project';
  protected $fillable = ['person_id','subject','description'];
  protected $modelRelations = array('PersonExperienceDetail');

  protected $validation = array(
    'rules' => array(
      'subject' => 'required|max:255',
    ),
    'messages' => array(
      'subject.required' => 'ห้วข้อโปรเจคห้ามว่าง',
    )
  );
}
