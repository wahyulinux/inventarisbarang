<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['category_id', 'warehouse_id', 'name', 'sku', 'stock', 'price', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
