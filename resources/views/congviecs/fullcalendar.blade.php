
<!-- <script src="{{asset('js/jquery.min.js') }}"></script> -->
<script>
    $(document).ready(function() {
        var calendar = '{{ isset($inc_calendar) ? $inc_calendar : "calendar" }}';
        $('#'+calendar).fullCalendar({

            <!--Header Section Including Previous,Next and Today-->
            header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
            },

            <!--Default Date-->
            defaultDate: '{{ date("Y-m-d") }}',
            editable: true,
            
            <!--Event Section-->
            eventLimit: true, // allow "more" link when too many events
            events: [
                @foreach( $congviec_users as $congviec_user )
                {
                title: '{{ $congviec_user->noidung }} - ( việc được giao )',
                url: '{{ $congviec_user->id }}',
                start: '{{ $congviec_user->ngaybatdau }}',
                end: '{{ $congviec_user->ngayketthuc }}'
                }
                ,
                @endforeach
                @foreach( $congviecs as $congviec )
                {
                title: '{{ $congviec->tencongviec }} - ( việc đã giao )',
                url: '{{ $congviec->id }}-viecdagiao',
                start: '{{ $congviec->ngaybatdau }}',
                end: '{{ $congviec->ngayketthuc }}',
                color: '#257e4a'
                }
                ,
                @endforeach
            ]
        });
        $('#'+calendar).on('click','.fc-event-container a', function(event) {
            event.preventDefault();
            loading_show();
            var flag = "";
            var data_id = $(this).attr('href');
            var n = data_id.indexOf("-viecdagiao");
            if ( n == -1 ) {
                flag = 1;
                var url = '{{ url("baocao/view_baocao_notifi") }}';
                var data = { congviec_ct_id : data_id} ;
                var dataType = 'text';
                
            }else{
                flag == 2;
                var data_id_split = data_id.split('-viecdagiao'); 
                var url = '{{ url("congviec/axjaxLoadDetail_Congviec") }}';
                var data = { congviec_id : data_id_split[0]} ;
                var dataType = 'json';
            }

            $.ajax({
                url: url,
                type: 'GET',
                dataType: dataType,
                data: data,
                success: function(result){
                    if ( flag == 1 ) {
                        $('#modal_baocao_notifi .modal-content').html(result);
                        $('#modal_baocao_notifi').modal('show');
                    }else{
                        $('#modal_view_work_detail .modal-body .tcv').text(result.congviec.tencongviec)
                        $('#modal_view_work_detail .modal-body .ngaybd').text(result.congviec.ngaybatdau);
                        $('#modal_view_work_detail .modal-body .ngaykt').text(result.congviec.ngayketthuc);
                        $('#modal_view_work_detail .modal-body .noidung').text(result.congviec.noidung);
                        $('#modal_view_work_detail .modal-body .status').text(result.congviec.trangthai);
                        $('#modal_view_work_detail .modal-body .nptc').text(result.congviec.nguoigiamsat);
                        var html = "";
                        if ( result.congviecCT.length != 0 ) {
                            $.each(result.congviecCT, function(index, val) {
                                html += "<tr>";
                                    html += "<td>"+(index+1)+"</td>";
                                    html += "<td>"+val.noidung+"</td>";
                                    html += "<td>"+val.listName_CongviecCT+"</td>"
                                html += "</tr>";   
                            });
                        }else{
                            html += "<tr>";
                                html += "<td colspan='3'><em>Chưa phân công công việc</em></td>";
                            html += "</tr>";
                        }
                        
                        $('#modal_view_work_detail .modal-body table').html(html);
                        $('#modal_view_work_detail').modal('show');
                    }
                    loading_hide();
                },
                error: function(er){
                    alert('co loi xay ra');
                }
            })
        });
    });
</script>

<div id='{{ isset($inc_calendar) ? $inc_calendar : "calendar" }}'></div>

<!-- Modal Báo cáo công việc -->
<div class="modal fade" id="modal_baocao_notifi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        
    </div>
  </div>
</div>

<!-- Modal Xem công việc -->
<div class="modal fade" id="modal_view_work_detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Xem công việc</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label>Tên công việc</label>
            <div class="form-control tcv"></div>
        </div>
        <div class="form-group">
            <label>Nội dung công việc</label>
            <div class="form-control noidung" style="height: auto;"></div>
        </div>
        <div class="form-group">
            <label>Trạng thái</label>
            <div class="form-control status"></div>
        </div>
        <div class="form-group">
            <label>Người giám sát</label>
            <div class="form-control nptc"></div>
        </div>
        <div class="form-group clearfix">
            <div class="col-xs-6 pd_none_left">
                <label>Ngày bắt đầu</label>
                <div class="form-control ngaybd"></div>
            </div>
            <div class="col-xs-6 pd_none_right">
                <label>Ngày kết thúc</label>
                <div class="form-control ngaykt"></div>
            </div>
        </div>
        
        <label>Công việc đã giao</label>
        <table class="table table-condensed">

        </table>
      </div>
    </div>
  </div>
</div>




