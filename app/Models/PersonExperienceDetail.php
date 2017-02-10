<?php

namespace App\Models;

use App\library\date;

class PersonExperienceDetail extends Model
{
  protected $table = 'person_experience_details';
  protected $fillable = ['model','model_id','person_id','experience_type_id','start_year','start_month','start_day','end_year','end_month','end_day','current'];

  public function personWorkingExperience() {
    return $this->hasOne('App\Models\PersonWorkingExperience','id','model_id');
  }

  public function personEducation() {
    return $this->hasOne('App\Models\PersonEducation','id','model_id');
  }

  public function personProject() {
    return $this->hasOne('App\Models\PersonProject','id','model_id');
  }

  public function personCertificate() {
    return $this->hasOne('App\Models\PersonCertificate','id','model_id');
  }

  public function __saveRelatedData($model,$options = array()) {
    $personExperienceDetail = $model->getModelRelationData('PersonExperienceDetail',
      array(
        'first' => true
      )
    );

    if(!empty($personExperienceDetail)){
      return $personExperienceDetail
      ->fill($options['value'])
      ->save();
    }else{
      return $this->fill($model->includeModelAndModelId($options['value']))->save();
    }

  }

  public function setPeriodData($attributes) {

    $data = array();

    $data = array(
      'start_year' => null,
      'start_month' => null,
      'start_day' => null,
      'end_year' => null,
      'end_month' => null,
      'end_day' => null,
      'current' => null,
    );

    foreach ($attributes['date_start'] as $key => $value) {
      $data['start_'.$key] = $value;
    }

    if(empty($attributes['current'])) {
      foreach ($attributes['date_end'] as $key => $value) {
        $data['end_'.$key] = $value;
      }
    }
    else{
      $data['current'] = $attributes['current'];
    }

    return $data;

  }

  public function getPeriod() {

    $date = new Date;

    $period = array();
    $startDate = array();
    $endDate = array();

    if(!empty($this->start_day)) {
      $startDate[] = $this->start_day;
    }

    if(!empty($this->start_month)) {
      $startDate[] = $date->getMonthName($this->start_month);
    }

    if(!empty($this->start_year)) {
      $startDate[] = $this->start_year+543;
    }

    if(!empty($startDate)) {
      $period[] = implode(' ', $startDate);
    }

    if(!empty($this->current) && $this->current) {
      $period[] = 'ถึงปัจจุบัน';
    }else{
      if(!empty($this->end_day)) {
        $endDate[] = $this->end_day;
      }

      if(!empty($this->end_month)) {
        $endDate[] = $date->getMonthName($this->end_month);
      }

      if(!empty($this->end_year)) {
        $endDate[] = $this->end_year+543;
      }

      if(!empty($startDate)) {
        $period[] = implode(' ', $endDate);
      }

    }

    return implode(' - ', $period);

  }

}
