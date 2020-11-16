@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">{{ isset($vanbanBanhanh)? 'Sửa văn bản ban hành' : 'Nhập văn bản ban hành' }}</h4>
        </div>
        <div class="col-sm-12">
            <div class="container">
                <form id="FormNhapVB" class="form-input" action="{{ route('save_vanban_banhanh_donvi') }}" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        @if (isset($vanbanBanhanh))
                            <input type="hidden" name="id" value="{{ $vanbanBanhanh->id }}"/>
                        @endif
    
                        <!-- Tên văn bản -->
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px;"><b>*Tên văn bản:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <textarea class="form-control" name="name" rows="5">{!! isset($vanbanBanhanh)? nl2br($vanbanBanhanh->name) : '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Thời gian ban hành -->
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px;"><b>*Thời gian ban hành:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input class="form-control datetime-picker" name="thoigian_banhanh" value="{{ isset($vanbanBanhanh)? $vanbanBanhanh->thoigian_banhanh_input : '' }}"/>
                                </div>
                            </div>
                        </div>
    
                        <!-- Đơn vị nhận -->
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px;"><b>*Đơn vị nhận:</b></p>
                                </div>
                                <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                    <select class="form-control chosen" multiple name="donvi_nhan_id[]">
                                        <option value="">Chọn đơn vị nhận</option>
                                        @foreach ($donvis as $val)
                                            <option value="{{ $val->id }}" {{ (isset($vanbanBanhanh) && $vanbanBanhanh->donvi_nhan_id == $val->id)? 'selected' : '' }}>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- User nhận -->
                        <div class="col-md-12 vanban">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px;"><b>*User nhận:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <div id="UserNhanContainer">
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
                                        @if (isset($vanbanBanhanh) && $vanbanBanhanh)
                                            <div class="checkbox-group">
                                                <div class="checkbox-l">
                                                    <label><input type="checkbox" class="check-all"> <span> {{ $vanbanBanhanh->donviNhan->name }}</span></label>
                                                </div>
                                                <div class="checkbox-c">
                                                    @foreach ($usersInDonvi as $user)
                                                        <div><label><input type="checkbox" value="{{ $user->id }}" name="user_nhan_ids[]" {{ in_array($user->id, $userNhanIdsArr)? 'checked' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @else
                                            Không có dữ liệu
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if (isset($vanbanBanhanh))
                            <!-- file cũ -->
                            <div class="col-md-12 vanban">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:7px"><b>File đính kèm đã có</b></p>
                                    </div>
                                    <div class="form-item-c" style="display: flex;align-items: center;">
                                        <a href="{{ route('dowload.file', [$vanbanBanhanh->file]) }}" target="_blank" title="{{ $vanbanBanhanh->file }}">
                                            {{ $vanbanBanhanh->file }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- file -->
                            <div class="col-md-12 vanban">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:7px"><b>Đính kèm file mới:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="file" onchange="validateFile(this)" class="btn btn-success" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" style="width: 100%" name="file">
                                                <span style="color: red;">Đính kèm file mới sẽ thay file đính kèm cũ</span>
                                            </div>
                                            <div class="col-md-9">
                                                <p style="padding-top:7px;"><i>Chỉ cho upload định dạng file: <span style="color: green;">doc, docx, xls, xlsx, ppt, pptx, pdf</span> với dung lượng < 20M</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- file -->
                            <div class="col-md-12 vanban">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:7px"><b>*File đính kèm:</b></p>
                                    </div>
                                    <div class="form-item-c">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <input type="file" onchange="validateFile(this)" class="btn btn-success" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" style="width: 100%" name="file">
                                            </div>
                                            <div class="col-md-9">
                                                <p style="padding-top:7px;"><i>Chỉ cho upload định dạng file: <span style="color: green;">doc, docx, xls, xlsx, ppt, pptx, pdf</span> với dung lượng < 20M</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-12 vanban" style="text-align: center">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px">Lưu văn bản</button>
                        </div>
                    </div>
                </form>
            </div>
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

    // form validate
    $('#FormNhapVB').validate({
        ignore: [],
        rules: {
            name: 'required',
            thoigian_banhanh: 'required',
            @if (!isset($vanbanBanhanh))
                file: 'required',
            @endif
            donvi_nhan_id: 'required'
        },
        messages: {
            name: 'Hãy nhập tên văn bản',
            thoigian_banhanh: 'Hãy chọn thời gian ban hành',
            @if (!isset($vanbanBanhanh))
                file: 'Hãy chọn file',
            @endif
            donvi_nhan_id: 'Hãy chọn đơn vị nhận'
        },
        submitHandler: function(form) {
            let formData = $('#FormNhapVB').serializeObject();

            if (!formData['user_nhan_ids[]'] || !formData['user_nhan_ids[]'].length) {
                jAlert('Hãy chọn người nhận', 'Thông báo');
                return false;
            }

            loading_show();
            form.submit();
        }
    });
    
    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

    $('.datetime-picker').datetimepicker({
		format: 'DD-MM-YYYY HH:mm',
		useCurrent: true
	});

    function loadUserDonViBanHanhCheckBox(donviIds, target, options) {
        options = options || {};

        let url = '{{url("load_user_donvibanhanh_checkbox")}}';
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
    
    $('select[name="donvi_nhan_id[]"]').change(function () {
        let donviIds = $(this).val();
        let selectedValues = $('#FormNhapVB').serializeObject()["user_nhan_ids[]"];
        //loadUserDonViBanHanhCheckBox([donviId], '#UserNhanContainer', {checkbox_name: 'user_nhan_ids[]'});
        loadUserDonViBanHanhCheckBox(donviIds, '#UserNhanContainer', {checkbox_name: 'user_nhan_ids[]', selected_values:selectedValues});
    });
</script>
@endsection