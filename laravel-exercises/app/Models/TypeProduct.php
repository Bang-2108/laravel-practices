<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduct extends Model
{
    use HasFactory;

    protected $table = 'type_products';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'image', 'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_type','id');
    }
}

