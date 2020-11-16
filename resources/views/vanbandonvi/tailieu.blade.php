<div class="form-group work_files">
	<ul class="list-group" id="list_congviec_tailieu">

	</ul>
	<div class="loader"></div>
</div>
<form id="upload_docs_work_file" action="{{ url('congviec_chitiet/ajaxUploadDocs_workDetail') }}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div id="file_cv">
		<input type="hidden" name="congviec_id_hidden" value="{{ sizeof($congviec) > 0 ? $congviec->id : '' }}"> 
		<div class="form-group">
	    	<label>Thêm file đính kèm</label>
	    	<p style="font-size: 12px;">
	    		<i>Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M</i>
	    	</p>
	    	<input type="file" class="btn btn-success" name="file_work_detail[]" value="File đính kèm" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" multiple="">
	    </div>
	</div>
</form>

<script>

	$(document).ready(function(){

		$('nav ul li a[href="#document-tab"]').click(function(event) {
		congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
			if ( typeof congviec_id !== 'undefined' ){
				$('#upload_docs_work_file').show();
				$('#upload_docs_work_file input[name=congviec_id_hidden]').val(congviec_id);
				$.ajax({
					url: '{{ url("congviec_chitiet/ajaxLoad_document") }}',
					type: 'GET',
					data: {congviec_id: congviec_id},
					success: function(data){
						$('#list_congviec_tailieu').html(data);
					},
					error: function(er){
						alert('Co loi xay ra');
					}
				})
			}else{
				$('#upload_docs_work_file').hide();
			}
		});

		$('#upload_docs_work_file input[type=file]').change(function(event) {
			congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
			if ( typeof congviec_id !== 'undefined' ){
				$('.loader').show('fast');
				$('#upload_docs_work_file').submit();
			}else{
				jAlert('Vui lòng tạo công việc có thể tải lên tài liệu','Thông báo');
				event.target.value = '';
			}
		});

		$('#upload_docs_work_file').ajaxForm({
			url: "{{ url('congviec_chitiet/ajaxUploadDocs_workDetail') }}",
			type: 'post',
			success: function(data){
				$('.loader').hide();
				jAlert('Tải lên thành công','Thông báo');
				$('.work_files ul.list-group').append(data)
				$('#upload_docs_work_file').resetForm();
			},
			error: function(er){
				alert('Có lổi xảy ra');
			}
		});

		remove_file_upload('.work_files');

		function remove_file_upload(el){
			$(el).on('click', '#list_congviec_tailieu .list-group-item .badge', function(event) {
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