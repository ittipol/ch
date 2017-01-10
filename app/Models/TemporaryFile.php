<?php

namespace App\Models;

use File;

class TemporaryFile extends Model
{
  protected $table = 'temporary_files';
  protected $fillable = ['model','filename','token','file_type','created_by'];
  private $temporaryPath = 'temporary/';

  public function moveTemporaryFile($path) {
    return File::move($path, storage_path($this->temporaryPath).$this->filename);
  }

  public function getTemporaryPath() {
    return $this->temporaryPath;
  }

  public function getFilePath($filename) {
    return storage_path($this->temporaryPath).$filename;
  }

  public function setUpdatedAt($value) {}

}
