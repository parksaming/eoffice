<div style="display: flex; margin: 15px 0 8px">
	<h3 class="name_work" style="margin: 0;flex: 1;">
		{{ sizeof($congviec) > 0 ? $congviec->tencongviec : '' }}
	</h3>
	
	@if($congviec && $congviec->user_id == session('user')['id'])
		<div>
			<a href="javascript:;"><i style="font-size: 20px;margin-right: 8px;" class="fa fa-pencil edit_work_btn" title="Sửa công việc" data-toggle="tooltip"></i></a>
			<a href="javascript:;"><i style="font-size: 20px;margin-left: 8px;" class="fa fa-bell"></i></a>
		</div>
	@endif
</div>
<div>
	<p class="uu_tien">
		Ưu tiên: <span class="nature_work">{{ sizeof($congviec) > 0 ? $congviec->tinhchat : '' }}</span> |
		Bắt đầu: 
		<span class="date_start">
			{{ sizeof($congviec) > 0 ? formatDMY($congviec->ngaybatdau) : '' }}   
		</span>
		- Kết thúc: 
		<span class="date_end">
			{{ sizeof($congviec) > 0  ? formatDMY($congviec->ngayketthuc) : '' }}
		</span>
	</p>
	<p class="status">
		<i class="fa fa-check-circle" aria-hidden="true"></i> 
		<strong>Trạng thái</strong>: 
		<span>{{ sizeof($congviec) > 0 ? $congviec->trangthai : '' }}</span>

		<a href="javascript:;" style="margin-left: 10px" class="btn-change-status-cv {{ ($congviec && $congviec->user_id == session('user')['id'])? '' : 'hidden' }}" cvid="{{ $congviec? $congviec->id : '' }}" cvstatus="{{ $congviec? $congviec->status : '' }}" title="Cập nhật trạng thái"><i class="fa fa-pencil"></i></a>
		<script>
			$(document).ready(function () {
				$('.btn-change-status-cv').click(function(event) {
					let congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
					if (typeof congviec_id !== 'undefined') {
						loading_show();
						$.ajax({
							url: '{{ route("congviec.get_view_change_status") }}',
							type: 'GET',
							data: {congviec_id: congviec_id},
							success: function(data) {
								loading_hide();
								$('#ChangeStatusCV').html(data).modal('show');
							},
							error: function(er) {
								loading_hide();
								alert('Có lỗi xảy ra');
							}
						})
					}
				});
			});
		</script>
	</p>
	<p class="nguoigiamsat">
		<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
		<strong>Người giám sát</strong>: 
		<span> {{ sizeof($congviec) > 0 ? $congviec->nguoigiamsat : '' }}</span>
	</p>
	<p class="nguoiphoihop">
		<i class="fa fa-user-circle-o" aria-hidden="true"></i> 
		<strong>Người phối hợp</strong>: 
		<span> {{ sizeof($congviec) > 0 ? $congviec->nguoiphoihop : '' }}</span>
	</p>
	<p>
		<i class="fa fa-briefcase" aria-hidden="true"></i> 
		<strong>Nội dung công việc</strong>:
	</p>
	<p class="content_work">{{ sizeof($congviec) > 0 ? $congviec->noidung : '' }} </p>
</div>
<h3>Phân công công việc:</h3>

<div class="table-responsive">
	<table class="table table-hover pccv" scrolling="auto">
		<?php  
			if (sizeof($congviec) > 0) {
				$congviec_chitiet = \App\CongviecChiTiet::where('congviec_id',$congviec->id)->groupBy('noidung')->get();
			}
		?>
		<tbody class="table-content">
			<?php  
				if (sizeof($congviec) > 0) {
					foreach( $congviec_chitiet as $key => $item ){
			?>
			<tr>
				<td><input type="checkbox" name="congviec_detail_id" value="{{ $item->id }}"></td>
				<td class="stt-work-detail">{{ $key+1 }}</td>
				<td class="work-detail-content">
					<div title="{!! strip_tags($item->noidung) !!}" data-toggle="tooltip">
						{!! $item->noidung !!}
					</div>
				</td>
				<?php  
					if ( sizeof($congviec) > 0 ) {
						$congviec_chitiet_2 = \App\CongviecChiTiet::where([
							['congviec_id',$item->congviec_id],
							['noidung',$item->noidung]
						])->get();
						$user_username = '';
						foreach ($congviec_chitiet_2 as $item_2) {
							$user_local = App\User::where('username',$item_2->user_username)->first();
							if ( count($user_local) > 0 ) {
								$user_username .= $user_local->fullname.'<br>';
							}else{
								$user_username .= $item_2->nguoiphutrach != null ? $item_2->nguoiphutrach : $item_2->user_username.'<br>';
							}
						}
						$user_username = rtrim($user_username,'<br>');
					}
				?>
				<td class="work-detail-txtName">
					<div class="width-150-hidden">
						{!! $user_username !!}
					</div>
				</td>
			</tr>
			<?php  
					}
				}
			?>
		</tbody>
	</table>
