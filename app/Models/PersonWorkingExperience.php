<?php

namespace App\Models;

class PersonWorkingExperience extends Model
{
  protected $table = 'person_working_experiences';
  protected $fillable = ['person_id','company','position','description'];
  protected $modelRelations = array('PersonExperienceDetail');

  protected $validation = array(
    'rules' => array(
      'company' => 'required|max:255',
      'position' => 'required|max:255',
    ),
    'messages' => array(
      'company.required' => 'บริษัทหรือสถานที่ทำงานห้ามว่าง',
      'position.required' => 'ตำแหน่งห้ามว่าง',
    )
  );

  public function fill(array $attributes) {

    if(!empty($attributes)) {

      $attributes['PersonExperienceDetail']['experience_type_id'] = 1;

      foreach ($attributes['date_start'] as $key => $value) {
        $attributes['PersonExperienceDetail']['start_'.$key] = $value;
      }

      unset($attributes['date_start']);

      if(empty($attributes['current'])) {
        foreach ($attributes['date_end'] as $key => $value) {
          $attributes['PersonExperienceDetail']['end_'.$key] = $value;
        }
        unset($attributes['date_end']);
      }
      else{
        $attributes['PersonExperienceDetail']['current'] = $attributes['current'];
      }
    }

    return parent::fill($attributes);

  }

  public function buildModelData() {

    $message = array();

    if(!empty($this->position)) {
      $message[] = $this->position;
    }

    if(!empty($this->company)) {
      $message[] = $this->company;
    }

    $message = implode(' ที่ ', $message);

    return array(
      'company' => $this->company,
      'position' => $this->position,
      'message' => $message
    );
  }

}
