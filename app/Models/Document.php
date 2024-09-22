<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $primaryKey = 'custom_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'custom_id',
        'date',
        'subject',
        'sender',
        'addresse',
        'person_name_position',
        'notes',
        'document_path',
    ];
    
}
