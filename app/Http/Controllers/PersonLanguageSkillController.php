<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\message;

class PersonLanguageSkillController extends Controller
{
  public function add() {

    $model = Service::loadModel('PersonSkill');

    $languages = Service::loadModel('Language')->where('active','=',1)->select('id','name')->get();

    $_languages = array();
    foreach ($languages as $language) {
      $_languages[] = array(
        $language->id,
        $language->name
      );
    }

    $model->form->setData('languages',json_encode($_languages));
   
    $this->data = $model->form->build();

    return $this->view('pages.person_experience.form.pereson_language_skill_add');

  }

  public function addingSubmit() {

    $model = Service::loadModel('PersonSkill');

    foreach (request()->get('skills') as $value) {

      $value = trim($value);

      if(!empty($value) && !$model->checkExistBySkill($value)) {
        $model->newInstance()->fill(array(
          'skill' => $value['name']
        ))->save();
      }
    }

    Message::display('ข้อมูลถูกบันทึกแล้ว','success');
    return Redirect::to('experience');

  }
}
