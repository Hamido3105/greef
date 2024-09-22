@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Document</h1>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sender">Sender</label>
            <input type="text" name="sender" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="addressed_to">Addressed To</label>
            <input type="text" name="addressed_to" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="transferred_to">Transferred To</label>
            <input type="text" name="transferred_to" class="form-control">
        </div>
        <div class="form-group">
            <label for="attached_documents_count">Attached Documents Count</label>
            <input type="number" name="attached_documents_count" class="form-control" min="0">
        </div>
        <div class="form-group">
            <label for="person_name_position">Person Name & Position</label>
            <input type="text" name="person_name_position" class="form-control">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="document">Upload Document (PDF)</label>
            <input type="file" name="document" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Document</button>
    </form>
</div>
@endsection
