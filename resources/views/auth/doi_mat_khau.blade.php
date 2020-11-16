@extends('templates.lanhdao')
@section('main')
    @include('flash::message')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            <div class="title-page col-md-12 col-sm-12 col-xs-12">
                <h4>Đổi mật khẩu - Username: <b><?php echo $users->fullname?></b></h4>
            </div>
        </div>
        <div class="page-content col-md-12 col-sm-12 dmk">
            {!! Form::open(['method' => 'post']) !!}
            <input type="hidden" name="id" value="{{ isset($users)? $users->id : ''}}">
            <div class="form-group col-md-6">
                <label>{{trans('Mật khẩu cũ')}} <span style="color:#a94442;">*</span></label>
                <input type="password" class="form-control" name="old_password" value="" >
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label>{{trans('Mật khẩu mới')}} <span style="color:#a94442;">*</span></label>
                <input type="password" class="form-control" name="password" value="">
            </div>
            <div class="clearfix"></div>
            <div class="form-group col-md-6">
                <label>{{trans('Xác nhận mật khẩu mới')}} <span style="color:#a94442;">*</span></label>
                <input type="password" class="form-control" name="confirm_password" value="">
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <button type="submit" class="btn btn-info">{{ isset($users)? trans('Cập nhật') : '' }}</button>
                </div>
            </div>

            <div class="clearfix"></div>
            {!! Form::close() !!}

        </div>
        <div class="clearfix"></div>
    </div>
    <script>
        $(document).ready(function () {
            $('input[name="old_password"]').focusout(function(){
                var oldpass = $(this).val();
                if(oldpass == ''){
                    jAlert('{!! trans('common.txt_please_enter_password_old') !!}','{!! trans("common.txt_message") !!}');
                    return false;
                }else {
                    checkoldpass(oldpass);
                }
            });
            function checkoldpass(oldpass){
                var url='';
                var oldpass = oldpass
                $.get(url,{oldpass:oldpass},function(data){
                    console.log(data);
                    if(data == 0){

                    }
                    else if(data == 1){
                        jAlert('{!! trans('common.txt_password_old_not_exactly') !!}','{!! trans("common.txt_message") !!}');
                        $('input[name="old_password"]').val('');
                        return false;
                    }
                })
            };
            $('form').formValidation({
                framework: 'bootstrap',
                message: 'This value is not valid',
                fields: {
                    old_password: {
                        validators: {
                            notEmpty: {
                                message: '{{trans('common.txt_ask_enter_old_password')}}'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: '{{trans('common.txt_ask_enter_new_password')}}'
                            },
                            stringLength: {
                                min:6,
                                message: '{{trans('common.txt_password_of_at_least_6_characters')}}'}
                        }
                    },
                    confirm_password: {
                        validators: {
                            notEmpty: {
                                message: '{{trans('common.txt_ask_confirm_new_password')}}'
                            },
                            identical: {
                                field: 'password',
                                message: '{{trans('common.txt_passwords_do_not_match')}}'
                            }
                        }
                    }
                }
            });
        });
        $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
    </script>
@endsection