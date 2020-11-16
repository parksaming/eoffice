<form id="form_Agreement_notifi" action='{{ url("baocao/agreement_report") }}' method="POST">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Duyệt và đánh giá báo cáo công việc</h4>
    </div>
    <div class="modal-body">
    	<?php  
    		$_congviec = App\CongViec::find($congviec_baocao->congviec_chitiet->congviec_id);
    	?>
    	<div class="form-group">
            <label>Tên công việc</label>
            <div class="form-control">{!! $_congviec->tencongviec !!}</div>
        </div>
        <div class="form-group">
            <label>Công việc được phân công</label>
            <div class="form-control" style="height: auto;">{!! strip_tags($congviec_baocao->congviec_chitiet->noidung) !!}</div>
        </div>
        <div class="form-group">
            <label>Tiến độ công việc</label>
            <div class="form-control">{!! $congviec_baocao->mucdohoanthanh !!}%</div>
        </div>
        <div class="form-group">
            <label>Nội dung báo cáo</label>
            <div class="form-control">{!! strip_tags($congviec_baocao->noidung) !!}</div>
        </div>
        @if( !isset($view_report_detail) )
        <div class="form-group">
            <label>Đánh giá báo cáo công việc</label>
            <textarea class="form-control" name="assessment" placeholder="Nhập đánh giá báo cáo công việc"></textarea>
        </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-not">Không duyệt</button>
        <button type="submit" class="btn btn-primary">Duyệt báo cáo</button>
    </div>

</form>

<script>
	
	$(document).ready(function(){
		$('#form_Agreement_notifi .btn-not').click(function(event) {
			jConfirm('Bạn có chắc chắn <span style="color:#f03">không duyệt</span> báo cáo này','Thông báo',function(r){
				if (r == false) {
					return false;
				}else{
					$.ajax({
					  url: '{{ url("baocao/agreement_report") }}',
					  type: 'POST',
					  dataType: 'json',
					  data: {
					  	assessment: 'no',
					  	congviec_baocao_id: '{{ $congviec_baocao->id }}',
					  	_token: '{{ csrf_token() }}',
					  },
					  success: function(data, textStatus, xhr) {
					  	$('#modal_agreement_report').modal('hide');
					    jAlert('Bạn đã không duyệt báo cáo','Thông báo');
					    var congviec_user_count = $('.notification .congviec_user_count').text();
			            $('.notification .congviec_user_count').text(congviec_user_count - 1);
			            $('.notification ul.dropdown-menu li.temp').remove();
					  },
					  error: function(xhr, textStatus, errorThrown) {
					    alert('co loi xay ra');
					  }
					});
				}
			});
		});

		$('#form_Agreement_notifi').ajaxForm({
			url: '{{ url("baocao/agreement_report") }}',
			type: 'POST',
			data: { congviec_baocao_id: '{{ $congviec_baocao->id }}' },
			dataType: 'json',
			success: function(data){
				if (data.assessment != '')
				$('.duyet_baocao a[data-id='+data.congviec_baocao_id+'] span').text('Đã duyệt');
				$('#modal_agreement_report').modal('hide');
				jAlert('Duyệt báo cáo thành công','Thông báo');
	            $('.notification ul.dropdown-menu li.temp').remove();
			},
			error: function(er){
				alert('co loi xay ra');
			}
		})
	})

</script>
