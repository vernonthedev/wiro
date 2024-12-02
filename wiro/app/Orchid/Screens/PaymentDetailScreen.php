<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use App\Models\Payment;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class PaymentDetailScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Payment $payment): iterable
    {
        return [
            'payment' => $payment,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Payment Details';
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
             //return a tabbed legend to display the payment data in a more concise way.
             Layout::tabs([
                'Payments Made' => Layout::legend('payment', [
                    Sight::make('id', 'Payment ID'),
                    Sight::make('loan_id', 'Loan ID'),
                    Sight::make('date', 'Date Of Payment')->render(function ($row) {
                        return \Carbon\Carbon::parse($row->date_of_birth)->format('d M Y');
                    }),
                    Sight::make('amount', 'Paid Amount'),
                    Sight::make('', 'Remaining Balance'),
                ]),
                'Running Loan' => Layout::legend('payment.loan', [
                    Sight::make('amount', 'Loan Amount'),
                    Sight::make('status', 'Loan Status'),
                ]),
                'Borrower Info' => Layout::legend('payment.loan.borrower', [
                    Sight::make('first_name', 'First Name'),
                    Sight::make('last_name', 'Last Name'),
                    Sight::make('email', 'Email'),
                    Sight::make('whatsapp_number', 'Whatsapp Number'),
                ]),
                'Loan Plan Information' => Layout::legend('payment.loan.loanPlan', [
                    Sight::make('name', 'Plan Name'),
                    Sight::make('interest_rate', 'Interest Rate (%)'),
                    Sight::make('duration', 'Duration (Months)'),
                 
                ]),
                'Loan Type Information' => Layout::legend('payment.loan.loanType', [
                    Sight::make('name', 'Type Name'),
                    Sight::make('description', 'Description'),
                ]),
                
            ]),
        ];
    }
}
