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
use App\Models\LoanPlan;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\TD;

class LoanPlanListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'loan_plans' => LoanPlan::latest()->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Available Loan Plans';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Loan Plan')
            ->modal('loanPlanModal')
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
            Layout::table('loan_plans', [
                TD::make('name', 'Plan Name'),
                TD::make('interest_rate', 'Interest Rate (%)'),
                TD::make('duration', 'Duration (Months)'),
                // TD::make('actions', 'Actions')
                //     ->render(function (LoanPlan $loanPlan) {
                //         return Link::make('Edit')
                //             ->route('platform.loan-plans.edit', $loanPlan->id);
                //     }),
            ]),
    
            Layout::modal('loanPlanModal', Layout::rows([ // Wrap input fields in Layout::rows()
                Input::make('loan_plan.name')
                    ->title('Plan Name')
                    ->placeholder('Enter Loan Plan Name'),
    
                Input::make('loan_plan.interest_rate')
                    ->title('Interest Rate')
                    ->placeholder('Enter Interest Rate'),
    
                Input::make('loan_plan.duration')
                    ->title('Duration')
                    ->placeholder('Enter Duration'),
            ]))
                ->title('Create New Loan Plan')
                ->applyButton('Add Loan Plan'),
        ];
    }

    
    //lets make the descriptions
    public function description(): ?string
    {
        return 'All Plans for the different Available loans';
    }

    //let's save our data to the database
    public function save(Request $request, LoanPlan $loan_plan)
    {
        $validated = $request->validate([
            'loan_plan.name' => 'required|string|max:255',
            'loan_plan.interest_rate' => 'required|integer|min:0',
            'loan_plan.duration' => 'required|string|max:255',
        ]);

        LoanPlan::create($validated['loan_plan']); 

        Toast::success('Loan was created successfully!');

        return redirect()->route('platform.loan.plans');
    }

}
