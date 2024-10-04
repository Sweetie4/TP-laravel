<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{

    use HasFactory;

    protected $table = 'tenants';

    protected $fillable=[
        'box_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'bank_account'
    ];

    public function box(): HasOne{
        return $this->hasOne(Box::class);
    }
}
