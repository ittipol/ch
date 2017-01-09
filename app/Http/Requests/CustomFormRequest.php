<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\library\service;
use Request;
use Session;

class CustomFormRequest extends FormRequest
{
  // private $model;
  public $formTokenData;

  public function __construct() {
    $data = Request::all();
    $this->model = service::loadModel($data['model']);
  }

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
    // return Auth::check();
  }

  public function messages()
  {
    return $this->model->validation['messages'];
  }

  public function rules()
  {
    $rules = array();
    foreach ($this->model->validation['rules'] as $key => $value) {

      if(!empty($this->model->validation['except'][$key]) && in_array($this->formTokenData['action'], $this->model->validation['except'][$key])) {
        continue;
      }
      
      $rules[$key] = $value;
    }

    return $rules;
  }
}
