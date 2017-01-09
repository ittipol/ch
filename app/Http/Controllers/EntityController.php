<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;

class EntityController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function create() {
    return $this->view('pages.entity.create');
  }

  public function add() {

    $this->form->district();

    // type invalid
    $entityTypeId = Service::loadModel('EntityType')->getData(array(
      'conditions' => array(
        array('alias','like',$this->query['type'])
      ),
      'fields' => array('id')
    ))->id;

    $this->form->set('entityTypeId',$entityTypeId);

    return $this->view('pages.entity.form.add.'.$this->query['type']);
  }

  public function submit(CustomFormRequest $request) {
    dd($request);
  }

}
