
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <script src="{{asset('js/alert.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Coded with love by Mutiullah Samim */
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #00aff0 !important;
        }
        .user_card {
            height: 400px;
            width: 350px;
            margin-top: auto;
            margin-bottom: auto;
            background: #3581F5;
            position: relative;
            display: flex;
            justify-content: center;
            flex-direction: column;
            padding: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 5px;

        }
        .brand_logo_container {
            position: absolute;
            height: 170px;
            width: 170px;
            top: -75px;
            border-radius: 50%;
            background: #00aff0;
            padding: 10px;
            text-align: center;
        }
        .brand_logo {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .form_container {
            margin-top: 100px;
        }
        .login_btn {
            width: 100%;
            background: #00aff0 !important;
            color: white !important;
        }
        .login_btn:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
        .login_container {
            padding: 0 2rem;
        }
        .input-group-text {
            background: #00aff0 !important;
            color: white !important;
            border: 0 !important;
            border-radius: 0.25rem 0 0 0.25rem !important;
        }
        .input_user,
        .input_pass:focus {
            box-shadow: none !important;
            outline: 0px !important;
        }
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: #00aff0 !important;
        }
    </style>
</head>
<!--Coded with love by Mutiullah Samim-->
<body>
<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center">
                <div class="brand_logo_container">
                    <img src="{{ asset('/img/logo-truong-250.png') }}" class="brand_logo" alt="Logo">
                </div>
            </div>
            <div class="d-flex justify-content-center form_container">
                <form id="loginForm" action="{{'login'}}" method="POST" class="login">
                    @if (Session::has('message'))
                        <div class="message-banner alert alert-{{ Session::get('alert-class') }}">
                            <span>{{ Session::get('message') }}</span>
                        </div>

                        <script>
                            $(document).ready(function () {
                                if ($('.message-banner').length) {
                                    setInterval(function () {
                                        $('.message-banner').remove();
                                    }, 6000);
                                }
                            });
                        </script>
                    @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" class="form-control input_user"  oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" required value="" id="tendangnhap" placeholder="Nhập email">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="password" class="form-control input_pass" oninvalid="InvalidMsgPass(this);" oninput="InvalidMsgPass(this);" required value="" placeholder="Mật khẩu" id="matkhau">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button type="submit" name="button" class="btn login_btn">Đăng nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function InvalidMsg(textbox) {
        if (textbox.value === '') {
            textbox.setCustomValidity('Vui lòng nhập email');
        } else if (textbox.validity.typeMismatch){
            textbox.setCustomValidity('Vui lòng nhập email hợp lệ');
        } else {
            textbox.setCustomValidity('');
        }

        return true;
    }
    function InvalidMsgPass(textbox) {
        if (textbox.value === '') {
            textbox.setCustomValidity('Vui lòng nhập mật khẩu');
        }else {
            textbox.setCustomValidity('');
        }
        return true;
    }
    function showpass() {
        $('#Showpass').modal('show');
    }
    $(document).ready(function(){
        //Validate login form
        Jquery('#loginForm').formValidation({
            framework: 'bootstrap',
            message: 'This value is not valid',
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: '{{trans('Vui lòng nhập email')}}'
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
