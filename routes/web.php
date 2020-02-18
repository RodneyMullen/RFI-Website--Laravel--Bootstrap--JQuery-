<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','WebpageController@showHome');
        
    
/*
Route::get('/welcome', function () {
    return view('welcome');
});*/



//send all other requests to this page
Route::fallback(function(){
    return view('webpage.invalidpage');
});

Auth::routes();

//route to web administration page. passes through auth script
Route::get('/webpageadmin', 'WebpageEditController@webpageDashboard')->name('webpageadmin');

// route to create a new webpage, passes through auth script
Route::get('/webpagecreate', 'WebpageEditController@webpageCreateForm')->name('webpagecreate');

// route to edit webpage with any page, passes through auth script
Route::get('/webpageedit/{page}', 'WebpageEditController@webpageEditForm');

// route to create a webpage, post to add page to database
Route::post('/webpagecreate','WebpageEditController@createWebpage')->name('webpagePersist');

// route to edit a webpage, post to edit values in database
Route::post('/webpageedit','WebpageEditController@editWebpage')->name('webpageEdit');


//route to member dashboard page. passes through auth script
Route::get('/memberdashboard', 'DashboardController@retreiveMembershipDashboard')->name('memberdashboard');



//route to view member page. passes through auth script
//Route::get('/viewmembers', 'HomeController@index')->name('viewmembers');

//route to view member page. passes through auth script
Route::get('/viewmembers', 'DashboardController@retrieveMemberList')->name('viewmembers');


// route to create a new member, passes through auth script
Route::get('/membercreate', 'MembershipController@retreiveAddNewMemberForm')->name('membercreate');

// route to create a new meber, post to add to database
Route::post('/membercreate','MembershipController@memberCreateRoute')->name('memberPersist');

// route to edit member with any member, passes through auth script
Route::get('/memberedit/{page}', 'MembershipController@retrieveEditMemberForm');

// route to edit a current member, post to add to database
Route::post('/memberedit','MembershipController@editMemberRoute')->name('membershipPersist');


// route to create/delete cert typer, passes through auth script
Route::get('/certtypes', 'CertificationController@certTypeForm')->name('certtypes');

// route to create a new meber, post to add to database
Route::post('/certtypes','CertificationController@certTypeRoute')->name('certTypePersist');
// route to create a new meber, post to add to database
//Route::post('/certtypes','CertificationController@CertRoute')->name('certTypeDeletePersist');


// route to create/delete ceritifcate, passes through auth script
Route::get('/addcertifications/{page}', 'CertificationController@addCertificiationForm');

// route to create a new meber, post to add to database
Route::post('/addcertifications','CertificationController@certificationRoute')->name('certPersist');
// route to create a new meber, post to add to database
//Route::post('/certtypes','CertificationC{/ontroller@CertRoute')->name('certTypeDeletePersist');

// route to create/delete insurnance type, passes through auth script
Route::get('/insurancetypes', 'InsuranceController@insuranceTypeForm')->name('insurancetypes');

// route to create a new meber, post to add to database
Route::post('/insurancetypes','InsuranceController@InsuranceTypeRoute')->name('insuranceTypePersist');

// route to create/delete insurnance provider, passes through auth script
Route::get('/insuranceproviders', 'InsuranceController@insuranceProvidersForm')->name('insuranceproviders');

// route to create a new insurance provider, post to add to database
Route::post('/insuranceproviders','InsuranceController@InsuranceProvidersRoute')->name('InsuranceProviderPersist');


// route to create/delete pratitioner insurance, passes through auth script
Route::get('/addpractitionerinsurance/{page}', 'InsuranceController@addPractitionerInsuranceForm');

// route to create a new insurance, post to add to database
Route::post('/addpractitionerinsurance','InsuranceController@practitionerInsuranceRoute')->name('pratitionerInsurancePersist');

// route to create/delete membership types, passes through auth script
Route::get('/membershiptypes', 'MembershipController@addMembershipTypesForm')->name('membershiptypes');

// route to create a new mebershi[ type, post to add to database
Route::post('/membershiptypes','MembershipController@membershipTypeRoute')->name('membershipTypePersist');

// route to create/delete rfi membership, passes through auth script
Route::get('/addrfimembership/{page}', 'MembershipController@addRFIMembershipForm');

// route to create a new rfi membership, post to add to database
Route::post('/addrfimembership','MembershipController@routeRFIMembership')->name('rfiMembershipPersist');

// route to create/delete practitioner listing preference, passes through auth script
Route::get('/practitionerlistingpreference', 'PractitionerController@practitionerListingPreferenceForm')->name('practitionerlistingpreference');

// route to create a new practitioner listing, post to add to database
Route::post('/practitionerlistingpreference','PractitionerController@routePractitionerListingPreference')->name('practitionerListingPreferencePersist');

// route to create/delete practitioner listing, passes through auth script
Route::get('/practitionerlisting/{page}', 'PractitionerController@practitionerListingForm');

// route to create a new practitioner listing, post to add to database
Route::post('/practitionerlisting','PractitionerController@practitionerListingRoute')->name('practitionerListingPersist');



// default route to open any page request.  If not present returns 404 page
Route::get('/{pagename}', 'WebpageController@show');


