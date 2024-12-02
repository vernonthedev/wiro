<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use App\Models\Loan;
use Orchid\Screen\TD;
use App\Models\Payment;
use Orchid\Screen\Actions\Link;

class LoanDetailScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Loan $loan): iterable
    {
        return [
            'loan' => $loan,
            // 'loan' => $loans->load(['borrower', 'loanPlan', 'loanType']),
            
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Loan Details';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            //return a tabbed legend to display the loan data in a more concise way.
            Layout::tabs([
                'Basic Details' => Layout::legend('loan', [
                    Sight::make('id', 'Loan ID'),
                    Sight::make('amount', 'Loan Amount'),
                    Sight::make('status', 'Loan Status'),
                ]),
                'Borrower Details' => Layout::legend('loan.borrower', [
                    Sight::make('first_name', 'First Name'),
                    Sight::make('last_name', 'Last Name'),
                    Sight::make('email', 'Email'),
                    Sight::make('whatsapp_number', 'Whatsapp Number'),
                ]),
                'Loan Plan Details' => Layout::legend('loan.loanPlan', [
                    Sight::make('name', 'Plan Name'),
                    Sight::make('interest_rate', 'Interest Rate (%)'),
                    Sight::make('duration', 'Duration (Months)'),
                 
                ]),
                'Loan Type Details' => Layout::legend('loan.loanType', [
                    Sight::make('name', 'Type Name'),
                    Sight::make('description', 'Description'),
                ]),
                'Payments Made' => Layout::table('loan.payments', [
                    TD::make('id', 'ID.'),
                    TD::make('loan_id', 'Loan')
                        ->render(fn(Payment $payment) => $payment->loan->borrower->first_name . ' ' . $payment->loan->borrower->last_name),
                    TD::make('amount', 'Amount(UGX)'),
                    TD::make('date', 'Payment Date')->render(function ($row) {
                        return \Carbon\Carbon::parse($row->date_of_birth)->format('d M Y');
                    }),
                    ]),
            ]),
        ];
    }
}
