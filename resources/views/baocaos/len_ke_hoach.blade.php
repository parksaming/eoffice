@extends('templates.lanhdao')
@section('main')
    <?php  $user=\Illuminate\Support\Facades\Session::get('user');?>
    <div class="search-page-form col-md-12 col-sm-12" style="margin-top: 30px;">
        @include('flash::message')
        <div class="filter-page col-md-8 col-sm-8 form-group">
            {!! Form::open(['url' => 'len_ke_hoach', 'method' => 'get']) !!}
                <h4 class="titile_guibaocao" style="text-align: center;"><b>Tạo lịch công việc trong tuần</b></h4>
            <div class="noidung">
            {!! Form::textarea('content',null,array('id'=>'content_editor','class' => 'form-control pull-left', 'placeholder' => "Nhập nội dung")) !!}
                <div id="load" class="loading" style="display:none;"><img src="../img/loadinggraphic.gif"/></div>
            </div>
            <div class="col-md-1" style=" padding: 6px; width: 10%;">
                <label class="tungay">Từ ngày</label>
            </div>
            <div class="col-md-3 no-padding-left fromday">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id ="day" name="day" class="form-control day" value="{{formatDMY($start_date)}}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
            <div class="col-md-2" style="padding:6px;width:11.666667%;">
                <label class="denngay">Đến ngày</label>
            </div>
            <div class="col-md-3 no-padding-left today" >
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' id="day_to"name="day_to" class="form-control day" value="{{formatDMY($end_date)}}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-3 btnluu">
                 <button type="button" onclick="send()" class="btn btn-primary send" data-toggle="modal"> Lưu</button>
             </div>
            {!! Form::close() !!}
        </div>

        <div class="filter-page col-md-4 col-sm-4 form-group kehoachdatao">
            {!! Form::open(['url' => 'ke_hoach_da_tao', 'method' => 'get']) !!}
            <h4 class="titile_guibaocao blue" style="text-align: center;"><b>Lịch tuần đã tạo</b></h4>
            <table class="table table-hover">
                @foreach($kehoachs as $kehoach)
                    <tbody>
                    <tr>
                        <td>
                            <i>Lịch tuần từ ngày <span class="blue">{{formatDMY($kehoach->start_day)}}</span> đến <span class="blue">{{formatDMY($kehoach->end_day)}}</span></i>
                            <br>
                            <i style="font-size: 12px;margin-right: 50px;float: right"><?php echo $kehoach['fullname'] ?></i>
                        </td>
                        <td>
                            <a href="javascript:;" onclick="xemkehoach('{{ $kehoach->id}}')" title="Xem chi tiết kế hoạch"><i class="fa fa-eye" ></i></a>

                           @if(  $end_date <= $kehoach['end_day']&& $kehoach['username']== session('user')['username'])
                                <a href="{{url('baocao/sua_ke_hoach/' . $kehoach->id)}}" title="Sửa kế hoạch"><i class="fa fa-pencil"></i></a>

                           @else
                            @endif
                        </td>
                    </tr>

                    </tbody>
                @endforeach
            </table>
            {!! Form::close() !!}
        </div>
        <div id="xemkehoach" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 92%;">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 0px;">

                    </div>
                    <div class="modal-footer" style="border-top:0; ">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $('#content_editor').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true
    });

function send() {
        jConfirm('{!! 'Bạn có muốn gửi kế hoạch?' !!}', '{!! 'Thông báo' !!}', function(r) {
            if(r){
                document.getElementById("load").style.display = "block";  // show the loading message.
                var url = "{{ url('baocao/len_ke_hoach') }}";
                var content = $("#content_editor").val();
                var day = $("#day").val();
                var day_to = $("#day_to").val();
                var token = '{{ csrf_token() }}';
                 $.post(url,{'content':content,'day':day,'day_to':day_to, '_token':token},function(data) {
                     document.getElementById("load").style.display = "none";
                    window.location.href = "{{ url('baocao/len_ke_hoach') }}";
                },'json');
            }
        });
    }

    function xem_ke_hoach() {
        content_editor = $("#content_editor").val();
        url = '{{url('baocao/xem_ke_hoach')}}';
        var content = content_editor;
        var day = $("#day").val();
        var day_to = $("#day_to").val();
        var token = '{{ csrf_token() }}';
        loading_show();
        document.getElementById("load").style.display = "block";  // show the loading message
        $.post(url,{'content[]':content,'day':day,'day_to':day_to,'_token':token}, function(data) {
            loading_hide();
            document.getElementById("load").style.display = "none";
            $('#FormRest .modal-body').html(data);

            $('#FormRest .modal-body .group-btn-approve').show();

            $('#FormRest').modal('show');
        });
    }
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false,

        });
        $('#datetimepicker2').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false,

        });
    });

    function xemkehoach(id) {
        url = '{{url('baocao/xem_chi_tiet_ke_hoach')}}';
        loading_show();
        document.getElementById("load").style.display = "block";  // show the loading message.
        $.get(url,{'id':id}, function(data) {
            loading_hide();
            document.getElementById("load").style.display = "none";
            $('#xemkehoach .modal-body').html(data);

            $('#xemkehoach .modal-body .group-btn-approve').show();

            $('#xemkehoach').modal('show');
        });
    }

    $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
</script>
@endsection