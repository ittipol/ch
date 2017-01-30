<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;


class WorkingExperienceController extends Controller
{

  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('WorkingExperience');
  }


  public function index() {

    $this->data = array(
      'exist' => $this->model->checkExistByPersonId()
    );
    
    return $this->view('pages.working-experience.main');

  }

  public function start() {

    if(!$this->model->checkExistByPersonId()) {
      $this->model->fill(array(
        'active' => 0
      ))->save();
    }

    return Redirect::to('working_experience');

  }
}
