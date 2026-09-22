<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TopActiveInvestorsExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Rank',
            'Investor Name',
            'Mobile Number',
            'Email',
            'Device Used',
            'Total Activity Count',
            'Last Active Date'
        ];
    }
}
