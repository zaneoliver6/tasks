<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'priority',
        'project_id',
    ];

    public function saveQuietly()
    {
        return static::withoutEvents(function() {
            return $this->save();
        });
    }
}
