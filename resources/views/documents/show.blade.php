@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تفاصيل المستند</h1>

    <div class="card">
        <div class="card-header">
            رقم المستند: {{ $document->custom_id }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $document->subject }}</h5>
            <p><strong>التاريخ:</strong> {{ $document->date }}</p>
            <p><strong>المرسل:</strong> {{ $document->sender }}</p>
            <p><strong>موجه إلى:</strong> {{ $document->addressed_to }}</p>
            <p><strong>تم تحويله إلى:</strong> {{ $document->transferred_to }}</p>
            <p><strong>عدد المستندات المرفقة:</strong> {{ $document->attached_documents_count }}</p>
            <p><strong>اسم الشخص والمسمى الوظيفي:</strong> {{ $document->person_name_position }}</p>
            <p><strong>ملاحظات:</strong> {{ $document->notes }}</p>

            <div class="form-group">
                <label for="documentFile">المستند المرفوع:</label>
                <br>
                <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank">عرض PDF</a>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('documents.edit', $document->custom_id) }}" class="btn btn-secondary">تعديل</a>
            <form action="{{ route('documents.destroy', $document->custom_id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">حذف</button>
            </form>
            <a href="{{ route('documents.index') }}" class="btn btn-info">العودة إلى القائمة</a>
        </div>
    </div>
</div>
@endsection
