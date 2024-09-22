@extends('layouts.app')

@section('content')
<div class="container">
    <h1>إنشاء مستند جديد</h1>

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

    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="date">التاريخ</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="subject">الموضوع</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="sender">المرسل اليه</label>
            <input type="text" name="sender" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="addresse"> العنوان</label>
            <input type="text" name="addresse" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="person_name_position"> انتقال </label>
            <input type="text" name="person_name_position" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="notes">ملاحظات</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="document">تحميل المستند (PDF)</label>
            <input type="file" name="document" class="form-control" accept=".pdf" required>
        </div>
        <button type="submit" class="btn btn-primary">إنشاء المستند</button>
    </form>
</div>
@endsection
