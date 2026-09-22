<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\PrimaryTransactionModel;
use App\Models\SecondaryTransactionModel;
use App\Models\PreIpoModel;
use App\Enums\DocumentTypeEnum;
use App\Models\StartupModel;
use App\Models\StartupRoundModel;

class UploadDocument extends Component
{
    use WithFileUploads,WithPagination;

    
    public $document;
    public $file;
    public $selectedTransactions = [];
    public $allowedMultipleSelection = [
        DocumentTypeEnum::mgtzip->value, 
        DocumentTypeEnum::mgtchallan->value, 
        DocumentTypeEnum::pas->value, 
        DocumentTypeEnum::sha->value
    ];
    
    // Add search and pagination properties
    public $search = '';
    public $perPage = 10;
    protected $paginationTheme = 'bootstrap';

    public $primaryDocuments = [
        DocumentTypeEnum::ssa->value, 
        DocumentTypeEnum::loi->value, 
        DocumentTypeEnum::offer->value, 
        DocumentTypeEnum::mgtzip->value, 
        DocumentTypeEnum::mgtchallan->value, 
        DocumentTypeEnum::pas->value, 
        DocumentTypeEnum::sha->value, 
        DocumentTypeEnum::rtgsreceipt->value, 
        DocumentTypeEnum::chequecounterslip->value
    ];
    public $secondaryDocuments = [
        DocumentTypeEnum::secondarysh->value, 
        DocumentTypeEnum::paymentreceipt->value
    ];
    public $preipoDocuments = [
        DocumentTypeEnum::preipodealslip->value
    ];
    public $hiddenDocuments = [
        DocumentTypeEnum::ssa->value, 
        DocumentTypeEnum::loi->value, 
        DocumentTypeEnum::offer->value, 
        DocumentTypeEnum::rtgsreceipt->value, 
        DocumentTypeEnum::secondarysh->value, 
        DocumentTypeEnum::paymentreceipt->value,
        DocumentTypeEnum::chequecounterslip->value,
        DocumentTypeEnum::preipodealslip->value,
        DocumentTypeEnum::sharereceipt->value,
        DocumentTypeEnum::preipoapproval->value, 
        DocumentTypeEnum::preiporejection->value, 
        DocumentTypeEnum::aadharfront->value, 
        DocumentTypeEnum::aadharback->value, 
        DocumentTypeEnum::pancard->value, 
        DocumentTypeEnum::bankcheque->value, 
        DocumentTypeEnum::clientmaster->value, 
        DocumentTypeEnum::ppm->value, 
        DocumentTypeEnum::ca->value
    ];

    public $startups = [];
    public $selectedStartup = null;
    public $rounds = [];
    public $selectedRound = null;

    public $selectAll = false;

