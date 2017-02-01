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
    
    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $this->model->paginator->setPage($page);
    $this->model->paginator->setPagingUrl('item/list');
    $this->model->paginator->setUrl('item/detail/{id}','detailUrl');

    $this->setData($this->model->paginator->build());

    return $this->view('pages.item.list');
  }

  public function detail() {

    $model = $this->model->find($this->param['item_id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'json' => array('Image')
    ));

    $this->setData($model->modelData->build());

    return $this->view('pages.item.detail');

  }

  public function post() {

    $this->model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $this->model->form->loadFieldData('ItemCategory',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'itemCategories'
    ));

    $this->model->form->loadFieldData('AnnouncementType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'announcementTypes'
    ));

    $this->setData($this->model->form->build());
    $this->setData(array('defaultAnnouncementType' => 2));

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
