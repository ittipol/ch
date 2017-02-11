<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;
use App\library\message;
use App\library\url;
use Redirect;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
  }

  public function detail() {

    $model = Service::loadModel('Job')->find($this->param['id']);

    if(empty($model)) {
      $this->error = array(
        'message' => 'ไม่พบประกาศนี้'
      );
      return $this->error();
    }

    $model->modelData->loadData(array(
      'models' => array('Image','Tagging'),
      'json' => array('Image')
    ));

    $this->mergeData($model->modelData->build());

    // Get Shop Address
    $shop = $model->getModelRelationData('ShopTo',array(
      'first' => true,
    ))->shop;

    // Get Slug
    $slug = $shop->getModelRelationData('Slug',array(
      'first' => true,
    ))->slug;

    // Get Branches
    $branchIds = $model->getRalatedData('JobToBranch',array(
      'list' => 'branch_id',
      'fields' => array('branch_id'),
    ));

    $branches = array();
    if(!empty($branchIds)){
      $branches = Service::loadModel('Branch')->whereIn('id',$branchIds)->get();
    }
    
    $url = new Url;

    $branchLocations = array();
    $hasBranchLocation = false;
    foreach ($branches as $branch) {

      $address = $branch->modelData->loadAddress();

      if(!empty($address)){

        $hasBranchLocation = true;

        $graphics = json_decode($address['_geographic'],true);
        
        $branchLocations[] = array(
          'id' => $branch->id,
          'address' => $branch->name,
          'latitude' => $graphics['latitude'],
          'longitude' => $graphics['longitude'],
          'detailUrl' => $url->setAndParseUrl('shop/'.$slug.'/branch_detail/{id}',$branch->getAttributes())
        );
      }
    }

    $this->setData('shopAddress',$shop->modelData->loadAddress());
    $this->setData('branchLocations',json_encode($branchLocations));
    $this->setData('hasBranchLocation',$hasBranchLocation);

    // Get person apply job
    $personApplyJob = Service::loadModel('PersonApplyJob')->where(array(
      array('person_id','=',session()->get('Person.id')),
      array('job_id','=',$this->param['id'])
    ))->exists();

    $this->setData('personApplyJob',$personApplyJob);

    if(!$personApplyJob) {
      $this->setData('jobApplyUrl',$url->setAndParseUrl('job/apply/{id}',array('id' => $this->param['id'])));
    }

    return $this->view('pages.job.detail');

  }

  public function add() {

    $model = Service::loadModel('Job');

    $model->form->loadFieldData('EmploymentType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'employmentTypes'
    ));

    $model->form->setData('branches',request()->get('shop')->getRelatedModelData('Branch'));

    $this->data = $model->form->build();

    return $this->view('pages.job.form.job_post');
  }

  public function addingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Job');

    $request->request->add(['ShopTo' => array('shop_id' => request()->get('shop')->id)]);

    if($model->fill($request->all())->save()) {
      Message::display('ลงประกาศงานแล้ว','success');
      return Redirect::to('shop/'.$request->slug.'/job');
    }else{
      return Redirect::back();
    }

  }

  public function edit() {

    $model = Service::loadModel('Job')->find($this->param['id']);

    if(empty($model) || ($model->person_id != session()->get('Person.id'))) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    $model->form->loadData(array(
      'models' => array('Image','Tagging'),
      'json' => array('Image','Tagging')
    ));
    $model->form->loadFieldData('EmploymentType',array(
      'key' =>'id',
      'field' => 'name',
      'index' => 'employmentTypes'
    ));

    $jobToBranch = $model->getRalatedData('JobToBranch',array(
      'fields' => array('branch_id')
    ));

    $branches = array();
    if(!empty($jobToBranch)) {
      foreach ($jobToBranch as $value) {
        $branches['branch_id'][] = $value->branch->id;
      }
    }

    // Get Selected Branch
    $model->form->setFormData('JobToBranch',$branches);
    // Get All branches in shop
    $model->form->setData('branches',request()->get('shop')->getRelatedModelData('Branch'));

    $this->data = $model->form->build();

    return $this->view('pages.job.form.job_edit');
  }

  public function editingSubmit(CustomFormRequest $request) {

    $model = Service::loadModel('Job')->find($this->param['id']);

    if(empty($model) || ($model->person_id != session()->get('Person.id'))) {
      $this->error = array(
        'message' => 'ขออภัย ไม่สามารถแก้ไขข้อมูลนี้ได้ หรือข้อมูลนี้อาจถูกลบแล้ว'
      );
      return $this->error();
    }

    if($model->fill($request->all())->save()) {
      Message::display('ข้อมูลถูกบันทึกแล้ว','success');
      return Redirect::to('shop/'.request()->slug.'/job');
    }else{
      return Redirect::back();
    }

  }

  public function apply() {

    $model = Service::loadModel('PersonApplyJob');

    $exist = $model->where(array(
      array('person_id','=',session()->get('Person.id')),
      array('job_id','=',$this->param['id'])
    ))->exists();

    if($exist) {
      Message::display('สมัครงานนี้แล้ว','info');
      return Redirect::to('job/detail/'.$this->param['id']);
    }

    $jobModel = Service::loadModel('Job')->find($this->param['id']);

    $shopToModel = Service::loadModel('ShopTo')
    ->select('shop_id')
    ->where(array(
      array('model','like','Job'),
      array('model_id','=',$this->param['id'])
    ))
    ->first();

    $this->data = $model->form->build();
    $this->setData('shopName',$shopToModel->shop->name);
    $this->setData('jobName',$jobModel->name);

    return $this->view('pages.job.form.job_apply');

  }

  public function applyingSubmit() {

    $model = Service::loadModel('PersonApplyJob');

    $exist = $model->where(array(
      array('person_id','=',session()->get('Person.id')),
      array('job_id','=',$this->param['id'])
    ))->exists();

    if($exist) {
      Message::display('สมัครงานนี้แล้ว','info');
      return Redirect::to('job/detail/'.$this->param['id']);
    }

    $shopToModel = Service::loadModel('ShopTo')
    ->select('shop_id')
    ->where(array(
      array('model','like','Job'),
      array('model_id','=',$this->param['id'])
    ))
    ->first();

    request()->request->add(['job_id' => $this->param['id']]);
    request()->request->add(['shop_id' => $shopToModel->shop_id]);

    if($model->fill(request()->all())->save()) {
      Message::display('สมัครงานนี้เรียบร้อยแล้ว','success');
      return Redirect::to('job/detail/'.$this->param['id']);
    }else{
      return Redirect::back();
    }

  }

  public function jobApplyList() {

    $model = Service::loadModel('PersonApplyJob');

    $page = 1;
    if(!empty($this->query)) {
      $page = $this->query['page'];
    }

    $model->paginator->disableGetImage();
    $model->paginator->criteria(array(
      'conditions' => array(
        array('shop_id','=',request()->get('shopId'))
      )
    ));
    $model->paginator->setPage($page);
    $model->paginator->setPagingUrl('shop/'.request()->slug.'/job_apply_list');
    $model->paginator->setUrl('experience/detail/{person_id}','experienceDetailUrl');
dd($model->paginator->build());
    $this->data = $model->paginator->build();

    // // Get job apply
    // $jobApplies = Service::loadModel('PersonApplyJob')
    // ->where('shop_id','=',request()->get('shopId'))
    // ->get();

    // foreach ($jobApplies as $jobApply) {
    //   // dd($jobApply->job);
    //   dd($jobApply->person);
    // }

    dd('dsad');

  }

}
