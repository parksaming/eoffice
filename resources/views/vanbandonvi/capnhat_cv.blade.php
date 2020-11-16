<div class="form-content-2 pull-right" id="form-content-2">
	<div class="pull-right">
		<button type="button" class="form-control" id="close-btn1"><i class="fa fa-times-circle" aria-hidden="true"></i></button>
	</div>
	
	<div class="form-add-jobs">
			<div class="title">
				<h3>Cập nhật công việc</h3>
			</div>
			<nav class="tab-form">
				<ul class="nav nav-tabs">
					<li><a class="menu-tab-form" data-toggle="tab" href="#thongtin_cv1" rel="thongtin_cv1" title="">Thông tin chung</a></li>
					<li><a class="menu-tab-form" data-toggle="tab" href="#file_cv1" rel="file_cv1" title="">File công việc</a></li>
					<li><a class="menu-tab-form" data-toggle="tab" href="#chitiet_cv1" rel="chitiet_cv1" title="">Chi tiết công việc</a></li>
				</ul>
			</nav>
			{!! Form::model($congviec, array('route' => array('congviec.update', count($congviec) != 0 ? $congviec->id : ''),'files' => true, 'method' => 'PUT')) !!}
			<input type="hidden" value="{{ session('user')['id'] }}" name="user_id">
			<input type="hidden" value="{{ session('user')['username'] }}" name="user_username">
			
			<div class="tab-content">
				<div class="item-content tab-pane fade in active" id="thongtin_cv1">
					<div class="form-group">
						<div class="col-xs-6">
							<div class="form-group">
						    	<label for="macongviec">Mã công việc:</label>
						    	<input type="text" class="form-control" id="macongviec" name="macongviec" required>
						    </div>
						</div>
						<div class="col-xs-6">
						    <div class="form-group">
						    	<label for="tencongviec">Tên công việc:</label>
						    	<input type="text" class="form-control" id="tencongviec" name="tencongviec" required>
						    </div>
						</div>
					</div>
				    <div class="form-group">
				    	<div class="col-xs-6">
				    		<div class="form-group">
						    	<label for="nguoigiamsat">Người giám sát:</label>
						    	<select class="form-control" name="nguoigiamsat" required>
						    		<option value="" selected>Chọn người giám sát</option>
						    		<option value="Hoàng">Hoàng</option>
						    		<option value="Ngân">Ngân</option>
						    		<option value="Thủy">Thủy</option>
						    	</select>
						    </div>
						</div>
						<div class="col-xs-6">
							<?php $tinhchats = DB::table('tinhchats')->get(); ?>
						    <div class="form-group">
						    	<label for="tinhchat">Độ ưu tiên:</label>
						    	<select class="form-control" name="tinhchat" required>
						    		<option>Chọn độ ưu tiên</option>
						    		@foreach($tinhchats as $tinhchat)
						    		<option value="{{$tinhchat->name}}">{{ $tinhchat->name}}</option>
						    		@endforeach
						    	</select>
						    </div>	
				    	</div>
				    </div>
				    <div class="form-group">
				    	<div class="col-xs-6">
						    <div class="form-group">
						    	<label for="ngaybd">Ngày bắt đầu:</label>
						    	<input type="text" class="form-control" id="ngaybd" name="ngaybd" required>
						    </div>	
				    	</div>
				    	<div class="col-xs-6">
						    <div class="form-group">
						    	<label for="ngaykt">Ngày kết thúc:</label>
						    	<input type="text" class="form-control" id="ngaykt" name="ngaykt" required>
						    </div>	
				    	</div>
				    </div>
				    <div class="form-group">
				    	<label for="noidung">Nội dung:</label>
				    	<textarea type="text" class="form-control" name="noidung" required></textarea>
				    </div>
				    <div class="form-group">
				    	<label for="trangthai">Trạng thái:</label>
				    	<select name="trangthai" class="form-control" required>
				    		<option>Chọn trạng thái</option>
				    		<option value="Chưa thực hiện">Chưa thực hiện</option>
				    		<option value="Đang thực hiện">Đang thực hiện</option>
				    		<option value="Đã hoàn thành">Đã hoàn thành</option>
				    		<option value="Tạm dừng">Tạm dừng</option>
				    		<option value="Hủy bỏ">Hủy bỏ</option>
				    	</select>
				    </div>
				    <div class="form-group">
				    	<label for="mucdohoanthanh">Mức độ hoàn thành:</label>
				    	<input type="text" class="form-control" name="mucdohoanthanh" required>
				    </div>
				    <br>
				    <div class="form-group">
						<input style="position: relative; bottom: 25px; left: 0px;" type="submit" class="btn btn-warning" name="" value="Lưu">
					</div>
				</div>
				
				{!!Form::close() !!}

				@include('congviecs.capnhat_congviec_file')
				@include('congviecs.capnhat_congviec_chitiet')
			</div>
	</div>
</div>