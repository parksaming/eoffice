<div class="header clearfix" id="fixnav" >
   <div class="col-sm-4 col-md-4">
        <div class="page-logo hidden-xs hidden-sm" style="margin-top: 10px;">
            <a href="{{url('dashboard')}}" id="lgo" >
                <img alt="logo" class="logo-default" src="{{asset('img/logo.png') }}" />
            </a>

        </div>
    </div>
    <div class=" col-sm-8 col-md-8">
        <h4 class="header-right col-sm-12">
            <strong style="padding-top: 1000px;">
                <a style="color: #fff; float: right; margin-top: 5px;" href="{{ url('dashboard') }}">Điều hành tác nghiệp</a>
            </strong>
        </h4 >
        <nav class="navbar-right col-sm-12" style="margin-top: -5px;">
            <ul class="nav navbar-nav" style="padding-top: 0px;">
                    <li class="dropdown dropdown-extended dropdown-notification hasAccount" id="header_notification_bar" title="Hôm nay">
                        <a href="#" class="dropdown-toggle">
                            <span class="current-time df-icon-size" style="color: #fff; background: url(./img/icon_lich.svg) no-repeat; padding-left: 20px">{{ date('d/m/Y') }}</span>
                        </a>
                    </li>
                    <li class="dropdown notification">
                        <a href="javascript:;" id="dropdownMenuButton" data-toggle="dropdown">
                            <span style="color: #fff;" class="glyphicon glyphicon-bell" aria-hidden="true"></span>
                            <span class="badge notification-count hidden">0</span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="notification-container">
                                <ul class="notifications"></ul>
                                <div class="notifications-menu">
                                    <a href="javascript:;" onclick="xemTatca()">Xem tất cả</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <script>
                        function getNotifications() {
                            $.get("{{ route('notification.list_notifications') }}", (res) => {
                                $('.notification .dropdown-menu .notifications').html(res)
                            })
                        }

                        function xemTatca() {
                            $.post("{{ route('notification.view_all') }}", {_token: $('meta[name="csrf-token"]').attr('content')}, (res) => {
                                getNotifications()
                            }, 'json')
                        }

                        getNotifications();    
                        setInterval(getNotifications, 60000)
                    </script>

                    <li class="dropdown"> 
                        <?php  
                            $username_explode = explode(" ",$user['fullname']);
                            $username_login = $username_explode[count($username_explode)-1];
                        ?>
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="false">
                            <span class="username username-hide-on-mobile hidden-sm" id="user_n">{{ $user['fullname'] }} <i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                            
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="https://portal.office.com/account/#personalinfo" title=""><i style="padding: 3px" class="fa fa-user-o" aria-hidden="true"></i>Cập nhật thông tin</a></li>
                            <li><a href="javascript:;" onclick="logout()" title=""><i style="padding: 3px" class="fa fa-key" aria-hidden="true"></i>Đăng xuất</a></li>
                        </ul>
                    </li>
                    <li><a href="#" title style="color: #fff;" data-toggle="modal" data-target="#form-content"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Góp ý</a></li>
                    
                    <div id="form-content" class="modal fade" role="dialog">
                        <form id="FormGopY" class="modal-dialog" action="{{ url('save_gop_y') }}" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Góp ý</h4>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div style="margin-bottom: 10px;">
                                        <label>Tên: </label>
                                        <input class="form-control" type="text" name="name" value="{{ session('user')['fullname'] }}">
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                        <label>Địa chỉ Email: </label>
                                        <input class="form-control" type="text" name="email" value="{{ session('user')['email'] }}">
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                        <label>Nội dung góp ý: </label>
                                        <textarea class="form-control" name="noidung"></textarea>
                                    </div>
                                    <div style="margin-bottom: 10px;">
                                        <label>File đính kèm: </label>
                                        <input type="file" name="file">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit">Góp ý</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                </div>
                            </form>
                            <script>
                                $('#FormGopY').validate({
                                    rules: {
                                        name: 'required',
                                        email: 'required',
                                        noidung: 'required'
                                    },
                                    messages: {
                                        name: 'Hãy nhập tên',
                                        email: 'Hãy nhập email',
                                        noidung: 'Hãy nhập nội dung'
                                    },
                                    submitHandler: function(form) {
                                        loading_show();
                                        form.submit();
                                    }
                                });
                            </script>
                        </div>
                    </div>
            </ul>
        <nav>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_baocao_notifi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_agreement_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        $('.notification ul.dropdown-menu li').click(function(event) {
            var flag = "";
            $('.notification ul.dropdown-menu li').removeClass('temp');
            $(this).addClass('temp');

            if ( !$(this).hasClass('onview')) {
                var congviec_user_count = $('.notification .congviec_user_count').text();
                $('.notification .congviec_user_count').text(congviec_user_count - 1);
            }
            $(this).addClass('onview');
            
            var congviec_ct_id = $(this).attr('data-cv_Chitiet_id');
            var congviec_baocao_id = $(this).attr('data-congviec_baocao_id');
            if ( typeof congviec_ct_id !== 'undefined') {
                // Báo cáo công việc
                var url = '{{ url("baocao/view_baocao_notifi") }}';
                var data = { congviec_ct_id : congviec_ct_id} ;
                flag = 1;
            }else{
                // Duyệt công việc 
                var url = '{{ url("baocao/view_agreement_report") }}';
                var data = { congviec_baocao_id : congviec_baocao_id} ;
                flag = 2;
            }
            loading_show();
            $.get(
                url,
                data, 
                function(result) {
                    if (flag == 1) {
                        $('#modal_baocao_notifi .modal-content').html(result);
                        $('#modal_baocao_notifi').modal('show');
                    }else{
                        $('#modal_agreement_report .modal-content').html(result);
                        $('#modal_agreement_report').modal('show');
                    }
                
                loading_hide();
            });
        });

        setTimeout(() => {
            $('.alert.alert-info').remove();
        }, 10000);

        $(document).on('click', '.remove-file', function () {
            $(this).closest('.group-file').find('input').removeClass('hidden');
            $(this).closest('.group-file').find('.file-container').remove();
        })
    })
</script>