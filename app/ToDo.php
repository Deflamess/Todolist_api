<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $fillable = [
      'task_name',
      'author_id',
      'assigned_to_id',
      'list_id',
      'is_done'
    ];
}