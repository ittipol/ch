<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class EntityController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Entity');
    $this->form->setModel($this->model);
  }

  public function index() {

  }

  public function create() {
    return $this->view('pages.entity.create');
  }

  public function add() {

    if(empty($this->query['type'])) {
      return Redirect::to('entity/create');
    }

    $entityType = Service::loadModel('EntityType')->getData(array(
      'conditions' => array(
        array('alias','like',$this->query['type'])
      ),
      'fields' => array('id')
    ));

    if(empty($entityType)) {
      return Redirect::to('entity/create');
    }

    $this->form->district();
    $this->form->set('entityTypeId',$entityType->id);

    return $this->view('pages.entity.form.add.'.$this->query['type']);
  }

  public function submit(CustomFormRequest $request) {

    $message = new Message();

    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ));

      $message->display('ข้อมูลถูกเพิ่มแล้ว','success');
      return Redirect::to($slugName->name);
    }else{
      return Redirect::back();
    }

  }

}
