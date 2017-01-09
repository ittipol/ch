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

  public function add() {

    $this->form->district();
    return $this->view('pages.product.form.add.product');

  }

}
