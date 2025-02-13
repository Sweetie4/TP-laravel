<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{

    use HasFactory;

    protected $table = 'payments';

    protected $fillable=[
        'contract_id',
        'due_date',
        'payment_date'
    ];
    

    public function contract():BelongsTo {
        return $this->belongsTo(Contract::class);
    }
}
