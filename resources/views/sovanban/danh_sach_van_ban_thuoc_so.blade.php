@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')

        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách thuộc sổ văn bản</h4>
            </div>

            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th>STT</th>
                        <th>Số đến</th>
                        <th>Nơi ban hành</th>
                        <th>Số ký hiệu</th>
                        <th>Ngày ban hành</th>
                        <th>Trích yếu</th>
                        <th>Trình Lãnh đạo</th>
                        <th>Hạn xử lý</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>  
                @if(sizeof($vanbans))
                    @php $stt = 1; @endphp
                    @foreach ($vanbans as $val)
                        <tr>
                            <td class="col-stt">{{$stt++}}</td>
                            <td>{{$val->soden}}</td>
                            <td>{{$val->cq_banhanh}}</td>
                            <td>
                                <a href="{{route('chitiet_vanban',$val->vanbanUser_id)}}" title="{{$val->kyhieu}}">{{$val->kyhieu}}</a>
                            </td>
                            <td>{{$val->ngayky}}</td>
                            <td>{{$val->title}}</td>
                            <td>
                            </td>
                            <td>{{$val->hanxuly}}</td>
                            <td>
                                @if ($val->status == 0)
                                    <span class="doNotAction lh36">Chưa xử lý</span>
                                @elseif ($val->status == 1)
                                    <span class="doNotAction lh36">Đang xử lý</span>
                                @elseif ($val->status == 2)
                                    <span class="doneAction lh36">Đã xử lý</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10" align="center"><i> Không có danh sách thuộc sổ văn bản</i></td>
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
