@extends('templates.lanhdao')
@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-5 col-sm-5 col-xs-12">
                <h2>Bảng tổng hợp thu nhập tháng {{ $date }}</h2>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="clearfix"></div>
            <div class="table-responsive" style="margin-top: 15px;">
                    <div class="scroll_detail_salary">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll">
                            <thead class="head-table">
                            <tr class="headings" style="text-align: center">
                                <th class="column-title scroll_thtn col-index" style="text-align: center">STT</th>
                                <th class="column-title scroll_thtn" style="text-align: left;white-space: nowrap;">Mã cán bộ</th>
                                <th class="column-title scroll_thtn" style="text-align: left;white-space: nowrap;">Họ và tên</th>
                                <th class="column-title scroll_thtn" style="text-align: left">Lương ngạch bậc</th>
                                <th class="column-title scroll_thtn" style="text-align: center">Phụ cấp chức vụ</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Quản lý phí</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Phụ cấp Công tác Đảng</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Lương tăng thêm</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">PC TN vượt khung</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Phụ cấp khác</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tiền giảng</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tiền công NCKH</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Phúc lợi</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Lương tháng 13</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Thu nhập khác</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tổng</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">PC TN nghề</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">PC ưu đãi nghề</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tổng</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Bảo hiểm thât nghiệp trừ vào lương</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Bảo hiểm xã hội trừ vào lương</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Bảo hiểm y tế trừ vào lương</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Kinh phí công đoàn trừ vào lương</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Giảm trừ bản thân</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tổng tiền giảm trừ người phụ thuộc</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tổng</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Tổng thu nhập tính thuế</th>
                                <th class="column-title scroll_thtn"  style="text-align: center">Thuế TNCN</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (sizeof($thtn))
                                <?php $i = '1' ?>
                                @foreach($thtn as $value)
                                    <tr class="even pointer">
                                        <td>{{$i++}}</td>
                                        <td style="text-align: left;white-space: nowrap;">  {{$value->macanbo}}</td>
                                        <td style="text-align: left;white-space: nowrap;">{{$value->fullname}}</td>
                                        <td style="text-align: left;">{{number_format($value->luong_ngach_bac,0,',',',')}}</td>
                                        <td style="text-align: left;">{{number_format($value->phucap_chucvu,0,',',',')}}</td>
                                        <td>{{number_format($value->quan_ly_phi,0,',',',')}}</td>
                                        <td>{{number_format($value->phucap_congtac_dang,0,',',',')}}</td>
                                        <td>{{number_format($value->luong_tang_them,0,',',',')}}</td>
                                        <td>{{number_format($value->phucap_thamnien_vuotkhung,0,',',',')}}</td>
                                        <td>{{number_format($value->phucap_khac,0,',',',')}}</td>
                                        <td>{{number_format($value->tien_giang,0,',',',')}}</td>
                                        <td>{{number_format($value->tiencong_nckh,0,',',',')}}</td>
                                        <td>{{number_format($value->phuc_loi,0,',',',')}}</td>
                                        <td>{{number_format($value->luongthang_muoi_ba,0,',',',')}}</td>
                                        <td>{{number_format($value->thunhap_khac,0,',',',')}}</td>
                                        <td>{{number_format($value->tong_cackhoan_tinhthue,0,',',',')}}</td>
                                        <td>{{number_format($value->phucap_thamnien_nghe,0,',',',')}}</td>
                                        <td>{{number_format($value->phucap_uudai_nghe,0,',',',')}}</td>
                                        <td>{{number_format($value->tongcackhoan_khongtinhthue,0,',',',')}}</td>
                                        <td>{{number_format($value->baohiem_thatnghiep_truvaoluong,0,',',',')}}</td>
                                        <td>{{number_format($value->baohiem_xahoi_truvaoluong,0,',',',')}}</td>
                                        <td>{{number_format($value->baohiem_yte_truvaoluong,0,',',',')}}</td>
                                        <td>{{number_format($value->kinhphi_congdoan_truvaoluong,0,',',',')}}</td>
                                        <td>{{number_format($value->giamtru_banthan,0,',',',')}}</td>
                                        <td>{{number_format($value->tongtien_giamtru_nguoiphuthuoc,0,',',',')}}</td>
                                        <td>{{number_format($value->tong_cackhoan_giamtru,0,',',',')}}</td>
                                        <td>{{number_format($value->tong_thunhap_tinhthue,0,',',',')}}</td>
                                        <td>{{number_format($value->thue_TNCN,0,',',',')}}</td>
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