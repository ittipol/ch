<?php

namespace App\Models;

class Province extends Model
{
  public $table = 'provinces';
  protected $fillable = ['name'];
  public $timestamps  = false;
}
