<?php $user=\Illuminate\Support\Facades\Session::get('user');
use App\Models\CheckUser;
?>
<div class="menu">
    <div class="col-md-10 col-sm-8">
        <nav class="list-menu">
            <ul class="nav navbar-nav">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <li class="dropdown">
                    <a class="dropbtn" href="#" title=""><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Bắt đầu <span class="caret"></span></a>
                    <ul class="dropdown-content" style="background-color: #0456a2;">
                        <li><a style="border-right: none; margin-bottom: 5px;" href="#" title="">Dự án</a></li>
                        <li><a style="border-right: none;" href="#" title="">Hệ thống</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" title="Văn bản" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Văn bản <span class="badge" style="color: #f5bebe;">3</span>
                    </a>
                </li>
                <li>
                    <a href="#" title="Tờ trình" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Tờ trình <span class="badge" style="color: #f5bebe;">10</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#" title="Công việc" data-toggle="collapse" data-target="#view-content" data-toggle="tooltip">
                        <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Công việc <span class="badge" style="color: #f5bebe;">5</span>
                    </a>
                </li>
            </ul>
        </nav>
</div>
<div class="col-md-2 col-sm-4">
        <nav>
            <ul class="nav navbar-nav">
                <li><a href="#" title=""><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Lịch công việc</a></li>
            </ul>
        </nav>
</div>
</div>    
</div>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <?php
        $check_user = CheckUser::select('check_user.*')->where('check_user.username', '=', \Illuminate\Support\Facades\Session::get('user_logged_username'))->first();
        ?>
        <div class="collapse navbar-collapse" id="myNavbar"style="position: relative;">
            <ul class="nav navbar-nav menu_ipad">
                @if($check_user)
                    <li class=""><a class="guibaocao" href="{{url('baocao/xem_bao_cao_don_vi')}}">Xem báo cáo đơn vị</a></li>
                    <li class=""><a class="guibaocao" href="{{url('baocao/len_ke_hoach')}}">Tạo lịch công việc trong tuần</a></li>
                    @if($user['type']=='hrm'):
                    <li class=""><a class="guibaocao" href="{{url('cong-viec-da-giao')}}" target="_blank">Báo cáo và giao việc chi tiết <span style="color:#11dea7;">*</span></a></li>
                    <li class=""><a class="guibaocao" href="{{url('dieu-hanh')}}" target="_blank">Điều hành tác nghiệp <span style="color:#11dea7;">*</span></a></li>
                    @endif
                @else
                    <li class=""><a class="guibaocao" href="{{url('guibaocao')}}">Gửi báo cáo hằng ngày</a></li>
                    <li class=""><a class="guibaocao" href="{{url('baocao/bao_cao_da_gui')}}">Báo cáo đã gửi</a></li>
                    @if($user['type']=='hrm'):
                        <li class=""><a class="guibaocao" href="{{url('cong-viec-da-giao')}}" target="_blank">Báo cáo và giao việc chi tiết <span style="color:#11dea7;">*</span></a></li>
                        <li class=""><a class="guibaocao" href="{{url('dieu-hanh')}}" target="_blank">Điều hành tác nghiệp <span style="color:#11dea7;">*</span></a></li>
                    @endif
                @endif

            </ul>
            
        </div>
    </div>
    <div class="column menumobi">
        <div id="dl-menu" class="dl-menuwrapper">
            <button class="dl-trigger">Open Menu</button>
            <ul class="dl-menu">
                @if($check_user)
                    <li class=""><a class="guibaocao" href="{{url('baocao/xem_bao_cao_don_vi')}}">Xem báo cáo đơn vị</a></li>
                    <li class=""><a class="guibaocao" href="{{url('baocao/len_ke_hoach')}}">Tạo lịch công việc trong tuần</a></li>
                    <li class=""><a class="guibaocao" href="{{url('cong-viec-da-giao')}}" target="_blank">Báo cáo và giao việc chi tiết <span style="color:#11dea7;">*</span></a></li>
                    <li class=""><a class="guibaocao" href="{{url('dieu-hanh')}}" target="_blank">Điều hành tác nghiệp <span style="color:#11dea7;">*</span></a></li>
                    <li class="aa"><a class="name" href="{{url('cap_nhat_thong_tin')}}" target="_blank"><b class="xinchao">Xin chào:</b><span style="color: #dbe00d"> {{$user['fullname']}}</span></a></li>
                    <li><a style="color: white" href="javascript:;" onclick="logout()"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
                @else
                    <li class=""><a class="guibaocao" href="{{url('guibaocao')}}">Gửi báo cáo hằng ngày</a></li>
                    <li class=""><a class="guibaocao" href="{{url('baocao/bao_cao_da_gui')}}">Báo cáo đã gửi</a></li>
                    @if($user['type']=='hrm'):
                        <li class=""><a class="guibaocao" href="{{url('cong-viec-da-giao')}}" target="_blank">Báo cáo và giao việc chi tiết <span style="color:#11dea7;">*</span></a></li>
                        <li class=""><a class="guibaocao" href="{{url('dieu-hanh')}}" target="_blank">Điều hành tác nghiệp <span style="color:#11dea7;">*</span></a></li>
                    @endif
                    @if($user['type']=='hrm'):
                    <li class="aa"><a class="name" href="{{url('cap_nhat_thong_tin')}}" target="_blank"><b class="xinchao">Xin chào:</b> <span style="color: #dbe00d">{{$user['fullname']}}</span></a></li>
                    @else
                        <li class="aa"><a class="name" href="{{url('doi-mat-khau/'.session('user')['id'])}}" target="_blank"><b class="xinchao">Xin chào:</b> <span style="color: #dbe00d">{{$user['fullname']}}</span></a></li>
                    @endif
                    <li><a style="color: white" href="javascript:;" onclick="logout()"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
                @endif
            </ul>

        </div> dl-menuwrapper
    </div>
</nav>