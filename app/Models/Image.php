<?php

namespace App\Models;

use App\library\token;
use App\library\service;
// use App\library\image AS ImageLib;
use File;
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
  }

  private function saveImages($model,$images,$options = array()) {

    $temporaryFile = new TemporaryFile;

    foreach ($images as $token => $imageGroup) {

      $directoryName = $model->modelName.'_'.$token;

      foreach ($imageGroup as $image) {

        if(empty($image['filename'])) {
          continue;
        }

        $path = $temporaryFile->getFilePath($image['filename'],array(
          'directoryName' => $directoryName
        ));

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

        $imageInstance = $this->newInstance();
        if($imageInstance->fill($model->includeModelAndModelId($value))->save()) {
          $this->moveImage($model,$path,$imageInstance->filename);
        }

      }

      // remove temp dir
      $temporaryFile->deleteTemporaryDirectory($directoryName);

      $temporaryFile->deleteTemporaryRecords($model->modelName,$token);

    }

  }

  public function moveImage($model,$oldPath,$filename) {
    // to
    $to = $model->getDirectory().$filename;
    // move image
    return File::move($oldPath, $to);
  }

  // public function deleteImages($model,$options = array()) {

  //   if(empty($this->formToken)) {
  //     return false;
  //   }

  //   $token = $this->formToken;

  //   $tempFileModel = new TempFile;
  //   $imagesTemp = $tempFileModel->where([
  //     ['token','=',$token],
  //     ['status','=','delete'],
  //     ['created_by','=',$personId]
  //   ]);

  //   $images = $imagesTemp->get();

  //   foreach ($images as $image) {

  //     $this->where([
  //       ['model','=',$model->modelName],
  //       ['model_id','=',$model->id],
  //       ['name','=',$image->name]
  //     ])->delete();

  //     File::Delete(storage_path($model->dirPath).$model->id.'/images/'.$image->name);
  //   }

  //   // delete temp file records
  //   $imagesTemp->delete();

  // }

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
