<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();

    if(!empty($this->param['slug'])){
      $this->slug = service::loadModel('Slug')->getData(array(
        'conditions' => array(
          array('name','like',$this->param['slug'])
        ),
        'first' => true,
        'fields' => array('name','model','model_id')
      ));
    }

    $this->model = Service::loadModel('Job');
  }

  public function add() {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $this->form->setModel($this->model);
    $this->form->employmentType();
    $this->form->branch(array(
      'shopId' => $this->slug->model_id
    ));

    return $this->view('pages.job.form.job_post');
  }

  public function submitAdding(CustomFormRequest $request) {

    if(!Service::loadModel('Shop')->checkPersonToShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }
// dd($request->all());
    if($this->model->fill($request->all())->save()) {
      Message::display('ลงประกาศงานแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }

  }

  // public function addCat() {
  //   exit('!!!');
  //       $data = array(
  //   'โต๊ะรีดผ้า',
  //   'ตะกร้าผ้า',
  //   'จักรเย็บผ้าและอุปกรณ์',
  //   'อุปกรณ์ดับกลิ่นผ้า'
  //       );

  //       $parentId = 927;

  //       foreach ($data as $value) {

  //         $_value = array(
  //           'name' => $value
  //         );

  //         if(!empty($parentId)) {
  //           $_value = array(
  //             'parent_id' => $parentId,
  //             'name' => $value
  //           );
  //         }

  //         Service::loadModel('Category')->newInstance()->fill($_value)->save();
  //       }
  //       dd('saved');

  // }
}
