@extends('templates.lanhdao')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align: center">Danh sách văn bản lưu</h3>
            </div>
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead class="head-table">
                    <tr>
                        <th>Số đến</th>
                        <th>Nơi ban hành</th>
                        <th>Số ký hiệu</th>
                        <th> Ngày ban hành</th>
                        <th>Trích yếu</th>
                        <th> Nơi nhận</th>
                        <th>Trạng thái</th>
                        <th>File</th>
                        <th>Chức năng</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lists as $list)
                        <tr>
                            <td>{{$list->soden}}</td>
                            <td>
                                @foreach($donvis as $donvi)
                                    @if ($donvi->id == $list->cq_banhanh)
                                        {{$donvi->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$list->kyhieu}}</td>
                            <td>{{$list->ngayky}}</td>
                            <td>{{$list->title}}</td>
                            <td>{{$list->noi_nhan}}</td>
                            <td>
                                @foreach ($publishs as $publish)
                                    @if ($publish->id == $list->publish_id)
                                        {{$publish->name}}
                                    @endif
                                @endforeach
                            </td>
                            <td></td>
                            <td>
                                <span style="padding:5px 10px"><a href="{{route('chitiet_vanban_luu',$list->id)}}">Xem Chi tiết</a></span>
                                <span style="padding:5px 10px"><a href ="{{route('edit_van_ban_luu',$list->id)}}">Chỉnh Sửa</a></span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection