<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hệ thống điều hành tác nghiệp - ĐHĐN</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="{{asset('css/backend/bootstrap-datetimepicker.css')}}" rel="stylesheet"/>
    <link href="{{asset('css/backend/nprogress.css')}}" rel="stylesheet">
    <link href="{{asset('css/backend/chosen.css')}}" rel="stylesheet">
    <link href="{{asset('css/alert.css')}}" rel="stylesheet">
    <!-- include codemirror (codemirror.css, codemirror.js, xml.js, formatting.js) -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/codemirror.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/codemirror/3.20.0/theme/monokai.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('js/datepicker/moment.min.js')}}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{asset('js/datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('js/alert.js')}}"></script>
    <script src="{{asset('js/formValidation.min.js')}}"></script>
    <script src="{{asset('js/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/validate/bootstrapValidator.min.js')}}"></script>
    <script src="{{asset('js/jquery.bootpag.min.js')}}"></script>
    <script src="{{asset('js/backend/custom.js')}}"></script>
    <script src="{{asset('js/backend/chosen.jquery.js')}}"></script>
    <!-- include summernote css/js-->

    <link href="http://summernote.org/bower_components/summernote/dist/summernote.css">
    <link href="http://summernote.org/bower_components/jquery/dist/jquery.js">
    <link href="http://summernote.org/bower_components/summernote/dist/summernote.js">
    <link href="http://summernote.org/bower_components/summernote/lang/summernote-ko-KR.js">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
    {{--<script src="{{asset('js/jquery-ui.multidatespicker.js')}}"></script>--}}
    <script src="{{asset('js/backend/custom.min.js')}}"></script>

    <script src="{{asset('js/datepicker/moment.js')}}"></script>
    <script src="{{asset('js/datepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('js/jquery.bootpag.min.js')}}"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
</head>
<body>
<?php $user=\Illuminate\Support\Facades\Session::get('user') ?>
<div class="container text-center">
    <h4><b class="hethong">HỆ THỐNG ĐIỀU HÀNH TÁC NGHIỆP - ĐHĐN</b></h4>
</div>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{--<a class="navbar-brand web"  style="color: white" href="#"><b class="hethong">HỆ THỐNG ĐIỀU HÀNH TÁC NGHIỆP - ĐHĐN</b></a>--}}
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            {{--<div class="titleweb"><b class="hethong_ipad">HỆ THỐNG ĐIỀU HÀNH TÁC NGHIỆP - ĐHĐN</b></div>--}}
            <ul class="nav navbar-nav">
                <li class=""><a class="guibaocao" href="{{url('guibaocao')}}">Gửi báo cáo hằng ngày</a></li>
                <li class=""><a class="guibaocao" href="{{url('baocao/bao_cao_da_gui')}}">Báo cáo đã gửi</a></li>
                <li class=""><a class="guibaocao" href="{{url('http://dieuhanh.udn.vn/tao-cong-viec')}}" target="_blank">Báo cáo và giao việc chi tiết</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a class="name" href="{{url('cap_nhat_thong_tin')}}" target="_blank"><b class="xinchao">Xin chào:</b> {{$user['fullname']}}</a></li>
                <li><a  class="guibaocao" href="javascript:;" onclick="logout()"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-left">
            @yield('main')
        </div>
    </div>
</div>
@include('templates.footer')
</body>
<script type="text/javascript">
    function logout() {
        jConfirm('Bạn có muốn đăng xuất?', 'Thông báo', function (r) {
            if (r) {
                loading_show();
                window.location.href = '{{ url("logout") }}';
            }
        });
    }

    //selected menu
    $(function(){
        var url = window.location.href;

        $("#myNavbar a").each(function() {
            if(url == (this.href)) {
                $(this).closest("li").addClass("active");
            }
        });
    });

</script>
</html>
