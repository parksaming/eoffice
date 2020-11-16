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
                @if (!isset($error))
                    <div style="height: 550px;overflow: auto;">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll">
                            <thead>
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
                            @if (sizeof($users))
                                <?php $i = '1' ?>
                                @foreach($users as $user)
                                    <tr class="even pointer">
                                        @if(strlen($user->macanbo) == '' )
                                            <td>{{ $i++}}</td>
                                            <td style="color: red ; text-align: left;white-space: nowrap;">  {{ $user->macanbo }}</td>
                                            <td style="color: red ;text-align: left;white-space: nowrap;">{{$user->fullname}}</td>
                                            <td style="color: red ;text-align: left;">{{$user->hs_luong_ngach_bac}}</td>
                                            <td style="color: red ;text-align: left;">{{$user->luong_ngach_bac}}</td>
                                            <td style="color: red">{{$user->hs_phucap_chucvu}}</td>
                                            <td style="color: red">{{$user->phucap_chucvu}}</td>
                                            <td style="color: red">{{$user->tyle_phucap_thamnien_vuotkhung}}</td>
                                            <td style="color: red">{{$user->phucap_thamnien_vuotkhung}}</td>
                                            <td style="color: red">{{$user->tyle_phucap_thamnien_nghe}}</td>
                                            <td style="color: red">{{$user->phucap_thamnien_nghe}}</td>
                                            <td style="color: red">{{$user->tyle_phucap_uudai_nghe}}</td>
                                            <td style="color: red">{{$user->phucap_uudai_nghe}}</td>
                                            <td style="color: red">{{$user->hs_phucap_khac}}</td>
                                            <td style="color: red">{{$user->phucap_khac}}</td>
                                            <td style="color: red">{{$user->hs_phucap_congtac_dang}}</td>
                                            <td style="color: red">{{$user->phucap_congtac_dang}}</td>
                                            <td style="color: red">{{$user->hs_luong_tang_them}}</td>
                                            <td style="color: red">{{$user->luong_tang_them}}</td>
{{--                                            <td style="color: red">{{$user->hs_quan_li_phi}}</td>--}}
{{--                                            <td style="color: red">{{$user->quan_li_phi}}</td>--}}
                                            <td style="color: red">{{$user->tong_thu_nhap}}</td>
                                            <td style="color: red">{{$user->khautru_BHXH}}</td>
                                            <td style="color: red">{{$user->khautru_BHTN}}</td>
                                            <td style="color: red">{{$user->khautru_BHYT}}</td>
                                            <td style="color: red">{{$user->khautru_KPCD}}</td>
                                            <td style="color: red">{{$user->tong_khau_tru}}</td>
                                            <td style="color: red">{{$user->thue_TNCN}}</td>
                                            <td style="color: red">{{$user->tru_tamung}}</td>
                                            <td style="color: red">{{$user->chiphiphatsinhkhac}}</td>
                                            <td style="color: red">{{$user->thuclinh}}</td>
                                            <td style="color: red">{{$user->so_taikhoan_canhan}}</td>
                                        @else
                                            <td>{{$i++}}</td>
                                            <td style="text-align: left;white-space: nowrap;">  {{$user->macanbo}}</td>
                                            <td style="text-align: left;white-space: nowrap;">{{$user->fullname}}</td>
                                            <td style="text-align: left;">{{$user->hs_luong_ngach_bac}}</td>
                                            <td style="text-align: left;">{{$user->luong_ngach_bac}}</td>
                                            <td>{{$user->hs_phucap_chucvu}}</td>
                                            <td>{{$user->phucap_chucvu}}</td>
                                            <td>{{$user->tyle_phucap_thamnien_vuotkhung}}</td>
                                            <td>{{$user->phucap_thamnien_vuotkhung}}</td>
                                            <td>{{$user->tyle_phucap_thamnien_nghe}}</td>
                                            <td>{{$user->phucap_thamnien_nghe}}</td>
                                            <td>{{$user->tyle_phucap_uudai_nghe}}</td>
                                            <td>{{$user->phucap_uudai_nghe}}</td>
                                            <td>{{$user->hs_phucap_khac}}</td>
                                            <td>{{$user->phucap_khac}}</td>
                                            <td>{{$user->hs_phucap_congtac_dang}}</td>
                                            <td>{{$user->phucap_congtac_dang}}</td>
                                            <td>{{$user->hs_luong_tang_them}}</td>
                                            <td>{{$user->luong_tang_them}}</td>
{{--                                            <td>{{$user->hs_quan_li_phi}}</td>--}}
{{--                                            <td>{{$user->quan_li_phi}}</td>--}}
                                            <td>{{$user->tong_thu_nhap}}</td>
                                            <td>{{$user->khautru_BHXH}}</td>
                                            <td>{{$user->khautru_BHTN}}</td>
                                            <td>{{$user->khautru_BHYT}}</td>
                                            <td>{{$user->khautru_KPCD}}</td>
                                            <td>{{$user->tong_khau_tru}}</td>
                                            <td>{{$user->thue_TNCN}}</td>
                                            <td>{{$user->tru_tamung}}</td>
                                            <td>{{$user->chiphiphatsinhkhac}}</td>
                                            <td>{{$user->thuclinh}}</td>
                                            <td>{{$user->so_taikhoan_canhan}}</td>
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
                                                   data-hs_luong_ngach_bac="{{ $user->hs_luong_ngach_bac }}"
                                                   data-luong_ngach_bac="{{ $user->luong_ngach_bac }}"
                                                   data-hs_phucap_chucvu="{{ $user->hs_phucap_chucvu }}"
                                                   data-phucap_chucvu="{{ $user->phucap_chucvu }}"
                                                   data-tyle_phucap_thamnien_vuotkhung="{{ $user->tyle_phucap_thamnien_vuotkhung }}"
                                                   data-phucap_thamnien_vuotkhung="{{ $user->phucap_thamnien_vuotkhung }}"
                                                   data-tyle_phucap_thamnien_nghe="{{ $user->tyle_phucap_thamnien_nghe }}"
                                                   data-phucap_thamnien_nghe="{{ $user->phucap_thamnien_nghe }}"
                                                   data-tyle_phucap_uudai_nghe="{{ $user->tyle_phucap_uudai_nghe }}"
                                                   data-phucap_uudai_nghe="{{ $user->phucap_uudai_nghe }}"
                                                   data-hs_phucap_khac="{{ $user->hs_phucap_khac }}"
                                                   data-phucap_khac="{{ $user->phucap_khac }}"
                                                   data-hs_phucap_congtac_dang="{{ $user->hs_phucap_congtac_dang }}"
                                                   data-phucap_congtac_dang="{{ $user->phucap_congtac_dang }}"
                                                   data-hs_luong_tang_them="{{ $user->hs_luong_tang_them }}"
                                                   data-luong_tang_them="{{ $user->luong_tang_them }}"
{{--                                                   data-hs_quan_li_phi="{{ $user->hs_quan_li_phi }}"--}}
{{--                                                   data-quan_li_phi="{{ $user->quan_li_phi }}"--}}
                                                   data-tong_thu_nhap="{{ $user->tong_thu_nhap }}"
                                                   data-khautru_bhxh="{{ $user->khautru_BHXH }}"
                                                   data-khautru_bhtn="{{ $user->khautru_BHTN }}"
                                                   data-khautru_bhyt="{{ $user->khautru_BHYT }}"
                                                   data-khautru_kpcd="{{ $user->khautru_KPCD }}"
                                                   data-tong_khau_tru="{{ $user->tong_khau_tru }}"
                                                   data-thue_tncn="{{ $user->thue_TNCN }}"
                                                   data-tru_tamung="{{ $user->tru_tamung }}"
                                                   data-chiphiphatsinhkhac="{{ $user->chiphiphatsinhkhac }}"
                                                   data-thuclinh="{{ $user->thuclinh }}"
                                                   data-so_taikhoan_canhan="{{ $user->so_taikhoan_canhan }}"
                                                   
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
            var url = "{{url('process_import_luong_phu_cap')}}";
            var token = '{{ csrf_token() }}';
            $.post(url, {
                index: index,
                total: total,
                date:itemUser.data('date'),
                macanbo: itemUser.data('macanbo'),
                fullname: itemUser.data('fullname'),
                hs_luong_ngach_bac: itemUser.data('hs_luong_ngach_bac'),
                luong_ngach_bac: itemUser.data('luong_ngach_bac'),
                hs_phucap_chucvu: itemUser.data('hs_phucap_chucvu'),
                phucap_chucvu: itemUser.data('phucap_chucvu'),
                tyle_phucap_thamnien_vuotkhung: itemUser.data('tyle_phucap_thamnien_vuotkhung'),
                phucap_thamnien_vuotkhung: itemUser.data('phucap_thamnien_vuotkhung'),
                tyle_phucap_thamnien_nghe: itemUser.data('tyle_phucap_thamnien_nghe'),
                phucap_thamnien_nghe: itemUser.data('phucap_thamnien_nghe'),
                tyle_phucap_uudai_nghe: itemUser.data('tyle_phucap_uudai_nghe'),
                phucap_uudai_nghe: itemUser.data('phucap_uudai_nghe'),
                hs_phucap_khac: itemUser.data('hs_phucap_khac'),
                phucap_khac: itemUser.data('phucap_khac'),
                hs_phucap_congtac_dang: itemUser.data('hs_phucap_congtac_dang'),
                phucap_congtac_dang: itemUser.data('phucap_congtac_dang'),
                hs_luong_tang_them: itemUser.data('hs_luong_tang_them'),
                luong_tang_them: itemUser.data('luong_tang_them'),
                // hs_quan_li_phi: itemUser.data('hs_quan_li_phi'),
                // quan_li_phi: itemUser.data('quan_li_phi'),
                tong_thu_nhap: itemUser.data('tong_thu_nhap'),
                khautru_bhxh: itemUser.data('khautru_bhxh'),
                khautru_bhtn: itemUser.data('khautru_bhtn'),
                khautru_bhyt: itemUser.data('khautru_bhyt'),
                khautru_kpcd: itemUser.data('khautru_kpcd'),
                tong_khau_tru: itemUser.data('tong_khau_tru'),
                thue_tncn: itemUser.data('thue_tncn'),
                tru_tamung: itemUser.data('tru_tamung'),
                chiphiphatsinhkhac: itemUser.data('chiphiphatsinhkhac'),
                thuclinh: itemUser.data('thuclinh'),
                so_taikhoan_canhan: itemUser.data('so_taikhoan_canhan'),
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