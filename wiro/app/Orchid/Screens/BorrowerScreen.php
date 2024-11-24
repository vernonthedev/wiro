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
            // Personal Information
            TD::make('first_name', "First Name")->width('100px'),
            TD::make('last_name', "Last Name")->width('100px'),
            TD::make('gender', "Gender")->width('100px'),
            TD::make('date_of_birth', 'Date Of Birth')
            ->render(function ($row) {
                return \Carbon\Carbon::parse($row->date_of_birth)->format('d M Y');
            }),
            TD::make('whatsapp_number', "Whatsapp Number"),
            TD::make('email', "Email"),

            // // Residential Information
            // TD::make('present_address', 'Present Address')->width('200px'),
            // TD::make('address_type', 'Address Type')->width('150px'),
            // TD::make('landmark', 'Landmark')->width('200px'),
            // TD::make('district_of_residence', 'District of Residence')->width('200px'),
            // TD::make('country', 'Country')->width('150px'),
            // TD::make('years_in_residence', 'Years in Residence')->width('150px'),

            // // Business/Employment Information
            // TD::make('business_name', 'Business/Company Name')->width('200px'),
            // TD::make('role', 'Role/Position')->width('150px'),
            // TD::make('status', 'Employment Status')->width('150px'),
            // TD::make('industry_of_business', 'Industry')->width('200px'),
            // TD::make('business_address', 'Business Address')->width('200px'),
            // TD::make('business_email', 'Business Email')->width('200px'),
            // TD::make('business_contact_person', 'Business Contact Person')->width('200px'),
            // TD::make('business_contact', 'Business Contact Number')->width('200px'),
            // TD::make('business_district', 'Business District')->width('200px'),
            // TD::make('business_country', 'Business Country')->width('150px'),

            // // Next of Kin Information
            // TD::make('next_of_kin_name', 'Next of Kin Name')->width('200px'),
            // TD::make('next_of_kin_relationship', 'Relationship')->width('150px'),
            // TD::make('next_of_kin_mobile', 'Next of Kin Mobile')->width('200px'),
            // TD::make('next_of_kin_email', 'Next of Kin Email')->width('200px'),
            // TD::make('next_of_kin_address', 'Next of Kin Address')->width('200px'),
            // TD::make('next_of_kin_country', 'Next of Kin Country')->width('150px'),
            // TD::make('next_of_kin_district', 'Next of Kin District')->width('200px'),
            // TD::make('next_of_kin_city', 'Next of Kin City')->width('200px')->defaultHidden(),

            TD::make('created_at', "Added On")->sort(),
            TD::make('actions', 'Actions')
            ->render(function (Borrowers $borrower) {
                return Link::make('View Loan History')
                    ->route('platform.borrower.history', $borrower->id);
            }),

        ]),

        Layout::modal('borrowerModal', Layout::tabs([
            'Personal Information' => Layout::rows([
                Input::make('borrower.first_name')
                    ->title('First Name')
                    ->placeholder('Enter First Name'),
        
                Input::make('borrower.last_name')
                    ->title('Last Name')
                    ->placeholder('Enter Last Name')
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
                    ->placeholder('Enter WhatsApp Number')
                    ->mask('+999 999 999 999')
                    ->required(),
        
                Input::make('borrower.email')
                    ->type('email')
                    ->title('Email Address')
                    ->placeholder('Enter Email Address')
                    ->required(),
            ]),
        
            'Residential Information' => Layout::rows([
                TextArea::make('borrower.present_address')
                    ->title('Present Address')
                    ->rows(3)
                    ->required(),
        
                Select::make('borrower.address_type')
                    ->title('Address Type')
                    ->options([
                        'rented' => 'Rented',
                        'owned' => 'Owned',
                    ])
                    ->required(),
        
                Input::make('borrower.landmark')
                    ->title('Landmark')
                    ->placeholder('Enter Nearby Landmark'),
        
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
            ]),
        
            'Business/Employment Information' => Layout::rows([
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
                        'student' => 'Student',
                    ])
                    ->required(),
        
                Input::make('borrower.industry_of_business')
                    ->title('Industry')
                    ->placeholder('Enter Business Industry'),
        
                TextArea::make('borrower.business_address')
                    ->title('Business Address')
                    ->rows(3),
        
                Input::make('borrower.business_email')
                    ->type('email')
                    ->title('Business Email')
                    ->placeholder('Enter Business Email'),
        
                Input::make('borrower.business_contact_person')
                    ->title('Business Contact Person')
                    ->placeholder('Enter Contact Person Name'),
        
                Input::make('borrower.business_contact')
                    ->title('Business Contact Number')
                    ->mask('+999 999 999 999'),
        
                Input::make('borrower.business_district')
                    ->title('Business District'),
        
                Input::make('borrower.business_country')
                    ->title('Business Country'),
            ]),
        
            'Next of Kin Information' => Layout::rows([
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
                    ->placeholder('Enter Next of Kin Email'),
        
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
            ]),
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
