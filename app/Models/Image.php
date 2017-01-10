<?php

namespace App\Models;

use App\library\token;
use App\library\service;
use App\library\file;
// use App\library\image AS ImageLib;
use Auth;
use Storage;
// use File;
use Session;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['model','model_id','filename','description','created_by'];
  public $noImagePath = '/images/common/no-img.png';

  private $maxFileSizes = 3145728;
  private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

  public function __construct() {  
    parent::__construct();
  }

  public function __saveRelatedData($model,$options = array()) {
    $this->saveImages($model,$options['value'],$options);
    $this->deleteImages($model,$options);
  }

  public function saveImages($model,$images,$options = array()) {

    $temporaryFile = new TemporaryFile;

    foreach ($images as $token => $imageGroup) {

      foreach ($imageGroup as $image) {

        if(empty($image['filename'])) {
          continue;
        }

        $path = $temporaryFile->getFilePath($image['filename']);

        if(!file_exists($path)){
          continue;
        }

        $value = array(
          'filename' => $image['filename'],
        );

        if(!empty($image['description'])) {
          $value = array_merge($value,array(
            'description' => $image['description']
          ));
        }

        $this->_save($model->includeModelAndModelId($value));

      }
dd('sae');
    //   $records = $temporaryFile->getData(array(
    //     'conditions' => array(
    //       ['file_type','like','image'],
    //       ['token','like',$token],
    //       ['created_by','like',Session::get('Person.id')]
    //     ),
    //     'fields' => array('filename')
    //   ));

    //   foreach ($records as $_temporaryFile) {
    //     dd($images);
    //     $path = $_temporaryFile->getFilePath();

    //     if(!file_exists($path)){
    //       continue;
    //     }

    //     $value = array(
    //       'filename' => $filename,
    //     );

    //     $this->fill($model->includeModelAndModelId($value))->save();

    //   }
    }

    $images = $imagesTemp->get();

    foreach ($images as $image) {

      // if(!in_array($image->type,$model->allowedImage['type'])) {
      //   continue;
      // }

      $filename = $image->name;

      $path = storage_path($tempFileModel->tempFileDir).$token.'/'.$filename;

      if(!file_exists($path)){
        continue;
      }

      // Crop image
      // $imageLib = new ImageLib($path);
      // $imageLib->crop(200,600,400,800);
      // $imageLib->save(storage_path($tempFileModel->tempFileDir).$token.'/'.$filename);

      $value = array(
        'model' => $model->modelName,
        'model_id' => $model->id,
        'name' => $filename,
        'type' => $image->type
      );

      if($this->_save($value)) {

        $to = storage_path($model->dirPath).$model->id.'/'.$image->type.'/'.$filename;

        // move to real dir
        File::move($path, $to);

        //
        // $tempFile->find($image['attributes']['id'])->delete();
      }
      
    }
    
    // remove temp dir
    $tempFileModel->deleteTempDir($token);

    // delete temp file records
    $imagesTemp->delete();

  }

  public function deleteImages($model,$options = array()) {

    if(empty($this->formToken)) {
      return false;
    }

    $token = $this->formToken;

    $tempFileModel = new TempFile;
    $imagesTemp = $tempFileModel->where([
      ['token','=',$token],
      ['status','=','delete'],
      ['created_by','=',$personId]
    ]);

    $images = $imagesTemp->get();

    foreach ($images as $image) {

      $this->where([
        ['model','=',$model->modelName],
        ['model_id','=',$model->id],
        ['name','=',$image->name]
      ])->delete();

      File::Delete(storage_path($model->dirPath).$model->id.'/images/'.$image->name);
    }

    // delete temp file records
    $imagesTemp->delete();

  }

  public function getImageUrl() {

    $dirPath = $this->storagePath.Service::generateModelDirName($this->model).'/';
    // $path = $this->noImagePath;

    $path = '';
    if(File::exists(storage_path($dirPath.$this->model_id.'/'.$this->type.'/'.$this->name))){
      $path = '/safe_image/'.$this->name;
    }

    return $path;
  }

  public function base64Encode() {

    $dirPath = 'image/'.strtolower($this->model).'/';
    $path = $this->noImagePath;

    if(File::exists(storage_path($dirPath.$this->model_id.'/'.$this->type.'/'.$this->name))){
      $path = '/safe_image/'.$this->name;
    }

    return base64_encode(File::get($path));
  }

  public function checkMaxSize($size) {
    if($size <= $this->maxFileSizes) {
      return true;
    }
    return false;
  }

  public function checkType($type) {
    if (in_array($type, $this->acceptedFileTypes)) {
      return true;
    }
    return false;
  }

  public function getMaxFileSizes() {
    return $this->maxFileSizes;
  }

  public function getAcceptedFileTypes() {
    return $this->acceptedFileTypes;
  }

}
