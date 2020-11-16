@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách đơn vị của cơ quan {{ $book->name }}</h4>
            </div>
            <a class="btn btn-info" style="float: right;margin-bottom: 10px;" href="{{ route('co_quan.create_don_vi', [$book->id]) }}"><i class="fa fa-plus"></i> Thêm đơn vị</a>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th>Tên đơn vị</th>
                        <th>Tên viết tắt</th>
                        <th>Email</th>
                        <th class="text-center col-fit-content">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($bookDetails))
                    @php $stt = 1 @endphp
                    @foreach ($bookDetails as $bookDetail)
                        <tr>
                            <td class="col-stt">{{$stt++}}</td>
                            <td><strong>{{$bookDetail->donviName}}</strong></td>
                            <td>{{$bookDetail->donviTenVT}}</td>
                            <td class="email_color">{{ implode('; ', $bookDetail->emails) }}</td>
                            <td class="text-center col-fit-content">
                                <span class="btn-table">
                                    <a href="{{ route('co_quan.edit_don_vi', [$bookDetail->id]) }}" title="Sửa đơn vị"><i class="fa fa-edit"></i></a>
                                </span>
                                <span class="btn-table">
                                    <a href="javascript:;" onclick="deleteDonVi({{ $bookDetail->id }})" title="Xóa đơn vị"><i class="fa fa-trash red"></i></a>
                                </span>
                            </td>
                        </tr>
                        @foreach ($bookDetail->users as $user)
                            <tr>
                                <td class="col-stt"></td>
                                <td>{{$user->fullname}}</td>
                                <td></td>
                                <td class="email_color">{{ trim($user->email) }}</td>
                                <td class="text-center"></td>
                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" align="center"><i>Không có dữ liệu</i></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function deleteDonVi(id) {
            jConfirm('Bạn có muốn xóa?', 'Thông báo', function (r) {
                if (r) {
                    loading_show();
                    
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('co_quan.delete_don_vi') }}", {ids:[id], _token:CSRF_TOKEN}, () => {
                        location.reload();
                    });
                }
            });
        }
    </script>
@endsection
