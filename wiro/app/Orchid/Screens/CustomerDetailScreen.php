<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use App\Models\Borrowers;

class CustomerDetailScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Borrowers $borrower): iterable
    {
        return [
            'borrower' => $borrower,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Customer Details';
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
            //return a legend to display the customer data in a more concise way.
            Layout::legend('borrower', [
                //personal info
                Sight::make('first_name', "First Name"),
                Sight::make('last_name', "Last Name"),
                Sight::make('email', "Email"),
                Sight::make('gender', "Gender"),
                Sight::make('date_of_birth', "Date Of Birth"),
                Sight::make('whatsapp_number', "Whatsapp Number"),
                //residential info
                Sight::make('present_address', 'Present Address'),
                Sight::make('address_type', 'Address Type'),
                Sight::make('landmark', 'Landmark'),
                Sight::make('district_of_residence', 'District of Residence'),
                Sight::make('country', 'Country'),
                Sight::make('years_in_residence', 'Years in Residence'),
                // Business/Employment Information
                Sight::make('business_name', 'Business/Company Name'),
                Sight::make('role', 'Role/Position'),
                Sight::make('status', 'Employment Status'),
                Sight::make('industry_of_business', 'Industry'),
                Sight::make('business_address', 'Business Address'),
                Sight::make('business_email', 'Business Email'),
                Sight::make('business_contact_person', 'Business Contact Person'),
                Sight::make('business_contact', 'Business Contact Number'),
                Sight::make('business_district', 'Business District'),
                Sight::make('business_country', 'Business Country'),
                // Next of Kin Information
                Sight::make('next_of_kin_name', 'Next of Kin Name'),
                Sight::make('next_of_kin_relationship', 'Relationship'),
                Sight::make('next_of_kin_mobile', 'Next of Kin Mobile'),
                Sight::make('next_of_kin_email', 'Next of Kin Email'),
                Sight::make('next_of_kin_address', 'Next of Kin Address'),
                Sight::make('next_of_kin_country', 'Next of Kin Country'),
                Sight::make('next_of_kin_district', 'Next of Kin District'),
                Sight::make('next_of_kin_city', 'Next of Kin City'),



            ]),
        ];
    }
}
