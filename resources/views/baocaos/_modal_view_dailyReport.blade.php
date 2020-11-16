<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Xem chi tiết báo cáo</h4>
</div>
<div class="modal-body">
  <div class="form-group">
      <label for="">Nội dung báo cáo</label>
      <div class="form-control" style="height: auto;">{!! $dailyReport->content !!}</div>
  </div>
  @if( $dailyReport->file != null )
  <div class="form-group">
      <label for="">File đính kèm</label>
      <div class="form-control">
		<a download="" href="{{ url('') }}/{{ $dailyReport->file }}">{{ $dailyReport->file }}</a>
      </div>
  </div>
  @endif
</div>
