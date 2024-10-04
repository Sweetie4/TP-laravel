<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    
    public function tenant(): HasOne{
        return $this->hasOne(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
