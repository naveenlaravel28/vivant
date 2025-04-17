<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packing extends Model
{
    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function pakingDetails() {
        return $this->hasMany(PackingDetail::class, 'packing_id');
    }
}
