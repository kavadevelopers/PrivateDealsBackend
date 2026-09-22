<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestUserTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle
{
    /**
     * @return array
     */
    public function array(): array
    {
        // Return empty array - template will only have headers, no sample data
        return [];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Mobile Number',
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row (headers)
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Guest Users';
    }
}
