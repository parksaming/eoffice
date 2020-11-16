<div class="form-content pull-right" id="form-content" style="height: 600px;">
    <div class="form-add">
        <div class="wizard">
            <div class="title create_work_title">
                <i id="close-btn" class="fa fa-times-circle" aria-hidden="true"></i>
                <h3 style="text-align: center;">Tạo công việc</h3>
            </div>
            <div class="wizard-inner">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active tab_step1">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab">Công việc chung
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab">Phân công công việc
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab">File công việc
                        </a>
                    </li>
                </ul>
            </div>
            <div role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <div class="tab-content">
                            <div class="item-content" id="thongtin_cv">
                                <form id="create_work" action="{{ url('congviec/chung') }}" method="POST"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ session('user')['username'] }}" name="user_username">
									<input type="hidden" value="{{ session('user')['user_id_login'] }}" name="user_id">
									<input type="hidden" value="{{ (isset($vanbanxuly) && $vanbanxuly)? $vanbanxuly->id : '' }}" name="vanbanxuly_donvi_id">
                                    <div class="form-group">
                                        <div class="col-xs-12 nopadding">
                                            <div class="form-group">
                                                <label for="tencongviec">Tên công việc:</label>
                                                @if ((isset($vanbanxuly) && $vanbanxuly))
                                                    <input type="text" class="form-control" id="tencongviec" name="tencongviec" value="Công việc theo VB: {{ trim($vanbanxuly->title) }}">
                                                @else
                                                    <input type="text" class="form-control" id="tencongviec" name="tencongviec" value="">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6 pd_none_left">
                                            <?php $tinhchats = DB::table('tinhchats')->get(); ?>
                                            <div class="form-group">
                                                <label for="tinhchat">Độ ưu tiên:</label>
                                                <select class="form-control" name="tinhchat">
                                                    @foreach($tinhchats as $tinhchat)
                                                        <option value="{{$tinhchat->name}}">{{ $tinhchat->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 pd_none_right">
                                            <div class="form-group">
                                                <label for="trangthai">Trạng thái:</label>
                                                <select name="trangthai" class="form-control">
                                                    <option value="Chưa thực hiện">Chưa thực hiện</option>
                                                    <option value="Đang thực hiện">Đang thực hiện</option>
                                                    <option value="Đã hoàn thành">Đã hoàn thành</option>
                                                    <option value="Tạm dừng">Tạm dừng</option>
                                                    <option value="Hủy bỏ">Hủy bỏ</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-6 pd_none_left">
                                            <div class="form-group">
                                                <label for="nguoigiamsat">Người giám sát:</label>
                                                <div id="choose_supervisor" class="form-control">
                                                    <span>Chọn người giám sát</span>
                                                    <input type="hidden" name="nguoigiamsat">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 pd_none_right">
											<div class="form-group">
												<label for="nguoiphoihop">Người phối hợp:</label>
												<div id="choose_supporter" class="form-control">
													<span>Chọn người phối hợp</span>
													<input type="hidden" name="nguoiphoihop">
												</div>
											</div>
										</div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-xs-6 pd_none_left">
                                            <div class="form-group">
                                                <label for="ngaybd">Ngày bắt đầu:</label>
                                                <input type="text" class="form-control" id="ngaybd" name="ngaybd" autocomplete="off" value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 pd_none_right">
                                            <div class="form-group">
                                                <label for="ngaykt">Ngày kết thúc:</label>
                                                <input type="text" class="form-control" id="ngaykt" name="ngaykt" autocomplete="off" value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="noidung">Nội dung:</label>
                                        @if ((isset($vanbanxuly) && $vanbanxuly))
                                            <textarea type="text" class="form-control" name="noidung">Công việc theo VB: {{ trim($vanbanxuly->title) }}</textarea>
                                        @else
                                            <textarea type="text" class="form-control" name="noidung"></textarea>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button id="create_joint_work" type="button" class="btn btn-default">Lưu
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <div class="item-content" id="chitiet_cv">
                            <form id="congviec_phancong" action="{{ url('congviec/phancong') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="nd-chitiet">Nội dung chi tiết:</label>
                                    <textarea type="text" class="form-control"
                                              name="nd_chitiet">{{ old('nd_chitiet') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Đơn vị:</label>
                                    <select class="form-control select_donvi" name="donvi">
                                        <option value="0">-- Chọn đơn vị --</option>
                                        @php $donvi = App\Models\Donvi::find(session('user')['donvi_id']); @endphp
                                        @if ($donvi)
                                            <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group nguoiphutrach">
                                    <label>Người phụ trách:</label>
                                    <button type="button" class="multiselect dropdown-toggle btn btn-default"
                                            data-toggle="dropdown" title="-- Chọn --">
                                        <span class="multiselect-selected-text">-- Chọn --</span>
                                        <b class="caret"></b>
                                    </button>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="col-xs-6 pd_none_left">
                                        <label for="ngaybatdau">Ngày bắt đầu:</label>
                                        <input type="text" class="form-control" id="ngaybatdau" name="ngaybatdau" autocomplete="off"
                                               value="{{ old('ngaybatdau') }}">
                                    </div>
                                    <div class="col-xs-6 pd_none_right">
                                        <label for="ngayketthuc">Ngày kết thúc:</label>
                                        <input type="text" class="form-control" id="ngayketthuc" name="ngayketthuc" autocomplete="off"
                                               value="{{ old('ngayketthuc') }}">
                                    </div>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input checked="" type="checkbox" name="add_continue"> Tiếp tục thêm công việc
                                        phân công
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-default">Lưu</button>
                                </div>
                            </form>
                            <div id="list_assignment_works">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Nội dung công việc</th>
                                        <th>Người nhận việc</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        @include('congviecs.congviecfile')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_choose_supervisor" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <h4 class="modal-title">Chọn người giám sát</h4>
			</div>
			<div class="modal-body">
			  <div class="form-group">
				  <label for="">Đơn vị:</label>
				  <select class="form-control select_donvi_of_supervisor" name="donvi">
					  <option value="0">-- Chọn đơn vị --</option>
					  @if (isset($donvis))
						  @foreach ($donvis as $donvi)
							  <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
						  @endforeach
					  @endif
				  </select>
			  </div>
			  <div class="form-group">
				  <label>Chọn người giám sát</label>
				  <select class="form-control select_donvi_of_nguoigiamsat">
					  <option value="">-- Chọn người giám sát --</option>
				  </select>
			  </div>
			</div>
	  </div>
	</div>
</div>

<div id="modal_choose_supporter" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Chọn người phối hợp</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label for="">Đơn vị:</label>
					<select class="form-control select_donvi_of_supporter" name="donvi">
						<option value="0">-- Chọn đơn vị --</option>
						@if (isset($donvis))
							@foreach ($donvis as $donvi)
								<option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label>Chọn người phối hợp</label>
					<select class="form-control select_donvi_of_nguoiphoihop">
						<option value="">-- Chọn người phối hợp --</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

    $(document).ready(function () {
        $(".ui-form-create-work").draggable();

        $('#create_joint_work').click(function (event) {
            $('#create_work').submit();
        });

        $("#create_work").validate({
            rules: {
                tencongviec: "required",
                ngaybd: "required",
                ngaykt: "required",
                noidung: "required",
                nguoigiamsat: "required",
                tinhchat: "required",
                trangthai: "required",
            },
            messages: {
                tencongviec: "Vui lòng nhập tên công việc",
                ngaybd: "Vui lòng nhập ngày bắt đầu",
                ngaykt: "Vui lòng nhập ngày kết thúc",
                noidung: "Vui lòng nhập nội dung",
                nguoigiamsat: "Vui lòng chọn người giám sát",
                tinhchat: "Vui lòng chọn độ ưu tiên",
                trangthai: "Vui lòng chọn trạng thái",
            }
        });

        $('#congviec_phancong').validate({
            rules: {
                nd_chitiet: "required",
                ngaybatdau: "required",
                ngayketthuc: "required",
                donvi: "required",
            },
            messages: {
                nd_chitiet: "Vui lòng nhập nội dung chi tiết",
                ngaybatdau: "Vui lòng nhập ngày bắt đầu",
                ngayketthuc: "Vui lòng nhập ngày kết thúc",
                donvi: "Vui lòng chọn đơn vị",
            }
        });

        $('#create_work').ajaxForm({
            url: '{{ url("congviec/chung") }}',
            type: 'get',
            dataType: 'json',
            success: function (data) {
                $('.wizard .nav-tabs > li[role="presentation"]').removeClass('active');
                $('.wizard .nav-tabs > li[role="presentation"]').eq(1).addClass('active');
                $('.wizard .tab-pane').removeClass('active');
                $('#step2').addClass('active');

                let params = {
                    get_view: 1,
                    // vanban_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                    vanban_donvi_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                    type: $('#SelectCVType').val(),
                    search: $('#InputCVSearch').val(),
                    date: $('#InputCVDate').val(),
                    status: $('#SelectCVStatus').val()
                };

                $.get("{{route('congviec.danhsach')}}", params, function(data) {
                    $('#congviec_table').html(data);
                });
                
                var congviec_id = data.congviec_id;
                axjaxLoadDetail_Congviec(congviec_id);
                $('#wrapper-action-work-detail,.container-work-detali').show();
            },
            error: function (er) {
                alert('Có lổi xảy ra');
            }
        });

        var $i = 1;
        $('#congviec_phancong').ajaxForm({
            url: '{{ url("congviec/phancong") }}',
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data == 'no_pt') {
                    jAlert('<span style="color:red">Chưa chọn người phụ trách</span>', 'Thông báo');
                } else {
                    if (data.session_congviec_id == 0) {
                        jAlert('Bạn phải tạo công việc chung trước', 'Thông báo');
                        return false;
                    }
                    if (data.add_continue != 'on') {
                        $('.wizard .nav-tabs > li[role="presentation"]').removeClass('active');
                        $('.wizard .nav-tabs > li[role="presentation"]').eq(2).addClass('active');
                        $('.wizard .tab-pane').removeClass('active');
                        $('#step3').addClass('active');
                    }

                    $('#congviec_phancong').resetForm();
                    resetMultiselect();
                    var html = '';
                    $.each(data.congviecCTs, function (index, item) {
                        html += '<tr>';
                        html += '<td>' + (index + 1) + '</td>';
                        html += '<td>' + item.noidung + '</td>';
                        html += '<td>' + item.listName_CongviecCT + '</td>';
                        html += '</tr>';
                    });

                    $('#list_assignment_works').show('fast', function () {
                        $(this).find('table tbody').html(html);
                    });

                    let params = {
                        get_view: 1,
                        // vanban_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                        vanban_donvi_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                        type: $('#SelectCVType').val(),
                        search: $('#InputCVSearch').val(),
                        date: $('#InputCVDate').val(),
                        status: $('#SelectCVStatus').val()
                    };

                    $.get("{{route('congviec.danhsach')}}", params, function(data) {
                        $('#congviec_table').html(data);
                    });
                    
                    var congviec_id = data.congviec_id;
                    axjaxLoadDetail_Congviec(congviec_id);
                }
            },
            error: function (er) {
                if (er.responseText == 'no_pt') {
                    jAlert('<span style="color:red">Chưa chọn người phụ trách</span>', 'Thông báo');
                } else {
                    alert('Có lổi xảy ra');
                }
            }
        })

        $('#congviec_file input[type=file]').on('change', function (event) {
            event.preventDefault();
            $('.loader').show('fast');
            $('#congviec_file').submit();
        });

        $('#congviec_file').ajaxForm({
            url: '{{ url("congviec/congviec_file") }}',
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                $('.loader').hide();
                $('#congviec_file').resetForm();
                if (data.session_congviec_id == 0) {
                    jAlert('Bạn phải tạo công việc chung trước', 'Thông báo');
                    return false;
                }
                $('#list_congviec_file').show('fast', function () {
                    $(this).find('ul').append(data.html);
                });

                let params = {
                    get_view: 1,
                    // vanban_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                    vanban_donvi_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
                    type: $('#SelectCVType').val(),
                    search: $('#InputCVSearch').val(),
                    date: $('#InputCVDate').val(),
                    status: $('#SelectCVStatus').val()
                };

                $.get("{{route('congviec.danhsach')}}", params, function(data) {
                    $('#congviec_table').html(data);
                });

                var congviec_id = data.congviec_id;
                axjaxLoadDetail_Congviec(congviec_id);
            },
            error: function (er) {
                alert('Co loi xay ra');
            }
        })

        $('.action-create-work #create, #form-content i#close-btn').click(function (event) {
            $('#create_work, #congviec_phancong, #congviec_file').resetForm();
            resetMultiselect();
            $.get('{{ url("congviec/remove_session_work") }}', function (data) {
                /* hũy session $congviec_id */
            });
        });

        $('.add_assignment_work').click(function (event) {
            $('#congviec_phancong').slideUp('fast', function () {
                $(this).slideDown('fast').resetForm();
            })
        });

        $('.select_donvi_of_supervisor').change(function (event) {
            loading_show();
            var madonvi = $(this).val();
            ajaxGetUserUnit(madonvi, '.select_donvi_of_nguoigiamsat', 'select_donvi_of_supervisor');
        });

		$('.select_donvi_of_supporter').change(function(event) {
        	loading_show();
			var madonvi =  $(this).val();
			ajaxGetUserUnit(madonvi, '.select_donvi_of_nguoiphoihop', 'select_donvi_of_supporter');
        });

        $('.select_donvi[name=donvi]').change(function (event) {
            loading_show();
            var madonvi = $(this).val();
            ajaxGetUserUnit(madonvi, '.nguoiphutrach');
        });

        $('.select_donvi_of_nguoigiamsat').change(function (event) {
            var val = $(this).val();
            if (val == '') {
                jAlert('<span style="color:#f03">Bạn chưa chọn người giám sát</span>', 'Thông báo');
                $('#choose_supervisor,#choose_supervisor2').find('span').text('Chọn người giám sát');
                $('#choose_supervisor').removeClass('selecting_ngs');
                return false;
            }
            var nguoigiamsat = val.split("+")[2];
            choose_supervisor(nguoigiamsat, '#choose_supervisor');
        });

		$('.select_donvi_of_nguoiphoihop').change(function(event) {
			var val = $(this).val();
			if (val == '') {
				jAlert('<span style="color:#f03">Bạn chưa chọn người phối hợp</span>','Thông báo');
				$('#choose_supporter').find('span').text('Chọn người phối hợp');
				$('#choose_supporter').removeClass('selecting_ngs');
				return false;
			}
			var nguoiphoihop = val.split("+")[2];
			choose_supporter(nguoiphoihop, '#choose_supporter');
		});

        function choose_supervisor(nguoigiamsat, el) {
            $(el + ' span').text(nguoigiamsat);
            $(el).find('input[name=nguoigiamsat]').val(nguoigiamsat);
            $(el).addClass('selecting_ngs');
            $('#modal_choose_supervisor').modal('hide');
        }

		function choose_supporter(nguoiphoihop, el) {
			$(el+' span').text(nguoiphoihop);
			$(el).find('input[name=nguoiphoihop]').val(nguoiphoihop);
			$(el).addClass('selecting_ngs');
			$('#modal_choose_supporter').modal('hide');
		}

        $('#choose_supervisor').click(function (event) {
            $('#modal_choose_supervisor').modal('show');
        });

		$('#choose_supporter').click(function(event) {
			$('#modal_choose_supporter').modal('show');
		});
    });

    function resetMultiselect() {
        $('.nguoiphutrach').html('<label>Người phụ trách:</label> <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --"><span class="multiselect-selected-text">-- Chọn --</span> <b class="caret"></b></button>');
    }

    function ajaxGetUserUnit(madonvi, el, action) {
        $.ajax({
            url: '{{ url("congviec/getUser_Unit") }}',
            type: 'GET',
            data: {
                madonvi: madonvi,
                select_donvi_of_supervisor: action,
            },
            success: function (data) {
                loading_hide();
                if (data != 0) {
                    $(el).html(data);
                } else {
                    if (!action) {
                        $(el).html('<label>Người phụ trách:</label> <button type="button" class="multiselect dropdown-toggle btn btn-default" data-toggle="dropdown" title="-- Chọn --"><span class="multiselect-selected-text">-- Chọn --</span> <b class="caret"></b></button>');
                    } else {
                        if (action == 'select_donvi_of_supporter') {
							$(el).html('<option value="">-- Chọn người phối hợp --</option>');
						}
						else {
							$(el).html('<option value="">-- Chọn người giám sát --</option>');
						}
                    }

                }
            },
            error: function (er) {
                alert('có lổi xảy ra');
            }
        })
    }

    function axjaxLoadDetail_Congviec(congviec_id) {
        $.ajax({
            url: '{{ url("congviec/axjaxLoadDetail_Congviec") }}',
            type: 'get',
            dataType: 'json',
            data: {
                congviec_id: congviec_id,
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                var tbody = "";
                var i = 1;
                $('.name_work').html(data.congviec.tencongviec);
                $('.uu_tien span.nature_work').html(data.congviec.tinhchat)
                $('.uu_tien span.date_start').html(data.congviec.ngaybatdau);
                $('.uu_tien span.date_end').html(data.congviec.ngayketthuc);

                let trangthai = '';
                if (data.congviec.trangthai == 0) {
                    trangthai = 'Đang thực hiện';
                } else if (data.congviec.trangthai == 1) {
                    trangthai = 'Đã hoàn thành';
                } else if (data.congviec.trangthai == 2) {
                    trangthai = 'Tạm dừng';
                } else if (data.congviec.trangthai == 3) {
                    trangthai = 'Hủy bỏ';
                }
                $('.status span').html(trangthai);

                if (data.congviec.user_id == '{{ session('user')['id'] }}') {
                    $('.status span').removeClass('hidden');
                }
                else {
                    $('.status span').addClass('hidden');
                }

                $('.nguoigiamsat span').html(data.congviec.nguoigiamsat);
                $('.nguoiphoihop span').html(data.congviec.nguoiphoihop);
                $('.content_work').html(data.congviec.noidung);

                if (data.congviec.user_id == {{session('user')['id']}}) {
                    $('#wrapper-action-work-detail').show();
                }
                else {
                    $('#wrapper-action-work-detail').hide();
                }

                if ((countMessage = data.congviec.congviec_message.length) > 0) {
                    $('.wrapper-right-content nav ul li a[href="#discuss-tab"]').html('Thảo luận <span class="badge">' + countMessage + '</span>')
                } else {
                    $('.wrapper-right-content nav ul li a[href="#discuss-tab"]').html('Thảo luận')
                }

                if ((countCV_baocao = data.congviec.congviec_baocao.length) > 0) {
                    $('.wrapper-right-content nav ul li a[href="#report-tab"]').html('Báo cáo <span class="badge">' + countCV_baocao + '</span>')
                } else {
                    $('.wrapper-right-content nav ul li a[href="#report-tab"]').html('Báo cáo')
                }

                if ((countCV_chittiet = data.countCongviec) > 0) {
                    $('.wrapper-right-content nav ul li a[href="#participant"]').html('Người tham gia <span class="badge">' + (countCV_chittiet) + '</span>')
                } else {
                    $('.wrapper-right-content nav ul li a[href="#participant"]').html('Người tham gia')
                }

                if ((countFile = data.congviecfile.length) > 0) {
                    $('.wrapper-right-content nav ul li a[href="#document-tab"]').html('Tài liệu <span class="badge">' + countFile + '</span>')
                } else {
                    $('.wrapper-right-content nav ul li a[href="#document-tab"]').html('Tài liệu')
                }

                // alert(data.congviec.congviec_message.length);
                $.each(data.congviecCT, function (index, item) {
                    let status = '';
                    switch (item.status) {
                        case 1:
                            status = '<span style="color:red">Chưa xử lý</span>';
                            break;
                        case 2:
                            status = '<span style="color:blue">Đang xử lý</span>';
                            break;
                        case 3:
                            status = '<span style="color:green">Đã xử lý</span>';
                            break;
                    }
                    tbody += '<tr>';
                    tbody += '<td>' + '<input type="checkbox" value="' + item.id + '" name="congviec_detail_id">' + '</td>';
                    tbody += '<td class="stt-work-detail">' + (i++) + '</td>';
                    tbody += '<td class="work-detail-content">';
                    tbody += '<div class="width-150-hidden" title="';
                    tbody += item.noidung;
                    tbody += '" data-toggle="tooltip">';
                    tbody += item.noidung;
                    tbody += '</div>';
                    tbody += '</td>';
                    tbody += '<td>' + item.mucdohoanthanh + '%</td>';
                    tbody += '<td>' + status + '</td>';
                    tbody += '<td class="work-detail-txtName">' + '<div class="width-150-hidden" title="'
                    tbody += item.listName_CongviecCT
                    tbody += '" data-toggle="tooltip">' + item.listName_CongviecCT + '</div>';
                    tbody += '</td>';

                    if (item.congviec_baocao && item.congviec_baocao.file) {
                        tbody += `<td>
                                    <a href="{{url('/files/vanban')}}/${item.congviec_baocao.file}" target="_blank" title="File đính kèm">
                                        <i class="fa fa-paperclip"></i>
                                    </a>
                                </td>`;
                    }
                    else {
                        tbody += `<td></td>`;
                    }

                    tbody += '<td><i style="cursor: pointer" title="Gia hạn công việc" class="fa fa-calendar"></i></td>';
                    tbody += '</tr>';
                });
                $('.pccv .table-content').html(tbody);

                $('input[name=congviec_id_hidden]').val(congviec_id);
                loading_hide();
            }
        })

    }

</script>