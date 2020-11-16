  	<div class="head_work">
  		<h3 style="float: none;">
	  		<span>Soạn thảo báo cáo</span>
	  	</h3>
	</div>
	<form action="{{ url('congviec/draft_report') }}" id="form_draft_report" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="form-group clearfix">
			<div class="col-md-3">
				<label for="">Kèm công việc</label>
			</div>
			<div class="col-md-9 thumb_work">
				<input onkeyup="f_work_search($(this).val())" type="text" class="form-control search_congviecUser" placeholder="Nhập từ khóa công việc...">
				<input type="hidden" name="congviec_user_id">
				<ul class="list_result_work_search">
				</ul>
				<div class="btn btn-default all_work_user">tất cả</div>
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-3">
				<label for="">Nội dung</label>
			</div>
			<div class="col-md-9">
				<textarea name="content" class="form-control summernote" placeholder="Nhập nội dung báo cáo..."></textarea>
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-3">
				<label for="">File đính kèm</label>
			</div>
			<div class="col-md-9">
				<input name="file" type="file" class="form-control">
				<em style="font-size: 12px">Chỉ upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M</em>
			</div>
		</div>
		<div class="form-group clearfix">
			<div class="col-md-9 col-md-offset-3">
				<input class="btn btn-default" type="submit" value="Gửi báo cáo">
			</div>
		</div>
	</form>

