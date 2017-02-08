<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\date;
use Redirect;

class PersonWorkingExperienceController extends Controller
{
  public function add() {
    
    $model = Service::loadModel('PersonWorkingExperience');

    $date = new Date;

    for ($i=1; $i <= 12; $i++) { 
      $month[$i] = $date->getMonthName($i);
    }

    $this->data = $model->form->build();
    $this->setData('latestYear',date('Y'));
    $this->setData('month',json_encode($month));

    return $this->view('pages.person_experience.form.person_working_add');
  }

  public function addingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('PersonWorkingExperience');

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('experience');
    }else{
      return Redirect::back();
    }
  }

}
