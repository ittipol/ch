<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class ShopController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Shop');
  }

  public function index() {

    $slug = service::loadModel('Slug')->getData(array(
      'conditions' => array(
        array('name','like',$this->param['slug'])
      ),
      'first' => true,
      'fields' => array('name','model','model_id')
    ));

    $shop = $this->model->find($slug->model_id);

    $this->modelData->setModel($shop);
    $this->modelData->loadData();

    $this->data = array(
      'shopUrl' => Service::url('shop/'.$this->param['slug']),
    );

    return $this->view('pages.shop.main');
  }

  public function setting() {

  }

  public function product() {

  }

  public function job() {

  }

  public function create() {
    $this->form->setModel($this->model);
    $this->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    return $this->view('pages.shop.form.shop_create');
  }

  public function submitCreating(CustomFormRequest $request) {

    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('shop/'.$slugName);
    }else{

      switch ($this->model->errorType) {
        case 1;
          $_message = 'คุณได้เพิ่มร้านค้าชื่อว่า '.$this->model->name.' ไปแล้ว โปรดใช้ชื่ออื่น';
          return Redirect::back()->withErrors([$_message]);
          break;

        case 2;
          $_message = 'มีร้านค้าชื่อ '.$this->model->name.' นี้แล้ว';
          return Redirect::back()->withErrors([$_message]);
          break;
      }

      return Redirect::back();
    }

  }
}
