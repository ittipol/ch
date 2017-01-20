<?php

namespace App\Models;

use App\library\token;
use App\library\service;
// use App\library\imageTool;
use File;
use Session;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['model','model_id','filename','description','created_by'];
  // public $noImagePath = 'images/common/no-img.png';

  private $maxFileSizes = 1048576;
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

      if(!empty($imageGroup['remove'])) {
        $removeFiles = $imageGroup['remove'];
        unset($imageGroup['remove']);

        $this->deleteImages($model,$removeFiles);

      }

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

          $to = $imageInstance->getImagePath();
          $this->moveImage($path,$to);

          $ext = pathinfo($imageInstance->filename, PATHINFO_EXTENSION);
          $filename = pathinfo($imageInstance->filename, PATHINFO_FILENAME);

          // $imageLib = new ImageTool($to);
          // $imageLib->resize(44,44);
          // $imageLib->save($imageInstance->getDirPath().$filename.'_44x44.'.$ext);

          // $imageLib = new ImageTool($to);
          // $imageLib->resize(340,340);
          // $imageLib->save($imageInstance->getDirPath().$filename.'_340x340.'.$ext);

        }

      }

      // resize image 44x44
      // resize image 340x340

      // remove temp dir
      $temporaryFile->deleteTemporaryDirectory($directoryName);

      $temporaryFile->deleteTemporaryRecords($model->modelName,$token);

    }

  }

  private function deleteImages($model,$images) {

    $images = $this
    ->whereIn('filename', $images)
    ->where([
      ['model','=',$model->modelName],
      ['model_id','=',$model->id],
      ['created_by','=',Session::get('Person.id')]
    ]);
    
    $_images = $images->get();

    foreach ($_images as $image) {
      
      $path = $image->getImagePath();

      if(!file_exists($path)){
        continue;
      }

      File::Delete($path);

    }

    $images->delete();

  }

  public function moveImage($oldPath,$to) {
    // move image
    return File::move($oldPath, $to);
  }

  public function getDirPath() {
    return storage_path($this->storagePath.Service::generateModelDir($this->model)).'/'.$this->model_id.'/';
  }

  public function getImagePath() {
    return $this->getDirPath().$this->filename;
  }

  public function getImageUrl() {
    // $path = $this->noImagePath;

    $path = '';
    if(File::exists($this->getImagePath())){
      $path = '/safe_image/'.$this->filename;
    }

    return $path;
  }

  public function base64Encode() {

    $dirPath = 'image/'.strtolower($this->model).'/';
    // $path = $this->noImagePath;

    $path = '';
    if(File::exists($this->getImagePath())){
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
