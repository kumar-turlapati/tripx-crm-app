<?php

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;
$routes = new Routing\RouteCollection();

/* default routes available in every routes file */
$routes->add('default_route', new Routing\Route('/', array(
  '_controller' => 'User\\Controller\\LoginController::indexAction',
)));
$routes->add('login', new Routing\Route('/login', array(
  '_controller' => 'User\\Controller\\LoginController::indexAction',
)));
$routes->add('forgot_password', new Routing\Route('/forgot-password', array(
  '_controller' => 'User\\Controller\\LoginController::forgotPasswordAction',
)));
$routes->add('reset_password', new Routing\Route('/reset-password', array(
  '_controller' => 'User\\Controller\\LoginController::resetPasswordAction',
)));
$routes->add('send_otp', new Routing\Route('/send-otp', array(
  '_controller' => 'User\\Controller\\LoginController::sendOTPAction',
)));
$routes->add('logout', new Routing\Route('/logout', array(
  '_controller' => 'User\\Controller\\LoginController::logoutAction',
)));
$routes->add('me', new Routing\Route('/me', array(
  '_controller' => 'User\\Controller\\UserController::editProfileAction',
)));
$routes->add('dashboard_crm', new Routing\Route('/crm-dashboard', array(
  '_controller' => 'User\\Controller\\DashBoardController::crmDashboardAction',
)));

# lead routes.
$routes->add('lead_create', new Routing\Route('/lead/create', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::leadCreateAction',
)));
$routes->add('lead_update', new Routing\Route('/lead/update/{leadCode}', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::leadUpdateAction',
)));
$routes->add('lead_remove', new Routing\Route('/lead/remove/{leadCode}', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::leadRemoveAction',
)));
$routes->add('leads_list', new Routing\Route('/leads/list/{pageNo}/{perPage}', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::leadListAction',
  'pageNo' => 1,
  'perPage' => 100,
)));
$routes->add('lead_details', new Routing\Route('/lead/details/{leadCode}', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::leadDetailsAction',
)));
$routes->add('lead_import', new Routing\Route('/lead/import', array(
  '_controller' => 'Crm\\Leads\\Controller\\LeadsController::importLeadsAction',
)));

// account routes
$routes->add('account_create', new Routing\Route('/account/create', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::accountCreateAction',
)));
$routes->add('account_update', new Routing\Route('/account/update/{accountCode}', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::accountUpdateAction',
)));
$routes->add('account_remove', new Routing\Route('/account/remove/{accountCode}', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::accountRemoveAction',
)));
$routes->add('accounts_list', new Routing\Route('/accounts/list/{pageNo}/{perPage}', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::accountListAction',
  'pageNo' => 1,
  'perPage' => 100,
)));
$routes->add('account_details', new Routing\Route('/account/details/{accountCode}', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::accountDetailsAction',
)));
$routes->add('account_import', new Routing\Route('/account/import', array(
  '_controller' => 'Crm\\Accounts\\Controller\\AccountsController::importAccountsAction',
)));

// contact routes
$routes->add('contact_create', new Routing\Route('/contact/create', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::contactCreateAction',
)));
$routes->add('contact_update', new Routing\Route('/contact/update/{contactCode}', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::contactUpdateAction',
)));
$routes->add('contact_remove', new Routing\Route('/contact/remove/{contactCode}', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::contactRemoveAction',
)));
$routes->add('contacts_list', new Routing\Route('/contacts/list/{pageNo}/{perPage}', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::contactListAction',
  'pageNo' => 1,
  'perPage' => 100,
)));
$routes->add('contact_details', new Routing\Route('/contact/details/{contactCode}', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::codntactDetailsAction',
)));
$routes->add('contact_import', new Routing\Route('/contact/import', array(
  '_controller' => 'Crm\\Contacts\\Controller\\ContactsController::importContactsAction',
)));

// transaction routes
$routes->add('trans_create', new Routing\Route('/transaction/create', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::transactionCreateAction',
)));
$routes->add('trans_update', new Routing\Route('/transaction/update/{contactCode}', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::transactionUpdateAction',
)));
$routes->add('trans_remove', new Routing\Route('/transaction/remove/{contactCode}', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::transactionRemoveAction',
)));
$routes->add('trans_list', new Routing\Route('/transaction/list/{pageNo}/{perPage}', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::transactionListAction',
  'pageNo' => 1,
  'perPage' => 100,
)));
$routes->add('trans_details', new Routing\Route('/transaction/details/{contactCode}', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::transactionDetailsAction',
)));
$routes->add('trans_import', new Routing\Route('/transaction/import', array(
  '_controller' => 'Crm\\Transactions\\Controller\\TransactionsController::importTransactionAction',
)));

// promotional offers routes
$routes->add('create_offer', new Routing\Route('/promo-offers/entry', array(
  '_controller' => 'Crm\\PromoOffers\\Controller\\PromoOffersController::promoOfferEntryAction',
)));
$routes->add('update_offer', new Routing\Route('/promo-offers/update/{offerCode}', array(
  '_controller' => 'Crm\\PromoOffers\\Controller\\PromoOffersController::promoOfferUpdateAction',
  'offerCode' => null,
)));
$routes->add('list_offers', new Routing\Route('/promo-offers/list', array(
'_controller' => 'Crm\\PromoOffers\\Controller\\PromoOffersController::promoOffersListAction',
)));

return $routes;