<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		{{--<link rel="shortcut icon" href="{{asset('img/favicon.ico')}}" type="image/x-icon" />--}}
        <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <script src="{{asset('js/backend/jquery.min.js')}}"></script>
        <script src="{{asset('js/alert.js')}}"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link type="text/css" rel="stylesheet" href="{{asset('css/login.css')}}">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>
        <div class="wrapper">
          <div class="login-form col-md-6 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12" >
              <div class="logo">
              </div>
              @if (Session::has('message'))
                  <div class="message-banner alert alert-{{ Session::get('alert-class') }}">
                      <span>{{ Session::get('message') }}</span>
                      <div class="close-message"><i class="fa fa-times"></i></div>
                  </div>

                  <script>
                      $(document).ready(function () {
                          if ($('.message-banner').length) {
                              setInterval(function () {
                                  $('.message-banner').remove();
                              }, 3000);
                          }
                      });
                  </script>
              @endif
              <div id="login-form-body" class="img-responsive">
                  <form id="loginForm" action="{{'login'}}" method="POST" class="login">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                          <input name="username" type="text" class="form-control" value=""id="tendangnhap" placeholder="Tên đăng nhập" >
                      </div>
                      <div class="form-group">
                          <input name="password" type="password" class="form-control" value="" placeholder="Mật khẩu" id="matkhau">
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-login form-control form-login">Đăng nhập</button>
                      </div>
                  </form>

              </div>


              <div class="login-form-footer">
              </div>
          </div>
        </div>
    <!--script validate login form-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/formValidation.min.js')}}"></script>

    <script>
        function showpass() {
            $('#Showpass').modal('show');
        }
        $(document).ready(function(){
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