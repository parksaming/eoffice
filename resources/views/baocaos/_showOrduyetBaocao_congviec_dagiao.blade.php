@if( count($congviec_users) > 0 )
<table class="table table-bordered" style="margin-top: 20px;">
	<thead>
		<tr>
			<th>STT</th>
			<th>Người báo cáo</th>
			<th>Trạng thái</th>
			<th>Duyệt</th>
			<th>Xem</th>
		</tr>
	</thead>
	<tbody>
		@foreach( $congviec_users as $key => $congviec_user)
		<?php  
		$congviec_baocao = App\Congviec_Baocao::where([
			['congviec_user_id',$congviec_user->id],
			['username',$congviec_user->user_username]
		]);
		?>
		<tr>
			<td>{{ $key+1 }}</td>
			<td>
				<?php  
					$user = \App\User::where('username',$congviec_user->user_username)->first();
				?>
				@if( count($user) > 0 )
				{{ $user->fullname }}
				@else
				{{ $congviec_user->user_username }}
				@endif
			</td>
			<td>
				@if( $congviec_baocao->count() > 0 )
					{!! 'Đã báo cáo' !!}
				@else
					{!! 'Chưa báo cáo' !!}
				@endif
			</td>
			<td class="duyet_baocao">
				@if( $congviec_baocao->count() > 0 )
					<a href="javascript:;" data-id = "{{ $congviec_baocao->first()->id }}" {!! $congviec_baocao->first()->assessment == 'no' ? 'style="color: #f03;"' : '' !!}>
						<i class="fa fa-check"></i>
						<span>
							@if($congviec_baocao->first()->assessment == NULL)
								Duyệt
							@elseif($congviec_baocao->first()->assessment == 'no')
								Không duyệt
							@else
								Đã duyệt
							@endif
						</span>
					</a>
				@else
					<i class="fa fa-check"></i> Duyệt
				@endif
				
			</td>
			<td class="xem_baocao">					
				@if( $congviec_baocao->count() > 0 )
					<a href="javascript:;" data-id = "{{ $congviec_baocao->first()->id }}">
						<i class="fa fa-eye"></i> Xem
					</a>
				@else
					<i class="fa fa-eye"></i> Xem
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div class="modal fade" id="modal_viewDetail_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- modal_viewDetail_report -->
</div>

<div class="modal fade" id="modal_Agreement_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Duyệt báo cáo công việc</h4>
      </div>
      <div class="modal-body">
      	<form action="" id="form_Agreement_report">
      		{{ csrf_field() }}
      		<input type="hidden" name="congviec_baocao_id">
		  <div class="form-group">
		    <label for="">Đánh giá báo cáo</label>
		    <textarea class="form-control" rows="3" name="assessment" placeholder="Nhập đánh giá báo cáo công việc..."></textarea>
		  </div>
		  <div class="form-group" style="text-align: right;">
		  	<input type="submit" value="Duyệt" class="btn btn-primary" style="margin-right: 15px;">
		  	<button type="button" class="btn btn-default btn-no2">Không duyệt</button>
		  </div>
		</form>
      </div>
    </div>
  </div>
</div>

<script>
	
	$('#report-tab').on('click', '.xem_baocao a', function(event) {
		data_id = $(this).attr('data-id');
		$.ajax({
			url: '{{ url("baocao/viewDetail_report") }}',
			type: 'POST',
			data: {data_id: data_id, _token: '{{ csrf_token() }}'},
			success: function(data){
				$('#modal_viewDetail_report').html(data);
				$('#modal_viewDetail_report').modal('show');
			},
			error: function(er){
				alert('co loi xay ra');
			}
		})
	});

	$('.duyet_baocao a').click(function(event) {
		var data_id = $(this).attr('data-id');
		$('#modal_Agreement_report input[name=congviec_baocao_id]').val(data_id);
		$('#modal_Agreement_report').modal('show');
	});

	$('#form_Agreement_report .btn-no2').click(function(event) {
		var congviec_baocao_id = $('#modal_Agreement_report input[name=congviec_baocao_id]').val();
		jConfirm('Bạn có chắc chắn không duyệt báo cáo này','Thông báo',function(r){
			$('#modal_Agreement_report').modal('hide');
			if (r == false) {
				return false
			}else{
				$.ajax({
				  url: '{{ url("baocao/agreement_report") }}',
				  type: 'POST',
				  dataType: 'json',
				  data: {
				  	assessment: 'no',
				  	congviec_baocao_id: congviec_baocao_id,
				  	_token: '{{ csrf_token() }}',
				  },
				  success: function(data, textStatus, xhr) {
				  	if (data.assessment == 'no')
					$('.duyet_baocao a[data-id='+data.congviec_baocao_id+'] span').html('<span style="color:#f03">Không duyệt</span>');
				    var congviec_user_count = $('.notification .congviec_user_count').text();
		            $('.notification .congviec_user_count').text(congviec_user_count - 1);
		            $('.notification ul.dropdown-menu li[data-congviec_baocao_id="'+congviec_baocao_id+'"]').remove();
				  },
				  error: function(xhr, textStatus, errorThrown) {
				    alert('co loi xay ra');
				  }
				});
			}
		});	
		return false;
	});
    
	$('#form_Agreement_report').ajaxForm({
		url: '{{ url("baocao/agreement_report") }}',
		type: 'POST',
		dataType: 'json',
		success: function(data){
			if (data.assessment != '')
			$('.duyet_baocao a[data-id='+data.congviec_baocao_id+'] span').text('Đã duyệt');
			$('#modal_Agreement_report').modal('hide');
			$('#form_Agreement_report').resetForm();
			jAlert('Duyệt báo cáo thành công','Thông báo');
			var congviec_user_count = $('.notification .congviec_user_count').text();
            $('.notification .congviec_user_count').text(congviec_user_count - 1);
            $('.notification ul.dropdown-menu li[data-congviec_baocao_id="'+$('#modal_Agreement_report input[name=congviec_baocao_id]').val()+'"]').remove();
		},
		error: function(er){
			alert('co loi xay ra');
		}
	})

</script>
@else

<p style="margin-top: 20px; text-align: center;">
	<em>Chưa có thành viên báo cáo công việc</em>
</p>


@endif

