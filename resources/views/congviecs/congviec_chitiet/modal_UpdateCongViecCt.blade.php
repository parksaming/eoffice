<div class="modal-dialog">
    <!-- Modal content-->
    <form id="form_congviec_user_update" action="{{ url('congviec_chitiet/update_work_detail') }}" method="POST" accept-charset="utf-8">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Cập nhật công việc</h4>
            </div>
            <div class="modal-body">
        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="congviec_detail_id" value="{{ $congviec_CT->id }}">
                <input class="form-control" type="hidden" name="congviec_id_hidden" value="{{ $congviec_CT->congviec_id }}">
                <div class="form-group">
                    <label>Nội dung công việc: </label>
                    <textarea class="form-control" name="noidung">{!! strip_tags($congviec_CT->noidung) !!}</textarea>
                </div>
                <div class="form-group clearfix">
                    <div class="col-xs-6 pd_none_left">
                        <label for="ngaybd">Ngày bắt đầu:</label>
                        <input type="text" class="form-control datepicker" name="ngaybatdau" value="{{ formatDMY($congviec_CT->ngaybatdau) }}">
                    </div>
                    <div class="col-xs-6 pd_none_right">
                        <label for="ngaykt">Ngày kết thúc:</label>
                        <input type="text" class="form-control datepicker" name="ngayketthuc" value="{{ formatDMY($congviec_CT->ngayketthuc) }}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Đơn vị:</label>
                    <select class="form-control select_donvi" name="donvi">
                        <option value="0">-- Chọn đơn vị --</option>
                    <?php
                        $user = session('user');
                        if ($user['type'] == 'hrm' && sizeof($donvis) > 0 && sizeof($dv_sess) > 0){
                            show_menu($donvis,1,0,$dv_sess['Donvi']['parent'],'');
                        }else{
                            echo '<option value="'.$user['donvi_id'].'">'.$user['donvi_id'].'</option>';
                        }
                    ?> 
                    </select>
                </div>
                <div class="form-group nguoiphutrach">
                    <label>Chọn người làm: </label>
                   <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --">
                        <span class="multiselect-selected-text">-- Chọn --</span> 
                        <b class="caret"></b>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn_update_congviec_user" type="submit">Cập nhật</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </form>
</div>

<script>

    $(document).ready(function() {

        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });

        $('#form_congviec_user_update').ajaxForm({
            url: '{{ url("congviec_chitiet/update_work_detail") }}',
            dataType: 'json',
            type: 'POST',
            success: function(data){
                if (data.error == 0) {
                    $('#modal_UpdateCongViecCt').modal('hide');
                    jAlert('Cập nhật thành công','Thông báo');
                    var congviec_id = data.congviec_id;
                    axjaxLoadDetail_Congviec(congviec_id);
                }else if(data.error == 1){
                    jAlert('Bạn chưa lựa chọn người thực hiện công việc','Thông báo');
                }
                
            },
            error: function(e){
                alert('Co loi xay ra');
            }
        });

        $('.select_donvi[name=donvi]').change(function(event) {
            loading_show();
            var madonvi =  $(this).val();
            $.ajax({
                url: '{{ url("congviec/getUser_Unit") }}',
                type: 'GET',
                data: {madonvi: madonvi},
                success: function(data){
                    loading_hide();
                    if (data != 0) {
                        $('.nguoiphutrach').html(data);
                    }else{
                        $('.nguoiphutrach').html('<label>Người phụ trách:</label> <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --"><span class="multiselect-selected-text">-- Chọn --</span> <b class="caret"></b></button>');
                    }
                },
                error: function(er){
                    alert('có lổi xảy ra');
                }
            })
        });
    });

</script>