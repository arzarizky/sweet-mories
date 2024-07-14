<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUIDAsPrimaryKey
{
    /**
     * override boot method
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * override getIncrementing method
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * override getKeyType method
     */
    public function getKeyType()
    {
        return 'string';
    }
}
