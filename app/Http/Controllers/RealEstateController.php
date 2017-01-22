<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;

class RealEstateController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Product');
  }

  public function post() {
    $this->form->setModel($this->model);
    $this->form->district();
    $this->form->realEstateType();
    $this->form->announcementType();

    $this->data = array(
      'defaultAnnouncementType' => 2
    );

    return $this->view('pages.real-estate.form.real-estate_post');
  }

  public function submitPosting(CustomFormRequest $request) {
    dd($request->all());
  }
}
