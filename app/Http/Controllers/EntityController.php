<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use Redirect;

class EntityController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function create() {
    return $this->view('pages.entity.create');
  }

  public function add() {

    if(empty($this->query['type'])) {
      return Redirect::to('entity/create');
    }

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
