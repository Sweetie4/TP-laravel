<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{

    use HasFactory;

    protected $table = 'tenants';

    protected $fillable=[
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'bank_account'
    ];

    public function user(): HasOne{
        return $this->hasOne(User::class);
    }

    public function contracts():HasMany{
        return $this->hasMany(Contract::class);
    }

    public function box(): HasMany{
        return $this->hasMany(Box::class);
    }
}
