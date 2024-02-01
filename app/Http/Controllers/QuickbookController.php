<?php

// app/Http/Controllers/QuickBooksController.php

namespace App\Http\Controllers;

use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer;
use Illuminate\Http\Request;

class QuickbookController extends Controller
{
    public function redirectToQuickBooks()
    {
        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('services.quickbooks.client_id'),
            'ClientSecret' => config('services.quickbooks.client_secret'),
            'RedirectURI' => config('services.quickbooks.redirect_uri'),
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => 'development', // Use 'production' for live environment
        ));

        $url = $dataService->getOAuth2LoginHelper()->getAuthorizationCodeURL();
        return redirect()->away($url);
    }

    public function handleCallback(Request $request)
    {
        $code = $request->input('code');

        $dataService = DataService::Configure(array(
            'auth_mode' => 'oauth2',
            'ClientID' => config('services.quickbooks.client_id'),
            'ClientSecret' => config('services.quickbooks.client_secret'),
            'RedirectURI' => config('services.quickbooks.redirect_uri'),
            'scope' => 'com.intuit.quickbooks.accounting',
            'baseUrl' => 'development', // Use 'production' for live environment
        ));

        $OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
        $accessToken = $OAuth2LoginHelper->exchangeAuthorizationCodeForToken($code, config('services.quickbooks.redirect_uri'));

        // Use the $accessToken to make API requests
        $customers = $this->getQuickBooksCustomers($dataService);

        // Dump data
        dd($customers);
    }

    public function getQuickBooksCustomers(DataService $dataService)
    {
        $customers = $dataService->Query("SELECT * FROM Customer");

        // Process $customers and return the data
        return $customers;
    }
}
