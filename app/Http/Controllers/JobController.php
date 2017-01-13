<?php

namespace App\Http\Controllers;

use App\library\service;

class JobController extends Controller
{
  public function __construct() { 
    parent::__construct();
    $this->model = Service::loadModel('Product');
  }

  public function add() {
    $this->form->setModel($this->model);
    $this->form->district();
    $this->form->productCategory();

    return $this->view('pages.product.form.add.product');
  }
}
