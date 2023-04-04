<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::calss);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::calss);
    }

    public function user()
    {
        return $this->belongsTo(User::calss);
    }
}
