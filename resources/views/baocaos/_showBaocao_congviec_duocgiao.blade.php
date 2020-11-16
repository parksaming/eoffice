@if( count($congviec_users) > 0 )

<form id="report_work_detail" method="POST">
	{{ csrf_field() }}
	<input type="hidden" name="congviec_id_hidden" value="{{ isset($congviec_id) ? $congviec_id : '' }}">
  <div class="form-group">
    <label for="">Công việc cần báo cáo</label>
    <ul class="list-group">
      @foreach($congviec_users as $key => $congviec_user)
      <?php  
      	$congviec_baocao = App\Congviec_Baocao::where([
      		['congviec_user_id',$congviec_user->id],
      		['username',$congviec_user->user_username]
      	]);
      ?>
      <li class="list-group-item">
        <div class="checkbox" style="{{ $key == 0 ? 'margin: 0' : '' }}">
          <label>
            <input type="checkbox" {{ ($congviec_baocao->count() == 0 || $congviec_baocao->first()->assessment == 'no') ? 'checked' : ''}} name="congviec_user_id[]" value="{{ $congviec_user->id }}"> {!! strip_tags($congviec_user->noidung) !!} <br>
            <em style="font-size: 12px">Trạng thái:
            @if( $congviec_baocao->count() == 0 )
  			     {!! 'chưa báo cáo' !!}
            @elseif( $congviec_baocao->first()->assessment == "" )
  			     {!! 'đang chờ duyệt' !!}
            @elseif( $congviec_baocao->first()->assessment == 'no' )
              {!! '<span style="color: #f03">Không duyệt</span>' !!}
            @else
              {!! 'đã duyệt' !!}
            @endif
            </em>
          </label>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
    <div class="form-group">
        <label for="mucdohoanthanh">Trạng thái công việc</label>

        <select name="status" class="form-control">
            <option value="1" @if($congviec_user->status==1) selected="selected" @endif>Chưa xử lý</option>
            <option value="2" @if($congviec_user->status==2) selected="selected" @endif>Đang xử lý</option>
            <option value="3" @if($congviec_user->status==3) selected="selected" @endif>Đã xử lý</option>
        </select>
    </div>
  <div class="form-group">
    <label for="mucdohoanthanh">Tiến độ công việc</label>
    <select name="mucdohoanthanh" class="form-control">
        @for($i = 1; $i <= 10; $i++)
            <option {{ isset($congviec_user->congviec_baocao) && $congviec_user->congviec_baocao->mucdohoanthanh == ($i*10) ? 'selected' : '' }} value="{{ $i*10 }}">{{ $i*10 }}%</option>
        @endfor
    </select>
  </div>
  <div class="form-group">
    <label for="">Nội dung</label>
    <textarea class="form-control" rows="3" name="noidung" placeholder="Nhập nội dung báo cáo">{!! isset($congviec_user->congviec_baocao) ? strip_tags($congviec_user->congviec_baocao->noidung) : '' !!}</textarea>
  </div>
    <div class="form-group">
        <label for="">File đính kèm</label>
        @if ($congviec_user->congviec_baocao && $congviec_user->congviec_baocao->file)
            <div class="group-file">
                <div class="file-container">
                    <a href="{{ route('dowload.file', $congviec_user->congviec_baocao->file) }}" target="_blank" title="{{ $congviec_user->congviec_baocao->file }}">
                        {{ $congviec_user->congviec_baocao->file }}
                    </a>
                    <a class="remove-file" href="javascript:;"><i class="fa fa-times red"></i></a>
                </div>
                <input class="hidden" type="file" name="file">
            </div>
        @else
            <input type="file" name="file">
        @endif
    </div>
  <button type="submit" class="btn btn-default">Gửi</button>
</form>

<script>
	
	$("#report_work_detail").validate({
        rules: {
            mucdohoanthanh: "required",
            noidung: "required",
        },
        messages: {
            mucdohoanthanh: "Vui lòng nhập tiến độ",
            noidung: "Vui lòng nhập nội dung",
        }
    });

    $('#report_work_detail').ajaxForm({
    	url: '{{ url("baocao/report_work_detail") }}',
    	type: 'POST',
    	success: function(data){
    		if (data == "ok") {
          $('#report_work_detail input[type=checkbox]').prop('checked', false);
    			jAlert('Báo cáo công việc thành công','Thông báo');
    			$('#report_work_detail input[type=checkbox]:checked').closest('label').find('em').text('( đang chờ duyệt )');
    		}else{
    			jAlert('<span style="color: #f03">Vui lòng chọn công việc báo cáo!</span>','Thông báo')
    		}
    	},
    	error: function(er){
    		alert('Có lổi xảy ra');
    	}
    });

</script>

@endif