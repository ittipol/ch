<?php

namespace App\Models;

use Schema;

class Role extends Model
{
  protected $table = 'roles';
  protected $fillable = ['name','alias'];
}
