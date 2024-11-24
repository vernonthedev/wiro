<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['borrower_id', 'loan_plan_id', 'loan_type_id', 'amount', 'status'];

    public function borrower()
    {
        return $this->belongsTo(Borrower::class);
    }

    public function loanPlan()
    {
        return $this->belongsTo(LoanPlan::class);
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
