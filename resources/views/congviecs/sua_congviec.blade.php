<div class="modal-dialog" role="document">
    <div class="modal-content">
		<form action="" id="form_edit_work" method="POST">
			{{ csrf_field() }}
			<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Sửa công việc</h4>
		    </div>
		    <div class="modal-body">
		    	<div class="form-group">
		    		<label>Tên công việc</label>
		    		<input type="text" name="tencongviec" class="form-control" value="{{ $congviec->tencongviec }}">
		    	</div>
		    	<div class="form-group">
		    		<div class="col-xs-6 pd_none_left">
			    		<div class="form-group">
					    	<label for="nguoigiamsat">Người giám sát:</label>
					    	<div id="choose_supervisor2" class="form-control">
					    		<span>{{ $congviec->nguoigiamsat }}</span>
					    		<input type="hidden" name="nguoigiamsat" value="{{ $congviec->nguoigiamsat }}">
					    	</div>
					    </div>
					</div>
					<div class="col-xs-6 pd_none_right">
						<div class="form-group">
							<?php  
								$uu_tien = \App\TinhChat::where('actived',1)
									->select('name')->get();
							?>
					    	<label for="tinhchat">Độ ưu tiên:</label>
					    	<select class="form-control" name="tinhchat">
					    		<option value="">-- Chọn độ ưu tiên --</option>
					    		@foreach( $uu_tien as $item )
					    		<option {{ $item->name == $congviec->tinhchat ? 'selected' : '' }} value="{{ $item->name }}">{{ $item->name }}</option>
					    		@endforeach
					    	</select>
					    </div>	
			    	</div>
		    	</div>
		    	<div class="form-group">
			    	<div class="col-xs-6 pd_none_left">
					    <div class="form-group">
					    	<label for="ngaybd">Ngày bắt đầu:</label>
					    	<input type="text" class="form-control datepicker" value="{{ formatDMY($congviec->ngaybatdau) }}" name="ngaybatdau">
					    </div>	
			    	</div>
			    	<div class="col-xs-6 pd_none_right">
					    <div class="form-group">
					    	<label>Ngày kết thúc:</label>
					    	<input type="text" class="form-control datepicker" value="{{ formatDMY($congviec->ngayketthuc) }}" name="ngayketthuc">
					    </div>	
			    	</div>
			    </div>
		        <div class="form-group">
                	<label>Nội dung công việc</label>
                	<textarea class="form-control" name="noidung">{!! strip_tags($congviec->noidung) !!}</textarea>
                </div>
                <div class="form-group">
			    	<label for="trangthai">Trạng thái:</label>
			    	<select name="trangthai" class="form-control">
			    		<option value="">-- Chọn trạng thái --</option>
			    		<option {{ $congviec->trangthai == 'Chưa thực hiện' ? 'selected' : '' }} value="Chưa thực hiện">Chưa thực hiện</option>
			    		<option {{ $congviec->trangthai == 'Đang thực hiện' ? 'selected' : '' }} value="Đang thực hiện">Đang thực hiện</option>
			    		<option {{ $congviec->trangthai == 'Đã hoàn thành' ? 'selected' : '' }} value="Đã hoàn thành">Đã hoàn thành</option>
			    		<option {{ $congviec->trangthai == 'Tạm dừng' ? 'selected' : '' }} value="Tạm dừng">Tạm dừng</option>
			    		<option {{ $congviec->trangthai == 'Hủy bỏ' ? 'selected' : '' }} value="Hủy bỏ">Hủy bỏ</option>
			    	</select>
			    </div>
		    </div>
			<div class="modal-footer">
			    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
			    <button type="submit" class="btn btn-primary">Lưu</button>
			</div>
		</form>
	</div>
 </div>

 <script>
 	
 	$(document).ready(function(){

 		$('form#form_edit_work').validate({
        	rules: {
                tencongviec: "required",
                ngaybatdau: "required",
                ngayketthuc: "required",
                noidung: "required",
                nguoigiamsat: "required",
                tinhchat: "required",
                trangthai: "required",
            },
            messages: {
                tencongviec: "Vui lòng nhập tên công việc",
                ngaybatdau: "Vui lòng nhập ngày bắt đầu",
                ngayketthuc: "Vui lòng nhập ngày kết thúc",
                noidung: "Vui lòng nhập nội dung",
                nguoigiamsat: "Vui lòng chọn người giám sát",
                tinhchat: "Vui lòng chọn độ ưu tiên",
                trangthai: "Vui lòng chọn trạng thái",
            }
        })

        $('form#form_edit_work').ajaxForm({
        	url: '{{ url("congviec/sua_congviec") }}',
        	type: 'POST',
        	data: { congviec_id: '{{ $congviec->id }}' },
        	success: function(data){
        		if (data == 'done') {
        			jAlert('Cập nhật công việc thành công','Thông báo');
        			reloadAjax();
        			axjaxLoadDetail_Congviec('{{ $congviec->id }}');
        		}else{
        			jAlert('Cập nhật thất bại','Thông báo');
        		}
        		$('#model_edit_work').modal('hide');
        	}
        })

        $('.select_donvi_of_nguoigiamsat').change(function(event) {
			var nguoigiamsat = $(this).val().split("+")[2];
			$('#choose_supervisor2 span').text(nguoigiamsat);
			$('#choose_supervisor2').find('input[name=nguoigiamsat]').val(nguoigiamsat);
			return false;
		});

        $('#choose_supervisor2').click(function(event) {
			$('#modal_choose_supervisor').modal('show');
		});

        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });

 	})

 </script>