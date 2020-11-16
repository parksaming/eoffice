@extends('templates.lanhdao')
@section('main')
    <div class="search-page-form col-md-12 col-sm-12" style="margin-top: 30px;" xmlns="http://www.w3.org/1999/html">
        @include('flash::message')
        @if(!sizeof($checkreport))
             <div class="filter-page col-md-8 col-sm-8 form-group">
                {!! Form::open(['url' => 'guibaocao', 'method' => 'get']) !!}
                    <h4 class="titile_guibaocao" style="text-align: center;"><b>Báo cáo cho ngày {{date('d-m-Y')}}</b></h4>
                <div class="noidung">
                {!! Form::textarea('content',null,array('id'=>'content_editor','class' => 'form-control pull-left', 'placeholder' => "Nhập nội dung")) !!}
                    <div id="load" class="loading" style="display:none;"><img src="img/loadinggraphic.gif"/></div>
                </div>
                <button type="button" onclick="xem('content_editor')" class="btn btn-primary xemtruoc" data-toggle="modal" data-target="#myModal">Xem trước</button>

                <div id="FormRest" class="modal fade" role="dialog">
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
                <button type="button" onclick="send()" class="btn btn-primary send" data-toggle="modal"> Gửi</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-4 col-sm-4 form-group kehoachdatao">
                @if($kehoachs)
                <h4 class="titile_guibaocao title_kehoach" style="text-align: center;"><b>Kế hoạch công việc từ ngày <span class="blue">{{formatDMY($kehoachs->start_day)}}</span> đến <span class="blue">{{formatDMY($kehoachs->end_day)}}</span> </b></h4>
                <table class="table table-hover">
                    <tbody>

                            <tr>
                                <td>
                                    <?php echo $kehoachs->content ?>
                                </td>
                            </tr>
                    </tbody>
                </table>
                @else
                    <h4 class="titile_guibaocao" style="text-align: center">Không có lịch tuần cho ngày {{date('d-m-Y')}}</h4>
                @endif
            </div>
        @else
            <h4 class="titile_guibaocao" style="text-align: center">Bạn đã gửi báo cáo cho ngày {{$day}}</h4>
            <div class="btn_xembaocao">
                <a href="{{'baocao/bao_cao_da_gui'}}" target="_blank"><input type="button"  class="btn btn-primary" value="Xem báo cáo" class="button"></a>
            </div>
        @endif
    </div>
<script type="text/javascript">
    $('#content_editor').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true
    });

function send() {
        jConfirm('{!! 'Bạn có muốn gửi báo cáo?' !!}', '{!! 'Thông báo' !!}', function(r) {
            if(r){
                document.getElementById("load").style.display = "block";  // show the loading message.
                var url = "{{ url('baocao/gui_bao_cao') }}";
                var content = $("#content_editor").val();
                var token = '{{ csrf_token() }}';
                 $.post(url,{'content':content, '_token':token},function(data) {
                     document.getElementById("load").style.display = "none";
                    window.location.href = "{{ url('guibaocao') }}";
                },'json');
            }
        });
    }

    function xem() {
        content_editor = $("#content_editor").val();
        url = '{{url('baocao/xem_bao_cao')}}';
        var content = content_editor;
        var token = '{{ csrf_token() }}';
        loading_show();
        document.getElementById("load").style.display = "block";  // show the loading message
        $.post(url,{'content[]':content,'_token':token}, function(data) {
            loading_hide();
            document.getElementById("load").style.display = "none";
            $('#FormRest .modal-body').html(data);

            $('#FormRest .modal-body .group-btn-approve').show();

            $('#FormRest').modal('show');
        });
    }

    $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
</script>
@endsection