@extends('templates.lanhdao')
@section('main')
<div class="container container-list">
    @include('flash::message')
    <div class="row">
        <div class="row">
            <h3 class="col-md-9 text-left">Danh sách tài khoản</h3>
            <div class="col-md-3 text-right" style="margin-top: 15px;display: flex">
                <a class="btn btn-primary pr-4" style="margin-bottom: 15px;" href="{{ route('them_tai_khoan') }}"><i class="fa fa-pencil-square-o"></i> Thêm tài khoản</a>
                <form id="form-search" method="GET" action="{{base_url()}}" accept-charset="UTF-8">
                    {{ csrf_field() }}
                    <input type="text"  placeholder="Tìm kiếm" name="keySearch" class="form-control ml-2"  value="<?php echo $keySearch;?>" />
                </form>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead class="head-table">
                <tr>
                    <th class="col-stt">STT</th>
                    <th>Mã cán bộ</th>
                    <th>Họ và tên</th>
                    <th>Đơn vị</th>
                    <th>Email</th>
                    <th>Vai trò</th>
                    <th style="width: 60px;"></th>
                </tr>
            </thead>
            <tbody>
                @if(sizeof($users))
                    @php $stt = ($users->currentPage() - 1) * $users->perPage() + 1 @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>{{ $user->macanbo }}</td>
                            <td>{{ $user->fullname }}</td>
                            <td>{{ $user->donvi? $user->donvi->name : '' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role_text }}</td>
                            <td style="text-align: center">
                                <a href="{{ route('sua_tai_khoan', $user->id) }}" title="Sửa tài khoản"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" align="center"><i> Không có dữ liệu</i></td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="pull-right">
            {!! $users->render() !!}
        </div>
    </div>
</div>
@endsection
