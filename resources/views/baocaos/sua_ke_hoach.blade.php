@extends('templates.lanhdao')
@section('main')
    <div class="search-page-form col-md-12 col-sm-12" style="margin-top: 30px;">
        @include('flash::message')
        <div class="filter-page col-md-8 col-sm-8 form-group">
            {!! Form::open(['url' => 'sua_ke_hoach', 'method' => 'post']) !!}
                <h4 class="titile_guibaocao" style="text-align: center;"><b>Sủa kế hoạch</b></h4>
            <input type="hidden" id="id" value="{{$plans->id}}" />
            <div class="noidung">
            {!! Form::textarea('content',$plans->content,array('id'=>'content_editor','class' => 'form-control pull-left', 'placeholder' => "Nhập nội dung")) !!}
                <div id="load" class="loading" style="display:none;"><img src="{{url('/img/loadinggraphic.gif')}}"/></div>
            </div>

            <div class="col-md-1" style="width:10%;padding:6px;">
                <label class="tungay">Từ ngày</label>
            </div>
            <div class="col-md-3 no-padding-left fromday">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id ="day" name="day" class="form-control day" value="{{ isset($plans)?formatDMY($plans->start_day): ''}}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-2" style="padding:6px;width: 10.666667%;">
                <label class="denngay">Đến ngày</label>
            </div>
            <div class="col-md-3 no-padding-left today" >
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' id="day_to"name="day_to" class="form-control day" value="{{ isset($plans)?formatDMY($plans->end_day): ''}}" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="col-md-8" style="padding:6px;margin-left: 100px;margin-top: 10px">
            <button type="button" onclick="xem_ke_hoach('content_editor')" class="btn btn-primary xemtruockh" data-toggle="modal" data-target="#myModal">Xem trước</button>

            <div id="FormRest" class="modal fade" role="dialog">
                <div class="modal-dialog" style="width: 90%;">
                    <div class="modal-content">
                        <div class="modal-body" style="padding: 0px;">

                        </div>
                        <div class="modal-footer" style="border-top:0; ">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" onclick="update()" class="btn btn-primary send" data-toggle="modal"> Cập nhật</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
<script type="text/javascript">
    $('#content_editor').summernote({
        height: 300,
        minHeight: null,
        maxHeight: null,
        focus: true
    });

function update() {
        jConfirm('{!! 'Bạn có muốn cập nhật kế hoạch?' !!}', '{!! 'Thông báo' !!}', function(r) {
            if(r){
                document.getElementById("load").style.display = "block";  // show the loading message.
                var url = "{{ url('baocao/sua_ke_hoach') }}";
                var content = $("#content_editor").val();
                var id = $("#id").val();
                var day = $("#day").val();
                var day_to = $("#day_to").val();
                var token = '{{ csrf_token() }}';
                 $.post(url,{'content':content,'day':day,'day_to':day_to,'id':id, '_token':token},function(data) {
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
    $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
</script>
@endsection