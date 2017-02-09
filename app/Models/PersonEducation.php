<?php

namespace App\Models;

class PersonEducation extends Model
{
  protected $table = 'person_educations';
  protected $fillable = ['person_id','academy','description','graduated'];
  protected $modelRelations = array('PersonExperienceDetail');

  protected $validation = array(
    'rules' => array(
      'academy' => 'required|max:255',
    ),
    'messages' => array(
      'academy.required' => 'สถานศึกษาห้ามว่าง',
    )
  );

  public function fill(array $attributes) {

    if(!empty($attributes)) {

      $attributes['PersonExperienceDetail']['experience_type_id'] = 2;

      foreach ($attributes['date_start'] as $key => $value) {
        $attributes['PersonExperienceDetail']['start_'.$key] = $value;
      }

      foreach ($attributes['date_end'] as $key => $value) {
        $attributes['PersonExperienceDetail']['end_'.$key] = $value;
      }
      unset($attributes['date_end']);
      
    }

    return parent::fill($attributes);

  }

  public function buildModelData() {

    $message = array();
    if(!empty($this->academy)) {
      $message[] = 'จบการศึกษา';
    }

    if(!empty($this->academy)) {
      $message[] = $this->academy;
    }

    $message = implode(' ที่ ', $message);

    return array(
      'academy' => $this->academy,
      // 'graduated' => $this->graduated,
      'message' => $message
    );
  }

}