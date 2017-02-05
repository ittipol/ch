<?php

namespace App\Models;

// use App\library\token;
use App\library\service;
use App\library\imageTool;
use App\library\url;
use File;
use Session;

class Image extends Model
{
  protected $table = 'images';
  protected $fillable = ['original_image_id','model','model_id','path','filename','description','image_type_id','created_by'];
  private $maxFileSizes = 2097152;
  private $acceptedFileTypes = ['image/jpg','image/jpeg','image/png', 'image/pjpeg'];

  private $imagePatterns = array(
    'profile-image' => array(
      'path' => 'profile',
      'rename' => 'profile-image'
    ),
    'cover' => array(
      'path' => 'profile',
      'rename' => 'cover'
    ),
    'image' => array(
      'path' => 'images'
    )
  );

  private $prefix = 'image';

  // photos/?tab=album&album_id=270003133398148
  // photos/?tab=album&album_id=1299989693406181

  public function __construct() {  
    parent::__construct();
  }

  public function imageType() {
    return $this->hasOne('App\Models\ImageType','id','image_type_id');
  }

  public function __saveRelatedData($model,$options = array()) {
    // $this->deleteImages($model,$options['value']['delete']);
    $this->saveImages($model,$options['value'],$options);
  }

  private function saveImages($model,$images,$options = array()) {

    $temporaryFile = new TemporaryFile;
    $imageType = new ImageType;

    $count = array();

    foreach ($images as $type => $value) {

      if(!$imageType->checkExistByAlias($type) || 
        (empty($model->images[$type]) || 
        ($model->images[$type]['limit'] == 0))) 
      {
        continue;
      }

      $directoryName = $model->modelName.'_'.$value['token'].'_'.$type;

      $count[$type] = 0;

      // Get Image type
      $imageType = $imageType->where('alias','like',$type)->select('path')->first();

      foreach ($value['images'] as $image) {

        if($model->images[$type]['limit'] < ++$count[$type]) {
          break;
        }

        $path = $temporaryFile->getFilePath($image['filename'],array(
          'directoryName' => $directoryName
        ));

        if(!file_exists($path)){
          continue;
        }

        $_value = array(
          'filename' => $image['filename'],
          'image_type_id' => $imageType->getIdByalias($type)
        );

        if(!empty($image['description'])) {
          $_value['description'] = $image['description'];
        }

        $imageInstance = $this->newInstance();
        if($imageInstance->fill($model->includeModelAndModelId($_value))->save()) {

          $toPath = $imageInstance->getDirPath().$imageInstance->imageType->path;
          if(!is_dir($toPath)){
            mkdir($toPath,0777,true);
          }

          $this->moveImage($path,$imageInstance->getImagePath());

        }

      }

      // remove temp dir
      $temporaryFile->deleteTemporaryDirectory($directoryName);

      $temporaryFile->deleteTemporaryRecords($model->modelName,$value['token']);

    }

  }

  // public function cache($model) {

  //   $imageStyle = new ImageStyle;

  //   $imagePath = $this->getImagePath();

  //   $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
  //   $filename = pathinfo($this->filename, PATHINFO_FILENAME);
  //   list($originalWidth,$originalHeight) = getimagesize($imagePath);

  //   $styles = $imageStyle->whereIn('alias',$model->getImageCache())->get();

  //   foreach ($styles as $style) {

  //     $width = $style->width;
  //     $height = $style->height;

  //     if(!empty($style->fx) && method_exists($imageStyle,$style->fx)) {
  //       list($width,$height) = $imageStyle->getImageSizeByRatio($originalWidth,$originalHeight,$width,$height);
  //     }

  //     $_filename = $filename.'_'.$width.'x'.$height.'.'.$ext;

  //     $path = $this->getDirPath().$style->path_name;
  //     if(!is_dir($path)){
  //       mkdir($path,0777,true);
  //     }

  //     $imageLib = new ImageTool($imagePath);
  //     $imageLib->resize($width,$height);
  //     $imageLib->save($path.'/'.$_filename);

  //     $value = array(
  //       'original_image_id' => $this->id,
  //       'filename' => $_filename,
  //       'image_style_id' => $imageStyle->getIdByalias($style->alias)
  //     );

  //     $this->newInstance()->fill($model->includeModelAndModelId($value))->save();

  //   }
    
  // }

  private function deleteImages($model,$imageIds) {

    $images = $this->newInstance();

    foreach ($imageIds as $imageId) {
      $images = $images->orWhere('id','=',$imageId)->orWhere('original_image_id','=',$imageId);
    }

    $images = $images->where([
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
    return storage_path($this->storagePath.Service::generateUnderscoreName($this->model)).'/'.$this->model_id.'/';
  }

  public function getImagePath($filename = '') {

    if(empty($filename)) {
      $filename = $this->filename;
    }

    if(!empty($this->imageType->path)) {
      $url = new Url;
      $filename = $url->addSlash($this->imageType->path).$filename;
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

  public function getFirstImage($model,$style) {

    $imageStyle = new ImageStyle;

    $image = $model->getRalatedModelData('Image',array(
      'conditions' => array(
        array('image_style_id','=',$imageStyle->getIdByalias($style))
      ),
      'first' => true
    ));

    $_image = array();
    if(!empty($image)) {
      $_image = $image->buildModelData();
    }

    return $_image;

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

    return array(
      'filename' => $this->filename,
      'description' => $this->description ? $this->description : '-',
      '_url' => $this->getImageUrl()
    );

  }

  public function buildFormData() {

    return array(
      'id' => $this->id,
      // 'filename' => $this->filename,
      'description' => $this->description ? $this->description : '',
      '_url' => $this->getImageUrl()
    );

  }

}
