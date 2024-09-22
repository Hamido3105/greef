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
        // تحميل القالب من المسار المحدد
        $templatePath = public_path('storage/app/template.xlsx');
        $spreadsheet = IOFactory::load($templatePath);

        // الحصول على الورقة النشطة من القالب
        $sheet = $spreadsheet->getActiveSheet();

        // جلب البيانات من قاعدة البيانات
        $documents = Document::all();

        // بدء إدخال البيانات من الصف رقم 2 (أو الصف المطلوب)
        $row = 2; // تعديل حسب صف البداية في القالب
        foreach ($documents as $document) {
            $sheet->setCellValue('A' . $row, $document->custom_id);
            $sheet->setCellValue('B' . $row, $document->subject);
            $sheet->setCellValue('C' . $row, $document->date);
            $sheet->setCellValue('D' . $row, $document->sender);
            $sheet->setCellValue('E' . $row, $document->addressed_to);
            $sheet->setCellValue('F' . $row, $document->transferred_to);
            $sheet->setCellValue('G' . $row, $document->attached_documents_count);
            $sheet->setCellValue('H' . $row, $document->person_name_position);
            $sheet->setCellValue('I' . $row, $document->notes);
            $sheet->setCellValue('J' . $row, $document->document_path);
            $sheet->setCellValue('K' . $row, $document->created_at);
            $sheet->setCellValue('L' . $row, $document->updated_at);
            $row++;
        }

        // حفظ الملف المعبأ كملف جديد في التخزين
        $filePath = storage_path('app/temp_documents_export.xlsx');
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        // إعداد الاستجابة مع الملف المعبأ للتنزيل
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
