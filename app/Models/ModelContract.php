<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelContract extends Model
{

    use HasFactory;

    protected $table= "models_contract";

    protected $fillable=[
       'landlord_id',
       'name',
       'content'
    ];
}
