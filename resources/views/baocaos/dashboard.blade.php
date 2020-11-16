@extends('templates.lanhdao')
@section('main')
    <div class="container-fluid pd-t20">
        <div class="col-sm-6">
            <div class="card card-default ">
                <div class="card-header"><b>Các văn bản</b></div>
                <div class="card-body card-5-7">
                    <div class="card-left">
                        <img src="{{asset('img/vanban.png')}}" class="img-responsive"/>
                    </div>
                    <div class="card-right">
                        <h4>Các văn bản</h4>
                        <p>Soạn thảo và gửi văn bản đến các đơn vị. Đồng thời quản lý bút phê, các văn bản gửi đến, gửi đi và ủy quyền gửi văn bản.</p><br><br><br>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><a title="Click để xem văn bản đến chưa đọc" href="{{route('danhsach.vanbanden')}}"><span class="col_red"> {{$vanbans }} </span> văn bản mới</a></div>
                            <div class="ml-auto p-2 bd-highlight" ><a title="Gửi văn bản" href="{{route('add.van.ban.den')}}">Gửi văn bản</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-default">
                <div class="card-header"><b>Quản lý báo cáo</b></div>
                <div class="card-body card-5-7">
                    <div class="card-left">
                        <img src="{{asset('img/qlybaocao.svg')}}" class="img-responsive"/>
                    </div>
                    <div class="card-right">
                        <h4>Quản lý báo cáo</h4>
                        <p>Soạn thảo và gửi các báo cáo cho các đơn vị cấp trên và các ban, văn phòng. Đồng thời quản lý các báo cáo gửi đến, gửi đi.</p><br><br><br>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><a title="Click để xem báo cáo chưa đọc" href="#"><span class="col_red"> 0 </span>báo cáo mới</a></div>
                            <div class="ml-auto p-2 bd-highlight" ><a title="Gửi báo cáo" href="#">Gửi báo cáo</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card card-default">
                <div class="card-header"><b>Quản lý tờ trình</b></div>
                <div class="card-body card-5-7">
                    <div class="card-left">
                        <img src="{{asset('img/totrinh.png')}}" class="img-responsive"/>
                    </div>
                    <div class="card-right">
                        <h4>Quản lý tờ trình</h4>
                        <p>Soạn thảo và gửi tờ trình cho cấp trên. Đồng thời quản lý các tờ trình đã gửi và các tờ trình đã nhận được.</p><br><br><br>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><a href="#" title="Click xem tờ trình mới chưa đọc"><span class="col_red"> 0 </span>tờ trình mới</a></div>
                            <div class="ml-auto p-2 bd-highlight" ><a title="Gửi tờ trình" href="#">Gửi tờ trình</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-default">
                <div class="card-header"><b>Quản lý công việc</b></div>
                <div class="card-body card-5-7">
                    <div class="card-left">
                        <img src="{{asset('img/qlycongviec.png')}}" class="img-responsive"/>
                    </div>
                    <div class="card-right">
                        <h4>Quản lý công việc</h4>
                        <p>Khởi tạo và quản lý các công việc đã giao, được giao.
                        </p><br><br><br>
                        <p><a href="#" title="Click xem công việc đã giao">Có<span class="col_red"> 0 </span> công việc đã giao</a></p>
                        <div class="d-flex bd-highlight mb-3">
                            <div class="p-2 bd-highlight"><a title="Click đê xem công việc được giao" href="#">Có<span class="col_red"> 0 </span>công việc được giao</a></div>
                            <div class="ml-auto p-2 bd-highlight"><a title="Tạo công việc mới" href="#">Tạo việc</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
