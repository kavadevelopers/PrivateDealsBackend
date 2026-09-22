<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\UtillsHelper;
use App\Helpers\DigioHelper;
use App\Http\Controllers\Controller;
use App\Models\PortfolioModel;
use App\Models\StartupMisModel;
use App\Models\StartupModel;
use App\Models\PrimaryTransactionModel;
use App\Models\InvestorMandatesModel;
use App\Models\PrimaryTransactionPaymentModel;
use App\Enums\PrimaryTransactionStatusEnum;
use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Models\InvestorModel;
use App\Models\StartupSharePriceModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MandateController extends Controller
{
	// public function defPayees($id){
	// 	InvestorPayee::where('investor_id',Auth::guard('investor')->user()->id)->update([
	// 		'is_default'	=> '0'
	// 	]);

	// 	InvestorPayee::where('id',$id)->update([
	// 		'is_default'	=> '1'
	// 	]);

	// 	Session::flash('success', 'Default Bank Account Changed');
	// 	return Redirect::back();
	// }

	// public function payeeSave(Request $rec){
	// 	// $addPayee = CastlerApi::addPayee(
    //     //     $rec->account_name,$rec->account_number,$rec->bank_name,$rec->bank_address,$rec->ifsc_code
    //     // );
	// 	// if($addPayee){
	// 	// 	if($addPayee->getStatusCode() == 201){
	// 	// 		$response = json_decode($addPayee->getBody()->getContents());
	// 			if(InvestorPayee::where('investor_id',Auth::guard('investor')->user()->id)->count() > 0){
	// 				$defVal = 0;
	// 			}else{
	// 				$defVal = 1;	
	// 			}
				
    //             InvestorPayee::insert([
	// 				'investor_id'			=> Auth::guard('investor')->user()->id,
	// 				// 'castler_payee_id'		=> $response->result->payeeId,
	// 				'castler_payee_id'		=> '',
	// 				'account_name'			=> $rec->account_name,
	// 				'account_number'		=> $rec->account_number,
	// 				'bank_name'				=> $rec->bank_name,
	// 				'ifsc_code'				=> $rec->ifsc_code,
	// 				'bank_address'			=> $rec->bank_address,
	// 				'is_default'			=> $defVal,
	// 				'created_at'			=> Common::_now()
	// 			]);

	// 			Session::flash('success', 'Bank Account Added');
	// 			return Redirect::back();
    //     //     }else if($addPayee->getStatusCode() == 422){
	// 	// 		Session::flash('error', 'This Account is already registered with us');
	// 	// 		return Redirect::back();
    //     //     }
	// 	// }else{
	// 	// 	Session::flash('error', 'Something went wrong.');
	// 	// 	return Redirect::back();
	// 	// }
	// }

	// public function bankPayees(){
	// 	$data['_title'] 	= 'Manage Bank Account';
	// 	$data['list']	= InvestorPayee::where('investor_id',Auth::guard('investor')->user()->id)->orderby('is_default','desc');
	// 	return view('front.dashboard.investor.manage-payees',$data);
	// }

	public function mandateBankSave(Request $rec): JsonResponse
	{
		$getMandate = DigioHelper::getMandate($rec->mandate);
		if ($getMandate->getStatusCode() == "200") {
			$getMandateResponse = json_decode($getMandate->getBody()->getContents());

			InvestorMandatesModel::create([
				'investor'						=> Auth::guard('investor')->user()->id,
				'mandate_id'					=> $getMandateResponse->mandate_id,
				'state'							=> $getMandateResponse->state,
				'customer_identifier'			=> $getMandateResponse->mandate_details->customer_identifier,
				'customer_name'					=> $getMandateResponse->mandate_details->customer_name,
				'customer_mobile'				=> $getMandateResponse->mandate_details->customer_mobile,
				'customer_account_number'		=> $getMandateResponse->mandate_details->customer_account_number,
				'customer_account_type'			=> $getMandateResponse->mandate_details->customer_account_type,
				'destination_bank_id'			=> $getMandateResponse->mandate_details->destination_bank_id,
				'destination_bank_name'			=> $getMandateResponse->mandate_details->destination_bank_name
			]);

			return UtillsHelper::json(['_return' => true,'data' => $getMandateResponse]);
		}else if ($getMandate->getStatusCode() == "400") {
			$formResponse = json_decode($getMandate->getBody()->getContents());
			return UtillsHelper::json(['_return' => false,'msg' => $formResponse->message]);
		}else{
			return UtillsHelper::json(['_return' => false,'msg' => 'Something went wrong. Please try again later.']);
		}
	}

	public function mandateBankCheck(Request $rec): JsonResponse
	{
		$investor = InvestorModel::where('id',Auth::guard('investor')->user()->id)->first();
		$investment = PrimaryTransactionModel::where('id',$rec->investment_id_step2)->with('startup')->first();
		// if($investment && $investment->_startup->is_public == '0'){
		// 	return UtillsHelper::json(['_return' => true,'is_demo' => '1','mandate_id' => microtime(true)]);		
		// }else{
			$checkBankDigio = DigioHelper::checkBankMandate($rec->ac_no,$rec->ifsc);
			// dd($checkBankDigio);
			if ($checkBankDigio->getStatusCode() == "200") {
				$response = json_decode($checkBankDigio->getBody()->getContents());
				if ($response->verified) {	
					$createMandateForm = DigioHelper::createMandateForm(
						$investor->mobile_number,
						$rec->ac_name,
						$rec->ac_no,
						$rec->ifsc,
						$rec->bank,
						$rec->investment_id_step2
					);		
					//for status
					// Investment::where('id',$rec->investment_id_step2)->update([
					// 	'is_mandate'	=> '1',
					// ]);
					if ($createMandateForm->getStatusCode() == "200") {
						$formResponse = json_decode($createMandateForm->getBody()->getContents());
						$authTokenApi = DigioHelper::generateAuthToken($formResponse->id);
						$authTokenGet = json_decode($authTokenApi->getBody()->getContents());
						return UtillsHelper::json(['_return' => true,'is_demo' => '0','data' => $formResponse,'token' => $authTokenGet->response->id,'mobile' => $investor->mobile_number]);		
					}else if ($createMandateForm->getStatusCode() == "400") {
						$formResponse = json_decode($createMandateForm->getBody()->getContents());
						return UtillsHelper::json(['_return' => false,'msg' => $formResponse->message]);
					}else{
						return UtillsHelper::json(['_return' => false,'msg' => 'Something went wrong. Please try again later.']);
					}
				}else{
					return UtillsHelper::json(['_return' => false,'msg' => $response->error_msg]);	
				}
			}else if ($checkBankDigio->getStatusCode() == "400") {
				$response = json_decode($checkBankDigio->getBody()->getContents());
				return UtillsHelper::json(['_return' => false,'msg' => $response->message]);
			}else{
				return UtillsHelper::json(['_return' => false,'msg' => 'Something went wrong. Please try again later.']);
			}
		//}
	}

	public function bankMandates(): View
	{
		$data['_title'] 	= 'Mandates (eNACH)';
		$data['mandates']	= InvestorMandatesModel::where('investor',Auth::guard('investor')->user()->id);
		return view('front.dashboard.investor.bank-mandate',$data);
	}
    
}
