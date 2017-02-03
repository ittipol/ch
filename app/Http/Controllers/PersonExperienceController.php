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
    $this->model = Service::loadModel('PersonExperience');

  }

  public function index() {

    $this->data = array(
      'exist' => $this->model->checkExistByPersonId()
    );
    
    return $this->view('pages.person_experience.main');

  }

  public function start() {

    if(!$this->model->checkExistByPersonId()) {
      $this->model->fill(array(
        'name' => Session::get('Person.name'),
        'active' => 0
      ))->save();
    }

    return Redirect::to('experience');

  }

  public function profileEdit() {

    $model = $this->model->where('person_id','=',Session::get('Person.id'))->first();

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

    $this->setData(array(
      'day' => $day,
      'month' => $month,
      'year' => $year
    ));

    $this->setData($model->form->build());

    return $this->view('pages.person_experience.form.profile_edit');

  }

}
