<?php

namespace App\Http\Controllers;

// use App\Models\Image;
// use App\Models\TempFile;
use App\library\service;
use App\library\file;
use App\library\image;
use Input;
use Session;

class ApiController extends Controller
{ 
  public function GetSubDistrict($districtId = null) {

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      exit('Error!!!');  //trygetRealPath detect AJAX request, simply exist if no Ajax
    }

    $subDistrictRecords = Service::loadModel('SubDistrict')->where('district_id', '=', $districtId)->get(); 

    $subDistricts = array();
    foreach ($subDistrictRecords as $subDistrict) {
      $subDistricts[$subDistrict['attributes']['id']] = $subDistrict['attributes']['name'];
    }

    return response()->json($subDistricts);
  }

  public function uploadImage() {

    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      exit('Error!!!');  //trygetRealPath detect AJAX request, simply exist if no Ajax
    }

    if(empty(Input::file('file'))) {
      $result = array(
        'success' => false,
        'message' => array(
          'type' => 'error',
          'title' => 'เกิดข้อผิดพลาด กรุณารีเฟรช แล้วลองอีกครั้ง'
        )
      );

      return response()->json($result);
    }

    $file = new File(Input::file('file'));

    $result = array(
      'success' => false,
    );

    if($file->checkFileSize() && $file->checkFileType()) {
      
      $tempFile = Service::loadModel('TemporaryFile');

      $value = array(
        'model' => Input::get('model'),
        'token' => Input::get('imageToken'),
        'filename' => $file->getFileName(),
        'file_type' => $file->getFileType()
      );

      if($tempFile->fill($value)->save()){
        $tempFile->moveTemporaryFile($file->getRealPath(),$tempFile->filename,array(
          'directoryName' => $tempFile->model.'_'.$tempFile->token
        ));

        $result = array(
          'success' => true,
          'filename' => $tempFile->filename
        );

      }
    }

    return response()->json($result);
  }

  // public function deleteImage() {

  //   if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  //     exit('Error');  //trygetRealPath detect AJAX request, simply exist if no Ajax
  //   }

  //   if(empty(Input::get('formToken')) || empty(Session::get(Input::get('formToken')))) {
  //     $result = array(
  //       'success' => false,
  //       'message' => array(
  //         'type' => 'error',
  //         'title' => 'เกิดข้อผิดพลาด กรุณารีเฟรช แล้วลองอีกครั้ง'
  //       )
  //     );

  //     return response()->json($result);
  //   }

  //   $success = false;

  //   // check image already exist in image table
  //   $imageModel = Service::loadModel('Image');
  //   $total = $imageModel->where('name','=',Input::get('filename'))->count();

  //   $tempFile = Service::loadModel('TempFile');

  //   if($total){
  //     $tempFile->name = Input::get('filename');
  //     $tempFile->type = Input::get('type');
  //     $tempFile->status = 'delete';
  //     $tempFile->token = Input::get('formToken');
  //     $tempFile->created_by = Session::get('Person.id');
  //     $tempFile->setFormToken(Input::get('formToken'));
      
  //     if($tempFile->save()){
  //       $success = true;
  //     }
  //   }else{
  //     $success = $tempFile->deletetempFile(Input::get('formToken'),Input::get('filename'));

  //     if($success){
  //       $tempFile->deleteRecord(Input::get('filename'),Input::get('formToken'),Input::get('type'),'add',Session::get('Person.id'));
  //     }

  //   }

  //   $result = array(
  //     'success' => $success
  //   );

  //   return response()->json($result);

  // }

}
