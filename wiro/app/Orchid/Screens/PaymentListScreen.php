<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Textarea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\LoanPlan;
use App\Models\Payment;
use App\Models\Borrowers;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\TD;

class PaymentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'payments'=> Payment::latest()->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'All Payments';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add New Payment')
            ->modal('paymentModal')
            ->method('save')
            ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('payments', [
                TD::make('loan_id', 'Loan')
                    ->render(fn(Payment $payment) => $payment->loan->borrower->first_name . ' ' . $payment->loan->borrower->last_name),
                TD::make('amount', 'Amount'),
                TD::make('date', 'Payment Date'),
                TD::make('actions', 'Actions')
                    ->render(function (Payment $payment) {
                        return Link::make('Details')
                            ->route('platform.payments', $payment->id);
                    }),
            ]),

            Layout::modal('paymentModal', Layout::rows([
                Select::make('payment.loan_id')
                    ->title('Loan')
                    ->options(function () {
                        // Using query to get the loan options
                        return Loan::with('borrower')
                            ->get()
                            ->mapWithKeys(function ($loan) {
                                return [
                                    $loan->id => $loan->borrower->first_name . ' ' . $loan->borrower->last_name
                                ];
                            })
                            ->toArray();
                    })
                    ->required(),

                Input::make('payment.amount')
                    ->title('Amount Paid')
                    ->type('number')
                    ->placeholder('Enter payment amount')
                    ->required(),

                DateTimer::make('payment.date')
                    ->title('Payment Date')
                    ->format('Y-m-d')
                    ->required(),
            ]))
                ->title('Add Payment')
                ->applyButton('Save Payment'),
        ];
    }

    //lets make the descriptions
    public function description(): ?string
    {
        return 'All Payments That have ever been taken by the customers';
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'payment.loan_id' => 'required|exists:loans,id',
            'payment.amount' => 'required|numeric|min:1',
            'payment.date' => 'required|date',
        ]);

        Payment::create([
            'loan_id' => $validated['payment']['loan_id'],
            'amount' => $validated['payment']['amount'],
            'date' => $validated['payment']['date'],
        ]);

        Toast::success('Payment saved successfully!');

        return redirect()->route('platform.payments');
    }

}
