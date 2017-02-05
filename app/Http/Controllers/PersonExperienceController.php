<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\date;
use Redirect;
use Session;

class PersonExperienceController extends Controller
{

  public function __construct() { 
    parent::__construct();
  }

  public function index() {

    $model = Service::loadModel('PersonExperience');

    if($model->checkExistByPersonId()) {
      // Get Profile
      $profile = $model->where('person_id','=',Session::get('Person.id'))->first();
      $profile->modelData->loadData();

      $this->mergeData(array(
        'profile' => $profile->modelData->build(true)
      ));
    }

    $this->mergeData(array(
      'exist' => $model->checkExistByPersonId()
    ));


    
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
      'order' => array('top','ASC')
    ));

    $date = new Date;

    $thaiLatestYear = date('Y') + 543;
    
    $day = array();
    $month = array();
    $year = array();

    for ($i=1; $i <= 31; $i++) { 
      $day[$i] = $i;
    }

    for ($i=1; $i <= 12; $i++) { 
      $month[$i] = $date->getMonthName($i);
    }

    for ($i=2500; $i <= $thaiLatestYear; $i++) { 
      $year[$i] = $i;
    }

    $this->mergeData(array(
      'day' => $day,
      'month' => $month,
      'year' => $year
    ));

    $model->form->loadData();

    $this->data = $model->form->build();
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
