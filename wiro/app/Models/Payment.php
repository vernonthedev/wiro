<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'amount', 'date'];

    // someone can only make payments for the loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
