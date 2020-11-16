<form id="FormChangeStatusCV" action="{{ route('congviec.change_status') }}" method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header " style="background:#01b2d2">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="modal-title styleH">Cập nhật trạng thái công việc</h3>
			</div>
			<div class="modal-body">
				<input type="hidden" value="" name="vanbanxuly_id">
				<div class="row" style="display: flex">
					<div class="col-sm-3" style="position: relative;top: 10px;">Tình trạng: <span style="color: red">(*)</span></div>
					<div class="col-sm-9">
						<input type="hidden" name="congviec_id" value="{{ $congviec->id }}">
						<select class="browser-default custom-select" name="status">
							<option value="0" {{ $congviec->trangthai == 0? 'selected' : '' }}>Đang thực hiện</option>
							<option value="1" {{ $congviec->trangthai == 1? 'selected' : '' }}>Đã hoàn thành</option>
							<option value="2" {{ $congviec->trangthai == 2? 'selected' : '' }}>Tạm dừng</option>
							<option value="3" {{ $congviec->trangthai == 3? 'selected' : '' }}>Hủy bỏ</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer" style="border-top:0; ">
				<button type="submit" class="btn btn-primary">Đồng ý</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
			</div>
		</div>
	</div>

	<script>
		$('#FormChangeStatusCV').submit(function (e) {
			e.preventDefault();

			let congviec_id = $(this).find('input[name="congviec_id"]').val();
			let status = $(this).find('select[name="status"]').val();
			let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

			loading_show();
			$.ajax({
				url: '{{ route("congviec.change_status") }}',
				type: 'POST',
				data: {congviec_id: congviec_id, status: status, _token: CSRF_TOKEN},
				success: function(data) {
					$('#ChangeStatusCV').modal('hide');
					$('.btn-search-cong-viec').click();
				},
				error: function(er) {
					loading_hide();
					alert('Có lỗi xảy ra');
				}
			});
		});
	</script>
</form>