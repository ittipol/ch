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
exit('!!!');
    $data = array(
'โต๊ะรีดผ้า',
'ตะกร้าผ้า',
'จักรเย็บผ้าและอุปกรณ์',
'อุปกรณ์ดับกลิ่นผ้า'
    );

    $parentId = 927;

    foreach ($data as $value) {

      $_value = array(
        'name' => $value
      );

      if(!empty($parentId)) {
        $_value = array(
          'parent_id' => $parentId,
          'name' => $value
        );
      }

      Service::loadModel('Category')->newInstance()->fill($_value)->save();
    }
    dd('saved');

    $this->form->setModel($this->model);
    $this->form->employmentType();

    return $this->view('pages.job.form.add.job');
  }
}
