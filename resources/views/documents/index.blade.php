@extends('layouts.app')

@section('content')
<div class="container">
    <h1>قائمة المستندات</h1>

    <!-- عرض رسائل النجاح -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a href="{{ route('documents.export') }}" class="btn btn-success">تصدير إلى Excel</a>

    <!-- جدول المستندات -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>رقم التعريف</th>
                <th>الموضوع</th>
                <th>التاريخ</th>
                <th>المرسل اليه</th>
                <th>ملاحظات</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $document)
            <tr>
                <td>{{ $document->custom_id }}</td>
                <td>{{ $document->subject }}</td>
                <td>{{ $document->date }}</td>
                <td>{{ $document->sender }}</td>
                <td>{{ $document->notes }}</td>
                <td>
                    <!-- الإجراءات: عرض، تعديل، حذف -->
                    <a href="{{ route('documents.show', str_replace('/', '-', $document->custom_id)) }}" class="text-primary" title="عرض">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('documents.edit', str_replace('/', '-', $document->custom_id)) }}" class="text-secondary mx-2" title="تعديل">
                        <i class="fas fa-edit"></i>
                    </a>

                    
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">لم يتم العثور على مستندات.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- روابط الترقيم -->
    <div class="d-flex justify-content-center">
        {{ $documents->links() }}
    </div>


</div>
@endsection
