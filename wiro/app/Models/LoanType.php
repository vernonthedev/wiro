<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    //can be given to many loans
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
