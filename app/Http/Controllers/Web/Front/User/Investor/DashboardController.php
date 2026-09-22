<?php

namespace App\Http\Controllers\Web\Front\User\Investor;

use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\UtillsHelper;
use App\Helpers\DigioHelper;
use App\Helpers\PrimaryHelper;
use App\Http\Controllers\Controller;
use App\Models\PortfolioModel;
use App\Models\StartupMisModel;
use App\Models\StartupModel;
use App\Models\PrimaryTransactionModel;
use App\Models\PrimaryTransactionPaymentModel;
use App\Models\PrimaryTransactionPaymen;
use App\Models\InvestorMandatesModel;
use App\Models\DocumentsModel;
use App\Models\StartupRoundModel;
use App\Models\InvestorFavStartupModel;
use App\Enums\PrimaryTransactionStatusEnum;
use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\PrimaryTransactionPaymentMode;
use App\Enums\DocumentTypeEnum;
use App\Models\StartupSharePriceModel;
use App\Repositories\InvestorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
	private $invRepo;

	function __construct(InvestorRepository $investorRepository)
	{
		$this->invRepo = $investorRepository;
	}

	function index(): View
	{
		// dd($this->invRepo->dashboard());
		setPageTitle('Dashboard');
		return view('front.investor.dashboard')->with($this->invRepo->dashboard());
	}

	function investment($slug): View
	{
		// dd("investment");
		// $id = Crypt::decrypt($id);
		$data['startup'] = StartupModel::where('url_slug', $slug)->where('is_deleted', '0')->with('details')->with('StartupOther')->with('faqs')->first();
		if ($data['startup']) {
			// if ($data['startup']->status == '6') {
			// 	return Redirect::back();
			// }
			$data['startupdet'] 	= $data['startup']->details;
			$data['bank'] 			= $data['startup']->bank;
			$data['_title'] 		= 'Investing in ' . $data['startup']->brand_name;
			// dd($data);
			return view('front.investment.index', $data);
		} else {
			abort(404);
		}
	}

	public function step1save(Request $request): JsonResponse
	{
		// dd($request);
		$investorId = Auth::guard('investor')->user()->id;
		$investment = PrimaryTransactionModel::where('investor_id', $investorId)->where('startup_id', $request->startup)->first();
		$roundId = StartupRoundModel::where('startup_id', $request->startup)->first();
		if ($investment) {
			$startup = StartupModel::where('id', $request->startup)->with('details')->first();
			$investment->round_id 			= $roundId->id;
			$investment->shares 			= ($request->amount / $startup->lastRounds->share_price);
			$investment->investment_amount 	= $request->amount;
			$investment->share_price 		= $startup->lastRounds->share_price;
			if ($request->payment_mode == 1) {
				$investment->payment_mode = PrimaryTransactionPaymentMode::mandate;
			} elseif ($request->payment_mode == 2) {
				$investment->payment_mode = PrimaryTransactionPaymentMode::rtgs;
			} else {
				$investment->payment_mode = PrimaryTransactionPaymentMode::cheque;
			}
			$investment->status = '1';
			$investment->save();

			$document = new DocumentsModel();
			$document->api_id = 'NULL';
			$document->path = 'NULL';
			$document->signed_path = 'NULL';
			$document->status = '0';
			$document->meta = json_encode([
				'investor_id' => $investorId,
				'startup_id'  => $request->startup,
				'round_id'    => $roundId
			]);
			$document->status = '0';
			$document->type = DocumentTypeEnum::ssa;
			$document->save();

			// $mandate = InvestorMandatesModel::where('investor_id',$investorId)->first();
			// dd($mandate);
			// $payment = new PrimaryTransactionPaymentModel;
			// $payment->transaction_id = $investment->id;
			// $payment->digio_mandate_id = $mandate->id;
			// $payment->status = '1';
			// $payment->document_id = $document->id;
			// $payment->save();


			// $isFav = FavoriteStartUp::where('investor',Auth::guard('investor')->user()->id)->where('startup',$rec->startup)->first();
			// if (!$isFav) {
			// 	FavoriteStartUp::insert([
			// 		'investor'		=> Auth::guard('investor')->user()->id,
			// 		'startup'		=> $rec->startup,
			// 		'cat'			=> Common::_now()
			// 	]);
			// }

			$body = Auth::guard('investor')->user()->name . ' has committed ' . $request->amount . ' in ' . $startup->brand_name;
			// Common::addNotification('2',Auth::guard('investor')->user()->id,'Committed',$body);

			// if($request->payment_mode == '2' || $request->payment_mode == '3'){
			// 	if($startup->details->ssa_id != '' && $startup->details->ssa_id != NULL && $startup->details->ssa_id != 'NA'){
			// 		PrimaryHelper::sendSSA($investment);
			// 	}


			$investment = PrimaryTransactionModel::where('id', $investment->id)->with('investor', 'startup')->first();
			if ($investment) {
				// 		if($investment->startup && $investment->investor){

				// 			// Common::addNotification('3',$investment->startup->id,'Commitment',$investment->investor->name.' has created a mandate for INR '.$investment->investment_amount.'. Please sign the Share Subscription Agreement (SSA) that has been sent to you via SMS.','raise/transactions');
				// 			// Wp11Helper::autoSendMessage('startup_mandate_created',$investment->startup->phone,$investment->startup->brand,[$investment->startup->brand,$investment->investor->name,$investment->investment_amount]);


				// 			// if($request->payment_mode == '2'){
				// 			// 	Common::addNotification('3',$investment->startup->id,'Commitment',$investment->investor->name.' has committed INR '.$investment->investment_amount.'. Please sign the Share Subscription Agreement (SSA) that has been sent to you via SMS.','raise/transactions');
				// 			// 	Wp11Helper::autoSendMessage('startup_if_rtgs',$investment->startup->phone,$investment->startup->brand,[$investment->startup->brand,$investment->investor->name,$investment->investment_amount]);

				// 			// 	Wp11Helper::autoSendMessage('investor_if_rtgs',$investment->investor->mobile,$investment->investor->name,[$investment->investor->name,$investment->startup->brand]);
				// 			// 	Common::addNotification('2',$investment->investor->id,'Commitment','Thank you for your commitment of INR '.$investment->investment_amount.' in '.$investment->startup->brand.'. As a part of the process, you would have received a Share Subscription Agreement (SSA) via text SMS. Kindly review and sign the document.','transactions');

				// 			// 	foreach (Common::adminMobiles() as $key => $value) {
				// 			// 		Wp11Helper::autoSendMessage('admin_if_rtgs',$value->mobile,$value->name,[$value->name,$investment->investor->name,'INR '.$investment->investment_amount,$investment->startup->brand]);
				// 			// 	}
				// 			// }

				// 			// Common::addNotification('3',$investment->startup->id,'Commitment',$investment->investor->name.' has committed INR '.$investment->investment_amount.'. Please sign the Share Subscription Agreement (SSA) that has been sent to you via SMS.','raise/transactions');
				// 			Wp11Helper::autoSendMessage('startup_termsheet_issued',$investment->startup->phone,$investment->startup->brand,[$investment->startup->rname,$investment->investor->name,$investment->investment_amount]);

				// 			Wp11Helper::autoSendMessage('investor_termsheet_issued',$investment->investor->mobile,$investment->investor->name,[$investment->investor->name,$investment->startup->brand]);
				// 			// Common::addNotification('2',$investment->investor->id,'Commitment','Thank you for your commitment of INR '.$investment->investment_amount.' in '.$investment->startup->brand.'. As a part of the process, you would have received a Share Subscription Agreement (SSA) via text SMS. Kindly review and sign the document.','transactions');

				// 			foreach (Common::adminMobiles() as $key => $value) {
				// 				Wp11Helper::autoSendMessage('admin_termsheet_issued',$value->mobile,$value->name,[$value->name,$investment->investor->name,$investment->investment_amount,$investment->startup->brand]);
				// 			}
				// 		}
				// 	}
				return UtillsHelper::json(1, ['view' => view('front.investment.child.step2')->render()]);
			} else {
				return UtillsHelper::json(1, ['view' => view('front.investment.child.step2')->render()]);
			}
		} else {
			return UtillsHelper::json(['_return' => false, 'msg' => 'Something went wrong']);
		}
	}

	public function step2save(Request $rec): JsonResponse
	{
		// dd($rec);
		$startup = StartupModel::where('id', $rec->startup)->with('details')->first();
		// if(!$startup && $startup->is_public == '0'){
		// 	$ssaId = "";
		// 	$inId = PrimaryTransactionModel::where('status','0')->where('startup',$rec->startup)->where('investor',Auth::guard('investor')->user()->id)->first();
		// 	if($startup->details->ssa_id != '' && $startup->details->ssa_id != NULL && $startup->details->ssa_id != 'NA'){
		// 		$doc = DigioHelper::sendSSA($inId->id);
		// 		$ssaId = "";
		// 		if ($doc->getStatusCode() == "200") {
		// 			$getDocResponse = json_decode($doc->getBody()->getContents());
		// 			$ssaId = $getDocResponse->id;
		// 			$investment = $inId;

		// 			DocumentsModel::create([
		// 				'api_id'	=> NULL,
		// 				'path' 		=> NULL,
		// 				'signed_path' 	=> NULL,
		// 				'status' 	=> '0',
		// 				// $investment->startup,
		// 				// 'did'		=> $ssaId,
		// 				// 'file'		=> '',
		// 				'type'		=> DocumentTypeEnum::ssa,
		// 				'user_data'	=> [
		// 					[
		// 						'investor_id'    => $investment->investor,
		// 						'startup_id'  	 => $investment->startup,
		// 						'round_id'       => ''
		// 					]
		// 				],

		// 			]);
		// 		}else{
		// 			$getDocResponse = json_decode($doc->getBody()->getContents());
		// 			return UtillsHelper::json(['_return' => false,'msg' => $getDocResponse->message]);

		// 			// $getDocResponse = json_decode($doc->getBody()->getContents());
		// 			// DigioErrors::create([
		// 			// 	'type'		=> 'ssa',
		// 			// 	'error' 	=> $getDocResponse->message
		// 			// ]);
		// 		}
		// 	}else{
		// 		return UtillsHelper::json(['_return' => false,'msg' => 'Send Delay Message']);
		// 		// WpHelper::eventInvestment($startup->id,Auth::guard('investor')->user()->id);
		// 	}

		// 	PrimaryTransactionPaymentModel::create([
		// 		'transaction_id'		=> $inId->id,
		// 		'document_id'			=> $ssaId,
		// 		'digio_mandate_id'		=> $rec->mandateid,
		// 		'status'				=> 'Completed'
		// 	]);

		// 	return UtillsHelper::json(['_return' => true,'view' => view('front.investment.child.step3')->render()]);

		// }else{
		$getMandate = DigioHelper::getMandate($rec->mandateid);
		if ($getMandate->getStatusCode() == "200") {
			$getMandateResponse = json_decode($getMandate->getBody()->getContents());

			$investment = PrimaryTransactionModel::find($rec->investment_id_step2);
			// dd($investment);
			if ($investment) {
				$document = DocumentsModel::create([
					'api_id'	=> $getMandateResponse->id,
					'path' 		=> 'NULL',
					'signed_path' 	=> 'NULL',
					'status' 	=> '0',
					// $investment->startup,
					// 'did'		=> $ssaId,
					// 'file'		=> '',
					'type'		=> DocumentTypeEnum::ssa,
					'user_data'	=> [
						[
							'investor_id'    => $investment->investor_id,
							'startup_id'  	 => $investment->startup_id,
							'round_id'       => $investment->round_id
						]
					],

				]);

				PrimaryTransactionPaymentModel::create([
					'transaction_id' 	=> $getMandateResponse->mandate_details->npci_txn_id,
					'digio_mandate_id'	=> $getMandateResponse->mandate_id,
					// 'document_id'		=> $getMandateResponse->digio_doc_id,
					'status'			=> 'Compeleted'
				]);

				$mandate = new InvestorMandatesModel;
				$mandate->investor_id = $investment->investor_id;
				$mandate->mandate_id = $getMandateResponse->mandate_id;
				$mandate->umrn_no = $getMandateResponse->umrn;
				$mandate->state = $getMandateResponse->bank_details->state;
				// $mandate->amount = $getMandateResponse->amount;
				$mandate->bank_account_no = $getMandateResponse->mandate_details->customer_account_number;
				$mandate->bank_account_type = $getMandateResponse->mandate_details->customer_account_type;
				$mandate->bank_ifsc_code = $getMandateResponse->mandate_details->destination_bank_id;
				$mandate->bank_id = $getMandateResponse->mandate_details->destination_bank_name;
				$mandate->save();

				// if($startup->details->ssa_id != '' && $startup->details->ssa_id != NULL && $startup->details->ssa_id != 'NA'){
				// 	PrimaryHelper::sendSSA($investment);
				// }

				$investment->status = 2;
				$investment->save();
			}
			return UtillsHelper::json(['_return' => true, 'view' => view('front.investment.child.step3')->render()]);
		} else if ($getMandate->getStatusCode() == "400") {
			$formResponse = json_decode($getMandate->getBody()->getContents());
			return UtillsHelper::json(['_return' => false, 'msg' => $formResponse->message]);
		} else {
			return UtillsHelper::json(['_return' => false, 'msg' => 'Something went wrong. Please try again later.', 'res' => $getMandate]);
		}
		// }
	}
}
