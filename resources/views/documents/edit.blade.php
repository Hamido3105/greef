@extends('layouts.app')

@section('content')
<div class="container">
    <h1>تعديل المستند</h1>

    <!-- عرض الأخطاء -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('documents.update', str_replace('/', '-', $document->custom_id)) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" name="date" class="form-control" value="{{ $document->date }}" required>
        </div>
        <div class="form-group">
            <label for="subject">الموضوع</label>
            <input type="text" name="subject" class="form-control" value="{{ $document->subject }}" required>
        </div>
        <div class="form-group">
            <label for="sender">المرسل اليه</label>
            <input type="text" name="sender" class="form-control" value="{{ $document->sender }}" required>
        </div>
        <div class="form-group">
            <label for="addresse">العنوان</label>
            <input type="text" name="addresse" class="form-control" value="{{ $document->addresse }}" required>
        </div>
        <div class="form-group">
            <label for="person_name_position">انتقال</label>
            <input type="text" name="person_name_position" class="form-control" value="{{ $document->person_name_position }}">
        </div>
        <div class="form-group">
            <label for="notes">ملاحظات</label>
            <textarea name="notes" class="form-control">{{ $document->notes }}</textarea>
        </div>
        <div class="form-group">
            <label for="document">تحميل مستند جديد (PDF) - اختياري</label>
            <input type="file" name="document" class="form-control" accept=".pdf">
        </div>

        <button type="submit" class="btn btn-primary">تحديث المستند</button>
    </form>
</div>
@endsection
