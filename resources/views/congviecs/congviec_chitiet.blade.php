<div class="item-content" id="chitiet_cv">
	<input type="hidden" name="user_id" value="{{ session('user')['id'] }}">
	<input type="hidden" name="congviec_id" value="{{ $congviec->id }}">
	<div class="form-group">
		<label for="nd-chitiet">Nội dung chi tiết:</label>
		<textarea type="text" class="form-control" name="nd-chitiet"></textarea>
	</div>
	<div class="form-group">
		<label>Người phụ trách:</label>
		<select class="form-control" name="nguoiphutrach">
			<option value="">Chọn người phụ trách</option>
			<option value="">Lê Thị Thanh</option>
			<option value="">Trần Thị Như</option>
			<option value="">Trần Thị Thanh</option>
		</select>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
		    <div class="form-group">
		    	<label for="ngaybatdau">Ngày bắt đầu:</label>
		    	<input type="text" class="form-control" id="ngaybatdau" name="ngaybatdau">
		    </div>	
    	</div>
    	<div class="col-xs-6">
		    <div class="form-group">
		    	<label for="ngayketthuc">Ngày kết thúc:</label>
		    	<input type="text" class="form-control" id="ngayketthuc" name="ngayketthuc">
		    </div>	
    	</div>
	</div>
</div>