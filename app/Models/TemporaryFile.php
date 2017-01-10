<?php

namespace App\Models;

class TemporaryFile extends Model
{
  protected $table = 'temporary_files';
  protected $fillable = ['model','filename','token','file_type','created_by'];

  public function setUpdatedAt($value) {}
}
