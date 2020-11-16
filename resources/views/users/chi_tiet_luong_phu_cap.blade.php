@extends('templates.lanhdao')
@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-5 col-sm-5 col-xs-12">
                <h2>Bảng thanh toán phụ cấp và lương {{ $date }}</h2>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="clearfix"></div>
            <div class="table-responsive" style="margin-top: 15px;">
                    <div style="overflow: auto;">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll">
                            <thead class="head-table">
                            <tr class="headings" style="text-align: center">
                                <th rowspan="2" class="column-title col-index" style="text-align: center">STT</th>
                                <th rowspan="2" class="column-title" style="text-align: left;white-space: nowrap;">Mã cán bộ</th>
                                <th rowspan="2" class="column-title" style="text-align: left;white-space: nowrap;">Họ và tên</th>
                                <th colspan="2" class="column-title" style="text-align: center">Lương ngạch bậc</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Phụ cấp chức vụ</th>
                                <th colspan="2" class="column-title" style="text-align: center">Phụ cấp thâm niên vượt khung</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Phụ cấp thâm niên nghề</th>
                                <th colspan="2" class="column-title" style="text-align: center">Phụ cấp ưu đãi nghề</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Phụ cấp khác</th>
                                <th colspan="2" class="column-title" style="text-align: center">Phụ cấp Công tác Đảng</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Lương tăng thêm</th>
{{--                                <th colspan="2" class="column-title" style="text-align: center">Quản lý phí</th>--}}
                                <th rowspan="2" class="column-title"  style="text-align: center">Tổng thu nhập</th>
                                <th colspan="5" class="column-title" style="text-align: center">Khấu trừ</th>
                                <th rowspan="2" class="column-title"  style="text-align: center">Thuế TNCN</th>
                                <th rowspan="2" class="column-title" style="text-align: center">Trừ tạm ứng, nợ thuế</th>
                                <th rowspan="2" class="column-title"  style="text-align: center">Trừ các khoản khác</th>
                                <th rowspan="2" class="column-title"  style="text-align: center">Thực lĩnh</th>
                                <th rowspan="2" class="column-title" style="text-align: center">Số TK cá nhân</th>
                            </tr>
                            <tr class="headings" style="text-align: center">
                                <th class="column-title" style="text-align: left">Hệ số</th>
                                <th class="column-title" style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Hệ số</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Tỷ lệ</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Tỷ lệ</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Tỷ lệ</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Hệ số</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Hệ số</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Hệ số</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
{{--                                <th class="column-title"  style="text-align: center">Hệ số</th>--}}
{{--                                <th class="column-title"  style="text-align: center">Số tiền</th>--}}
                                <th class="column-title"  style="text-align: center">BHXH</th>
                                <th class="column-title"  style="text-align: center">BHTN</th>
                                <th class="column-title"  style="text-align: center">BHYT</th>
                                <th class="column-title"  style="text-align: center">KPCĐ</th>
                                <th class="column-title"  style="text-align: center">Tổng</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(sizeof($lpc))
                            @php $i = 1; @endphp
                            @foreach($lpc as $value)
                                    <tr class="even pointer">
                                            <td>{{$i++}}</td>
                                            <td style="text-align: left;white-space: nowrap;">  {{$value->macanbo}}</td>
                                            <td style="text-align: left;white-space: nowrap;">{{$value->fullname}}</td>
                                            <td style="text-align: left;">{{$value->hs_luong_ngach_bac}}</td>
                                            <td style="text-align: left;">{{number_format($value->luong_ngach_bac,0,',',',')}}</td>
                                            <td>{{number_format($value->hs_phucap_chucvu,0,',',',')}}</td>
                                            <td>{{number_format($value->phucap_chucvu,0,',',',')}}</td>
                                            <td>{{$value->tyle_phucap_thamnien_vuotkhung}}</td>

                                            <td>{{number_format($value->phucap_thamnien_vuotkhung,0,',',',')}}</td>
                                            <td>{{$value->tyle_phucap_thamnien_nghe}}</td>
                                            <td>{{number_format($value->phucap_thamnien_nghe,0,',',',')}}</td>
                                            <td>{{$value->tyle_phucap_uudai_nghe}}</td>

                                            <td>{{number_format($value->phucap_uudai_nghe,0,',',',')}}</td>
                                            <td>{{$value->hs_phucap_khac}}</td>
                                            <td>{{number_format($value->phucap_khac,0,',',',')}}</td>
                                            <td>{{$value->hs_phucap_congtac_dang}}</td>

                                            <td>{{number_format($value->phucap_congtac_dang,0,',',',')}}</td>
                                            <td>{{$value->hs_luong_tang_them}}</td>
                                            <td>{{number_format($value->luong_tang_them,0,',',',')}}</td>
{{--                                            <td>{{$value->hs_quan_li_phi}}</td>--}}

{{--                                            <td>{{number_format($value->quan_li_phi,0,',',',')}}</td>--}}
                                            <td>{{number_format($value->tong_thu_nhap,0,',',',')}}</td>
                                            <td>{{number_format($value->khautru_BHXH,0,',',',')}}</td>
                                            <td>{{number_format($value->khautru_BHTN,0,',',',')}}</td>
                                            <td>{{number_format($value->khautru_BHYT,0,',',',')}}</td>
                                            <td>{{number_format($value->khautru_KPCD,0,',',',')}}</td>
                                            <td>{{number_format($value->tong_khau_tru,0,',',',')}}</td>
                                            <td>{{number_format($value->thue_TNCN,0,',',',')}}</td>
                                            <td>{{number_format($value->tru_tamung,0,',',',')}}</td>
                                            <td>{{number_format($value->chiphiphatsinhkhac,0,',',',')}}</td>
                                            <td>{{number_format($value->thuclinh,0,',',',')}}</td>
                                            <td>{{$value->so_taikhoan_canhan}}</td>
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