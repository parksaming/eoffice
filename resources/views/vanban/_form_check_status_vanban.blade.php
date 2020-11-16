@if ($vanbanxuly)
    <form id="FormChangeVBStatus" action="{{ route('vanban.cap_nhat_trang_thai_xu_ly') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header " style="background:#01b2d2">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title styleH">Xử lý văn bản</h3>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="{{ $vanbanxuly->id }}" name="vanbanxuly_id">
                    <div class="row" style="display: flex; margin-bottom: 20px;">
                        <div class="col-sm-3" style="position: relative;top: 10px;">Tình trạng: <span style="color: red">(*)</span></div>
                        <div class="col-sm-9">
                            <select class="browser-default custom-select select-vanban-status" id="status" name="status">
                                <option value="">Chọn tình trạng</option>
                                <option value="1" {{ $vanbanxuly->status == 1? 'selected' : '' }}>Chưa xử lý</option>
                                <option value="2" {{ $vanbanxuly->status == 2? 'selected' : '' }}>Đang xử lý</option>
                                <option value="3" {{ $vanbanxuly->status == 3? 'selected' : '' }}>Đã xử lý</option>
                            </select>
                        </div>
                    </div>

                    @if ($vanbanxuly->parent_id)
                        <div class="row choose-completed {{ $vanbanxuly->status != 3? 'hidden' : '' }}" style="display: flex; margin-bottom: 20px;">
                            <div class="col-sm-3" style="position: relative;top: 10px;">Minh chứng: <span style="color: red">(*)</span></div>
                            <div class="col-sm-9">
                                <textarea name="minhchung" {{ $vanbanxuly->status != 3? 'disabled' : '' }} class="form-control choose-completed-item" cols="30" rows="5">{{ $vanbanxuly->minhchung }}</textarea>
                            </div>
                            <div class="clearfix"></div>
                        </div>
    
                        @if ($vanbanxuly->file_minhchung)
                            <div class="row choose-completed {{ $vanbanxuly->status != 3? 'hidden' : '' }}" style="display: flex; margin-bottom: 20px; align-items: center;">
                                <div class="col-sm-3" style="position: relative;">File đính kèm đã có</div>
                                <div class="col-sm-9">
                                    <a href="{{ route('dowload.file', [$vanbanxuly->file_minhchung]) }}" target="_blank" title="{{ $vanbanxuly->file_minhchung }}">
                                        {{ $vanbanxuly->file_minhchung }}
                                    </a>
                                </div>
                            </div>
                        @endif
                        
                        <div class="row choose-completed {{ $vanbanxuly->status != 3? 'hidden' : '' }}" style="display: flex; margin-bottom: 20px;">
                            <div class="col-sm-3" style="position: relative;top: 10px;">File đính kèm</div>
                            <div class="col-sm-9">
                                <input type="file" name="file" {{ $vanbanxuly->status != 3? 'disabled' : '' }} class="btn btn-success choose-completed-item" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf,.jpg,.png,.gif,.pdf" style="width: 100%;text-align: left;">
                            </div>
                        </div>
    
                        @if ($check)
                            <div class="row choose-completed {{ $vanbanxuly->status != 3? 'hidden' : '' }}" style="display: flex; margin-bottom: 20px;">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label style="color: red;font-style: italic;font-weight: normal;">Không thể cập nhật trạng thái đã xử lý! Có văn bản chuyển tiếp trong luồng chưa xử lý xong. <br>Hãy chọn "Cập nhật trạng thái xử lý văn bản cấp dưới" để có thể chuyển sang đã xử lý.</label>
                                    <label><input class="choose-completed-item" {{ $vanbanxuly->status != 3? 'disabled' : '' }} type="checkbox" style="display: inline-block" name="force_change" class="choose-completed-item" value="1"> Cập nhật trạng thái xử lý văn bản cấp dưới</label>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="modal-footer" style="border-top:0; ">
                    <button type="submit" class="btn btn-primary">Đồng ý</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $('.select-vanban-status').change(function () {
                    const status = $(this).val();
                    if (status == 3) {
                        $('.choose-completed .choose-completed-item').attr('disabled', false);
                        $('.choose-completed').removeClass('hidden');
                    }
                    else {
                        $('.choose-completed .choose-completed-item').attr('disabled', true);
                        $('.choose-completed').addClass('hidden');
                    }
                })

                $('#FormChangeVBStatus').validate({
                    rules: {
                        minhchung: 'required',
                        status: 'required',
                        force_change: 'required'
                    },
                    messages: {
                        minhchung: 'Hãy nhập minh chứng đã xử lý văn bản',
                        status: 'Hãy chọn trạng thái',
                        force_change: ''
                    },
                    submitHandler: function(form) {
                        loading_show();
                        form.submit();
                    }
                })
            })
        </script>
    </form>
@else
    <div style="color: red;">
        Có lỗi! Dũ liệu không tồn tại
    </div>
@endif
