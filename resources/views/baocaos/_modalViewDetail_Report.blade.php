<!-- Modal -->

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Xem báo cáo công việc</h4>
        </div>
        <div class="modal-body">
            <form action="">
                <div class="form-group">
                    <label>Nội dung công việc</label>
                    <div class="form-control" style="height: auto;">
                        {!! strip_tags($congviec_user->noidung) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label>Trạng thái công việc</label>
                    <div class="form-control" style="height: auto;">
                        @if($congviec_user->status==1)
                            Chưa xử lý
                        @elseif($congviec_user->status==2)
                            Đang xử lý
                        @elseif($congviec_user->status==3)
                            Đã xử lý1
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Tiến độ công việc (%)</label>
                    <div class="form-control">
                        {{ $congviec_baocao->mucdohoanthanh }}%
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Nội dung báo cáo</label>
                    <div class="form-control">{!! strip_tags($congviec_baocao->noidung) !!}</div>
                </div>

                @if ($congviec_baocao->file)
                    <div class="form-group">
                        <label>File đính kèm</label>
                        <div>
                            <a href="{{ route('dowload.file', $congviec_baocao->file) }}" target="_blank" title="File đính kèm">
                                {{ $congviec_baocao->file }}
                            </a>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

