<?php

namespace App\library;

class Image
{
  private $image;
  private $filename;
  private $width;
  private $height;
  private $maxFileSizes;
  private $acceptedFileTypes;
  private $cachePath = 'cache/';

  private $imageCache = array(
    'xs' => array(
      'width' => 50,
      'height' => 50,
      'fx' => '',
    ),
    // 'sm' => array(
    //   'width' => ,
    //   'height' => ,
    //   'fx' => '',
    // ),
    // 'md' => array(
    //   'width' => ,
    //   'height' => ,
    //   'fx' => '',
    // ),
    'list' => array(
      'width' => 250,
      'height' => 250,
      'fx' => 'getImageSizeByRatio',
    ),
  );

  public function __construct($image = null) {

    $url = new Url;

    $this->cachePath = $url->addSlash(storage_path($this->cachePath));

    if(!empty($image)) {

      $this->image = $image;
      $this->generateFileName();

      list($this->width,$this->height) = getimagesize($this->image->getRealPath());

      $model = Service::loadModel('Image');
      $this->maxFileSizes = $model->getMaxFileSizes();
      $this->acceptedFileTypes = $model->getAcceptedFileTypes();

    }

  }

  private function generateFileName() {
    $this->filename = time().Token::generateNumber(15).$this->image->getSize().'.'.$this->image->getClientOriginalExtension();
  }

  public function getFileName() {
    return $this->filename;
  }

  public function getOriginalFileName() {
    return $this->image->getClientOriginalName();
  }

  public function getRealPath() {
    return $this->image->getRealPath();
  }

  public function checkFileType() {
    return in_array($this->image->getMimeType(), $this->acceptedFileTypes);
  }

  public function checkFileSize() {
    if($this->image->getSize() <= $this->maxFileSizes){
      return true;
    }
    return false;
  }

  public function generateImageSize($imageType,$originalWidth = null,$originalHeight = null){

    if(empty($originalWidth)) {
      $originalWidth = $this->width; 
    }

    if(empty($originalHeight)) {
      $originalHeight = $this->height; 
    }

    $ratio = abs($originalWidth/$originalHeight);

    $width = $originalWidth;
    $height = $originalHeight;

    if($imageType == 'photo') {

      if(($originalWidth > 960) || ($originalHeight > 960)) {

        if($originalWidth > $originalHeight) {

          $width = 960;

          if(($ratio > 1) && ($ratio < 1.6)) {
            $width = $originalWidth/2;
          } 

          $height = round($originalHeight*($width/$originalWidth));

        }elseif($originalWidth < $originalHeight) {

          $height = 960;

          if(($ratio > 1) && ($ratio < 1.6)) {
            $height = $originalHeight/2;
          } 

          $width = round($originalWidth*($height/$originalHeight));

        }else {
          // ratio = 1
          $width = 960;
          $height = 960;
        }  

      }

    }elseif($imageType == 'profile-image') {
      // avatar fix height at 320px
      // or automatic crop
      $height = 400;
      $width = round($originalWidth*($height/$originalHeight));
    }

    return array($width,$height);

  }

  public function getCacheImageUrl($model,$alias) {

    $url = new Url;

    $ext = pathinfo($model->filename, PATHINFO_EXTENSION);
    $filename = pathinfo($model->filename, PATHINFO_FILENAME);

    $value = $this->imageCache[$alias];
    $_filename = $filename.'_'.$value['width'].'x'.$value['height'].'.'.$ext;
    $path = $url->addSlash($this->cachePath.$filename).$_filename;
dd(file_exists($path));
    $path = '';
    if(File::exists($this->getImagePath())){
      $path = '/safe_image/'.$filename;
    }

    return $path;
  }

  public function cache($model,$alias) {

    $url = new Url;

    // check image in cache first
    // if() {

    // }

    $path = $model->getImagePath();

    if(!file_exists($path)){
      return false;
    }

    $value = $this->imageCache[$alias];

    $ext = pathinfo($model->filename, PATHINFO_EXTENSION);
    $filename = pathinfo($model->filename, PATHINFO_FILENAME);
    list($originalWidth,$originalHeight) = getimagesize($path);

    $width = $value['width'];
    $height = $value['height'];

    if(!empty($value['fx']) && method_exists($this,$value['fx'])) {
      list($width,$height) = $this->getImageSizeByRatio($originalWidth,$originalHeight,$width,$height);
    }

    $cachePath = $url->addSlash($this->cachePath.$filename);
    if(!is_dir($cachePath)){
      mkdir($cachePath,0777,true);
    }

    $filename = $filename.'_'.$width.'x'.$height.'.'.$ext;

    $imageLib = new ImageTool($path);
    $imageLib->resize($width,$height);
    return $imageLib->save($cachePath.$filename);

  }

  public function getImageSizeByRatio($originalWidth,$originalHeight,$width,$height) {

    if (($originalWidth > $originalHeight) && (abs($originalWidth - $originalHeight) > 280)){
      $width = (int)ceil($originalWidth*($height/$originalHeight));
    } else if (($originalWidth < $originalHeight) && (abs($originalWidth - $originalHeight) > 280)){
      $height = (int)ceil($originalHeight*($width/$originalWidth));
    }

    return array($width,$height);
  }

}