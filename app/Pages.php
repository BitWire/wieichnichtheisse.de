<?php

namespace App;

use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    protected $fillable = [
        'name', 'altNames'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->setAttribute($model->getKeyName(), Uuid::generate(4));
        });
    }
}
