<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'path', 'type', 'size', 'extension', 'mime_type', 'public_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
