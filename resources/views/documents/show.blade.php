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
            <p><strong>المرسل اليه :</strong> {{ $document->sender }}</p>
            <p><strong> العنوان :</strong> {{ $document->addresse ?? 'لا يوجد' }}</p>
            <p><strong>الانتقال:</strong> {{ $document->person_name_position ?? 'لا يوجد' }}</p> <!-- عرض الحقل الخاص بالانتقال -->
            <p><strong>ملاحظات:</strong> {{ $document->notes ?? 'لا يوجد' }}</p>

            <div class="form-group">
                <label for="documentFile">المستند المرفوع:</label>
                <br>
                <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank">عرض PDF</a>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('documents.edit', $document->custom_id) }}" class="btn btn-secondary">تعديل</a>
            
            <a href="{{ route('documents.index') }}" class="btn btn-info">العودة إلى القائمة</a>
        </div>
    </div>
</div>
@endsection
