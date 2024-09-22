<?php

namespace App\Exports;

use App\Models\Document;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;

class DocumentsExport
{
    public function export()
    {
        $templatePath = public_path('storage/app/template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);

        $sheet = $spreadsheet->getActiveSheet();

        $documents = Document::all();

        $row = 2;
        foreach ($documents as $document) {
            $sheet->setCellValue('A' . $row, $document->custom_id);
            $sheet->setCellValue('B' . $row, $document->date);
            $sheet->setCellValue('C' . $row, $document->subject);
            $sheet->setCellValue('D' . $row, $document->sender);
            $sheet->setCellValue('E' . $row, $document->addresse);
            $sheet->setCellValue('F' . $row, $document->person_name_position);
            $sheet->setCellValue('G' . $row, $document->notes);
            $row++;
        }


        $filePath = storage_path('app/temp_documents_export.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
