<?php
namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use App\Models\Loan;
use App\Models\Borrowers;
use Orchid\Screen\Actions\Link;

class BorrowerHistoryScreen extends Screen
{
    public $borrower;  // To hold the borrower object

    public function query(Borrowers $borrower): iterable
    {
        $this->borrower = $borrower;  // Assign the borrower object

        // Fetch all loans associated with the borrower
        $loans = $borrower->loans()->latest()->get();

        return [
            'loans' => $loans,
        ];
    }

    public function name(): ?string
    {
        return 'Borrower Loan History';
    }

    public function description(): ?string
    {
        return 'View all loans for the selected borrower';
    }

    public function layout(): iterable
    {
        return [
            Layout::table('loans', [
                TD::make('id', 'No.'),
                TD::make('amount', 'Loan Amount'),
                TD::make('status', 'Status'),
                TD::make('created_at', 'Loan Date')
                    ->render(fn($loan) => $loan->created_at->format('d M Y')),
                TD::make('actions', 'Actions')
                    ->render(function (Loan $loan) {
                        return Link::make('View Loan Details')
                            ->route('platform.loan.details', $loan->id);  // Link to loan details page
                    }),
            ]),
        ];
    }
}
