<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioImportModel extends Model
{
    use HasFactory;

    protected $table = 'portfolio_import';

    protected $fillable = [
        'investor_id',
        'type',
        'company_id',
        'other_name',
        'shares',
        'share_price',
        'date',
    ];

    function startup(): BelongsTo
    {
        return $this->belongsTo(StartupModel::class, 'startup_id');
    }

    function investor(): BelongsTo
    {
        return $this->belongsTo(InvestorModel::class, 'investor_id');
    }
}
