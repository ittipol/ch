<?php

namespace App\Http\Controllers;

use App\library\service;
use App\library\message;
use Redirect;

class PersonLanguageSkillController extends Controller
{
  public function add() {

    $model = Service::loadModel('PersonLanguageSkill');

    // Get languages
    $languages = Service::loadModel('Language')->where('active','=',1)->select('id','name')->get();

    $_languages = array();
    foreach ($languages as $language) {
      $_languages[] = array(
        $language->id,
        $language->name
      );
    }

    // Get language skill lavels
    $languageSkillLevels = Service::loadModel('LanguageSkillLevel')->all();

    $levels = array();
    foreach ($languageSkillLevels as $level) {
      $levels[] = array(
        $level->id,
        $level->name
      );
    }

    $model->form->setData('languages',json_encode($_languages));
    $model->form->setData('levels',json_encode($levels));
   
    $this->data = $model->form->build();

    return $this->view('pages.person_experience.form.pereson_language_skill_add');

  }

  public function addingSubmit() {

    $model = Service::loadModel('PersonLanguageSkill');

    foreach (request()->get('languages') as $value) {


      if(!empty($value) && !$model->checkExistByLanguageId($value['language'])) {
        $model->newInstance()->fill(array(
          'language_id' => $value['language'],
          'language_skill_level_id' => $value['level']
        ))->save();
      }
    }

    Message::display('ข้อมูลถูกบันทึกแล้ว','success');
    return Redirect::to('experience');

  }
}
