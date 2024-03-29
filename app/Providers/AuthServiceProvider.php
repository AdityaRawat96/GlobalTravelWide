<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Affiliate' => 'App\Policies\AffiliatePolicy',
        'App\Models\Airline' => 'App\Policies\AirlinePolicy',
        'App\Models\Attachment' => 'App\Policies\AttachmentPolicy',
        'App\Models\Attendance' => 'App\Policies\AttendancePolicy',
        'App\Models\Catalogue' => 'App\Policies\CataloguePolicy',
        'App\Models\Company' => 'App\Policies\CompanyPolicy',
        'App\Models\Customer' => 'App\Policies\CustomerPolicy',
        'App\Models\Directory' => 'App\Policies\DirectoryPolicy',
        'App\Models\DirectoryContents' => 'App\Policies\DirectoryContentsPolicy',
        'App\Models\Expense' => 'App\Policies\ExpensePolicy',
        'App\Models\Hotel' => 'App\Policies\HotelPolicy',
        'App\Models\Invoice' => 'App\Policies\InvoicePolicy',
        'App\Models\Notification' => 'App\Policies\NotificationPolicy',
        'App\Models\Payment' => 'App\Policies\PaymentPolicy',
        'App\Models\Pnr' => 'App\Policies\PnrPolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Query' => 'App\Policies\QueryPolicy',
        'App\Models\Quotation' => 'App\Policies\QuotationPolicy',
        'App\Models\Refund' => 'App\Policies\RefundPolicy',
        'App\Models\Reminder' => 'App\Policies\ReminderPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\UserData' => 'App\Policies\UserDataPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
