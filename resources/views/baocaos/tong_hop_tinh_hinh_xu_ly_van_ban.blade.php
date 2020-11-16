@extends('templates.lanhdao')
@section('main')
    <style>
        .table thead.head-table tr th {
            vertical-align: middle;
            text-align: center; 
            font-weight:bold;
            border-bottom-width: 1px;
        }
    </style>
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Thống kê tình hình xử lý văn bản đến trên Hệ thống e-office</h4>
                <span style="display: block; text-align: center; font-weight: bold; margin-bottom: 20px;">Thời điểm xuất báo cáo: {{date('d/m/Y')}}</span>
            </div>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th class="col-stt" style="width: 3%;" rowspan="3">TT</th>
                        <th style="width: 7%;" rowspan="3">Đơn vị</th>
                        <th style="width: 9%;" rowspan="3">Cán bộ</th>
                        <th style="width: 3%;" rowspan="3">Tổng số nhận</th>
                        <th style="width: 3%;" rowspan="3">Văn bản không có hạn xử lý</th>
                        <th style="width: 20%;" colspan="8">Văn bản có hạn xử lý</th>
                    </tr>
                    <tr>
                        <th style="width: 20%;" colspan="3">Đã hoàn thành</th>
                        <th style="width: 20%;" colspan="2">Chưa hoàn thành</th>
                        <th style="width: 20%;" colspan="3">Tổng số</th>
                    </tr>
                    <tr>
                        <th style="width: 5%;">Trước hạn</th>
                        <th style="width: 5%;">Đúng hạn</th>
                        <th style="width: 5%;">Quá hạn</th>
                        <th style="width: 5%;">Trong hạn</th>
                        <th style="width: 5%;">Quá hạn</th>
                        <th style="width: 5%;">Trước hạn</th>
                        <th style="width: 5%;">Đúng hạn</th>
                        <th style="width: 5%;">Quá hạn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = ($data->currentPage() - 1) * $data->perPage() + 1 ?>
                    @foreach ($data as $val)
                        <tr>
                            <td class="col-stt">{{ $stt++ }}</td>
                            <td>{{ $val->tenDonViNhan }}</td>
                            <td>{{ $val->fullname }}</td>
                            <td>{{ $val->tongSoVBDen }}</td>
                            <td>{{ $val->tongVBKhongHanXuLy }}</td>
                            <td>{{ $val->tongVBHoanThanhTruocHan }}</td>
                            <td>{{ $val->tongVBHoanThanhDungHan }}</td>
                            <td>{{ $val->tongVBHoanThanhQuaHan }}</td>
                            <td>{{ $val->tongVBChuaHoanThanhTrongHan }}</td>
                            <td>{{ $val->tongVBChuaHoanThanhQuaHan }}</td>
                            <td>{{ $val->tongVBHoanThanhTruocHan }}</td>
                            <td>{{ $val->tongVBHoanThanhDungHan + $val->tongVBChuaHoanThanhTrongHan }}</td>
                            <td>{{ $val->tongVBHoanThanhQuaHan + $val->tongVBChuaHoanThanhQuaHan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                @include('pagination', ['paginator' => $data, 'interval' => 5])
            </div>
        </div>
    </div>
@endsection