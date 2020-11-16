<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đăng nhập hệ thống</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <script src="{{asset('js/backend/jquery.min.js')}}"></script>
    <link type="text/css" rel="stylesheet" href="{{asset('css/login2.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/alert.js')}}"></script>

</head>
<body style="display: block;">
<div id="livezilla_tracking" style="display:none"></div>
<div id="background_branding_container" class="ie_legacy overlay_img">
</div>
<div id="background_page_overlay" class="overlay ie_legacy" aria-hidden="true"
     style="visibility: visible; display: none; background-color: rgb(0, 114, 198);">
</div>
<div id="login_no_script_panel" class="login_panel" aria-hidden="true" style="display: none;">
    @if (Session::has('message'))
        <div class="message-banner alert alert-{{ Session::get('alert-class') }}">
            <span>{{ Session::get('message') }}</span>
            <div class="close-message"><i class="fa fa-times"></i></div>
        </div>
    @endif
</div>
<div id="login_panel" class="login_panel" style="display: block;">
    <table class="login_panel_layout" style="height: 100%;">
        <tbody>
        <tr class="login_panel_layout_row" style="height: 100%;">
            <td id="login_panel_left"></td>
            <td id="login_panel_center">
                <div class="login_inner_container">
                    <div class="inner_container cred" style="height: auto;">
                        <div class="login_workload_logo_container">
                            <h1 id="login_workload_logo_text" class="workload_img_text gianttext"
                                style="visibility: visible;">
                                <span class="logo">HỆ THỐNG ĐIỀU HÀNH TÁC NGHIỆP - ĐH Đà Nẵng</span>
                            </h1>
                        </div>
                        <ul class="login_cred_container">
                            <li class="login_cred_field_container">
                                <h2 class="warning title2">Hệ thống điều hành tác nghiệp</h2>
                                <div id="login_error_container" class="login_error_container">
                                    Xin chào, vui lòng chọn loại tài khoản để đăng nhập:
                                </div>
                                <div class="group_1">
                                    <ul style="float: left; margin-right: 10px;" class="ul_log">
                                        <li>
                                            <a href=" {{$url_login}} "
                                               class="dieuhanh">
                                                Microsoft Office 365
                                                <div class="text_warning" style="font-size: 12px;">
                                                    Tích hợp đầy đủ các dịch vụ của của Microsoft Office 365.<br><b>
                                                        Click vào đây để đăng nhập</b>
                                                </div>
                                            </a>

                                        </li>
                                    </ul>
                                </div>

                                <div style="clear: both; font-size: 12px; padding-top: 10px;">
                                    <div>Tài khoản Microsoft Office 365 dùng cho tất cả các hệ thống của Đại học Đà
                                        Nẵng, và còn có thể sử dụng miễn phí các tiện ích của Microsoft Office 365 như:
                                    </div>
                                    <ul class="group_list">
                                        <li>Outlook: Hộp thư điện tử</li>
                                        <li>OneDrive: Kho lưu trữ trực tuyến</li>
                                        <li>Lync: Công cụ giao tiếp tối ưu, hỗ trợ hội nghị truyền hình lên đến 250 kết
                                            nối
                                        </li>
                                        <li>Trọn bộ Microsoft Office trực tuyến: MS Word, Excel, PowerPoint, OneNote…
                                        </li>
                                        <li>Quản lý danh bạ cá nhân, lịch làm việc …</li>
                                        <li>….</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="push"></div>
                </div>

            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
<!--script validate login form-->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/formValidation.min.js')}}"></script>

<script>
    function showpass() {
        $('#Showpass').modal('show');
    }

    $(document).ready(function () {
        //Validate login form
        $('#loginForm').formValidation({
            framework: 'bootstrap',
            message: 'This value is not valid',
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: '{{trans('Vui lòng nhập tên đăng nhập')}}'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '{{trans('Vui lòng nhập mật khẩu')}}'
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>