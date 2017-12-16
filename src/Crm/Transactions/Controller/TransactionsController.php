<?php 

namespace Crm\Contacts\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Atawa\Utilities;
use Atawa\Template;
use Atawa\Flash;
use Atawa\Importer;
use Atawa\CrmUtilities;

use Crm\Transaction\Model\Transaction;

class TransactionsController
{

	public function __construct() {
    $this->template = new Template(__DIR__.'/../Views/');
    $this->trans_model = new Transaction;
    $this->flash = new Flash;
	}

	# contact create action
	public function transactionCreateAction(Request $request) {
	}

	# contact update action
	public function transactionUpdateAction(Request $request) {
	}

	# contact remove action
	public function transactionRemoveAction(Request $request) {
	}

	# contact list action
	public function transactionListAction(Request $request) {
	}

  # contact details
  public function transactionDetailsAction(Request $request) {
  }

  # import contacts through xls, ods, xlsx
  public function importTransactionAction(Request $request) {
  }
}