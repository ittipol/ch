<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomFormRequest;
use App\library\service;

class ItemController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Item');
  }

  public function post() {
    $this->form->setModel($this->model);
    $this->form->district();
    $this->form->itemCategory();
    $this->form->announcementType();

    $this->data = array(
      'defaultAnnouncementType' => 2
    );

    return $this->view('pages.item.form.post.item');
  }

  public function submitPosting(CustomFormRequest $request) {
    dd($request->all());
  }
}
