<form class="report_work_detail" action='{{ url("baocao/report_work_detail") }}' method="POST">
  {{ csrf_field() }}
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Báo cáo nhanh công việc</h4>
  </div>
  <div class="modal-body">
    <div class="form-group">
        <label>Tên công việc</label>
        <div class="form-control">{!! strip_tags($congviec_user->congviec->tencongviec) !!}</div>
    </div>
    <div class="form-group">
        <label for="">Công việc được phân công</label>
        <div class="form-control" style="height: auto;">
            {!! strip_tags($congviec_user->noidung) !!}
        </div>
    </div>
    <div class="form-group">
        <label for="">Tiến độ công việc</label>
        <select name="mucdohoanthanh" class="form-control">
            @for($i = 1; $i <= 10; $i++)
              <option {{ isset($congviec_user->congviec_baocao) && $congviec_user->congviec_baocao->mucdohoanthanh == ($i*10) ? 'selected' : '' }} value="{{ $i*10 }}">{{ $i*10 }}%</option>
            @endfor
        </select>
    </div>
    <div class="form-group">
        <label for="">Nội dung báo cáo</label>
        <textarea class="form-control" rows="3" name="noidung" placeholder="Nhập nội dung báo cáo">{!! isset($congviec_user->congviec_baocao) ? strip_tags($congviec_user->congviec_baocao->noidung) : '' !!}</textarea>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>
</form>

<script>
  
  $(document).ready(function(){
    $(".report_work_detail").validate({
        rules: {
            mucdohoanthanh: "required",
            noidung: "required",
        },
        messages: {
            mucdohoanthanh: "Vui lòng nhập tiến độ",
            noidung: "Vui lòng nhập nội dung",
        }
    });

    $('.report_work_detail').ajaxForm({
      url: '{{ url("baocao/report_work_detail") }}',
      type: 'post',
      data: { 'congviec_user_id[]': '{{ $congviec_user->id }}' },
      success: function(data){
        if (data == "ok") {
          flag = true;
          $('#modal_baocao_notifi').modal('hide');
          jAlert('Báo cáo công việc thành công','Thông báo');
          $('.notification ul.dropdown-menu li.temp').remove();
          $('.notification ul.dropdown-menu li[data-cv_chitiet_id="{{ $congviec_user->id }}"]').remove();
        }
      },
      error: function(er){
        alert('Có lổi xảy ra');
      }
    });

  })

</script>