@extends('templates.layout')
@section('main')
    <div class="search-page-form col-md-12 col-sm-12" style="margin-top: 30px;">
        <div class="filter-page col-md-12 col-sm-12 form-group">
            {!! Form::open(['url' => 'baocao/bao_cao_da_gui', 'method' => 'post']) !!}
            {{--<div class="col-xs-2"><label>Từ ngày</label></div>--}}
            <div class="col-md-2">
                <input type="text" class="date_filter_pc form-control col-md-10 form-day" id="tungay" name="day" value="{{formatDMY($start_date)}}">
            </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="page-content col-md-12 col-sm-12">
           <h4 style="text-align: center"><b>BẢNG BÁO CÁO NGÀY {{formatDMY($start_date)}} </b></h4>
            <div class="table-responsive">
                <div class="tablescroll-static" style="float:left; width:100%">
                    <table  class="table table-bordered table-striped bulk_action" style="text-align: left;float: left; overflow-y: visible;">
                        <thead>
                        <tr>
                            <th style="text-align: center">TT</th>
                            <th style="text-align: center;width: 70%">Nội dung</th>
                            <th style="text-align: center">Chức năng</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(sizeof($reports))
                            <?php $stt=1;?>
                            @foreach($reports as $report)
                                <tr>
                                    <td style="text-align: center">{{$stt++}}</td>
                                    <td style="text-align: center">{{strip_tags($report['content'])}}</td>
                                    <td style="text-align: center">
                                        <a href="javascript:;" onclick="xem('{{ $report['id']}}','{{$start_date}}')" title="xem báo cáo"><i class="fa fa-eye" ></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="3" style="text-align: center">Không có báo cáo nào được tìm thấy</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="xembaocao" class="modal fade" role="dialog">
            <div class="modal-dialog" style="width: 70%;">
                <div class="modal-content">
                    <div class="modal-body" style="padding: 0px;">

                    </div>
                    <div class="modal-footer" style="border-top:0; ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">

        $('.date_filter_pc').datetimepicker({
            format: 'DD/MM/YYYY',
            useCurrent: false,
        })
        $('#content_editor').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
        function xem(id_report,date) {
            url = '{{url('baocao/xem_noi_dung_bao_cao')}}';
            loading_show();
            $.get(url,{'id_report':id_report,'date':date}, function(data) {
                loading_hide();
                $('#xembaocao .modal-body').html(data);

                $('#xembaocao .modal-body .group-btn-approve').show();

                $('#xembaocao').modal('show');
            });
        }

        $('div.alert').not('.alert-important').delay(2000).fadeOut(350);
</script>
@endsection