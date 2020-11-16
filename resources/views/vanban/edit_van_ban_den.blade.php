@extends('templates.lanhdao')
@section('main')

<style>
    .chosen-container-multi .chosen-choices li.search-choice-disabled {
        height: 21px !important;
        line-height: 11px;
    }
</style>
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Sửa văn bản đến</h4>
        </div>
        <div class="col-sm-12">
            <form id="FormEditVBDen" class="form-input" action="{{route('save.vanban')}}" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" >
                    <input type="hidden" name="loai" value="Đến">
                    <input type="hidden" name="book_id" value="1">
                    <input type="hidden" name="vanban_id" value="{{ $vanban->id }}">
                    <div class="col-md-12 vanban">
                       <p><b>I.THÔNG TIN VĂN BẢN</b></p>
                    </div>

                    <!-- sổ văn bản -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px;"><b>Sổ văn bản</b></p>
                            </div>
                            <div class="form-item-c">
                                <select class="chosen form-control" name="sovanban_id">
                                    @foreach ($sovanbandens as $val)
                                        <option value="{{ $val->id }}" {{ $vanban->sovanban_id == $val->id? 'selected' : '' }}>{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- tiêu đề -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px;line-height: 100px"><b>*Tiêu đề:</b></p>
                            </div>
                            <div class="form-item-c">
                                <textarea class="form-control" name="title" id="name" rows="5">{!! nl2br($vanban->title) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban">
                        <!-- loại văn bản -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Loại văn bản:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control" name="loaivanban_id" id="loaivanban">
                                        <option value="">Chọn loại văn bản</option>
                                        @foreach ($loaivanbans as $val)
                                            <option value="{{$val->id}}" {{ $vanban->loaivanban_id == $val->id? 'selected' : '' }}>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ngày đến -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Ngày đến:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="ngayden" id="startngayden" value="{{ date('d-m-Y', strtotime($vanban->ngayden)) }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <!-- Số đến -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Số đến:</b> </p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="soden" value="{{ $vanban->soden }}" id="soden">
                                </div>
                            </div>
                        </div>

                        <!-- Ký hiệu -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Ký hiệu:</b> </p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="kyhieu" value="{{ $vanban->kyhieu }}" id="kyhieu">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <!-- CQ ban hành -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>CQ ban hành:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="cq_banhanh" value="{{ $vanban->cq_banhanh }}">
                                </div>
                            </div>
                        </div>

                        <!-- Ngày ký -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Ngày ký:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="ngayky" id="ngayky" a="{{$vanban->ngayky}}" value="{{ date('d-m-Y', strtotime($vanban->ngaykyVal)) }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban">
                        <!-- Lĩnh vực -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Lĩnh vực:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control" id="" name="linhvuc_id">
                                        <option value="">Chọn lĩnh vực</option>
                                        @foreach ($linhvucs as $val)
                                            <option value="{{$val->id}}" {{ $vanban->linhvuc_id == $val->id? 'selected' : '' }}>{{$val->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Người ký -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Người ký:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="nguoiky" value="{{ $vanban->nguoiky }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban">
                        <!-- Hạn xử lý -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Hạn xử lý:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="hanxuly" id="hanxuly" value="{{ $vanban->hanxulyVal? date('d-m-Y', strtotime($vanban->hanxulyVal)) : '' }}" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <!-- Publish -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Publish:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control" name="publish">
                                        <option value="">Chọn publish</option>
                                        <?php
                                            $stt = 1;
                                        ?>
                                        @foreach ($publishs as $val)
                                            <option value="{{$val->id}}" {{ $vanban->publish_id == $val->id? 'selected' : '' }}>{{$stt++ . '.'.$val->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Độ khẩn -->
                    <div class="col-md-12 vanban">
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Độ khẩn:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select  class="form-control" name="urgency" id="urgency">
                                        @for ($i=1;$i <= $countcombo; $i++)
                                            <option value="{{$i}}" {{ $vanban->urgency == $i? 'selected' : '' }}>{{$combobox[$i]}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px;line-height: 100px"><b>Ghi chú:</b></p>
                            </div>
                            <div class="form-item-c">
                                <textarea  class="form-control" name="note" id="note"  rows="5">{!! nl2br($vanban->note) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- file cũ -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p><b>File đính kèm đã có</b></p>
                            </div>
                            <div class="form-item-c" style="display: flex;flex-direction: column;">
                                @php
                                    $files = explode(';', $vanban->file_dinhkem)
                                @endphp
                                @foreach ($files as $file)
                                    <a href="{{ route('dowload.file', [$file]) }}" target="_blank" title="{{ $file }}">{{ $file }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- file -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>File đính kèm <br>(Nhấn Ctrl để chọn nhiều file):</b></p>
                            </div>
                            <div class="form-item-c">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="files[]" multiple class="btn btn-success" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" style="width: 100%;text-align: left;">
                                        <span style="color: red;">Đính kèm file mới sẽ thay các file đính kèm cũ</span>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="padding-top:7px;"><i>Chỉ cho upload định dạng file: <span style="color: green;">doc, docx, xls, xlsx, ppt, pptx, pdf</span> với dung lượng < 20M</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- check không có người chủ trì -->
                    <div class="col-md-12 vanban" style="margin-top: 25px;">
                        <div class="form-item">
                            <div class="form-item-l"></div>
                            <div class="form-item-c">
                                <label><input type="checkbox" value="1" name="not_have_chutri" {{ $vanban->not_have_chutri? 'checked' : '' }} {{ sizeof($userChuTriDaXemVanBanIds)? 'disabled' : '' }}> Không có người chủ trì</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban" style="margin-top: 10px;">
                        <div class="col-sm-6" style="padding-left: 0;">
                            <!-- đơn vị chủ trì -->
                            <div style="margin-bottom: 15px;">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:10px;"><b>Đơn vị chủ trì:</b></p>
                                    </div>
                                    <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                        <select class="form-control chosen" name="donvi_id" {{ (sizeof($userChuTriDaXemVanBanIds) || $vanban->not_have_chutri)? 'disabled' : '' }}>
                                            <option value="">Chọn đơn vị chủ trì</option>
                                            @foreach ($bookDetails as $val)
                                                <option value="{{$val->donvi->id}}" {{ $vanban->donvi_id == $val->donvi->id? 'selected' : '' }}>{{$val->donvi->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Người chủ trì -->
                            <div>
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p><b>Người chủ trì:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                        <div id="UserChutriContainer">
                                            <style>
                                                .checkbox-group {
                                                    margin-bottom: 5px;
                                                }
                                                .checkbox-l {
                                                    font-weight: bold;
                                                }
                                                .checkbox-c {
                                                    padding: 0 0 0 15px;
                                                }
                                                .checkbox-c label {
                                                    font-weight: normal;
                                                }
                                                .checkbox-c input {
                                                    margin-right: 5px;
                                                }
                                            </style>
                                            @if (sizeof($userChuTris))
                                                @foreach ($userChuTris as $donviName => $users)
                                                    <div class="checkbox-group">
                                                        <div class="checkbox-l">
                                                            <label><input type="checkbox" class="check-all"> <span> {{ $donviName }}</span></label>
                                                        </div>
                                                        <div class="checkbox-c">
                                                            @foreach ($users as $user)
                                                                <div><label><input type="checkbox" value="{{ $user->id }}" name="user_chutri_ids[]" checked {{ in_array($user->id, $userChuTriDaXemVanBanIds)? 'disabled' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                Không có dữ liệu
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6" style="padding-right: 0;">
                            <!-- đơn vị phối hợp -->
                            <div style="margin-bottom: 15px;">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:10px;"><b>Đơn vị phối hợp:</b></p>
                                    </div>
                                    <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                        <select class="form-control chosen" name="donvi_phoihop_ids[]" multiple>
                                            @foreach ($bookDetails as $val)
                                                <option value="{{$val->donvi->id}}" {{ in_array($val->donvi->id, $vanban->donViPhoiHopIdsVal)? 'selected' : '' }} {{ in_array($val->donvi->id, $donviPhoiHopDaXemVanBanIds)? 'disabled' : '' }}>{{$val->donvi->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Người phối hợp -->
                            <div>
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p><b>Người phối hợp:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                        <style>
                                            .checkbox-group {
                                                margin-bottom: 5px;
                                            }
                                            .checkbox-l {
                                                font-weight: bold;
                                            }
                                            .checkbox-c {
                                                padding: 0 0 0 15px;
                                            }
                                            .checkbox-c label {
                                                font-weight: normal;
                                            }
                                            .checkbox-c input {
                                                margin-right: 5px;
                                            }
                                        </style>
                                        <div id="UserPhoihopDaXemContainer">
                                            @foreach ($userTrongDonViPhoiHops as $donviId => $val)
                                                @if (in_array($donviId, $donviPhoiHopDaXemVanBanIds))
                                                    <div class="checkbox-group">
                                                        <div class="checkbox-l">
                                                            <label><input type="checkbox" class="check-all"> <span> {{ $val->name }}</span></label>
                                                        </div>
                                                        <div class="checkbox-c">
                                                            @foreach ($val->users as $user)
                                                                <div><label><input type="checkbox" value="{{ $user->id }}" name="user_phoihop_ids[]" {{ in_array($user->id, $vanban->userPhoiHopIdsVal)? 'checked' : '' }} {{ in_array($user->id, $userPhoiHopDaXemVanBanIds)? 'disabled' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div id="UserPhoihopContainer">
                                            @if (sizeof($userTrongDonViPhoiHops))
                                                @foreach ($userTrongDonViPhoiHops as $donviId => $val)
                                                    @if (!in_array($donviId, $donviPhoiHopDaXemVanBanIds))
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-l">
                                                                <label><input type="checkbox" class="check-all"> <span> {{ $val->name }}</span></label>
                                                            </div>
                                                            <div class="checkbox-c">
                                                                @foreach ($val->users as $user)
                                                                    <div><label><input type="checkbox" value="{{ $user->id }}" name="user_phoihop_ids[]" {{ in_array($user->id, $vanban->userPhoiHopIdsVal)? 'checked' : '' }} {{ in_array($user->id, $userPhoiHopDaXemVanBanIds)? 'disabled' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                Không có dữ liệu
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" name="type_submit" value="notsendmail" class="btn btn-primary" style="margin-top:10px; margin-right: 15px;">Cập nhật văn bản</button>
                        <button type="submit" name="type_submit" value="sendmail" class="btn btn-primary" style="margin-top:10px; margin-left: 15px;">Cập nhật và gửi mail</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $.fn.serializeObject = function() {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    var numberUserPhoiHopDaXemVanBan = <?php echo json_encode(sizeof($userPhoiHopDaXemVanBanIds)) ?>;
    var numberUserChuTriDaXemVanBan = <?php echo json_encode(sizeof($userChuTriDaXemVanBanIds)) ?>;

    // form validate
    $('#FormEditVBDen').validate({
        ignore: [],
        rules: {
            title: {
                required: true
            },
            loaivanban_id: {
                required: true
            },
            ngayden: {
                required: true
            },
            soden: {
                remote: {
                    url: "{{ url('check_number_van_ban_trong_ngay') }}",
                    type: "post",
                    data: {
                        _token: function () {
                            return $('meta[name="csrf-token"]').attr('content');
                        },
                        number: function() {
                            return $('input[name="soden"]').val();
                        },
                        date: function() {
                            return $('input[name="ngayden"]').val();
                        },
                        vanban_id: "{{ $vanban->id }}"
                    }
                }
            },
            ngayky: {
                required: true
            },
            donvi_id: {
                required: true
            }
        },
        messages: {
            title: {
                required: "Hãy nhập tiêu đề văn bản"
            },
            loaivanban_id: {
                required: "Hãy chọn loại văn bản"
            },
            ngayden: {
                required: "Hãy chọn ngày đến"
            },
            ngayky: {
                required: "Hãy chọn ngày ký"
            },
            donvi_id: {
                required: "Hãy chọn đơn vị chủ trì"
            }
        },
        submitHandler: function(form) {
            let formData = $('#FormEditVBDen').serializeObject();

            if($('input[name="not_have_chutri"]').is(':checked')) {
                if (!numberUserPhoiHopDaXemVanBan) {
                    if (!formData['user_phoihop_ids[]'] || !formData['user_phoihop_ids[]'].length) {
                        jAlert('Hãy chọn người phối hợp', 'Thông báo');
                        return false;
                    }
                }
            }
            else {
                if (!numberUserChuTriDaXemVanBan) {
                    if (!formData['user_chutri_ids[]'] || !formData['user_chutri_ids[]'].length) {
                        jAlert('Hãy chọn người chủ trì', 'Thông báo');
                        return false;
                    }
                }
            }

            loading_show();
            form.submit();
        }
    });

    $('input[name="ngayden"]').change(function () {
        $("#FormEditVBDen").valid();
    });
    
    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

    $('select[name="donvi_id"]').change(function () {
        let donviId = $(this).val();
        loadUserDonViDenCheckBox([donviId], '#UserChutriContainer', {checkbox_name: 'user_chutri_ids[]'});
    });

    $('select[name="donvi_phoihop_ids[]"]').change(function (evt, params) {
        let donviIds = $(this).val();
        let selectedValues = $('#FormEditVBDen').serializeObject()["user_phoihop_ids[]"];

        loadUserDonViDenCheckBox(donviIds, '#UserPhoihopContainer', {checkbox_name: 'user_phoihop_ids[]', selected_values:selectedValues});
    });

    $('input[name="not_have_chutri"]').click(function () {
        if($(this).is(':checked')) {
            $('input[name="user_chutri_ids[]"]').attr('checked', false).attr('disabled', true);
        }
        else {
            $('input[name="user_chutri_ids[]"]').attr('disabled', false);
        }
    });

    function loadUserDonViDenCheckBox(donviIds, target, options) {
        options = options || {};

        let url = '{{url("load_user_donviden_checkbox")}}';
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        
        let params = {
            _token: CSRF_TOKEN,
            selected_values: options.selected_values || [],
            donvi_ids: donviIds,
            checkbox_name: options.checkbox_name || ''
        };

        loading_show();
        $.post(url, params, (res) => {
            loading_hide();
            $(target).html(res);
        });
    }
</script>
@endsection