</div>


<div id="wrapper-action-work-detail" {{ ($congviec && $congviec->user_id == session('user')['id'])? '' : 'hidden' }}>
	<div class="col-xs-2">
		<button type="button" class="btn btn-primary action-add-congviec_user">Thêm</button>
		<div id="modal_congviec_user" class="modal fade modal_congviec_user" role="dialog">
			<div class="modal-dialog">
	            <!-- Modal content-->
	            <div class="modal-content">
	                <div class="modal-header">
	                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                    <h4 class="modal-title">Phân công công việc</h4>
	                </div>
	                <div class="modal-body">
	                    <form id="form_congviec_user" action="" method="post" accept-charset="utf-8">
	                		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                        <input class="form-control" type="hidden" name="congviec_id_hidden" value="{{ isset($congviec) ? $congviec->id : '' }}">
	                        <div class="form-group">
	                        	<label>Nội dung công việc: </label>
	                        	<textarea class="form-control" name="noidung"></textarea>
	                        </div>
	                        <div class="form-group clearfix">
	                        	<div class="col-xs-6 pd_none_left">
							    	<label for="ngaybd">Ngày bắt đầu:</label>
							    	<input type="text" class="form-control datepicker" autocomplete="off" name="ngaybatdau" value="">
						    	</div>
						    	<div class="col-xs-6 pd_none_right">
							    	<label for="ngaykt">Ngày kết thúc:</label>
							    	<input type="text" class="form-control datepicker" autocomplete="off" name="ngayketthuc" value="">
						    	</div>
	                        </div>
	                        <div class="form-group">
								<label for="">Đơn vị:</label>
								<select class="form-control select_donvi" name="donvi">
									<option value="0">-- Chọn đơn vị --</option>
									@php $donvi = App\Models\Donvi::find(session('user')['donvi_id']); @endphp
									@if ($donvi)
										<option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
									@endif
                                ?> 
                                </select>
							</div>
	                        <div class="form-group nguoiphutrach">
								<label>Người phụ trách:</label>
								<button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --">
									<span class="multiselect-selected-text">-- Chọn --</span> 
									<b class="caret"></b>
								</button>
							</div>
	                    </form>
	                </div>
	                <div class="modal-footer">
	                    <button class="btn btn-primary btn_add_congviec_user" type="submit">Thêm</button>
	                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
	                </div>
	            </div>
	        </div>
		</div>
	</div>
	<div class="col-xs-2">
		<button type="button" class="btn btn-danger btn-delete-work-detail">Xóa</button>
	</div>
	<div class="col-xs-2">
		<button type="button" class="btn btn-success action-update-congviec_user">Cập nhật</button>
	</div>

	<div id="modal_UpdateCongViecCt" class="modal fade" role="dialog">
		<!-- load ajax form UpdateCongViecCt  -->
	</div>
</div>

<!-- Modal -->
<div id="model_edit_work" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

</div>

<div id="ChangeStatusCV" class="modal fade" role="dialog">
	
</div>

