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
      $startDate[] = $this->start_year;
    }

    if(!empty($startDate)) {
      $period[] = implode(' ', $startDate);
    }

    // if(empty($this->start_year) || empty($this->start_month) || empty($this->start_day)) {
    //   $displayStartDate = false;
    // }

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
        $endDate[] = $this->end_year;
      }

      if(!empty($startDate)) {
        $period[] = implode(' ', $endDate);
      }

    }

    return implode(' - ', $period);

  }

}
