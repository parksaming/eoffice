@extends('templates.lanhdao')
@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-5 col-sm-5 col-xs-12">
                <h2>Bảng thanh toán phụ cấp khác {{ $date }}</h2>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="clearfix"></div>
            <div class="table-responsive" style="margin-top: 15px;">
                @if (!isset($error))
                    <div style="height: auto;overflow: auto;">
                        <table class="table table-bordered table-striped bulk_action dragscroll tb-dragscroll" style="display: inline-table;">
                            <thead>
                            <tr class="headings" style="text-align: center">
                                <th rowspan="2" class="column-title col-index" style="text-align: center">STT</th>
                                <th rowspan="2" class="column-title" style="text-align: left;white-space: nowrap;">Mã cán bộ</th>
                                <th rowspan="2" class="column-title" style="text-align: left;white-space: nowrap;">Họ và tên</th>
                                <th colspan="2" class="column-title" style="text-align: center">Tiền giảng</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Quản lí phí</th>
                                <th colspan="2" class="column-title"  style="text-align: center">Lương tăng thêm</th>
                                <th colspan="2" class="column-title" style="text-align: center">Khoán điện thoại</th>
                                <th rowspan="2" class="column-title" style="text-align: center">Thu nhập khác</th>
                                <th rowspan="2" class="column-title" style="text-align: center">Trừ tạm ứng,thuế TNCN</th>
                                <th rowspan="2" class="column-title" style="text-align: center">Thực nhận</th>
                            </tr>
                            <tr class="headings" style="text-align: center">
                                <th class="column-title" style="text-align: left">Số tiết</th>
                                <th class="column-title" style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Tổng hệ số</th>
                                <th class="column-title"  style="text-align: center">Hệ số</th>
                                <th class="column-title"  style="text-align: center">Tổng hệ số</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                                <th class="column-title"  style="text-align: center">Số tháng</th>
                                <th class="column-title"  style="text-align: center">Số tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if (sizeof($users))
                                <?php $i = '1' ?>
                                @foreach($users as $user)
                                    <tr class="even pointer">
                                        @if(strlen($user->macanbo) == '' )
{{--                                            <td>{{ $i++}}</td>--}}
{{--                                            <td style="color: red ; text-align: left;white-space: nowrap;"> {{ $user->macanbo }}</td>--}}
{{--                                            <td style="color: red ;text-align: left;white-space: nowrap;">{{$user->fullname}}</td>--}}
{{--                                            <td style="color: red ;text-align: left;">{{$user->sotiet_tien_giang}}</td>--}}
{{--                                            <td style="color: red ;text-align: left;">{{$user->tien_giang}}</td>--}}
{{--                                            <td style="color: red">{{$user->hs_quan_ly_phi}}</td>--}}
{{--                                            <td style="color: red">{{$user->quan_ly_phi}}</td>--}}
{{--                                            <td style="color: red">{{$user->hs_luong_tang_them}}</td>--}}
{{--                                            <td style="color: red">{{$user->luong_tang_them}}</td>--}}
{{--                                            <td style="color: red">{{$user->sothang_dienthoai}}</td>--}}
{{--                                            <td style="color: red">{{$user->khoan_dien_thoai}}</td>--}}
{{--                                            <td style="color: red">{{$user->thu_nhap_khac}}</td>--}}
{{--                                            <td style="color: red">{{$user->trutam_ungthue_tncn}}</td>--}}
{{--                                            <td style="color: red">{{$user->thuc_nhan}}</td>--}}
                                        @else
                                            <td>{{$i++}}</td>
                                            <td style="text-align: left;white-space: nowrap;">  {{$user->macanbo}}</td>
                                            <td style="text-align: left;white-space: nowrap;">{{$user->fullname}}</td>
                                            <td style="text-align: left;">{{$user->sotiet_tien_giang}}</td>
                                            <td style="text-align: left;">{{$user->tien_giang}}</td>
                                            <td>{{$user->hs_quan_ly_phi}}</td>
                                            <td>{{$user->quan_ly_phi}}</td>
                                            <td>{{$user->hs_luong_tang_them}}</td>
                                            <td>{{$user->luong_tang_them}}</td>
                                            <td>{{$user->sothang_dienthoai}}</td>
                                            <td>{{$user->khoan_dien_thoai}}</td>
                                            <td>{{$user->thu_nhap_khac}}</td>
                                            <td>{{$user->trutam_ungthue_tncn}}</td>
                                            <td>{{$user->thuc_nhan}}</td>
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
                                                   data-sotiet_tien_giang="{{ $user->sotiet_tien_giang }}"
                                                   data-tien_giang="{{ $user->tien_giang }}"
                                                   data-hs_quan_ly_phi="{{ $user->hs_quan_ly_phi }}"
                                                   data-quan_ly_phi="{{ $user->quan_ly_phi }}"
                                                   data-hs_luong_tang_them="{{ $user->hs_luong_tang_them }}"
                                                   data-luong_tang_them="{{ $user->luong_tang_them }}"
                                                   data-sothang_dienthoai="{{ $user->sothang_dienthoai }}"
                                                   data-khoan_dien_thoai="{{ $user->khoan_dien_thoai }}"
                                                   data-thu_nhap_khac="{{ $user->thu_nhap_khac }}"
                                                   data-trutam_ungthue_tncn="{{ $user->trutam_ungthue_tncn }}"
                                                   data-thuc_nhan="{{ $user->thuc_nhan }}"
                                            />

                                    @endforeach
                                </div>
                                <div class="number-record" style="padding-bottom: 10px;">
{{--                                    @if($countMaCanBoEmpty !=0)--}}
{{--                                        <p style="margin-bottom: 10px; color: red;">{{trans('common.txt_have')}} {{$countMaCanBoEmpty}} {{trans('common.txt_users_who_have_a_tag_code_of_less_than_6_characters_are_not_added')}}.</p>--}}
{{--                                    @endif--}}

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
            var url = "{{url('process_import_thu_nhap_khac')}}";
            var token = '{{ csrf_token() }}';
            $.post(url, {
                index: index,
                total: total,
                date:itemUser.data('date'),
                macanbo: itemUser.data('macanbo'),
                fullname: itemUser.data('fullname'),
                sotiet_tien_giang: itemUser.data('sotiet_tien_giang'),
                tien_giang: itemUser.data('tien_giang'),
                hs_quan_ly_phi: itemUser.data('hs_quan_ly_phi'),
                quan_ly_phi: itemUser.data('quan_ly_phi'),
                hs_luong_tang_them: itemUser.data('hs_luong_tang_them'),
                luong_tang_them: itemUser.data('luong_tang_them'),
                sothang_dienthoai: itemUser.data('sothang_dienthoai'),
                khoan_dien_thoai: itemUser.data('khoan_dien_thoai'),
                thu_nhap_khac: itemUser.data('thu_nhap_khac'),
                trutam_ungthue_tncn: itemUser.data('trutam_ungthue_tncn'),
                thuc_nhan: itemUser.data('thuc_nhan'),
                _token: token
            }, function (data) {
                console.log(data);

                nextIndex = data.next_index;
                //console.log(nextIndex);
                percent = data.percent;
                //console.log(percent);
                total = data.total;
                //console.log(total);
                //console.log(data);
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