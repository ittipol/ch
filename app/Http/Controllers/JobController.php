<?php

namespace App\Http\Controllers;

use App\library\service;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Job');
  }

  public function post() {

    $this->form->setModel($this->model);
    $this->form->employmentType();

    return $this->view('pages.job.form.job_post');
  }

  public function submitPosting(CustomFormRequest $request) {

    if($this->model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('job/detail/'.$this->model->id);
    }else{
      return Redirect::back();
    }

  }

  public function addCat() {
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

  }
}