    // Listen for search updates
    protected $queryString = ['search'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDocument()
    {
        $this->resetPage();
        $this->selectedTransactions = [];
        $this->selectAll = false;

        if (in_array($this->document, $this->primaryDocuments)) {
            $this->startups = StartupModel::orderBy('brand_name')->get();
            $this->selectedStartup = null;  // Reset the selected startup
            $this->selectedRound = null; // Reset the selected round
            $this->rounds = [];
        } else {
            $this->startups = [];
            $this->rounds = [];
            $this->selectedStartup = null;
            $this->selectedRound = null;
        }
    }
    
    public function updatedSelectedStartup($startupId)
    {
        $this->selectedStartup = $startupId;

        if (!$this->selectedStartup) {
            $this->rounds = [];
            $this->selectedRound = null;
            return;
        }

        // Fetch rounds for the selected startup
        $this->rounds = StartupRoundModel::where('startup_id', $this->selectedStartup)
            ->where('is_deleted', 0)
            ->orderBy('name')
            ->get();

        // Reset the selected round since we have new rounds
        $this->selectedRound = null;
        
        // Force a re-render by using the dispatch method (Livewire v3)
        $this->dispatch('rounds-updated');
    }

    public function updatedSelectedTransactions()
    {
        if (!in_array($this->document, $this->allowedMultipleSelection)) {
            if (!is_array($this->selectedTransactions)) {
                $this->selectedTransactions = [$this->selectedTransactions];
            } else {
                $this->selectedTransactions = array_slice($this->selectedTransactions, -1);
            }
        }
    }

    public function loadTransactions()
    {
        if (!$this->document) {
            return collect([]);
        }

        $query = null;
        $modelType = null;
        
        // Determine which transaction model to query based on document type
        if (in_array($this->document, $this->primaryDocuments)) {
            $query = PrimaryTransactionModel::where('status', 10);
            $modelType = 'primary';
                // Apply startup filter for primary transactions
            if ($this->selectedStartup) {
                $query->where('startup_id', $this->selectedStartup);
            }

            // Apply round filter for primary transactions
            if ($this->selectedRound) {
                $query->where('round_id', $this->selectedRound);
            }
        } elseif (in_array($this->document, $this->secondaryDocuments)) {
            $query = SecondaryTransactionModel::where('status', 8);
            $modelType = 'secondary';
        } elseif (in_array($this->document, $this->preipoDocuments)) {
            $query = PreIpoModel::where('status', 5);
            $modelType = 'preipo';
        } else {
            return collect([]);
        }
        
        // Load relationships based on model type
        if ($modelType === 'primary') {
            $query->with('investor');
        } elseif ($modelType === 'secondary') {
            $query->with(['investor', 'seller', 'startup']);
        } elseif ($modelType === 'preipo') {
            $query->with(['investor', 'startup']);
        }
        
        if ($this->search) {
            // Apply search to relevant fields based on model type
            $query->where(function($q) use ($modelType) {
                // Add investor search for all model types
                if (in_array($modelType, ['primary', 'secondary', 'preipo'])) {
                    $q->whereHas('investor', function($subQ) {
                        $subQ->where('name', 'like', '%' . $this->search . '%');
                    });
                }
                
                // Add seller search only for secondary
                if ($modelType === 'secondary') {
                    $q->orWhereHas('seller', function($subQ) {
                        $subQ->where('name', 'like', '%' . $this->search . '%');
                    });
                }
                
                // Add startup search for secondary and preipo
                if (in_array($modelType, ['secondary', 'preipo'])) {
                    $q->orWhereHas('startup', function($subQ) {
                        $subQ->where('brand_name', 'like', '%' . $this->search . '%');
                    });
                }
                
                // Add general field searches for all model types
                $q->orWhere('instrument', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->paginate($this->perPage);
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            // Unselect all transactions
            $this->selectedTransactions = [];
            $this->selectAll = false;
        } else {
            // Select all transactions only if checkboxes exist
            $transactions = $this->loadTransactions();

            if ($transactions->count() > 0) {
                $this->selectedTransactions = $transactions->pluck('id')->toArray();
                $this->selectAll = true;
            }
        }
    }
    public function getFilteredDocumentTypesProperty()
    {
        // Filter out hidden document types
        return collect(DocumentTypeEnum::cases())->filter(function($docType) {
            return !in_array($docType->value, $this->hiddenDocuments);
        });
    }

    // public function save()
    // {
    //     $this->validate([
    //         'document' => 'required|string',
    //         'file' => 'required|file|mimes:pdf|max:' . UtillsHelper::maxFileImageSizeInKB(),
    //         'selectedTransactions' => 'required|array|min:1',
    //         'selectedStartup' => 'required',
    //         'selectedRound' => 'nullable',
    //     ]);
       
    //     $startup = StartupModel::find($this->selectedStartup);
    //     if (!$startup) {
    //         session()->flash('error', 'Startup not found.');
    //         return;
    //     }

    //     if ($this->file) {
    //         $filePath = FileUpDownHelper::uploadManualDocument($this->file->getRealPath());

    //         if ($filePath) {
    //         // Define metadata
    //         $investors = [];
    //         foreach ( $this->selectedTransactions as $key => $value) {
    //             $transaction = PrimaryTransactionModel::find($value);
    //             if ($transaction) {
    //                 $investors[] = $transaction->investor->id;
    //             }
    //         }
    //         $sname = $this->document;
    //         $meta = [
    //             'name' => $this->document.' - ' . $startup->brand_name,
    //             'sname' => $sname,
    //             'investor' => $investors,
    //             'startup' => [
    //                 $startup->id
    //             ],
    //             'primary_transactions' => $this->selectedTransactions
    //         ];

    //         // Upload file using FileUpDownHelper
    //         // $filePath = FileUpDownHelper::uploadManualDocument($this->file->getRealPath());

           
    //             // Store in database
    //         DocumentsModel::create([
    //             'api_id' => null,
    //             'path' => $filePath,
    //             'signed_path' => $filePath,
    //             'status' => 1,
    //             'type' => $this->document,
    //             'meta' => $meta,
    //         ]);

    //         session()->flash('message', 'Document uploaded successfully!');
    //        $this->reset(['document', 'file', 'selectedTransactions', 'selectedStartup', 'selectedRound']);
    //     } else {
    //         session()->flash('error', 'File upload failed.');
            
    //     }
    //     // $path = $this->file->store('documents', 'public');

    //     // session()->flash('message', 'Document uploaded successfully!');

    //     // $this->reset(['document', 'file', 'selectedTransactions', 'selectedStartup', 'selectedRound']);
    // }


    public function render()
    {
        return view('admin.livewire.upload-document', [
            'documentTypes' => $this->filteredDocumentTypes,
            'transactions' => $this->loadTransactions(),
        ]);
    }
}
