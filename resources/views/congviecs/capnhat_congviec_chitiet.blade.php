<div class="item-content tab-pane fade" id="chitiet_cv1">
{!! Form::model( array('route' => array('congviec_chitiet.update'),'files' => true, 'method' => 'PUT')) !!}
	<input type="hidden" name="user_id" value="{{ session('user')['id'] }}">
	<input type="hidden" name="congviec_id" value="{{ count($congviec) != 0 ? $congviec->id : '' }}">
	<div class="form-group">
		<label for="nd-chitiet">Nội dung chi tiết:</label>
		<textarea type="text" class="form-control" name="nd-chitiet" required></textarea>
	</div>
	<div class="form-group">
		<label>Người phụ trách:</label>
		<select class="form-control" name="nguoiphutrach" required>
			<option value="">Trần Thị Như</option>
			<option value="">Lê Thị Thanh</option>
		</select>
	</div>
	<div class="form-group">
		<div class="col-xs-6">
		    <div class="form-group">
		    	<label for="ngaybatdau">Ngày bắt đầu:</label>
		    	<input type="text" class="form-control" id="ngaybatdau" name="ngaybatdau" required>
		    </div>	
    	</div>
    	<div class="col-xs-6">
		    <div class="form-group">
		    	<label for="ngayketthuc">Ngày kết thúc:</label>
		    	<input type="text" class="form-control" id="ngayketthuc" name="ngayketthuc" required>
		    </div>	
    	</div>
	</div>
	<div class="item-bottom">
		<button type="submit" class="btn btn-primary">Thêm</button>
		<button type="button" class="btn btn-danger" id="close1">Hủy</button>
	</div>
{!! Form::close() !!}
</div>
