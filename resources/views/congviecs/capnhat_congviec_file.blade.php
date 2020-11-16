<div class="item-content tab-pane fade" id="file_cv1">
	{!! Form::model(array('route' => array('congviecfile.update'),'files' => true, 'method' => 'PUT')) !!}
		<input type="hidden" name="congviec_id" value="{{ count($congviec) != 0 ? $congviec->id : '' }}">
		<div class="form-group">
	    	<label>File đính kèm</label>
	    	<p style="font-size: 12px;"><i>Chỉ cho upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M</i></p>
	    	<input style="width: 117px;" type="file" class="btn btn-success" name="file" value="File đính kèm">
	    </div>
	    <div class="form-group">
	    	<button style="position: relative; bottom: 0px; left: 0px;" type="submit" class="btn btn-warning">Lưu</button>
	    </div>	
    {!! Form::close() !!}
</div>