@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')

        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách sổ văn bản</h4>
            </div>

            <a class="btn btn-info" style="float: right; margin-bottom: 10px;" href="{{ route('sovanban.create') }}"><i class="fa fa-plus"></i> Thêm sổ văn bản</a>

            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt">STT</th>
                        <th>Tên</th>
                        <th>Loại (VB đến /VB đi)</th>
                        <th>Trạng thái</th>
                        <th>Số lượng</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($sovanbans))
                    @php $stt = 1; @endphp
                    @foreach ($sovanbans as $val)
                        <tr>
                            <td class="col-stt">{{$stt++}}</td>
                            <td>{{$val->name}}</td>
                            <td>{{$val->type}}</td>
                            <td>
                                @if ($val->status == 1)
                                    <span class="label label-success">Đang sử dụng</span>
                                @elseif ($val->status == 0)
                                    <span class="label label-warning">Không sử dụng</span>
                                @endif
                            </td>
                            <td>{{$val->vanbans_count}}</td>
                            <td class="col-stt">
                                <a href="{{ route('sovanban.danh_sach_van_ban_thuoc_so', [$val->id]) }}" title="danh sách sổ văn bản"><i class="fa fa-list" aria-hidden="true"></i></a></td>
                            <td class="col-stt">
                                <a href="{{ route('sovanban.edit', [$val->id]) }}" title="Sửa sổ văn bản"><i class="fa fa-edit"></i></a>
                            </td>
                            <td class="col-stt">
                                <a href="javascript:;" onclick="deleteSoVanBan({{ $val->id }})" title="Xóa sổ văn bản"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" align="center"><i> Không có dữ liệu</i></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function deleteSoVanBan(id) {
            jConfirm('Bạn có muốn xóa?', 'Thông báo', function (r) {
                if (r) {
                    loading_show();
                    
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post("{{ route('sovanban.delete') }}", {ids:[id], _token:CSRF_TOKEN}, () => {
                        location.reload();
                    });
                }
            });
        }
    </script>
@endsection
