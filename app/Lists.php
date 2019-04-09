<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'list_name'
    ];

    protected function todo()
    {
        return $this->hasMany(ToDo::class);
    }

    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}