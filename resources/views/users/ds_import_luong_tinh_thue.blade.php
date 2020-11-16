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
                @if (!isset($error))
                    <div style="height: 550px;overflow: auto;">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll">
                            <thead>
                            <tr class="headings" style="text-align: center">
                                <th class="column-title col-index" style="text-align: center">STT</th>
                                <th class="column-title" style="text-align: left;white-space: nowrap;">Mã cán bộ</th>
                                <th class="column-title" style="text-align: left;white-space: nowrap;">Họ và tên</th>
                                <th class="column-title" style="text-align: left">Lương ngạch bậc</th>
                                <th class="column-title" style="text-align: center">Phụ cấp chức vụ</th>
                                <th class="column-title"  style="text-align: center">Quản lý phí</th>
                                <th class="column-title"  style="text-align: center">Phụ cấp Công tác Đảng</th>
                                <th class="column-title"  style="text-align: center">Lương tăng thêm</th>
                                <th class="column-title"  style="text-align: center">PC TN vượt khung</th>
                                <th class="column-title"  style="text-align: center">Phụ cấp khác</th>
                                <th class="column-title"  style="text-align: center">Tiền giảng</th>
                                <th class="column-title"  style="text-align: center">Tiền công NCKH</th>
                                <th class="column-title"  style="text-align: center">Phúc lợi</th>
                                <th class="column-title"  style="text-align: center">Lương tháng 13</th>
                                <th class="column-title"  style="text-align: center">Thu nhập khác</th>
                                <th class="column-title"  style="text-align: center">Tổng</th>
                                <th class="column-title"  style="text-align: center">PC TN nghề</th>
                                <th class="column-title"  style="text-align: center">PC ưu đãi nghề</th>
                                <th class="column-title"  style="text-align: center">Tổng</th>
                                <th class="column-title"  style="text-align: center">Bảo hiểm thât nghiệp trừ vào lương</th>
                                <th class="column-title"  style="text-align: center">Bảo hiểm xã hội trừ vào lương</th>
                                <th class="column-title"  style="text-align: center">Bảo hiểm y tế trừ vào lương</th>
                                <th class="column-title"  style="text-align: center">Kinh phí công đoàn trừ vào lương</th>
                                <th class="column-title"  style="text-align: center">Giảm trừ bản thân</th>
                                <th class="column-title"  style="text-align: center">Tổng tiền giảm trừ người phụ thuộc</th>
                                <th class="column-title"  style="text-align: center">Tổng</th>
                                <th class="column-title"  style="text-align: center">Tổng thu nhập tính thuế</th>
                                <th class="column-title"  style="text-align: center">Thuế TNCN</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (sizeof($users))
                                <?php $i = '1' ?>
                                @foreach($users as $user)
                                    <tr class="even pointer">
                                        @if(strlen($user->macanbo) == '' )
                                            <td>{{ $i++}}</td>
                                            <td style="color: red ; text-align: left;white-space: nowrap;">  {{ $user->macanbo }}</td>
                                            <td style="color: red ;text-align: left;white-space: nowrap;">{{$user->fullname}}</td>
                                            <td style="color: red ;text-align: left;">{{$user->luong_ngach_bac}}</td>
                                            <td style="color: red ;text-align: left;">{{$user->phucap_chucvu}}</td>
                                            <td style="color: red">{{$user->quan_ly_phi}}</td>
                                            <td style="color: red">{{$user->phucap_congtac_dang}}</td>
                                            <td style="color: red">{{$user->luong_tang_them}}</td>
                                            <td style="color: red">{{$user->phucap_thamnien_vuotkhung}}</td>
                                            <td style="color: red">{{$user->phucap_khac}}</td>
                                            <td style="color: red">{{$user->tien_giang}}</td>
                                            <td style="color: red">{{$user->tiencong_nckh}}</td>
                                            <td style="color: red">{{$user->phuc_loi}}</td>
                                            <td style="color: red">{{$user->luongthang_muoi_ba}}</td>
                                            <td style="color: red">{{$user->thunhap_khac}}</td>
                                            <td style="color: red">{{$user->tong_cackhoan_tinhthue}}</td>
                                            <td style="color: red">{{$user->phucap_thamnien_nghe}}</td>
                                            <td style="color: red">{{$user->phucap_uudai_nghe}}</td>
                                            <td style="color: red">{{$user->tongcackhoan_khongtinhthue}}</td>
                                            <td style="color: red">{{$user->baohiem_thatnghiep_truvaoluong}}</td>
                                            <td style="color: red">{{$user->baohiem_xahoi_truvaoluong}}</td>
                                            <td style="color: red">{{$user->baohiem_yte_truvaoluong}}</td>
                                            <td style="color: red">{{$user->kinhphi_congdoan_truvaoluong}}</td>
                                            <td style="color: red">{{$user->giamtru_banthan}}</td>
                                            <td style="color: red">{{$user->tongtien_giamtru_nguoiphuthuoc}}</td>
                                            <td style="color: red">{{$user->tong_cackhoan_giamtru}}</td>
                                            <td style="color: red">{{$user->tong_thunhap_tinhthue}}</td>
                                            <td style="color: red">{{$user->thue_TNCN}}</td>
                                        @else
                                            <td>{{$i++}}</td>
                                            <td style="text-align: left;white-space: nowrap;">  {{$user->macanbo}}</td>
                                            <td style="text-align: left;white-space: nowrap;">{{$user->fullname}}</td>
                                            <td style="text-align: left;">{{$user->luong_ngach_bac}}</td>
                                            <td style="text-align: left;">{{$user->phucap_chucvu}}</td>
                                            <td>{{$user->quan_ly_phi}}</td>
                                            <td>{{$user->phucap_congtac_dang}}</td>
                                            <td>{{$user->luong_tang_them}}</td>
                                            <td>{{$user->phucap_thamnien_vuotkhung}}</td>
                                            <td>{{$user->phucap_khac}}</td>

                                            <td>{{$user->tien_giang}}</td>
                                            <td>{{$user->tiencong_nckh}}</td>
                                            <td>{{$user->phuc_loi}}</td>
                                            <td>{{$user->luongthang_muoi_ba}}</td>
                                            <td>{{$user->thunhap_khac}}</td>

                                            <td>{{$user->tong_cackhoan_tinhthue}}</td>
                                            <td>{{$user->phucap_thamnien_nghe}}</td>
                                            <td>{{$user->phucap_uudai_nghe}}</td>
                                            <td>{{$user->tongcackhoan_khongtinhthue}}</td>
                                            <td>{{$user->baohiem_thatnghiep_truvaoluong}}</td>
                                            <td>{{$user->baohiem_xahoi_truvaoluong}}</td>
                                            <td>{{$user->baohiem_yte_truvaoluong}}</td>
                                            <td>{{$user->kinhphi_congdoan_truvaoluong}}</td>
                                            <td>{{$user->giamtru_banthan}}</td>
                                            <td>{{$user->tongtien_giamtru_nguoiphuthuoc}}</td>
                                            <td>{{$user->tong_cackhoan_giamtru}}</td>
                                            <td>{{$user->tong_thunhap_tinhthue}}</td>
                                            <td>{{$user->thue_TNCN}}</td>
                                        @endif
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
                    <div class="search-page-form">
                        <div class="page-content">
                            @if (isset($users) && sizeof($users) > 0)                            
                                <div class="data-contaner">
                                    <?php $modelParent = $users[0];?>
                                    @foreach($users as $index => $user)
                                            <input class="user" type="hidden"  data-date="{{ $date }}" data-fullname="{{ $user->fullname }}"
                                                   data-macanbo="{{ $user->macanbo }}"
                                                   data-luong_ngach_bac="{{ $user->luong_ngach_bac }}"
                                                   data-phucap_chucvu="{{ $user->phucap_chucvu }}"
                                                   data-quan_ly_phi="{{ $user->quan_ly_phi }}"
                                                   data-phucap_congtac_dang="{{ $user->phucap_congtac_dang }}"
                                                   data-luong_tang_them="{{ $user->luong_tang_them }}"
                                                   data-phucap_thamnien_vuotkhung="{{ $user->phucap_thamnien_vuotkhung }}"
                                                   data-phucap_khac="{{ $user->phucap_khac }}"
                                                   data-tien_giang="{{ $user->tien_giang }}"
                                                   data-tiencong_nckh="{{ $user->tiencong_nckh }}"
                                                   data-phuc_loi="{{ $user->phuc_loi }}"
                                                   data-luongthang_muoi_ba="{{ $user->luongthang_muoi_ba }}"
                                                   data-thunhap_khac="{{ $user->thunhap_khac }}"
                                                   data-tong_cackhoan_tinhthue="{{ $user->tong_cackhoan_tinhthue }}"
                                                   data-phucap_thamnien_nghe="{{ $user->phucap_thamnien_nghe }}"
                                                   data-tongcackhoan_khongtinhthue="{{ $user->tongcackhoan_khongtinhthue }}"
                                                   data-baohiem_thatnghiep_truvaoluong="{{ $user->baohiem_thatnghiep_truvaoluong }}"
                                                   data-baohiem_xahoi_truvaoluong="{{ $user->baohiem_xahoi_truvaoluong }}"
                                                   data-baohiem_yte_truvaoluong="{{ $user->baohiem_yte_truvaoluong }}"
                                                   data-kinhphi_congdoan_truvaoluong="{{ $user->kinhphi_congdoan_truvaoluong }}"
                                                   data-giamtru_banthan="{{ $user->giamtru_banthan }}"
                                                   data-phucap_uudai_nghe="{{ $user->phucap_uudai_nghe }}"
                                                   data-tongtien_giamtru_nguoiphuthuoc="{{ $user->tongtien_giamtru_nguoiphuthuoc }}"
                                                   data-tong_cackhoan_giamtru="{{ $user->tong_cackhoan_giamtru }}"
                                                   data-tong_thunhap_tinhthue="{{ $user->tong_thunhap_tinhthue }}"
                                                   data-thue_tncn="{{ $user->thue_TNCN }}"
                                            />

                                    @endforeach
                                </div>
                                <div class="number-record" style="padding-bottom: 10px;">
                                    @if($countMaCanBoEmpty !=0)
                                        <p style="margin-bottom: 10px; color: red;">{{trans('common.txt_have')}} {{$countMaCanBoEmpty}} {{trans('common.txt_users_who_have_a_tag_code_of_less_than_6_characters_are_not_added')}}.</p>
                                    @endif

                                    @if($total)
                                        <p>  {{trans('common.txt_have')}} {{$total}} {{trans('common.txt_users_will_be_added')}}.</p>
                                    @endif
                                </div>

                                @if ($total)
                                    <button class="btn btn-primary btn-insert">Lưu danh sách</button>
                                @elseif(!$total)
                                    <input type="button" value="Trở về" onclick="goBack()">
                                @endif

                                <div class="bg_ptr" style="display: none;">
                                    <div class="progress-status">Đang xử lý</div>
                                    <div>Đã thêm vào <span id="offset"></span>/<span
                                                id="total"></span></div>
                                    <div class="progress-bar-container">
                                        <span class="progress-bar"></span>
                                        <div class="process">
                                            <div class="percent_">
                                                <div class="dr_" style="color: #fff; font-size: 14px;">0%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 35px; text-align: center;">
                                    <a class="btn btn-primary btn-done" href="{{ url('quan-ly-luong-thue') }}"
                                       style="display: none;">Hoàn thành</a>
                                </div>
                            @else
                                <div style="margin-bottom: 10px; color: red;">Không có dữ liệu</div>
                            @endif
                        </div>
                    </div>
                @else
                    <div style="margin-bottom: 10px; color: red;">Lỗi dữ liệu</div>
                @endif

        </div>
        <div class="clearfix"></div>
    </div>
    <script>
        $(document).ready(function () {
            $(".btn-insert").click(function () {
                $(this).prop('disabled', true);
                $(".bg_ptr").css('display', 'block');
                $(".btn-insert").hide();
                $(".number-record").hide();
                total = $('.user').length;
                process(0, total);
            });
        });

        function process(index, total) {
            itemUser = $('.user').eq(index);console.log(itemUser);
            var url = "{{url('process_import_tong_hop_thu_nhap')}}";
            var token = '{{ csrf_token() }}';
            $.post(url, {
                index: index,
                total: total,
                date:itemUser.data('date'),
                macanbo: itemUser.data('macanbo'),
                fullname: itemUser.data('fullname'),
                luong_ngach_bac: itemUser.data('luong_ngach_bac'),
                phucap_chucvu: itemUser.data('phucap_chucvu'),
                quan_ly_phi: itemUser.data('quan_ly_phi'),
                phucap_congtac_dang: itemUser.data('phucap_congtac_dang'),
                luong_tang_them: itemUser.data('luong_tang_them'),
                phucap_thamnien_vuotkhung: itemUser.data('phucap_thamnien_vuotkhung'),
                phucap_khac: itemUser.data('phucap_khac'),
                tien_giang: itemUser.data('tien_giang'),
                tiencong_nckh: itemUser.data('tiencong_nckh'),
                phuc_loi: itemUser.data('phuc_loi'),
                luongthang_muoi_ba: itemUser.data('luongthang_muoi_ba'),
                thunhap_khac: itemUser.data('thunhap_khac'),
                tong_cackhoan_tinhthue: itemUser.data('tong_cackhoan_tinhthue'),
                phucap_thamnien_nghe: itemUser.data('phucap_thamnien_nghe'),
                phucap_uudai_nghe: itemUser.data('phucap_uudai_nghe'),
                tongcackhoan_khongtinhthue: itemUser.data('tongcackhoan_khongtinhthue'),
                baohiem_thatnghiep_truvaoluong: itemUser.data('baohiem_thatnghiep_truvaoluong'),
                baohiem_xahoi_truvaoluong: itemUser.data('baohiem_xahoi_truvaoluong'),
                baohiem_yte_truvaoluong: itemUser.data('baohiem_yte_truvaoluong'),
                kinhphi_congdoan_truvaoluong: itemUser.data('kinhphi_congdoan_truvaoluong'),
                giamtru_banthan: itemUser.data('giamtru_banthan'),
                tongtien_giamtru_nguoiphuthuoc: itemUser.data('tongtien_giamtru_nguoiphuthuoc'),
                tong_cackhoan_giamtru: itemUser.data('tong_cackhoan_giamtru'),
                tong_thunhap_tinhthue: itemUser.data('tong_thunhap_tinhthue'),
                thue_tncn: itemUser.data('thue_tncn'),
                _token: token
            }, function (data) {

                nextIndex = data.next_index;
                percent = data.percent;
                total = data.total;
                console.log(data);
                if (nextIndex < total) {
                    $('.progress-bar').css('width', percent + '%');
                    $("#offset").html(nextIndex);
                    $("#total").html(total);
                    $('.dr_').html((percent) + '%.').show('fast', function () {
                        process(nextIndex, total);
                    });
                } else {
                    $('.progress-bar').css('width', '100%');
                    $('.percent_').css({width: '100%'});
                    $('.dr_').html('Hoàn thành');
                    $("#offset").html(total);
                    $("#total").html(total);
                    $(".progress-status").hide();
                    $(".btn-done").show();
                }

            }, 'json');
        }
        function goBack() {
            window.history.back()
        }
    </script>
@endsection