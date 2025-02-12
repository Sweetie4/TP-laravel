<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Box extends Model
{

    use HasFactory;

    protected $table="boxes";

    protected $fillable =[
        'owner_id',
        'tenant_id',
        'address',
        'img_url',
        'price'
    ];

    
    public function tenant(): BelongsTo{
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany {
        return $this->hasMany(Contract::class);
    }
}
