<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Payment extends Model
{
    use HasFactory, AsSource;

    protected $fillable = ['loan_id', 'amount', 'date'];

    // someone can only make payments for the loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
