<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class LoanPlan extends Model
{
    use HasFactory, AsSource;

    protected $fillable = ['name', 'interest_rate', 'duration'];

    //can be given to many loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
