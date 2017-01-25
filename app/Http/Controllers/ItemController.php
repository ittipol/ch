<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use Redirect;

class ItemController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Item');
  }

  public function listView() {

    $this->paginator->setModel($this->model);
     $this->paginator->build();

    // $a = Service::loadModel('Item')->paginate(15);
    // dd($a);
    dd('fsdf');
  }

  public function detail($itemId) {
    $item = $this->model->find($itemId);

    if(empty($item)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $this->modelData->setModel($item);
    $this->modelData->loadData(array(
      'json' => array('Image')
    ));
    
    return $this->view('pages.item.detail');

  }

  public function post() {
    $this->form->setModel($this->model);
    $this->form->district();
    $this->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));
    $this->form->itemCategory();
    $this->form->announcementType();

    $this->data = array(
      'defaultAnnouncementType' => 2
    );

    return $this->view('pages.item.form.item_post');
  }

  public function submitPosting(CustomFormRequest $request) {

    if($this->model->fill($request->all())->save()) {
      Message::display('ลงประกาศเรียบร้อยแล้ว','success');
      return Redirect::to('item/detail/'.$this->model->id);
    }else{
      return Redirect::back();
    }

  }
}
