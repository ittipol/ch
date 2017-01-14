<?php

namespace App\Models;

class Job extends Model
{
  public $table = 'jobs';
  protected $fillable = ['name','description','salary','employment_type_id','nationality','age','gender','educational_level','experience','number_of_position','welfare'];
  protected $modelRelated = array('Company','Tagging');
  protected $behavior = array(
    'Lookup' => array(
      'format' =>  array(
        'keyword' => '{{name}} {{salary}} {{nationality}} {{educational_level}}',
        'keyword_1' => '{{EmploymentType.name|Job.employment_type_id=>EmploymentType.id}}',
        'description' => '{{description}}'
      )
    )
  );

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Job::saved(function($job){

      if($job->state == 'create') {
        $companyHasJob = new CompanyHasJob;
        $companyHasJob->setFormToken($job->formToken);
        $companyHasJob->saveSpecial($job->temporaryData['company_id'],$job->id);
      }

      if(!empty($job->companyHasJob->id) && !empty($job->temporaryData['department_id'])) {
        $departmentHasJob = new DepartmentHasJob;
        $departmentHasJob->setFormToken($job->formToken);
        $departmentHasJob->saveSpecial($job->companyHasJob->id,$job->temporaryData['department_id'],$job->id);
      }

      $lookup = new Lookup;
      $lookup->setFormToken($job->formToken)->__saveRelatedData($job);

    });
  }

  public function companyHasJob() {
    return $this->hasOne('App\Models\CompanyHasJob','job_id','id');
  }

}
