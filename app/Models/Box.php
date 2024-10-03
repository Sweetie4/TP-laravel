<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{

    use HasFactory;

    protected $table="boxes";

    protected $fillable =[
        'owner_id',
        'address',
        'img_url',
        'price'
    ];
}
