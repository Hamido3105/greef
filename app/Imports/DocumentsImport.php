<?php

namespace App\Imports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DocumentsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Document([
            'custom_id' => $row['custom_id'], // Ensure the heading matches the Excel column
            'subject' => $row['subject'],
            'date' => $row['date'],
            'sender' => $row['sender'],
            'addressed_to' => $row['addressed_to'],
            'transferred_to' => $row['transferred_to'],
            'attached_documents_count' => $row['attached_documents_count'],
            'person_name_position' => $row['person_name_position'],
            'notes' => $row['notes'],
            'document_path' => $row['document_path'], // This might need to be adjusted based on your Excel structure
        ]);
    }
}
