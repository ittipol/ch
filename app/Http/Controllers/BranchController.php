<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\url;
use Redirect;

class BranchController extends Controller
{

  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Branch');
  }

  public function detail() {

    $model = $this->model->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ขออภัย ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'models' => array('Image','Address','Contact'),
      'json' => array('Image')
    ));

    $this->setData($model->modelData->build());

    // Get Branches
    $jobIds = $model->getRalatedData('JobToBranch',array(
      'list' => 'job_id',
      'fields' => array('job_id'),
    ));

    $jobs = Service::loadModel('Job');
    $jobs->paginator->setPerPage(12);
    $jobs->paginator->setUrl('job/detail/{id}','detailUrl');
    $jobs->paginator->criteria(array(
      'conditions' => array(
        'in' => array(
          array('id',$jobIds)
        )
      ),
      'order' => array('id','DESC')
    ));

    $this->setData(array(
      'jobs' => $jobs->paginator->getModelData()
    ));

    return $this->view('pages.branch.detail');

  }

  public function add() {

    if(!Service::loadModel('Shop')->checkPersonInShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $this->model->form->loadFieldData('District',array(
      'conditions' => array(
        ['province_id','=',9]
      ),
      'key' =>'id',
      'field' => 'name',
      'index' => 'districts'
    ));

    $this->setData($this->model->form->build());

    return $this->view('pages.branch.form.branch_add');
  }

  public function addingSubmit(CustomFormRequest $request) {

    if(!Service::loadModel('Shop')->checkPersonInShop($this->slug->model_id)){
      $this->error = array(
        'message' => 'คุณไม่มีสิทธิแก้ไขร้านค้านี้'
      );
      return $this->error();
    }

    $request->request->add(['ShopTo' => array('shop_id' => $this->slug->model_id)]);

    if($this->model->fill($request->all())->save()) {
      Message::display('สาขา '.$this->model->name.' ถูกเพิ่มแล้ว','success');
      return Redirect::to('shop/'.$this->slug->name.'/job');
    }else{
      return Redirect::back();
    }
  }

}
