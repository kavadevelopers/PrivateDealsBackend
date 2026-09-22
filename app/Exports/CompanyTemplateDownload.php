<?php

namespace App\Exports;

use App\Models\CompanyModel;
use App\Models\SellerMasterModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CompanyTemplateDownload implements FromArray, WithHeadings, WithStyles, WithTitle
{
    public function array(): array
    {
        // Fetching data from the database
        $companies = CompanyModel::pluck('brand_name');

        // Preparing the data array
        $data = [];
        foreach ($companies as $company) {
            // Add company name and leave Retail Price column blank
            $row = [$company, ''];

            // Add empty columns for sellers dynamically
            $sellers = SellerMasterModel::pluck('company_name')->toArray();
            $row = array_merge($row, array_fill(0, count($sellers), ''));

            $data[] = $row;
        }

        return $data;
    }

    public function headings(): array
    {
        // Fetch sellers dynamically for headings
        $sellers = SellerMasterModel::pluck('company_name')->toArray();
        $sellerColumns = array_map(fn($seller) => $seller, $sellers);

        return array_merge(['Company', 'Retail Price'], $sellerColumns);
    }

    public function styles(Worksheet $sheet)
    {
        // Get the number of data rows
        $data = $this->array();
        $lastRow = count($data) + 1; // Including the header row

        // Styling the header row
        $sheet->getStyle('A1:Z1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Styling all cells with borders
        $sheet->getStyle('A1:Z1000')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Lock the entire header row (A1:Z1)
        $sheet->getStyle('A1:Z1')->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

        // Lock only Column A (Company)
        $sheet->getStyle("A2:A$lastRow")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_PROTECTED);

        // Unlock all other columns, including Retail Price (Column B) and seller columns
        $sheet->getStyle("B2:Z$lastRow")->getProtection()->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

        // Enable sheet protection
        $sheet->getProtection()->setSheet(true);

        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        for ($row = 2; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto-fit row height
        }
    }

    public function title(): string
    {
        return 'Company Data';
    }
}
