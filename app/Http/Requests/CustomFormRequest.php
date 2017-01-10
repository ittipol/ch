<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\library\service;
use Request;
use Session;

class CustomFormRequest extends FormRequest
{
  private $model;

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
    $data = Request::all();

    $rules = array();
    foreach ($this->model->validation['rules'] as $key => $value) {

      if(!empty($this->model->validation['except'][$key])) {

        $skip = false;
        foreach ($this->model->validation['except'][$key] as $_key => $_value) {
          if(!empty($data[$_key]) && ($data[$_key] == $_value)) {
            $skip = true;
          }
        }

        if($skip) {
          continue;
        }
      }
      
      $rules[$key] = $value;
    }

    return $rules;
  }
}
