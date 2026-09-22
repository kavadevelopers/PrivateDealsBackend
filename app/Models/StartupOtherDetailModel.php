<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StartupOtherDetailModel extends Model
{
    use HasFactory;

    protected $table = 'startup_other_details';

    protected $fillable = [
        'startup_id',
        'round_id',
        'number_of_founders',
        'name_of_founder',
        'age',
        'education_qualification',
        'work_exp',
        'startup_failures_successful_exits',
        'pitchdeck',
        'financial_model',
        'founder_email_id',
        'founder_contact_number',
        'highlights',
        'idea',
        'key_information',
        'ssa_id',
        'ssa_sign_coordinates',
        'offer_sign_coordinates',
        'equity_offered',
        'floor',
        'cap',
    ];

    public function startup():BelongsTo
    {
        return $this->belongsTo(StartupModel::class);
    }

    public function round():BelongsTo
    {
        return $this->belongsTo(StartupRoundModel::class);
    }
}
