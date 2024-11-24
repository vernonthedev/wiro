<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Textarea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Actions\ModalToggle;
use Illuminate\Http\Request;
use App\Models\Borrowers;
use Orchid\Support\Facades\Toast;
use Orchid\Screen\TD;


class BorrowerScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'borrowers' => Borrowers::latest()->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Borrowers';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Customer')
                ->modal('borrowerModal')
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
            Layout::table('borrowers', [
            TD::make('first_name', "First Name"),
            TD::make('created_at')->sort(),

        ]),

            Layout::modal('borrowerModal', Layout::rows([
                Input::make('borrower.first_name')
                    ->title('First Name')
                    ->placeholder('Enter First Name'),
                    // ->help('The name of the task to be created.'),

                    Input::make('borrower.last_name')
                    ->title('Full Name')
                    ->placeholder('Enter Last name')
                    ->required(),

                    
                    Input::make('borrower.gender')
                    ->title('Gender')
                    ->placeholder('Enter Gender')
                    ->required(),
    
    
                DateTimer::make('borrower.date_of_birth')
                    ->title('Date of Birth')
                    ->format('Y-m-d')
                    ->required(),
    
                Input::make('borrower.whatsapp_number')
                    ->title('WhatsApp Number')
                    ->placeholder('Enter WhatsApp number')
                    ->mask('+999 999 999 999')
                    ->required(),
    
                Input::make('borrower.email')
                    ->type('email')
                    ->title('Email Address')
                    ->placeholder('Enter email address')
                    ->required(),
    
                // Residential Information Section
                TextArea::make('borrower.present_address')
                    ->title('Present Address')
                    ->rows(3)
                    ->required(),
    
                Select::make('borrower.address_type')
                    ->title('Address Type')
                    ->options([
                        'rented' => 'Rented',
                        'owned' => 'Owned'
                    ])
                    ->required(),
    
                Input::make('borrower.landmark')
                    ->title('Landmark')
                    ->placeholder('Enter nearby landmark'),
    
                Input::make('borrower.district_of_residence')
                    ->title('District of Residence')
                    ->required(),
    
                Input::make('borrower.country')
                    ->title('Country')
                    ->required(),
    
                Input::make('borrower.years_in_residence')
                    ->type('number')
                    ->title('Years in Residence')
                    ->min(0)
                    ->required(),
    
                // Business/Employment Information Section
                Input::make('borrower.business_name')
                    ->title('Business/Company Name')
                    ->required(),
    
                Input::make('borrower.role')
                    ->title('Role/Position')
                    ->required(),
    
                Select::make('borrower.status')
                    ->title('Employment Status')
                    ->options([
                        'employed' => 'Employed',
                        'business_owner' => 'Business Owner',
                        'student' => 'Student'
                    ])
                    ->required(),
    
                Input::make('borrower.industry_of_business')
                    ->title('Industry')
                    ->placeholder('Enter business industry'),
    
                TextArea::make('borrower.business_address')
                    ->title('Business Address')
                    ->rows(3),
    
                Input::make('borrower.business_email')
                    ->type('email')
                    ->title('Business Email')
                    ->placeholder('Enter business email'),
    
                Input::make('borrower.business_contact_person')
                    ->title('Business Contact Person')
                    ->placeholder('Enter contact person name'),
    
                Input::make('borrower.business_contact')
                    ->title('Business Contact Number')
                    ->mask('+999 999 999 999'),
    
                Input::make('borrower.business_district')
                    ->title('Business District'),
    
                Input::make('borrower.business_country')
                    ->title('Business Country'),
    
                // Next of Kin Information Section
                Input::make('borrower.next_of_kin_name')
                    ->title('Next of Kin Name')
                    ->required(),
    
                Input::make('borrower.next_of_kin_relationship')
                    ->title('Relationship')
                    ->required(),
    
                Input::make('borrower.next_of_kin_mobile')
                    ->title('Next of Kin Mobile')
                    ->mask('+999 999 999 999')
                    ->required(),
    
                Input::make('borrower.next_of_kin_email')
                    ->type('email')
                    ->title('Next of Kin Email')
                    ->placeholder('Enter next of kin email'),
    
                TextArea::make('borrower.next_of_kin_address')
                    ->title('Next of Kin Address')
                    ->rows(3)
                    ->required(),
    
                Input::make('borrower.next_of_kin_country')
                    ->title('Next of Kin Country')
                    ->required(),
    
                Input::make('borrower.next_of_kin_district')
                    ->title('Next of Kin District')
                    ->required(),
    
                Input::make('borrower.next_of_kin_city')
                    ->title('Next of Kin City')
                    ->required(),
            ]))
                ->title('Create New Borrower')
                ->applyButton('Add Customer'),
        ];
    }

    //lets make the descriptions
    public function description(): ?string
    {
        return 'All Customers in the system';
    }

    //save the borrower to the database
    public function save(Request $request, Borrowers $borrower)
    {
        $validated = $request->validate([
            'borrower.first_name' => 'required|string|max:255',
            'borrower.last_name' => 'required|string|max:255',
            'borrower.gender' => 'required|string|max:255',
            'borrower.date_of_birth' => 'required|date|before:today',
            'borrower.whatsapp_number' => 'required|string|max:20',
            'borrower.email' => 'required|email|unique:borrowers,email,'.$borrower->id,
            
            'borrower.present_address' => 'required|string',
            'borrower.address_type' => 'required|in:rented,owned',
            'borrower.landmark' => 'nullable|string|max:255',
            'borrower.district_of_residence' => 'required|string|max:255',
            'borrower.country' => 'required|string|max:255',
            'borrower.years_in_residence' => 'required|integer|min:0',
            
            'borrower.business_name' => 'required|string|max:255',
            'borrower.role' => 'required|string|max:255',
            'borrower.status' => 'required|in:employed,business_owner,student',
            'borrower.industry_of_business' => 'nullable|string|max:255',
            'borrower.business_address' => 'nullable|string',
            'borrower.business_email' => 'nullable|email',
            'borrower.business_contact_person' => 'nullable|string|max:255',
            'borrower.business_contact' => 'nullable|string|max:20',
            'borrower.business_district' => 'nullable|string|max:255',
            'borrower.business_country' => 'nullable|string|max:255',
            
            'borrower.next_of_kin_name' => 'required|string|max:255',
            'borrower.next_of_kin_relationship' => 'required|string|max:255',
            'borrower.next_of_kin_mobile' => 'required|string|max:20',
            'borrower.next_of_kin_email' => 'nullable|email',
            'borrower.next_of_kin_address' => 'required|string',
            'borrower.next_of_kin_country' => 'required|string|max:255',
            'borrower.next_of_kin_district' => 'required|string|max:255',
            'borrower.next_of_kin_city' => 'required|string|max:255',
        ]);

        Borrowers::create($validated['borrower']); 

        Toast::success('Borrower was saved successfully!');

        return redirect()->route('platform.borrowers');
    }
}
