<form id="congviec_file" action="{{ url('congviec/congviec_file') }}" method="POST" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="item-content" id="file_cv">
		<div class="form-group">
	    	<label>File đính kèm</label>
	    	<p style="font-size: 12px;"><i>Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M</i></p>
	    	<input type="file" class="btn btn-success" name="file[]" value="File đính kèm" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" multiple="">
	    </div>
	    <div class="form-group">
	    	<button type="button" class="btn btn-default">Hoàn thành</button>
	    </div>    
	    <div class="form-group" id="list_congviec_file" style="display: none;">
	    	<h5>Danh sách files công việc:</h5>
	    	<ul class="list-group">
	    	</ul>
	    </div>
	    <div class="loader"></div>
	</div>
</form>

<script>
		
	$(document).ready(function($) {
		$('#congviec_file button').click(function(event) {
			$('#close-btn').trigger('click');
		});

		$('#close-btn,#create,#congviec_file button').click(function(event) {
			$('#list_assignment_works,#list_congviec_file').hide('fast', function() {
				$(this).find('ul').html('');
			});
			$('#choose_supervisor').removeClass('selecting_ngs')
			$('#choose_supervisor').find('span').text('Chọn người giám sát');
			$('#choose_supervisor').find('input[name=nguoigiamsat]').val('');
			$('.select_donvi_of_nguoigiamsat').html('<option value="">-- Chọn người giám sát --</option>');
			$('#modal_choose_supervisor select.select_donvi_of_supervisor option:eq(0)').prop('selected', true);
		});

		remove_file_upload('#list_congviec_file');

		function remove_file_upload(id){
			$(id).on('click', '.list-group-item .badge', function(event) {
				congviec_file_id = $(this).attr('data-id');
				$(this).closest('.list-group-item').remove();
				$.post('{{ url("congviec_file/ajaxRemove_file") }}', 
					{
						congviec_file_id: congviec_file_id,
						_token: '{{ csrf_token() }}',
					}, 
					function(data, textStatus, xhr) {
					if (textStatus != 'success') {
						alert('Co loi xay ra');
					}
				});
			});
		}
	});

</script>