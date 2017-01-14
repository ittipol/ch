<?php

namespace App\Http\Controllers;

use App\library\service;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Job');
  }

  public function add() {

    $this->form->setModel($this->model);
    $this->form->employmentType();

    return $this->view('pages.job.form.add.job');
  }
}
