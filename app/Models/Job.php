<?php

namespace App\Models;

class Job extends Model
{
  public $table = 'jobs';
  protected $fillable = ['employment_type_id','name','description','salary','recruitment','recruitment_detail'];
  protected $modelRelated = array('Image','Tagging');
  protected $directory = true;

  // protected $behavior = array(
  //   'Lookup' => array(
  //     'format' =>  array(
  //       'keyword' => '{{name}} {{salary}} {{nationality}} {{educational_level}}',
  //       'keyword_1' => '{{EmploymentType.name|Job.employment_type_id=>EmploymentType.id}}',
  //       'description' => '{{description}}'
  //     )
  //   )
  // );

  protected $validation = array(
    'rules' => array(
      'name' => 'required|max:255',
      // 'description' => 'required',
      // 'salary' => 'required|regex:/^[\d,]*(\.\d{1,2})?$/|max:255',
      'salary' => 'required',
    ),
    'messages' => array(
      'name.required' => 'ชื่อห้ามว่าง',
      // 'description.required' => 'รายละเอียดงานห้ามว่าง',
      'salary.required' => 'เงินเดือนห้ามว่าง',
      // 'salary.regex' => 'รูปแบบจำนวนเงินเดือนไม่ถูกต้อง',
    )
  ); 

  public function __construct() {  
    parent::__construct();
  }

  public static function boot() {

    parent::boot();

    Job::saving(function($model){

      // preg_match_all('/\d+/', $model->salary, $matches);
      // Print the entire match result
      // dd($matches);

      $model->recruitment = array(
        's' => '1',
        'c' => $model->recruitment_custom ? 1 : 0
      );

      dd($model);

    });

    Job::saved(function($job){

      // if($job->state == 'create') {
      //   $companyHasJob = new CompanyHasJob;
      //   $companyHasJob->setFormToken($job->formToken);
      //   $companyHasJob->saveSpecial($job->temporaryData['company_id'],$job->id);
      // }

      // if(!empty($job->companyHasJob->id) && !empty($job->temporaryData['department_id'])) {
      //   $departmentHasJob = new DepartmentHasJob;
      //   $departmentHasJob->setFormToken($job->formToken);
      //   $departmentHasJob->saveSpecial($job->companyHasJob->id,$job->temporaryData['department_id'],$job->id);
      // }

      // $lookup = new Lookup;
      // $lookup->setFormToken($job->formToken)->__saveRelatedData($job);

    });
  }

}
