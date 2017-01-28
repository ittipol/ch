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
    // dd($request->all());
    if($this->model->fill($request->all())->save()) {

      $slugName = $this->model->getRalatedModelData('Slug',array(
        'fields' => 'name'
      ))->name;

      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('item/detail/'.$this->model->id);
    }else{

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

      return Redirect::back();
    }

  }
}
