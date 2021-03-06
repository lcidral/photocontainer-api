<?php

namespace PhotoContainer\PhotoContainer\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Event extends EloquentModel
{
    protected $table = 'events';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}