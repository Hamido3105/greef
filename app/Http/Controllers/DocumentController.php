<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Index method to list all documents with pagination
    public function index(Request $request)
{
    // If search filters exist, modify the query accordingly
    $query = Document::query();

    if ($request->filled('subject')) {
        $query->where('subject', 'like', '%' . $request->subject . '%');
    }

    if ($request->filled('sender')) {
        $query->where('sender', 'like', '%' . $request->sender . '%');
    }

    // Order the documents by the numeric part of custom_id
    $documents = $query->orderByRaw("CAST(SUBSTRING_INDEX(custom_id, '/', -1) AS UNSIGNED) DESC")->paginate(10);

    // Return the index view with paginated documents
    return view('documents.index', compact('documents'));
}

    public function create()
    {
        return view('documents.create');
    }

    // Store new document
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'subject' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'addresse' => 'required|string|max:255',
            'person_name_position' => 'nullable|string|max:255',  // حقل انتقال
            'notes' => 'nullable|string',  // حقل ملاحظات
            'document' => 'required|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('document')) {
            $filePath = $request->file('document')->store('documents', 'public');
        }

        $year = date('Y');
        $lastDocument = Document::whereYear('created_at', $year)->orderBy('created_at', 'desc')->first();
        $newNumber = $lastDocument ? str_pad((int) substr($lastDocument->custom_id, -3) + 1, 3, '0', STR_PAD_LEFT) : '001';
        $customId = $year . '/' . $newNumber;

        Document::create([
            'custom_id' => $customId,
            'subject' => $request->input('subject'),
            'date' => $request->input('date'),
            'sender' => $request->input('sender'),
            'addresse' => $request->input('addresse'),
            'person_name_position' => $request->input('person_name_position'),  // إضافة انتقال
            'notes' => $request->input('notes'),  // إضافة ملاحظات
            'document_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully');
    }


    // Show a single document (for viewing details)
    public function show($custom_id)
{
    // Convert custom_id from format yyyy-nnn to yyyy/nnn
    $custom_id = str_replace('-', '/', $custom_id);
    $document = Document::findOrFail($custom_id);

    return view('documents.show', compact('document'));
}

    // Edit method to show the edit form for a document
    public function edit($custom_id)
    {
        $custom_id = str_replace('-', '/', $custom_id);
        // Find the document by its ID
        $document = Document::findOrFail($custom_id);

        // Return the edit view with the document data
        return view('documents.edit', compact('document'));
    }

    // Update method to handle document updates
    public function update(Request $request, $custom_id)
{
    // تحويل custom_id من format yyyy-nnn إلى yyyy/nnn
    $custom_id = str_replace('-', '/', $custom_id);

    // تحقق من صحة المدخلات
    $request->validate([
        'subject' => 'required|string|max:255',
        'date' => 'required|date',
        'sender' => 'required|string|max:255',
        'person_name_position' => 'nullable|string|max:255',
        'addresse' => 'required|string|max:255',
        'notes' => 'nullable|string|max:500',
        'document' => 'nullable|mimes:pdf|max:2048',
    ]);

    // البحث عن المستند بواسطة custom_id
    $document = Document::findOrFail($custom_id);

    // إذا كان هناك ملف جديد، احذف الملف القديم وقم بتخزين الملف الجديد
    if ($request->hasFile('document')) {
        Storage::disk('public')->delete($document->document_path);
        $filePath = $request->file('document')->store('documents', 'public');
        $document->document_path = $filePath;
    }

    // تحديث بيانات المستند
    $document->update([
        'subject' => $request->input('subject'),
        'date' => $request->input('date'),
        'sender' => $request->input('sender'),
        'person_name_position' => $request->input('person_name_position'),
        'addresse' => $request->input('addresse'),
        'notes' => $request->input('notes'),
    ]);

    return redirect()->route('documents.index')->with('success', 'تم تحديث المستند بنجاح');
}


    // Delete method to handle document deletion
    

}
