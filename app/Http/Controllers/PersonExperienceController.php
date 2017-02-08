<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\date;
use App\library\url;
use Redirect;
use Session;

class PersonExperienceController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function index() {

    $model = Service::loadModel('PersonExperience');

    if(!$model->checkExistByPersonId()) {
      return $this->view('pages.person_experience.start');
    }

    $url = new Url;

    // Get Profile
    $profile = $model->where('person_id','=',Session::get('Person.id'))->first();
    $profile->modelData->loadData(array(
      'models' => array('Address','Contact')
    ));

    // Get skill
    $skills = Service::loadModel('PersonSkill')->where('person_id','=',session()->get('Person.id'))->get();
    
    $url->setUrl('experience/skill_edit/{skill}','editUrl');
    $url->setUrl('experience/skill_delete/{skill}','deleteUrl');

    $_skills = array();
    foreach ($skills as $skill) {
      $_skills[] = array_merge(array(
        'skill' => $skill->skill,
      ),$url->parseUrl($skill->getAttributes())); 
    }

    // Get language skill
    $languageSkills = Service::loadModel('PersonLanguageSkill')->where('person_id','=',session()->get('Person.id'))->get();
   
    $url->clearUrls();
    $url->setUrl('experience/language_skill_edit/{id}','editUrl');
    $url->setUrl('experience/language_skill_delete/{id}','deleteUrl');

    $_languageSkills = array();
    foreach ($languageSkills as $languageSkill) {
      $_languageSkills[] = array_merge(array(
        'name' => $languageSkill->language->name,
        'level' => $languageSkill->languageSkillLevel->name
      ),$url->parseUrl($languageSkill->language->getAttributes()));
    }

    // Get working
    $workingDetails = Service::loadModel('PersonExperienceDetail')
    ->orderBy('start_year','DESC')
    ->orderBy('start_month','DESC')
    ->where('person_id','=',session()
    ->get('Person.id'))->get();

    $url->clearUrls();
    $url->setUrl('experience/working_edit/{id}','editUrl');
    $url->setUrl('experience/working_delete/{id}','deleteUrl');

    $workings = array();
    foreach ($workingDetails as $detail) {
      
      $workingDetail = $detail->{lcfirst($detail->model)};

      $workings[] = array_merge(array(
        'company' => $workingDetail->company,
        'position' => $workingDetail->position,
        'peroid' => $detail->getPeriod()
      ),$url->parseUrl($workingDetail->getAttributes()));

    }

    $this->setData('profile',$profile->modelData->build(true));
    $this->setData('profileImageUrl',$profile->getProfileImageUrl());
    $this->setData('skills',$_skills);
    $this->setData('languageSkills',$_languageSkills);
    $this->setData('workings',$workings);

    return $this->view('pages.person_experience.main');

  }

  public function start() {

    $model = Service::loadModel('PersonExperience');

    if(!$model->checkExistByPersonId()) {
      $model->fill(array(
        'name' => Session::get('Person.name'),
        'active' => 0
      ))->save();
    }

    return Redirect::to('experience');

  }

  public function profileEdit() {

    $model = Service::loadModel('PersonExperience')->where('person_id','=',Session::get('Person.id'))->first();

    $model->form->loadFieldData('Province',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'provinces',
      'order' => array(
        array('top','ASC')
      )
    ));

    $model->form->setData('websiteTypes',json_encode(array(
      array('private-website','เว็บไซต์ส่วนตัว'),
      array('blog','บล็อก'),
      array('company-website','เว็บไซต์บริษัท')
    )));

    $date = new Date;

    $latestYear = date('Y');
    
    $day = array();
    $month = array();
    $year = array();

    for ($i=1; $i <= 31; $i++) { 
      $day[$i] = $i;
    }

    for ($i=1; $i <= 12; $i++) { 
      $month[$i] = $date->getMonthName($i);
    }

    for ($i=1957; $i <= $latestYear; $i++) { 
      $year[$i] = $i+543;
    }

    // $this->mergeData(array(
    //   'day' => $day,
    //   'month' => $month,
    //   'year' => $year
    // ));

    $model->form->loadData(array(
      'model' => array(
        'Address','Contact'
      )
    ));

    $this->data = $model->form->build();
    $this->setData('profileImage',json_encode($model->getProfileImage()));
    $this->setData('day',$day);
    $this->setData('month',$month);
    $this->setData('year',$year);

    return $this->view('pages.person_experience.form.profile_edit');

  }

  public function profileEditingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('PersonExperience')->where('person_id','=',Session::get('Person.id'))->first();

    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('experience');
    }else{
      return Redirect::back();
    }

  }

}
