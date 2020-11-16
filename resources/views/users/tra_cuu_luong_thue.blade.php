@extends('templates.lanhdao')
@section('main')
    <div class="container-fuild pdt20">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="title-text">Xem lương - thuế cá nhân</h3>
            </div>
        </div>
        <div class="row mt-22">
            <div class="col-md-12">
                <form id="FilterForm" method="GET" action="{{ route('xem_luong_thue') }}">
                    <div class="form-row">
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p style="padding-top:7px"><b>Tháng</b></p>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" name="date" class="form-control input-date" id="date"
                                                   value="{{ $date1 }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="row">
{{--                                        <div class="col-md-2">--}}
{{--                                            <p style="padding-top:7px"><b>Loại</b></p>--}}
{{--                                        </div>--}}
                                        <div class="col-md-10" style="margin-top: -20px;">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="check1" name="check" value="luongphucap" {{ $check == 'luongphucap'? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check1" >Danh sách lương và phụ cấp</label><br>

                                                <input type="radio" class="custom-control-input" id="check2" name="check" value="tonghopthunhap" {{ $check == 'tonghopthunhap'? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check2" >Danh sách tổng hợp thu nhập thuế</label><br>

                                                <input type="radio" class="custom-control-input" id="check3" name="check" value="tonghopthunhapkhac" {{ $check == 'tonghopthunhapkhac'? 'checked' : '' }}>
                                                <label class="custom-control-label" for="check3" >Danh sách thu nhập khác</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary" id="search">Tra cứu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="tablescroll tb-parent">
            <div class="tablescroll-static tb-first">
                <table class="table table-bordered table-striped tablescroll-vertical-line-right">
                    <thead class="head-table">
                    <tr>
                        <th rowspan="2" class="w-nowrap h-head">Mã cán bộ</th>
                        <th rowspan="2" class="w-nowrap h-head">Họ và tên</th>

                    </tr>

                    </thead>
                    <tbody>
                    <?php if(isset($users) && sizeof($users) > 0) :?>
                    <tr class="w-nowrap">
                        <td class="text-center">{{$users->macanbo}}</td>
                        <td>{{$users->fullname}}</td>
                    </tr>
                    <?php else:?>
                    <tr class="w-nowrap">
                        <td colspan="2" class="h34"></td>
                    </tr>
                    <?php endif?>
                    </tbody>
                </table>
            </div>
            <?php if($check == 'tonghopthunhap'):?>
            <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end">
                <table class="table table-bordered table-striped txt-center">
                    <thead class="head-table">

                    <tr>
                        <th class="text-center" colspan="13">Các khoản tính thuế</th>
                        <th class="text-center" colspan="3">Các khoản không tính thuế</th>
                        <th class="text-center" colspan="7">Các khoản giảm trừ</th>
                        <th rowspan="2" class="w-nowrap">Tổng thu nhập tính thuế</th>
                        <th class="text-center" rowspan="2" class="w-nowrap">Thuế TNCN</th>

                    </tr>
                    <tr>
                        <th class="w-nowrap">Lương ngạch bậc</th>
                        <th class="w-nowrap">Phụ cấp chức vụ</th>
                        <th class="w-nowrap">Quản lý phí</th>
                        <th class="w-nowrap">Phụ cấp Công tác Đảng</th>
                        <th class="w-nowrap">Lương tăng thêm</th>
                        <th class="w-nowrap">Phụ cấp thâm niên vượt khung</th>
                        <th class="w-nowrap">Phụ cấp khác</th>
                        <th class="w-nowrap">Tiền giảng</th>
                        <th class="w-nowrap">Tiền công NCKH</th>
                        <th class="w-nowrap">Phúc lợi</th>
                        <th class="w-nowrap">Lương tháng 13</th>
                        <th class="w-nowrap">Thu nhập khác</th>
                        <th class="w-nowrap">Tổng</th>
                        <th class="w-nowrap">Phụ cấp thâm niên nghề</th>
                        <th class="w-nowrap">Phụ cấp ưu đãi nghề</th>
                        <th class="w-nowrap">Tổng</th>
                        <th class="w-nowrap">Bảo hiểm thât nghiệp trừ vào lương</th>
                        <th class="w-nowrap">Bảo hiểm xã hội trừ vào lương</th>
                        <th class="w-nowrap">Bảo hiểm y tế trừ vào lương</th>
                        <th class="w-nowrap">Kinh phí công đoàn trừ vào lương</th>
                        <th class="w-nowrap">Giảm trừ bản thân</th>
                        <th class="w-nowrap">Tổng tiền giảm trừ người phụ thuộc</th>
                        <th class="w-nowrap">Tổng</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($users) && sizeof($users) > 0) :?>
                    <tr class="w-nowrap">
                        <td>{{number_format($users->luong_ngach_bac,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_chucvu,0,',',',')}}</td>
                        <td>{{number_format($users->quan_ly_phi,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_congtac_dang,0,',',',')}}</td>
                        <td>{{number_format($users->luong_tang_them,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_thamnien_vuotkhung,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_khac,0,',',',')}}</td>
                        <td>{{number_format($users->tien_giang,0,',',',')}}</td>
                        <td>{{number_format($users->tiencong_nckh,0,',',',')}}</td>
                        <td>{{number_format($users->phuc_loi,0,',',',')}}</td>
                        <td>{{number_format($users->luongthang_muoi_ba,0,',',',')}}</td>
                        <td>{{number_format($users->thunhap_khac,0,',',',')}}</td>
                        <td>{{number_format($users->tong_cackhoan_tinhthue,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_thamnien_nghe,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_uudai_nghe,0,',',',')}}</td>
                        <td>{{number_format($users->tongcackhoan_khongtinhthue,0,',',',')}}</td>
                        <td>{{number_format($users->baohiem_thatnghiep_truvaoluong,0,',',',')}}</td>
                        <td>{{number_format($users->baohiem_xahoi_truvaoluong,0,',',',')}}</td>
                        <td>{{number_format($users->baohiem_yte_truvaoluong,0,',',',')}}</td>
                        <td>{{number_format($users->kinhphi_congdoan_truvaoluong,0,',',',')}}</td>
                        <td>{{number_format($users->giamtru_banthan,0,',',',')}}</td>
                        <td>{{number_format($users->tongtien_giamtru_nguoiphuthuoc,0,',',',')}}</td>
                        <td>{{number_format($users->tong_cackhoan_giamtru,0,',',',')}}</td>
                        <td>{{number_format($users->tong_thunhap_tinhthue,0,',',',')}}</td>
                        <td>{{number_format($users->thue_TNCN,0,',',',')}}</td>

                    </tr>
                    <?php else:?>
                    <tr class="w-nowrap">
                        <td colspan="22">Không có dữ liệu</td>
                    </tr>
                    <?php endif?>
                    </tbody>
                </table>
            </div>
            <?php elseif ($check == 'luongphucap'):?>
            <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end">
                <table class="table table-bordered table-striped txt-center">
                    <thead class="head-table">

                    <tr>
                        <th class="w-nowrap text-center" colspan="2">Lương ngạch bậc</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp chức vụ</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp thâm niên vượt khung</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp thâm niên nghề</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp ưu đãi nghề</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp khác</th>
                        <th class="w-nowrap text-center" colspan="2">Phụ cấp Công tác Đảng</th>
                        <th class="w-nowrap text-center" colspan="2">Lương tăng thêm</th>
{{--                        <th class="w-nowrap text-center" colspan="2">Quản lý phí</th>--}}
                        <th rowspan="2" class="w-nowrap text-center">Tổng thu nhập</th>
                        <th class="w-nowrap text-center" colspan="5">Khấu trừ</th>


                        <th rowspan="2" class="w-nowrap">Thuế TNCN</th>
                        <th rowspan="2" class="w-nowrap">Trừ tạm ứng, nợ thuế</th>
                        <th rowspan="2" class="w-nowrap">Trừ các tài khoản khác</th>
                        <th rowspan="2" class="w-nowrap">Thực lĩnh</th>
                        <th rowspan="2" class="w-nowrap">Số TK cá nhân</th>

                    </tr>
                    <tr>
                        <th class="w-nowrap">Hệ số</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Hệ số</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Hệ số</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Tỷ lệ</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Tỷ lệ</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Tỷ lệ</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Hệ số</th>
                        <th class="w-nowrap">Số tiền</th>
                        <th class="w-nowrap">Hệ số</th>
                        <th class="w-nowrap">Số tiền</th>
{{--                        <th class="w-nowrap">Hệ số</th>--}}
{{--                        <th class="w-nowrap">Số tiền</th>--}}

                        <th class="w-nowrap">BHXH</th>
                        <th class="w-nowrap">BHTN</th>
                        <th class="w-nowrap">BHYT</th>
                        <th class="w-nowrap">KPCĐ</th>
                        <th class="w-nowrap">Tổng</th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($users) && sizeof($users) > 0) :?>
                    <tr class="w-nowrap">
                        <td>{{$users->hs_luong_ngach_bac}}</td>
                        <td>{{number_format($users->luong_ngach_bac,0,',',',')}}</td>
                        <td>{{$users->hs_phucap_chucvu}}</td>
                        <td>{{number_format($users->phucap_chucvu,0,',',',')}}</td>
                        <td>{{number_format($users->tyle_phucap_thamnien_vuotkhung,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_thamnien_vuotkhung,0,',',',')}}</td>
                        <td>{{number_format($users->tyle_phucap_thamnien_nghe,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_thamnien_nghe,0,',',',')}}</td>
                        <td>{{number_format($users->tyle_phucap_uudai_nghe,0,',',',')}}</td>
                        <td>{{number_format($users->phucap_uudai_nghe,0,',',',')}}</td>
                        <td>{{$users->hs_phucap_khac}}</td>
                        <td>{{number_format($users->phucap_khac,0,',',',')}}</td>
                        <td>{{$users->hs_phucap_congtac_dang}}</td>
                        <td>{{number_format($users->phucap_congtac_dang,0,',',',')}}</td>
                        <td>{{$users->hs_luong_tang_them}}</td>
                        <td>{{number_format($users->luong_tang_them,0,',',',')}}</td>
{{--                        <td>{{$users->hs_quan_li_phi}}</td>--}}
{{--                        <td>{{number_format($users->quan_li_phi,0,',',',')}}</td>--}}
                        <td>{{number_format($users->tong_thu_nhap,0,',',',')}}</td>
                        <td>{{number_format($users->khautru_BHXH,0,',',',')}}</td>
                        <td>{{number_format($users->khautru_BHTN,0,',',',')}}</td>
                        <td>{{number_format($users->khautru_BHYT,0,',',',')}}</td>
                        <td>{{number_format($users->khautru_KPCD,0,',',',')}}</td>
                        <td>{{number_format($users->tong_khau_tru,0,',',',')}}</td>
                        <td>{{number_format($users->thue_TNCN,0,',',',')}}</td>
                        <td>{{number_format($users->tru_tamung,0,',',',')}}</td>
                        <td>{{number_format($users->chiphiphatsinhkhac,0,',',',')}}</td>
                        <td>{{number_format($users->thuclinh,0,',',',')}}</td>
                        <td>{{$users->so_taikhoan_canhan}}</td>
                    </tr>
                    <?php else:?>
                    <tr class="w-nowrap">
                        <td colspan="22">Không có dữ liệu</td>
                    </tr>
                    <?php endif?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="tablescroll-scroll dragscroll dragscroll-tb tb-end">
                <table class="table table-bordered table-striped txt-center">
                    <thead class="head-table">
                    <tr>
                        <th class="w-nowrap text-center" colspan="2">Tiền giảng</th>
                        <th class="w-nowrap text-center" colspan="2">Quản lí phí</th>
                        <th class="w-nowrap text-center" colspan="2">Lương tăng thêm</th>
                        <th class="w-nowrap text-center" colspan="2">Khoán điện thoại</th>
                        <th rowspan="2" class="w-nowrap">Thu nhập khác</th>
                        <th rowspan="2" class="w-nowrap">Trừ tạm ứng, thuế TNCN</th>
                        <th rowspan="2" class="w-nowrap">Thực nhận</th>

                    </tr>
                    <tr>
                        <th class="w-nowrap">Số tiết</th>
                        <th class="w-nowrap">Số tiền</th>

                        <th class="w-nowrap">Tổng hệ số</th>
                        <th class="w-nowrap">Số tiền</th>

                        <th class="w-nowrap">Tổng hệ số</th>
                        <th class="w-nowrap">Số tiền</th>

                        <th class="w-nowrap">Số tháng</th>
                        <th class="w-nowrap">Số tiền</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($users) && sizeof($users) > 0) :?>
                    <tr class="w-nowrap">
                        <td>{{$users->sotiet_tien_giang}}</td>
                        <td>{{number_format($users->tien_giang,0,',',',')}}</td>
                        <td>{{$users->hs_quan_ly_phi}}</td>
                        <td>{{number_format($users->quan_ly_phi,0,',',',')}}</td>
                        <td>{{$users->hs_luong_tang_them}}</td>
                        <td>{{number_format($users->luong_tang_them,0,',',',')}}</td>
                        <td>{{$users->sothang_dienthoai}}</td>
                        <td>{{number_format($users->khoan_dien_thoai,0,',',',')}}</td>
                        <td>{{number_format($users->thu_nhap_khac,0,',',',')}}</td>
                        <td>{{number_format($users->trutam_ungthue_tncn,0,',',',')}}</td>
                        <td>{{number_format($users->thuc_nhan,0,',',',')}}</td>
                    </tr>
                    <?php else:?>
                    <tr class="w-nowrap">
                        <td colspan="22">Không có dữ liệu</td>
                    </tr>
                    <?php endif?>
                    </tbody>
                </table>
            </div>
        <?php endif?>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            // tháng năm
            $('.input-date').datetimepicker({
                format: 'MM/YYYY',
                useCurrent: false,
                maxDate: 'now'
            });
            $('#search').click(function () {

                if ($('input[name="date"]').val() == '') {
                    jAlert("Vui lòng chọn tháng ", "Thông báo");
                    return false;
                }
                if ($('select[name="typeLuong"]').val() == '') {
                    jAlert("Vui lòng chọn loại thuế/lương", "{!! trans('common.txt_message') !!}");
                    return false;
                }
                $('#FilterForm').submit();
            });
        });

    </script>
@endsection