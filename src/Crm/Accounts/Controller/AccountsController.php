<?php 

namespace Crm\Accounts\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Atawa\Utilities;
use Atawa\Template;
use Atawa\Flash;
use Atawa\Importer;
use Atawa\CrmUtilities;

use Crm\Accounts\Model\Account;

class AccountsController
{

	public function __construct() {
    $this->template = new Template(__DIR__.'/../Views/');
    $this->account_model = new Account;
    $this->flash = new Flash;
	}

	# account create action
	public function accountCreateAction(Request $request) {
	}

	# account update action
	public function accountUpdateAction(Request $request) {
	}

	# account remove action
	public function accountRemoveAction(Request $request) {
	}

	# account list action
	public function accountListAction(Request $request) {
	}

  # account details
  public function accountDetailsAction(Request $request) {
  }

  # import accounts through xls, ods, xlsx
  public function importAccountsAction(Request $request) {
  }

}