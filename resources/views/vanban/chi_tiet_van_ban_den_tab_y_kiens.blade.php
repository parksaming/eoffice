@php
$loggedUser = (object) session('user')
@endphp

<!-- button Thêm trao đổi -->
<div style="text-align: right; margin-bottom: 10px;">
    <a href="javascript:;" onclick="showModalFormAddYKien({{$vbxuly->id}})" class="btn btn-primary btn-show-form"><i class="fa fa-plus"></i> Thêm trao đổi</a>
</div>

<!-- danh sách trình lãnh đạo và ý kiến của mỗi trình lãnh đạo -->
<div>
    <table class="table table-bordered mg-t20">
        <thead class="head-table">

            <tr>
                <th>STT</th>
                <th>Thời gian</th>
                <th>Người tạo</th>
                <th>Người nhận</th>
                <th>Nội dung</th>
                <td>Tập tin</td>
                <th style="text-align: center; width: 60px;">Trả lời</th>
            </tr>
        </thead>
        <tbody>
            @if($ykiens)
                @php $stt = 1; @endphp
                <!-- danh sách ý kiến của vanbanxuly -->
                @foreach ($ykiens as $ykien)
                <tr>
                    <td class="col-stt">{{$stt++}}</td>
                    <td>{{$ykien->created_at}}</td>
                    <td>{{$ykien->userTao->fullname}}</td>
                    <td>
                        <div class="ds-usernhan" data-content="{{ $ykien->userNhansView }}">
                            {!! $ykien->userNhansViewShortText !!}
                        </div>
                    </td>
                    <td>{!!nl2br($ykien->noidung)!!}</td>
                    <td>
                        @php $files = @unserialize($ykien->file); @endphp
                        @if(is_array($files))
                            @foreach($files as $key => $file)
                            @if($key == 1) <br> @endif
                            <a download="" href="{{ url('local/files', $file) }}">{{ $file }}</a>
                            @endforeach
                        @else
                            <a download="" href="{{ url('local/files', $ykien->file) }}">{{ $ykien->file }}</a>
                        @endif
                    </td>
                    <td style="text-align: center; width: 60px;">
                        <a href="javascript:;" class="btn-reply" data-users="{{ json_encode($userIdsTrongLuong) }}"><i class="fa fa-reply-all" title="Trả lời tất cả"></i></a>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td colspan="6" align="center"><i>Không có dữ liệu</i></td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<div id="ModalFormYKien" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Trao đổi</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('trinh_lanh_dao.save_ykien') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="vanban_id" value="{{ $vbxuly->vanbanUser_id }}">
                    <input type="hidden" name="vanbanxuly_id" value="">

                    <div style="margin-bottom: 10px;">Người nhận</div>
                    <div style="margin-bottom: 15px;">
                        <select name="receiver_ids[]" class="form-control chosen" multiple>
                            @foreach ($userReceivers as $val)
                                <option value="{{ $val->id }}">{{ $val->fullname.($val->chucdanh? ' - '.$val->chucdanh.' - ' : '').$val->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 10px;">Nội dung</div>
                    <div style="margin-bottom: 15px;">
                        <textarea class="form-control" name="noidung" cols="30" rows="5" placeholder="Nhập nội dung ý kiến"></textarea>
                    </div>

                    <div class="form-group">
                        <input name="file[]" type="file" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" id="inputFile" multiple="">
                    </div>
                    <div style="text-align: right;margin-top: 15px;">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ModalFormPhanHoi" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Phản hồi</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('trinh_lanh_dao.save_ykien') }}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="id" value="">
                    <input type="hidden" name="vanban_id" value="{{ $vbxuly->vanbanUser_id }}">
                    <input type="hidden" name="vanbanxuly_id" value="">

                    <div style="margin-bottom: 10px;">Người nhận</div>
                    <div style="margin-bottom: 15px;">
                        <select name="receiver_ids[]" class="form-control chosen" multiple>
                            @foreach ($userReceivers as $val)
                                <option value="{{ $val->id }}">{{ $val->fullname.($val->chucdanh? ' - '.$val->chucdanh.' - ' : '').$val->email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="margin-bottom: 10px;">Nội dung</div>
                    <div style="margin-bottom: 15px;">
                        <textarea class="form-control" name="noidung" cols="30" rows="5" placeholder="Nhập nội dung ý kiến"></textarea>
                    </div>

                    <div class="form-group">
                        <input name="file[]" type="file" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" id="inputFile" multiple="">
                    </div>
                    <div style="text-align: right;margin-top: 15px;">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ModalDSUserNhan" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách người nhận</h4>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>

<style>
    .ds-usernhan {
        cursor: pointer;
    }
    .usernhands {
        margin-bottom: 8px;
    }
    .usernhan-name::after {
        content: ', ';
    }
    .usernhands-read {
        float: right;
        font-size: 12px;
        font-style: italic;
    }
    .chosen-container-multi .chosen-choices li.search-field input[type="text"].default {
        width: 190px !important;
    }
</style>
<script>
    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', 'placeholder_text_multiple': 'Chọn một hoặc nhiều người', width: '100%', search_contains:true});

    $('.ds-usernhan').click(function () {
        let content = $(this).attr('data-content');
        let $modalDSUserNhan = $('#ModalDSUserNhan');

        $modalDSUserNhan.find('.modal-body').html(content);
        $modalDSUserNhan.modal('show');
    });

    $('.btn-reply').click(function () {
        let $modalFormYKien = $('#ModalFormPhanHoi');
        let $selectUserNhans = $modalFormYKien.find('select[name="receiver_ids[]"]');

        $modalFormYKien.find('form')[0].reset();

        $selectUserNhans.val( $(this).data('users') );
        $selectUserNhans.trigger("chosen:updated");

        $modalFormYKien.modal('show');
    });

    function showModalFormAddYKien(vanbanxulyId) {
        let $modal = $('#ModalFormYKien');

        $modal.find('form')[0].reset();
        
        $modal.find('select[name="receiver_ids[]"]').trigger("chosen:updated");

        $modal.find('input[name="vanbanxuly_id"]').val(vanbanxulyId);

        $modal.modal('show');
    }
</script>