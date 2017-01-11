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
      Message::display('ไม่พบประเภทของข้อมูลนี้ โปรดเลือกใหม่อีกครั้ง','error');
      return Redirect::to('entity/create');
    }

    $this->form->district();
    $this->form->set('entityType',$this->query['type']);

    return $this->view('pages.entity.form.add.'.$this->query['type']);
  }

  public function submit(CustomFormRequest $request) {

    $message = new Message();

    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      Message::display('ข้อมูลถูกเพิ่มแล้ว','success');
      return Redirect::to($slugName);
    }else{

      if(!empty($this->model->errorType)) {
        switch ($this->model->errorType) {
          case 1;
            $EntityTypeName = Service::loadModel('EntityType')->find($this->model->entity_type_id)->name;
            
            $_message = 'คุณได้เพิ่ม'.$EntityTypeName.'ชื่อว่า '.$this->model->name.' ไปแล้ว โปรดใช้ชื่ออื่น';
            return Redirect::back()->withErrors([$_message]);
            break;

          case 2;
            $_message = 'มี'.$EntityTypeName.'ไปแล้ว';
            return Redirect::back()->withErrors([$_message]);
            break;
        }
      }

      return Redirect::back();
    }

  }

}
