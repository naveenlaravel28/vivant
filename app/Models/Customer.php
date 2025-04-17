<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
