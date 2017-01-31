<?php

namespace App\Models;

class JobToBranch extends Model
{
  public $table = 'job_to_branchs';
  protected $fillable = ['job_id','branch_id'];
  public $timestamps  = false;

  public function __saveRelatedData($model,$options = array()) {

    if(!empty($options['value']['branch_id'])) {

      if($model->state == 'update') {
        $this->where('job_id','=',$model->id)->delete();
      }
      
      foreach ($options['value']['branch_id'] as $branchId) {
        
        $this->newInstance()->fill(array(
          'job_id' => $model->id,
          'branch_id' => $branchId,
        ))->save();

      }

    }

    return true;
  }
}
