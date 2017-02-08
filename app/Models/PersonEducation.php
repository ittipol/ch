<?php

namespace App\Models;

class PersonEducation extends Model
{
  protected $table = 'person_educations';
  protected $fillable = ['person_id','academy','description','graduated'];
  protected $modelRelations = array('PersonExperienceDetail');

  // protected $validation = array(
  //   'rules' => array(
  //     'company' => 'required|max:255',
  //     'position' => 'required|max:255',
  //   ),
  //   'messages' => array(
  //     'company.required' => 'บริษัทหรือสถานที่ทำงานห้ามว่าง',
  //     'position.required' => 'ตำแหน่งห้ามว่าง',
  //   )
  // );
}
