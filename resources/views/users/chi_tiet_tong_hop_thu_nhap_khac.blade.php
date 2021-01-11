@extends('templates.lanhdao')
@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-5 col-sm-5 col-xs-12">
                <h2>Bảng tổng hợp thu nhập khác {{ $date }}</h2>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="clearfix"></div>
            <div class="table-responsive" style="margin-top: 15px;">
                <div class="scroll_detail_salary">
                    <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll" style="display: inline-table;">
                        <thead class="head-table">
                        <tr class="headings" style="text-align: center">
                            <th rowspan="2" class="column-title col-index scroll_top_one top_head_scroll_tnk" style="text-align: center">STT</th>
                            <th rowspan="2" class="column-title scroll_top_one top_head_scroll_tnk" style="text-align: left;white-space: nowrap;">Mã cán bộ</th>
                            <th rowspan="2" class="column-title scroll_top_one top_head_scroll_tnk" style="text-align: left;white-space: nowrap;">Họ và tên</th>
                            <th colspan="2" class="column-title tnk_menu add_down" style="text-align: center">Tiền giảng</th>
                            <th colspan="2" class="column-title tnk_menu add_down"  style="text-align: center">Quản lí phí</th>
                            <th colspan="2" class="column-title tnk_menu add_down"  style="text-align: center">Lương tăng thêm</th>
                            <th colspan="2" class="column-title tnk_menu add_down" style="text-align: center">Khoán điện thoại</th>
                            <th rowspan="2" class="column-title scroll_top_one top_head_scroll_tnk" style="text-align: center">Thu nhập khác</th>
                            <th rowspan="2" class="column-title scroll_top_one top_head_scroll_tnk" style="text-align: center">Trừ tạm ứng,thuế TNCN</th>
                            <th rowspan="2" class="column-title scroll_top_one top_head_scroll_tnk" style="text-align: center">Thực nhận</th>
                        </tr>
                        <tr class="headings" style="text-align: center">
                            <th class="column-title add_down_two" style="text-align: left">Số tiết</th>
                            <th class="column-title add_down_two" style="text-align: center">Số tiền</th>
                            <th class="column-title add_down_two"  style="text-align: center">Tổng hệ số</th>
                            <th class="column-title add_down_two"  style="text-align: center">Hệ số</th>
                            <th class="column-title add_down_two"  style="text-align: center">Tổng hệ số</th>
                            <th class="column-title add_down_two"  style="text-align: center">Số tiền</th>
                            <th class="column-title add_down_two"  style="text-align: center">Số tháng</th>
                            <th class="column-title add_down_two"  style="text-align: center">Số tiền</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(sizeof($thtnk))
                            @php $i = 1; @endphp
                            @foreach($thtnk as $value)
                                <tr class="even pointer">
                                    <td>{{$i++}}</td>
                                    <td style="text-align: left;white-space: nowrap;">  {{$value->macanbo}}</td>
                                    <td style="text-align: left;white-space: nowrap;">{{$value->fullname}}</td>
                                    <td style="text-align: left;">{{$value->sotiet_tien_giang}}</td>
                                    <td style="text-align: left;">{{number_format($value->tien_giang,0,',',',')}}</td>

                                    <td>{{$value->hs_quan_ly_phi}}</td>
                                    <td>{{number_format($value->quan_ly_phi,0,',',',')}}</td>
                                    <td>{{$value->hs_luong_tang_them}}</td>
                                    <td>{{number_format($value->luong_tang_them,0,',',',')}}</td>
                                    <td>{{$value->sothang_dienthoai}}</td>
                                    <td>{{number_format($value->khoan_dien_thoai,0,',',',')}}</td>
                                    <td>{{number_format($value->thu_nhap_khac,0,',',',')}}</td>
                                    <td>{{number_format($value->trutam_ungthue_tncn,0,',',',')}}</td>
                                    <td>{{number_format($value->thuc_nhan,0,',',',')}}</td>
                                </tr>
                            @endforeach

                        @else
                            <tr>
                                <td colspan="12">{{ trans('common.txt_no_data') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="clearfix"></div>
        </div>

@endsection