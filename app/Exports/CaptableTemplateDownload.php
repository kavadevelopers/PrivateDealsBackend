<?php

namespace App\Exports;

use App\Enums\InstrumentTypeEnum;
use App\Enums\InvestorTypeEnum;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CaptableTemplateDownload implements FromArray, WithHeadings, WithStyles, WithTitle, WithEvents
{
    private $data;

    public function __construct(array $data)
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
            'Name',
            'Email',
            'Mobile Number',
            'Share',
            'Holding Percentage',
            'Instrument Type',
            'Investor Type',
            'Promoter', // New promoter column
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([ // Updated range for new column
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
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->getStyle("A1:H1000")->applyFromArray([ // Updated range for new column
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ]);
    }

    public function title(): string
    {
        return 'Investor Data';
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function (\Maatwebsite\Excel\Events\AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $instrumentTypes = $this->getEnumValues(InstrumentTypeEnum::class);
                $investorTypes = $this->getEnumValues(InvestorTypeEnum::class);

                for ($row = 2; $row <= 1000; $row++) {
                    $this->applyDropdown($sheet, "F$row", $instrumentTypes);
                    $this->applyDropdown($sheet, "G$row", $investorTypes);
                    $this->applyDropdown($sheet, "H$row", '"Yes,No"'); // Dropdown for promoter column
                }
            },
        ];
    }

    private function applyDropdown(Worksheet $sheet, $cell, $options)
    {
        $validation = $sheet->getCell($cell)->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $validation->setFormula1($options);
        $validation->setShowInputMessage(true);
        $validation->setPromptTitle('Choose an option');
        $validation->setPrompt('Please select a value from the dropdown.');
    }

    private function getEnumValues(string $enumClass): string
    {
        return '"' . implode(',', array_map(fn($enum) => $enum->value, $enumClass::cases())) . '"';
    }
}
