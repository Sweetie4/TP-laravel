<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{

    use HasFactory;

    protected $table= "contracts";

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    
    protected $fillable=[
       'name',
       'owner_id',
       'tenant_id',
       'box_id',
       'model_id',
       'monthly_price',
       'start_date',
       'end_date',
       'file_path'
    ];

    public function tenant():BelongsTo{
        return $this->belongsTo(Tenant::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function box(): BelongsTo
    {
        return $this->belongsTo(Box::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(ModelContract::class);
    }

    public function payments() : HasMany {
        return $this->hasMany(Payment::class);
    }
}
