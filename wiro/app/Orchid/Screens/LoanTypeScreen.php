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
use App\Models\LoanType;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\TD;

class LoanTypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'loan_types' => LoanType::latest()->get(),
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
            ->modal('LoanTypeModal')
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
            Layout::table('loan_types', [
                TD::make('name', 'Type Name'),
                TD::make('description', 'Type Description'),
                TD::make('actions', 'Actions')
                    ->render(function (LoanType $LoanType) {
                        return Link::make('Edit')
                            ->route('platform.loan.types', $LoanType->id);
                    }),
            ]),
    
            Layout::modal('LoanTypeModal', Layout::rows([
                Input::make('loan_type.name')
                    ->title('Loan Type')
                    ->placeholder('Enter loan type name')
                    ->required(),

                Input::make('loan_type.description')
                    ->title('Description')
                    ->placeholder('Enter a description for the loan type'),
            ]))
                ->title('Create New Loan Type')
                ->applyButton('Add Loan Type'),
        ];
    }

    
    //lets make the descriptions
    public function description(): ?string
    {
        return 'All Types for the different Available loans';
    }

    //let's save our data to the database
    public function save(Request $request, LoanType $loan_type)
    {
        $validated = $request->validate([
            'loan_type.name' => 'required|string|max:255',
            'loan_type.description' => 'required|string|max:1024',
        ]);

        LoanType::create($validated['loan_type']); 

        Toast::success('Loan Type was created successfully!');

        return redirect()->route('platform.loan.types');
    }

}