<script>

	$(window).load(function() {
		var congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
    	if ( typeof congviec_id === 'undefined' ) {
    		$('.container-work-detali').hide();
    		return false
    	}
	});
	
	$('#select-filter-placeholder').multiselect({
        enableFiltering: true,
        filterPlaceholder: 'Tìm kiếm ...'
    });

    $('.action-add-congviec_user').click(function(event) {
    	var congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
    	if ( typeof congviec_id === 'undefined' ) {
    		jAlert('Không thể thêm phân công công việc khi không có công việc!','Thông báo');
    		return false
    	}
    	$('#form_congviec_user').resetForm();
    	$('.nguoiphutrach').html('<label>Người phụ trách:</label> <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --"><span class="multiselect-selected-text">-- Chọn --</span> <b class="caret"></b></button>');
    	$('#modal_congviec_user').modal('show');
    });
	
	$('.btn_add_congviec_user').click(function(event) {
		$('#form_congviec_user').submit();
	});

	$(document).ready(function(){

		$('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });

		$("#form_congviec_user").validate({
            rules: {
                noidung: "required",
                user_username: "required",
                ngaybatdau: "required",
                ngayketthuc: "required",
            },
            messages: {
                noidung: "Vui lòng nhập nội dung",
                user_username: "Vui lòng chọn người làm",
                ngaybatdau: "Vui lòng nhập ngày bắt đầu",
                ngayketthuc: "Vui lòng nhập ngày kết thúc",
            }
        });

		$('#form_congviec_user').ajaxForm({
			url: "{{ url('/congviec_chitiet/ajaxAdd_workDetail') }}",
			type: 'get',
			dataType: 'json',
	        success: function(responseText)
	        {
	        	if (responseText.error == 1) {
	        		jAlert('<span style="color:#f03">Bạn chưa chọn người thực hiện công việc</span>','Thông báo');
	        		return false;
	        	}
	        	$('.modal_congviec_user').modal('hide')
	        	var congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
	        	axjaxLoadDetail_Congviec(congviec_id);
	        },
	        error: function(er){
	        	alert('Co loi xay ra');
	        }
		})

		$('.btn-delete-work-detail').click(function(event) {
			var congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
	    	if ( typeof congviec_id === 'undefined' ) {
	    		jAlert('Không có công việc để xóa!','Thông báo');
	    		return false
	    	}			
			var arr_val = '';

			jConfirm('Bạn có chắc chắn muốn xóa không ?','Thông báo',function(r){
				if (r == true) {
					$('table.pccv tbody tr').each(function(index, el) {
						$cm = $(this).find('input[name=congviec_detail_id]:checked');
						arr_val += $cm.val()+',';
						$cm.closest('tr').remove();
					});
					list_work_detail_id = arr_val.replace(/undefined,/g,'');
					if (list_work_detail_id == '') {
						jAlert('<span class="col_red">Bạn chưa chọn đối tượng cần xóa</span>','Thông báo');
						return false;
					}

					$.ajax({
						url: '{{ url("congviec_chitiet/delete_work_detail") }}',
						type: 'post',
						data: {
							'_token' : '{{ csrf_token() }}',
							'list_work_detail_id': list_work_detail_id
						},
						success: function(data){
							$('table.pccv tbody tr').each(function(index, el) {
								$(this).find('.stt-work-detail').text(index+1);
							});
						},
						error: function() {
							alert('Có lổi xảy ra');
						}
					})
				}else{
					return false;
				}
			});
			
		});

		$('.action-update-congviec_user').click(function(event) {
			var congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
	    	if ( typeof congviec_id === 'undefined' ) {
	    		jAlert('Không có công việc để cập nhật!','Thông báo');
	    		return false
	    	}
			var i = 0;
			var congviec_detail_id = $('input[name=congviec_detail_id]:checked').map(function(index, elem) {
				i++;
				return $(this).val()
			}).get();

			if (typeof congviec_detail_id === 'undefined' || congviec_detail_id == '') {
				jAlert('<span class="col_red">Hảy chọn một công việc để cập nhật</span>','Thông báo');
				return false;
			}

			if ( i > 1 ) {
				jAlert('<span class="col_red">Chỉ có thể chọn một công việc để cập nhật</span>','Thông báo');
				return false;
			}
			loading_show();
			$.ajax({
				url: '{{ url("congviec_chitiet/update_work_detail") }}',
				type: 'get',
				data: {
					congviec_detail_id: congviec_detail_id,
				},
				success: function(data){
					loading_hide();
					$('#modal_UpdateCongViecCt').html(data).modal('show');
				},
				error: function(){

				}
			})		
		});

		$('.edit_work_btn').click(function(event) {
			congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
			if ( typeof congviec_id !== 'undefined' ) {
				loading_show();
				$.ajax({
					url: '{{ url("congviec/sua_congviec") }}',
					type: 'GET',
					data: {congviec_id: congviec_id},
					success: function(data){
						loading_hide();
						$('#model_edit_work').html(data).modal('show');
					},
					error: function(er){
						alert('Co loi xay ra');
					}
				})
			}
		});

	})

</script>