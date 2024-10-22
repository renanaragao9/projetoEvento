<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'items' => 'array',
        'image' => 'array',
        'date'=>'datetime'
    ];

    protected $dates = ['date'];

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function users() {
        return $this->belongsToMany('App\Models\User');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
