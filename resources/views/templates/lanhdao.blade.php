<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hệ thống điều hành tác nghiệp - ĐHĐN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.css') }}" type="text/css"/>
    <link href="{{asset('css/backend/nprogress.css')}}" rel="stylesheet">
    <link href="{{asset('css/backend/chosen.css')}}" rel="stylesheet">
    <link href="{{asset('css/alert.css')}}" rel="stylesheet">

    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">


    <link href="http://summernote.org/bower_components/summernote/dist/summernote.css">
    <link href="http://summernote.org/bower_components/jquery/dist/jquery.js">
    <link href="http://summernote.org/bower_components/summernote/dist/summernote.js">
    <link href="http://summernote.org/bower_components/summernote/lang/summernote-ko-KR.js">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/default.css')}}?v=1"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/component.css')}}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}?v=2">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-tagsinput.css')}}">

    <script src="{{asset('js/jquery.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
    <script src="{{asset('js/alert.js')}}"></script>
    <script src="{{asset('js/formValidation.min.js')}}"></script>
    <script src="{{asset('js/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate/bootstrapValidator.min.js')}}"></script>
    <script src="{{asset('js/jquery.form.min.js')}}"></script>
    <script src="{{asset('js/jquery.bootpag.min.js')}}"></script>
    <script src="{{asset('js/backend/custom.js')}}"></script>
    <script src="{{asset('js/backend/chosen.jquery.js')}}"></script>
    <script src="{{asset('js/backend/custom.min.js')}}"></script>
    <script src="{{asset('js/jquery.dlmenu.js')}}"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>

    <script src="{{asset('js/jquery.bootpag.min.js')}}"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('js/modernizr.custom.js')}}"></script>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/bootstrap-tagsinput.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="{{asset('js/custom.js')}}" type="text/javascript" charset="utf-8"></script>

    <link rel="stylesheet" type="text/css" href="{{asset('js/treeview/dx.common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('js/treeview/dx.light.css')}}"/>
    <script src="{{asset('js/treeview/dx.all.js')}}"></script>

    <link href="{{asset('js/datetimepicker/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <script src="{{asset('js/datetimepicker/moment-with-locales.js')}}"></script>
    <script src="{{asset('js/datetimepicker/bootstrap-datetimepicker.js')}}"></script>
    <script src="{{asset('js/dragscroll.js')}}"></script>
    <style>
        .notifi {
            display: inline-block;
            width: 20px;
            height: 12px;
            position: relative;
        }
        .notifi > div {
            background-color: red;
            border-radius: 50%;
            height: 5px;
            width: 5px;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
<?php $user = \Illuminate\Support\Facades\Session::get('user');
use App\Models\CheckUser;
use App\Models\VanbanUser;
use App\Models\VanbanXuLy;
?>
@include('templates.header')

@include('templates.menu')

<div class="clearfix"></div>
<?php
$combobox = array(
    '1' => 'Bình Thường',
    '2' => 'Khẩn',
    '3' => 'Thượng Khẩn',
    '4' => 'Hỏa Tốc'
);
$countcombo = count($combobox);
$curUrl = Request::path();
$user = (object)$user;
$userRoles = App\Models\User::$roles;
//$donviuser = App\Models\Donvi::find($user->donvi_id);
?>
<div class="container-fluid" style="padding: 0">
    <div class="col-sm-2 col-md-2 pd-l">
        <div class="bg-light border-right " id="sidebar-wrapper">
            <div class="sidebar-heading">
                <a href="javascript:;" class="bg-home list-group-item list-group-item-action" style="color: white;">
                    <div id="sidebar_icon">
                        <i class="fa fa-life-ring icon-root"></i>
                    </div>
                    <div id="postt">
                        <b style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;"> Tra cứu Lương - Thuế</b>
                    </div>
                </a>
            </div>
            <div class="list-group list-group-flush">
                <ul id="menu-hlavni-menu" class="" style="list-style-type: none;padding: 0;">

                    @if (isset($user->qlluong) && $user->qlluong === 1)               
                    <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-has-children">
                        <a class="list-group-item list-group-item-action bg-light {{ $curUrl == 'quan-ly-luong-thue'? 'active' : '' }}"
                           title="Quản lý nhập lương - thuế" href="{{ route('import_luong') }}">
                           <div id="sidebar_icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div id="postt">Quản lý nhập lương - thuế</div>
                        </a>
                    </li>
                    @endif
                    <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-has-children">
                        <a class="list-group-item list-group-item-action bg-light {{ $curUrl == 'xem-luong-thue'? 'active' : '' }}"
                           title="Xem lương - thuế cá nhân" href="{{ route('xem_luong_thue') }}">
                           <div id="sidebar_icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div id="postt">Xem lương - thuế cá nhân</div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Hướng dẫn sử dụng -->
            <div class="sidebar-heading" style="display: none;">
                <a href="javascript:;" class="bg-home list-group-item list-group-item-action" style="color: white;">
                    <div id="sidebar_icon">
                        <i class="fa fa-life-ring icon-root"></i>
                    </div>
                    <div id="postt">
                        <b style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;"> HDSD</b>
                    </div>
                </a>
            </div>
            <div class="list-group list-group-flush" style="display: none;">
                <ul id="menu-hlavni-menu" class="" style="list-style-type: none;padding: 0;">
                    <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-has-children">
                        <a class="list-group-item list-group-item-action bg-light" title="Hướng dẫn sử dụng"
                           target="_blank" href="https://drive.google.com/file/d/14Aoy4w7lE89OIKpWLXGVaqN4GALWkQEV/view">
                            <div id="sidebar_icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <div id="postt">Hướng dẫn sử dụng</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-sm-10 col-md-10" style=" margin-bottom: 20px">
        @include('flash::message')
        @yield('main')
    </div>
</div>
@include('partials._loading')
@include('templates.footer')
</body>
<script>
    $(function () {
        $('#dl-menu').dlmenu();
    });

    {{--function getNoVanBanDenNew() {--}}
    {{--    $.get("{{ route('getvanbandennew') }}", (res) => {--}}
    {{--        if (!res.error) {--}}
    {{--            if (res.number) {--}}
    {{--                $('.no-vbden-new').text(res.number).removeClass('hidden')--}}
    {{--                $('.no-vbden-new').closest('.parent-notifi').find('.notifi').removeClass('hidden')--}}
    {{--            } else {--}}
    {{--                $('.no-vbden-new').text(res.number).addClass('hidden')--}}
    {{--                $('.no-vbden-new').closest('.parent-notifi').find('.notifi').addClass('hidden')--}}
    {{--            }--}}
    {{--        }--}}
    {{--    }, 'json')--}}
    {{--}--}}

    {{--function getNoVanBanDenNewDonvi() {--}}
    {{--    $.get("{{ route('getvanbandennew_donvi') }}", (res) => {--}}
    {{--        if (!res.error) {--}}
    {{--            if (res.number) {--}}
    {{--                $('.no-vbden-new_donvi').text(res.number).removeClass('hidden')--}}
    {{--                $('.no-vbden-new_donvi').closest('.parent-notifi').find('.notifi').removeClass('hidden')--}}
    {{--            } else {--}}
    {{--                $('.no-vbden-new_donvi').text(res.number).addClass('hidden')--}}
    {{--                $('.no-vbden-new_donvi').closest('.parent-notifi').find('.notifi').addClass('hidden')--}}
    {{--            }--}}
    {{--        }--}}
    {{--    }, 'json')--}}
    {{--}--}}

    function getNoVanBanNoiBoNew() {
        $.get("{{ route('getvanbannoibonew') }}", (res) => {
            if (!res.error) {
                if (res.number) {
                    $('.no-vbnoibo-new').text(res.number).removeClass('hidden')
                    $('.no-vbnoibo-new').closest('.parent-notifi').find('.notifi').removeClass('hidden')
                } else {
                    $('.no-vbnoibo-new').text(res.number).addClass('hidden')
                    $('.no-vbnoibo-new').closest('.parent-notifi').find('.notifi').addClass('hidden')
                }
            }
        }, 'json')
    }

    $(document).ready(function () {
        $('.menu-item > a').click(function (e) {
            $(this).next('.sub-menu').slideToggle();
        });

        getNoVanBanDenNew();
        getNoVanBanDenNewDonvi();
        getNoVanBanNoiBoNew();
        setInterval(getNoVanBanDenNew, 5000);
        setInterval(getNoVanBanDenNewDonvi, 5000);
        setInterval(getNoVanBanNoiBoNew, 5000);
    });

    function logout() {
        jConfirm('Bạn có muốn đăng xuất?', 'Thông báo', function (r) {
            if (r) {
                loading_show();
                window.location.href = '{{ url("logout") }}';
            }
        });
    }

    //selected menu
    $(function () {
        var url = window.location.href;

        $("#myNavbar a").each(function () {
            if (url == (this.href)) {
                $(this).closest("li").addClass("active");
            }
        });
    });
    $(function () {
        var url = window.location.href;

        $("#dl-menu a").each(function () {
            if (url == (this.href)) {
                $(this).closest("li").addClass("active");
            }
        });
    });

    $(document).on('click', '.check-all', function () {
        $group = $(this).closest('.checkbox-group');

        if ($(this).is(':checked')) {
            $group.find('.checkbox-c input:enabled').prop('checked', true);
        } else {
            $group.find('.checkbox-c input:enabled').prop('checked', false);
        }
    });

    $(document).ready(function () {

        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });

        $(document).ready(function () {
            $("#create").click(function () {
                $(".form-content").toggle("");
            });
        });

        $('#close-btn').click(function () {
            $('.form-content').hide();
        });

        $('#close').click(function () {
            $('.form-content').hide();
        });


        $('#ngaybd,#ngaykt,#ngaybatdau,#ngayketthuc,#datepicker,.datepicker,#startngayden,#ngayky,#hanxuly,#InputCVDate').datepicker({
            dateFormat: 'dd-mm-yy'
        });

        $('.btn_search_work').click(function (event) {
            if ($('.box_search_work_user form').hasClass('hover_form_search')) {
                $('.box_search_work_user form').removeClass('hover_form_search');
            } else {
                $('.box_search_work_user form').addClass('hover_form_search');
            }
        });

        $(window).click(function (event) {
// console.log(event);
            if (event.target.className == 'container' || event.target.className == ' js no-touch cssanimations csstransitions') {
                $('.box_search_work_user form').removeClass('hover_form_search');
            }
        });

    });
    $(".chosen-select").chosen();
    $.validator.setDefaults({ignore: ":hidden:not(select)"});
    $('#donvi_cauhinh,#donvisoan').change(function () {
        var donvi = $(this).val();
        var url = "{{route('ajax.user')}}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {id_donvi: donvi, _token: CSRF_TOKEN}, function (data) {
            $('#signer').html(data);
            $('#signer').trigger("chosen:updated");
        })
    });
    $('#deployment-unit').change(function () {
        var donvi = $(this).val();
        var url = "{{route('ajax.user')}}";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {'id_donvi': donvi, '_token': CSRF_TOKEN}, function (data) {
            $('#implementer').html(data);
            $('#implementer').trigger("chosen:updated");
        })
    });

    var root = '{{asset('/')}}';

    $(function () {
        $("#startngayden,#endngayden,#startvanban,#endvanban,#starthanxuly,#endhanxuly,#ngaybh_tu,#ngaybh_den,#ngaygui_tu,#ngaygui_den,#ngaydi").datepicker(
            {
                dateFormat: 'dd-mm-yy',
            }
        );
    });
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

        $('keySearch').change(function () {
            $('#form-search').submit();
        });

</script>

</html>