<?php 

namespace Crm\Contacts\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Atawa\Utilities;
use Atawa\Template;
use Atawa\Flash;
use Atawa\Importer;
use Atawa\CrmUtilities;

use Crm\Contacts\Model\Contact;

class ContactsController
{

	public function __construct() {
    $this->template = new Template(__DIR__.'/../Views/');
    $this->contact_model = new Contact;
    $this->flash = new Flash;
	}

	# contact create action
	public function contactCreateAction(Request $request) {
	}

	# contact update action
	public function contactUpdateAction(Request $request) {
	}

	# contact remove action
	public function contactRemoveAction(Request $request) {
	}

	# contact list action
	public function contactListAction(Request $request) {
	}

  # contact details
  public function codntactDetailsAction(Request $request) {
  }

  # import contacts through xls, ods, xlsx
  public function importContactsAction(Request $request) {
  }
}