<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Loan extends Model
{
    use HasFactory, AsSource;

    protected $fillable = ['borrower_id', 'loan_plan_id', 'loan_type_id', 'amount', 'status'];

    public function borrower()
    {
        return $this->belongsTo(Borrowers::class, 'borrower_id');
    }

    public function loanPlan()
    {
        return $this->belongsTo(LoanPlan::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class, 'loan_type_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
