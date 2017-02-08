<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\message;
use Redirect;

class PersonSkillController extends Controller
{
  public function add() {

    $model = Service::loadModel('PersonSkill');

    $this->data = $model->form->build();

    return $this->view('pages.person_experience.form.pereson_skill_add');

  }

  public function addingSubmit() {

    $model = Service::loadModel('PersonSkill');

    foreach (request()->get('skills') as $value) {

      $value = trim($value['name']);

      if(!empty($value) && !$model->checkExistBySkill($value)) {
        $model->newInstance()->fill(array(
          'skill' => $value
        ))->save();
      }
    }

    Message::display('ข้อมูลถูกบันทึกแล้ว','success');
    return Redirect::to('experience');

  }

  public function edit() {

    $model = Service::loadModel('PersonSkill');

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่มีข้อมูลนี้ หรือ ข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    return $this->view('pages.item.form.item_edit');

  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('PersonSkill');
// check skill is exist then return error cannot add this skill
    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่มีข้อมูลนี้ หรือ ข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('item/detail/'.$model->id);
    }else{
      return Redirect::back();
    }
    
  }

}
