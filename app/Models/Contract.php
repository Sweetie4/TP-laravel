<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{

    use HasFactory;

    protected $table= "contracts";

    protected $fillable=[
       'name',
       'owner_id',
       'tenant_id',
       'file_path'
    ];
}
