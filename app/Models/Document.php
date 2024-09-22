<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'custom_id'; // Set custom_id as the primary key
    public $incrementing = false; // Set to false since custom_id is not an integer
    protected $keyType = 'string'; // Specify that the primary key is a string

    protected $fillable = [
        'custom_id',
        'subject',
        'date',
        'sender',
        'addressed_to',
        'transferred_to',
        'attached_documents_count',
        'person_name_position',
        'notes',
        'document_path',
    ];
}
