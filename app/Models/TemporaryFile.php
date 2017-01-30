<?php

namespace App\Models;

use File;
use Session;

class TemporaryFile extends Model
{
  protected $table = 'temporary_files';
  protected $fillable = ['model','filename','token','file_type','created_by'];
  private $temporaryPath = 'temporary/';

  public function moveTemporaryFile($oldPath,$filename,$options = array()) {

    $temporaryPath = storage_path($this->temporaryPath);

    if(!is_dir($temporaryPath)){
      mkdir($temporaryPath,0777,true);
    }

    if(!empty($options['directoryName'])) {
      $temporaryPath .= $options['directoryName'].'/';

      if(!is_dir($temporaryPath)){
        mkdir($temporaryPath,0777,true);
      }

    }

    return File::move($oldPath, $temporaryPath.$filename);
  }

  public function getFilePath($filename,$options = array()) {

    $temporaryPath = storage_path($this->temporaryPath);

    if(!empty($options['directoryName'])) {
      $temporaryPath .= $options['directoryName'].'/';
    }

    return $temporaryPath.$filename;
  }

  public function getTemporaryPath() {
    return $this->temporaryPath;
  }

  public function deleteTemporaryFile($directoryName,$filename) {

    if(empty($directoryName) || empty($filename)) {
      return false;
    }

    return File::Delete(storage_path($this->temporaryPath).$directoryName.'/'.$filename);
  }

  public function deleteTemporaryDirectory($directoryName) {

    if(empty($directoryName)) {
      return false;
    }

    return File::deleteDirectory(storage_path($this->temporaryPath).$directoryName);
  }

  public function checkExistSpecifiedTemporaryRecord($modelName,$token) {
    return $this->where([
      ['model','=',$modelName],
      ['token','=',$token],
      ['created_by','=',Session::get('Person.id')]
    ])->exists();
  }

  public function deleteSpecifiedTemporaryRecord($modelName,$token,$filename) {
    return $this->where([
      ['model','=',$modelName],
      ['token','=',$token],
      ['filename','=',$filename],
      ['created_by','=',Session::get('Person.id')]
    ])->delete();
  }

  public function deleteTemporaryRecords($modelName,$token) {
    return $this->where([
      ['model','=',$modelName],
      ['token','=',$token],
      ['created_by','=',Session::get('Person.id')]
    ])->delete();
  }

  public function setUpdatedAt($value) {}

}
