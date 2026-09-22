<?php

namespace App\Http\Controllers\Web\Admin;

use App\Helpers\FileUpDownHelper;
use App\Helpers\UtillsHelper;
use App\Http\Controllers\Controller;
use App\Models\DocumentsModel;
use App\Models\PreIpoModel;
use App\Models\PrimaryTransactionModel;
use App\Models\SecondaryTransactionModel;
use App\Models\StartupModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UploadDocumentController extends Controller
{
    function create(Request $request): View
    {
        setPageTitle('Upload Document');
        return view('admin.pages.transaction.uploadDocument.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'document' => 'required|string',
                'file' => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
                'selectedTransactions' => 'required',
                'selectedStartup' => 'required',
                'selectedRound' => 'nullable',
            ]);
            Log::debug('File validated:', [
                'name' => $request->file->getClientOriginalName()
            ]);

            $selectedTransactions = array_map('intval', json_decode($request->selectedTransactions, true));
            $startup = StartupModel::find($request->selectedStartup);
            if (!$startup) {
                return back()->with('error', 'Startup not found.');
            }
            if ($request->hasFile('file')) {
                $filePath = FileUpDownHelper::uploadManualDocument($request->file('file'));

                if ($filePath) {
                    $investors = [];
                    foreach ($selectedTransactions as $transactionId) {
                        $transaction = PrimaryTransactionModel::find($transactionId);
                        if ($transaction) {
                            $investors[] = $transaction->investor->id;
                        }
                    }
                    $meta = [
                        'name' => $request->document . ' - ' . $startup->brand_name,
                        'sname' => $request->document,
                        'investor' => $investors,
                        'startup' => [$startup->id],
                        'primary_transactions' => $selectedTransactions,
                    ];
                    $document = DocumentsModel::create([
                        'api_id' => null,
                        'path' => $filePath,
                        'signed_path' => $filePath,
                        'status' => 1,
                        'type' => $request->document,
                        'meta' => $meta,
                    ]);
                    if ($document) {
                        return back()->with('success', 'Document uploaded successfully!');
                    } else {
                        return back()->with('error', 'Failed to save document to database.');
                    }
                } else {
                    return back()->with('error', 'File upload failed.');
                }
            }

            return back()->with('error', 'No file uploaded.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function storeSingleTransactionDoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_type' => 'required',
            'doc_file' => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }
        $transactionId = $request->input('transaction_id');

        $transaction = PrimaryTransactionModel::find($transactionId);

        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found.'], 200);
        }

        $startup = $transaction->startup;
        $investor = $transaction->investor;

        if (!$startup) {
            return UtillsHelper::json(0, ['message' => 'Startup associated with this transaction not found.'], 200);
        }

        if (!$investor) {
            return UtillsHelper::json(0, ['message' => 'Investor associated with this transaction not found.'], 200);
        }

        $filePath = FileUpDownHelper::uploadManualDocument($request->file('doc_file'));

        if (!$filePath) {
            return UtillsHelper::json(0, ['message' => 'File upload failed.'], 200);
        }

        $document = DocumentsModel::create([
            'api_id' => null,
            'path' => $filePath,
            'signed_path' => $filePath,
            'status' => 1,
            'type' => $request->doc_type,
            'meta' => [
                'name' => $request->doc_type . ' - ' . $startup->brand_name,
                'aname' => $request->doc_type . ' of ' . $startup->brand_name . ' and ' . $investor->name,
                'sname' => $request->doc_type . ' - ' .  $investor->name,
                'startup' =>  [$startup->id],
                'investor' => [$investor->id],
                'primary_transactions' => [$transaction->id],
            ],
        ]);

        if ($document) {
            return UtillsHelper::json(1, [
                'message' => 'Document uploaded successfully!',
                'document' => $document
            ], 200);
        } else {
            return UtillsHelper::json(0, ['message' => 'Failed to save document to database.'], 200);
        }
        return UtillsHelper::json(0, ['message' => 'No file uploaded.'], 200);
    }

    public function storeSingleSecTransactionDoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_type' => 'required',
            'doc_file' => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $transactionId = $request->input('transaction_id');
        $transaction = SecondaryTransactionModel::find($transactionId);

        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found.'], 200);
        }

        $startup = $transaction->startup;
        $buyer = $transaction->buyer;
        $seller = $transaction->seller;

        if (!$startup) {
            return UtillsHelper::json(0, ['message' => 'Startup associated with this transaction not found.'], 200);
        }

        if (!$buyer) {
            return UtillsHelper::json(0, ['message' => 'Buyer associated with this transaction not found.'], 200);
        }

        if (!$seller) {
            return UtillsHelper::json(0, ['message' => 'Seller associated with this transaction not found.'], 200);
        }

        // Upload document
        $filePath = FileUpDownHelper::uploadManualDocument($request->file('doc_file'));

        if (!$filePath) {
            return UtillsHelper::json(0, ['message' => 'File upload failed.'], 200);
        }

        // Store document details in the database
        $document = DocumentsModel::create([
            'api_id' => null,
            'path' => $filePath,
            'signed_path' => $filePath,
            'status' => 1,
            'type' => $request->doc_type,
            'meta' => [
                'name' => $request->doc_type . ' - ' . $startup->brand_name,
                'sname' => $request->doc_type . ' - ' .  $buyer->name . ' & ' . $seller->name,
                'startup' =>  [$startup->id],
                'investor' => [$buyer->id, $seller->id],
                'secondary_transaction' => [$transaction->id],
            ],
        ]);

        if ($document) {
            return UtillsHelper::json(1, [
                'message' => 'Document uploaded successfully!',
                'document' => $document
            ], 200);
        } else {
            return UtillsHelper::json(0, ['message' => 'Failed to save document to database.'], 200);
        }
    }

    public function storeSinglePreipoTransactionDoc(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doc_type' => 'required',
            'doc_file' => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileDocumentSizeInKB(),
        ]);

        if ($validator->fails()) {
            return UtillsHelper::json(0, ['message' => $validator->errors()->first()]);
        }

        $transactionId = $request->input('transaction_id');
        $transaction = PreIpoModel::find($transactionId);

        if (!$transaction) {
            return UtillsHelper::json(0, ['message' => 'Transaction not found.'], 200);
        }

        $investor = $transaction->investor;
        $company = $transaction->company;

        if (!$investor) {
            return UtillsHelper::json(0, ['message' => 'Investor associated with this transaction not found.'], 200);
        }

        if (!$company) {
            return UtillsHelper::json(0, ['message' => 'Company associated with this transaction not found.'], 200);
        }

        // Upload document
        $filePath = FileUpDownHelper::uploadManualDocument($request->file('doc_file'));

        if (!$filePath) {
            return UtillsHelper::json(0, ['message' => 'File upload failed.'], 200);
        }

        // Store document details in the database
        DocumentsModel::where('type', $request->doc_type)
            ->whereJsonContains('meta->preipo_transactions', $transaction->id)
            ->delete();
        $document = DocumentsModel::create([
            'api_id' => null,
            'path' => $filePath,
            'signed_path' => $filePath,
            'status' => 1,
            'type' => $request->doc_type,
            'meta' => [
                'name' => $request->doc_type . ' - ' . $company->brand_name,
                'investor' => [$investor->id],
                'preipo_transactions' => [$transaction->id],
            ],
        ]);

        if ($document) {
            $transaction->status = '3';
            $transaction->save();
            return UtillsHelper::json(1, [
                'message' => 'Document uploaded successfully!',
                'document' => $document
            ], 200);
        } else {
            return UtillsHelper::json(0, ['message' => 'Failed to save document to database.'], 200);
        }
    }
}
