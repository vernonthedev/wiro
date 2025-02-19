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
use App\Models\LoanType;
use App\Models\Borrowers;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\TD;

class LoanListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'loans' => Loan::latest()->get(),
            'borrowers'=> Borrowers::all(),
            'loan_plans'=> LoanPlan::all(),
            'loan_types'=> LoanType::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Running Loans';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Create New Loan Application')
            ->modal('loanModal')
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
            Layout::table('loans', [
                TD::make('borrower.first_name', 'Borrower')
                    ->render(fn($loan) => $loan->borrower->first_name . ' ' . $loan->borrower->last_name),
                TD::make('amount', 'Loan Amount(UGX)'),
                TD::make('status', 'Status'),
                TD::make('loanType.name', 'Loan Type')
                    ->render(fn($loan) => $loan->loanType->name ?? 'N/A'),
                TD::make('actions', 'Actions')
                    ->render(function (Loan $loan) {
                        return Link::make('Details')->route('platform.loan.details', $loan->id);
                    }),
            ]),

            // Loan creation modal
            Layout::modal('loanModal', Layout::rows([
                Select::make('loan.borrower_id') 
                    ->title('Borrower')
                    ->options($this->query()['borrowers']->pluck('first_name', 'id')->toArray()) //get the available borrowers in the sys
                    ->placeholder('Select Borrower')
                    ->required(),

                Select::make('loan.loan_plan_id') 
                    ->title('Loan Plan')
                    ->options($this->query()['loan_plans']->pluck('name', 'id')->toArray()) //get the available loan plans
                    ->placeholder('Select Loan Plan')
                    ->required(),

                Select::make('loan.loan_type_id')
                    ->fromModel(LoanType::class, 'name')
                    ->title('Loan Type')
                    ->empty('Select Loan Type')
                    ->required(),

                Input::make('loan.amount')
                    ->title('Loan Amount')
                    ->placeholder('Enter Loan Amount')
                    ->required(),

                Input::make('loan.interest_rate')  
                    ->title('Interest Rate')
                    ->placeholder('Enter Interest Rate')
                    ->required(),

                Input::make('loan.duration') 
                    ->title('Duration (Months)')
                    ->placeholder('Enter Duration')
                    ->required(),
            ]))
            ->title('Create New Loan')
            ->applyButton('Add Loan'),
        ];
    }

    //lets make the descriptions
    public function description(): ?string
    {
        return 'All Loans That have ever been taken by the customers';
    }

  
    //let's save our data to the database
    public function save(Request $request, LoanPlan $loan_plan, Loan $loan)
    {
        $validated = $request->validate([
            'loan.borrower_id' => 'required|exists:borrowers,id', // Borrower selection validation
            'loan.loan_type_id' => 'required|exists:loan_types,id',
            'loan.loan_plan_id' => 'required|exists:loan_plans,id', // Loan plan validation
            'loan.amount' => 'required|numeric|min:1',
            'loan.interest_rate' => 'required|numeric|min:0',
            'loan.duration' => 'required|integer|min:1',
        ]);

        // Loan::create($validated['loan']); 
        Loan::create([
            'borrower_id' => $validated['loan']['borrower_id'],
            'loan_plan_id' => $validated['loan']['loan_plan_id'],
            'loan_type_id' => $validated['loan']['loan_type_id'],
            'amount' => $validated['loan']['amount'],
            'interest_rate' => $validated['loan']['interest_rate'],
            'duration' => $validated['loan']['duration'],
            'status' => 'pending', // Set status as pending
        ]);

        Toast::success('Loan was created successfully!');

        return redirect()->route('platform.loan.plans');
    }
}
