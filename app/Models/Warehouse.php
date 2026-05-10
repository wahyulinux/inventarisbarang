<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = ['name', 'code', 'address', 'description'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
