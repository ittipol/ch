<?php

namespace App\Models;

use App\library\token;
use App\library\service;
use App\library\imageTool;
use File;
use Session;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['original_image_id','model','model_id','filename','description','image_style_id','created_by'];
  private $maxFileSizes = 1048576;
  private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

  public function __construct() {  
    parent::__construct();
  }

  public function imageStyle() {
    return $this->hasOne('App\Models\ImageStyle','id','image_style_id');
  }

  public function __saveRelatedData($model,$options = array()) {
    $this->saveImages($model,$options['value'],$options);
  }

  private function saveImages($model,$images,$options = array()) {

    $temporaryFile = new TemporaryFile;
    $imageStyle = new ImageStyle;

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
          'image_style_id' => $imageStyle->getIdByalias('original')
        );

        if(!empty($image['description'])) {
          $value = array_merge($value,array(
            'description' => $image['description']
          ));
        }

        $imageInstance = $this->newInstance();
        if($imageInstance->fill($model->includeModelAndModelId($value))->save()) {

          $this->moveImage($path,$imageInstance->getImagePath());
          $imageInstance->cache($model);

        }

      }

      // remove temp dir
      $temporaryFile->deleteTemporaryDirectory($directoryName);

      $temporaryFile->deleteTemporaryRecords($model->modelName,$token);

    }

  }

  public function cache($model) {

    $imageStyle = new ImageStyle;

    $imagePath = $this->getImagePath();

    $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
    $filename = pathinfo($this->filename, PATHINFO_FILENAME);

    $imageInfo = getimagesize($imagePath);

    $h = 50;
    $w = 50;
    // $w = (int)ceil($imageInfo[0]*($h/$imageInfo[1]));
    $_filename = $filename.'_'.$w.'x'.$h.'.'.$ext;

    // $path = $this->getDirPath().'xs/';
    // if(!is_dir($path)){
    //   mkdir($path,0777,true);
    // }

    $imageLib = new ImageTool($imagePath);
    $imageLib->resize($w,$h);
    $imageLib->save($this->getDirPath().$_filename);

    $value = array(
      'original_image_id' => $this->id,
      'filename' => $_filename,
      'image_style_id' => $imageStyle->getIdByalias('xs')
    );

    $this->newInstance()->fill($model->includeModelAndModelId($value))->save();

    // =====================================================================

    $h = 250;
    $w = 250;
    $_filename = $filename.'_'.$w.'x'.$h.'.'.$ext;

    // $path = $this->getDirPath().'list/';
    // if(!is_dir($path)){
    //   mkdir($path,0777,true);
    // }

    $imageLib = new ImageTool($imagePath);
    $imageLib->resize($w,$h);
    $imageLib->save($this->getDirPath().$_filename);

    $value = array(
      'original_image_id' => $this->id,
      'filename' => $_filename,
      'image_style_id' => $imageStyle->getIdByalias('list')
    );

    $this->newInstance()->fill($model->includeModelAndModelId($value))->save();

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

  public function getImagePath($filename = '') {

    if(empty($filename)) {
      $filename = $this->filename;
    }

    return $this->getDirPath().$filename;
  }

  public function getImageUrl($filename = '') {

    if(empty($filename)) {
      $filename = $this->filename;
    }

    $path = '';
    if(File::exists($this->getImagePath())){
      $path = '/safe_image/'.$filename;
    }

    return $path;
  }

  public function base64Encode() {

    $dirPath = 'image/'.strtolower($this->model).'/';

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

  public function buildModelData() {

    if(empty($this)) {
      return null;
    }

    return array(
      'filename' => $this->filename,
      'description' => $this->description,
      '_url' => $this->getImageUrl()
    );

  }

}
