<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    protected $fillable = [
      'task_name',
      'author_id',
      'assigned_to_id',
      'lists_id',
      'is_done'
    ];

    public function lists()
    {
        return $this->belongsTo(Lists::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}