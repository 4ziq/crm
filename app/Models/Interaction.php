<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    /** @use HasFactory<\Database\Factories\InteractionFactory> */
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'interaction_date',
        'type',
        'notes',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
