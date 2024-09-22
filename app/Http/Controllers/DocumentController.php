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

        // Order the documents by creation date (most recent first) and paginate the results
        $documents = $query->orderBy('created_at', 'desc')->paginate(10);

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
        'subject' => 'required|string|max:255',
        'date' => 'required|date',
        'sender' => 'required|string|max:255',
        'addressed_to' => 'required|string|max:255',
        'document' => 'required|mimes:pdf|max:2048',
    ]);

    // Handle file upload and save the document to storage
    if ($request->hasFile('document')) {
        $filePath = $request->file('document')->store('documents', 'public');
    }

    // Generate custom ID format: yyyy/nnn
    $year = date('Y');
    $lastDocument = Document::whereYear('created_at', $year)->orderBy('created_at', 'desc')->first();

    if ($lastDocument) {
        $lastNumber = (int) substr($lastDocument->custom_id, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '001';
    }

    $customId = $year . '/' . $newNumber;

    Document::create([
        'custom_id' => $customId,
        'subject' => $request->input('subject'),
        'date' => $request->input('date'),
        'sender' => $request->input('sender'),
        'addressed_to' => $request->input('addressed_to'),
        'transferred_to' => $request->input('transferred_to'),
        'attached_documents_count' => $request->input('attached_documents_count'),
        'person_name_position' => $request->input('person_name_position'),
        'notes' => $request->input('notes'),
        'document_path' => $filePath, // Save the file path
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
    public function edit($id)
    {
        // Find the document by its ID
        $document = Document::findOrFail($id);

        // Return the edit view with the document data
        return view('documents.edit', compact('document'));
    }

    // Update method to handle document updates
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'subject' => 'required|string|max:255',
            'date' => 'required|date',
            'sender' => 'required|string|max:255',
            'addressed_to' => 'required|string|max:255',
            'document' => 'nullable|mimes:pdf|max:2048', // Optional document update
        ]);

        // Find the document by its ID
        $document = Document::findOrFail($id);

        // Handle optional file upload if there's a new document
        if ($request->hasFile('document')) {
            // Delete the old document
            Storage::disk('public')->delete($document->document_path);

            // Store the new document
            $filePath = $request->file('document')->store('documents', 'public');
            $document->document_path = $filePath; // Update the file path
        }

        // Update document information
        $document->update([
            'subject' => $request->input('subject'),
            'date' => $request->input('date'),
            'sender' => $request->input('sender'),
            'addressed_to' => $request->input('addressed_to'),
            'transferred_to' => $request->input('transferred_to'),
            'attached_documents_count' => $request->input('attached_documents_count'),
            'person_name_position' => $request->input('person_name_position'),
            'notes' => $request->input('notes'),
        ]);

        // Redirect with a success message
        return redirect()->route('documents.index')->with('success', 'Document updated successfully');
    }

    // Delete method to handle document deletion
    public function destroy($id)
    {
        // Find the document by its ID
        $document = Document::findOrFail($id);

        // Delete the associated file from storage
        Storage::disk('public')->delete($document->document_path);

        // Delete the document from the database
        $document->delete();

        // Redirect with a success message
        return redirect()->route('documents.index')->with('success', 'Document deleted successfully');
    }
    
}
