<?php

namespace Crm\PromoOffers\Model;

use Atawa\ApiCaller;
use Atawa\Utilities;

class PromoOffers
{
	/** create promo offer in the system **/
	public function createPromoOffer($params=array()) {
		$client_id = Utilities::get_current_client_id();
		$request_uri = 'promo-offers/create/'.$client_id;		

		# call api.
		$api_caller = new ApiCaller();
		$response = $api_caller->sendRequest('post',$request_uri,$params);
		$status = $response['status'];
		if ($status === 'success') {
			return array('status'=>true,'offerCode' => $response['response']['offerCode']);
		} elseif($status === 'failed') {
			return array('status' => false, 'apierror' => $response['reason']);
		}
	}

	/** update promo offer in the system **/
	public function updatePromoOffer($params = [], $offer_code='') {
		$client_id = Utilities::get_current_client_id();
		$request_uri = 'promo-offers/update/'.$offer_code.'/'.$client_id;

		# call api.
		$api_caller = new ApiCaller();
		$response = $api_caller->sendRequest('put',$request_uri,$params);
		$status = $response['status'];
		if ($status === 'success') {
			return array('status'=>true,'updatedRows' => $response['response']['updated']);
		} elseif($status === 'failed') {
			return array('status' => false, 'apierror' => $response['reason']);
		}		
	}

	/** get promo offer details **/
	public function getPromoOfferDetails($offer_code='') {
		$client_id = Utilities::get_current_client_id();
		$request_uri = 'promo-offers/details/'.$offer_code.'/'.$client_id;

		# call api.
		$api_caller = new ApiCaller();
		$response = $api_caller->sendRequest('get',$request_uri,[]);
		$status = $response['status'];
		if ($status === 'success') {
			return array('status' => true,'offerDetails' => $response['response']['offerDetails']);
		} elseif($status === 'failed') {
			return array('status' => false, 'apierror' => $response['reason']);
		}
	}

	/** list promo offers in the system **/
	public function getAllPromoOffers($params=array()) {
		$client_id = Utilities::get_current_client_id();
		$request_uri = 'promo-offers/list/'.$client_id;

		# call api.
		$api_caller = new ApiCaller();
		$response = $api_caller->sendRequest('get',$request_uri,$params);
		$status = $response['status'];
		if ($status === 'success') {
			return array('status'=>true,'response' => $response['response']);
		} elseif($status === 'failed') {
			return array('status' => false, 'apierror' => $response['reason']);
		}
	}

	/** get live promo offers from the portal **/
	public function getLivePromoOffers($params = array()) {
		$client_id = Utilities::get_current_client_id();
		$request_uri = 'promo-offers/live/'.$client_id;

		# call api.
		$api_caller = new ApiCaller();
		$response = $api_caller->sendRequest('get',$request_uri,$params);
		$status = $response['status'];
		if ($status === 'success') {
			return array('status'=>true,'response' => $response['response']);
		} elseif($status === 'failed') {
			return array('status' => false, 'apierror' => $response['reason']);
		}
	}

}