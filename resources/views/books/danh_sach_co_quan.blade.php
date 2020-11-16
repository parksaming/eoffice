@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách cơ quan</h4>
            </div>
            <a class="btn btn-info" style="float: right; margin-bottom: 10px;" href="javascript:;"><i class="fa fa-plus"></i> Thêm cơ quan</a>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th>Tên cơ quan</th>
                        <th>Loại cơ quan</th>
                        <th class="text-center col-fit-content">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($books))
                    @php $stt = 1 @endphp
                    @foreach ($books as $book)
                        <tr>
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>{{ $book->name }}</td>
                            <td>{{ $book->type }}</td>
                            <td class="text-center col-fit-content">
                                <span class="btn-table">
                                    <a href="{{ route('co_quan.list_don_vi', [$book->id]) }}" title="Xem danh sách đơn vị"><i class="fa fa-eye"></i></a>
                                </span>
                                <span class="btn-table">
                                    <a href="{{ route('co_quan.edit', [$book->id]) }}" title="Sửa cơ quan"><i class="fa fa-edit"></i></a>
                                </span>
                                <span class="btn-table">
                                    <a href="javascript:;" onclick="deleteCoQuan({{ $book->id }})" title="Xóa cơ quan"><i class="fa fa-trash red"></i></a>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" align="center"><i>Không có dữ liệu</i></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteCoQuan(id) {
            jConfirm('Bạn có muốn xóa?', 'Thông báo', function (r) {
                if (r) {
                    loading_show();
                    
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('co_quan.delete') }}", {ids:[id], _token:CSRF_TOKEN}, () => {
                        location.reload();
                    });
                }
            });
        }
    </script>
@endsection
