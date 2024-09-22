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
                <th>المرسل</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $document)
            <tr>
                <td>{{ $document->custom_id }}</td> <!-- رقم التعريف المخصص -->
                <td>{{ $document->subject }}</td>
                <td>{{ $document->date }}</td>
                <td>{{ $document->sender }}</td>
                <td>
                    <!-- الإجراءات: عرض، تعديل، حذف -->
                    <a href="{{ route('documents.show', str_replace('/', '-', $document->custom_id)) }}" class="btn btn-primary">عرض</a>
                    <a href="{{ route('documents.edit', $document->custom_id) }}" class="btn btn-secondary">تعديل</a>

                    <!-- زر الحذف يستدعي النافذة -->
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $document->id }}">
                        حذف
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">لم يتم العثور على مستندات.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- روابط الترقيم -->
    <div class="d-flex justify-content-center">
        {{ $documents->links() }}
    </div>

    <!-- نافذة تأكيد الحذف -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد أنك تريد حذف هذا المستند؟
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- تضمين JS الخاص بـ Bootstrap و jQuery لتشغيل النوافذ -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // الزر الذي استدعى النافذة
        var documentId = button.data('id');  // استخراج المعلومات من سمات data-*
        var action = '{{ route('documents.destroy', ':id') }}'; // تحديث URL الخاص بالنموذج

        action = action.replace(':id', documentId);
        $('#deleteForm').attr('action', action); // تعيين الخاصية action للنموذج
    });
</script>
@endsection
