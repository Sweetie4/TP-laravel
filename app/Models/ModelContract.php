<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModelContract extends Model
{

    use HasFactory;

    protected $table= "models_contract";

    protected $fillable=[
       'landlord_id',
       'name',
       'content'
    ];

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts():HasMany {
        return $this->hasMany(Contract::class);
    }
}
