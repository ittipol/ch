<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;
use Session;

class ProductController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Product');
  }

  public function index() {
    dd('pd index');
  }

  public function detail() {
    dd('pd detail');
  }

  public function add() {
    $this->form->setModel($this->model);
    $this->form->district();
    $this->form->productCategory();

    return $this->view('pages.product.form.add.product');
  }

  public function addingSubmit(CustomFormRequest $request) {
dd($request->all());
    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      Message::display('ข้อมูลถูกเพิ่มแล้ว','success');
      return Redirect::to('product/'.$slugName);
    }else{
      return Redirect::back();
    }

  }

  public function edit($productId) {

    $model = $this->model->find($productId);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศขายนี้'
      );
      return $this->error();
    }

    // if($model->created_by != Session::get('Person.id')) {
    //   $this->error = array(
    //     'message' => 'คุณไม่สามารถแก้ไขประกาศขายนี้ได้'
    //   );
    //   return $this->error();
    // }

    $this->form->setModel($model);
    $this->form->loadFormData();
    $this->form->district();
    
    return $this->view('pages.product.form.edit.product');

  }

  public function editingSubmit(CustomFormRequest $request,$productId) {

    $product = $this->model->find($productId);

    if($product->fill($request->all())->save()) {

      $slugName = $product->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      Message::display('ข้อมูลถูกเพิ่มแล้ว','success');
      return Redirect::to('product/'.$slugName);
    }else{
      return Redirect::back();
    }
  }

}
