<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class ProductController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Product');
    $this->form->setModel($this->model);
  }

  public function index() {
    dd('pd index');
  }

  public function detail() {
    dd('pd detail');
  }

  public function add() {

    $this->form->district();
    return $this->view('pages.product.form.add.product');

  }

  public function submit(CustomFormRequest $request) {

    $message = new Message();

    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      $message->display('ข้อมูลถูกเพิ่มแล้ว','success');
      return Redirect::to('product/'.$slugName);
    }else{
      return Redirect::back();
    }

  }

  public function edit($productId) {
    dd($productId);
  }

}
