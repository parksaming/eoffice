@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Nhập văn bản đến</h4>
        </div>
        <div class="col-sm-12">
            <form id="FormNhapVBDen" class="form-input" action="{{route('add.vanban_donvi')}}" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" >
                    <input type="hidden" name="loai" value="Đến">
                    <input type="hidden" name="book_id" value="1">
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
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
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
                                <textarea class="form-control" name="title" id="name" rows="5"></textarea>
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
                                        @foreach ($loaivanbans as $loaivanban)
                                            <option value="{{$loaivanban->id}}" {{ $loaivanban->id == 18? 'selected' : '' }}>{{$loaivanban->name}}</option>
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
                                    <input type="text" class="form-control" name="ngayden" id="startngayden" autocomplete="off">
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
                                    <input type="text" class="form-control" name="soden" id="soden">
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
                                    <input type="text" class="form-control" name="kyhieu" id="kyhieu">
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
                                    <input type="text" class="form-control" name="cq_banhanh">
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
                                    <input type="text" class="form-control" name="ngayky" id="ngayky" autocomplete="off">
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
                                        @foreach ($linhvucs as $linhvuc)
                                            <option value="{{$linhvuc->id}}">{{$linhvuc->name}}</option>
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
                                    <input type="text" class="form-control" name="nguoiky" >
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
                                    <input type="text" class="form-control" name="hanxuly" id="hanxuly" autocomplete="off">
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
                                        @foreach ($publishs as $publish)
                                            <option value="{{$publish->id}}">{{$stt++ . '.'.$publish->name}}</option>
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
                                            <option value="{{$i}}">{{$combobox[$i]}}</option>
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
                                <textarea class="form-control" name="note" id="note"  rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- file -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>*File đính kèm <br>(Nhấn Ctrl để chọn nhiều file):</b></p>
                            </div>
                            <div class="form-item-c">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="file" name="files[]" multiple class="btn btn-success" accept=".doc,.docx,.xls,.xlsx,.ppt,.pptx,.pdf" style="width: 100%;text-align: left;">
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
                                <label><input type="checkbox" value="1" name="not_have_chutri"> Không có người chủ trì</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban" style="margin-top: 10px;">
                        <div class="col-sm-6" style="padding-left: 0;">
                            <!-- đơn vị chủ trì -->
                            <div style="margin-bottom: 15px;">
                                <div class="form-item">
                                    <div class="form-item-l">
                                        <p style="padding-top:10px;"><b>*Đơn vị chủ trì:</b></p>
                                    </div>
                                    <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                        <select class="form-control chosen" name="donvi_id">
                                            <option value="">Chọn đơn vị chủ trì</option>
                                            @foreach ($donvichons as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
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
                                        <div id="UserChutriContainer">Không có dữ liệu</div>
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
                                            @foreach ($donvichons as $val)
                                                <option value="{{$val->id}}">{{$val->name}}</option>
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
                                        <div id="UserPhoihopContainer">Không có dữ liệu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px" >Gửi văn bản</button>
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

    // form validate
    $('#FormNhapVBDen').validate({
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
                    url: "{{ url('check_number_van_ban_trong_ngay_donvi') }}",
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
                        }
                    }
                }
            },
            ngayky: {
                required: true
            },
            donvi_id: {
                required: true
            },
            'files[]': {
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
            },
            'files[]': {
                required: "Hãy chọn file đính kèm"
            }
        },
        submitHandler: function(form) {
            let formData = $('#FormNhapVBDen').serializeObject();

            if($('input[name="not_have_chutri"]').is(':checked')) {
                if (!formData['user_phoihop_ids[]'] || !formData['user_phoihop_ids[]'].length) {
                    jAlert('Hãy chọn người phối hợp', 'Thông báo');
                    return false;
                }
            }
            else {
                if (!formData['user_chutri_ids[]'] || !formData['user_chutri_ids[]'].length) {
                    jAlert('Hãy chọn người chủ trì', 'Thông báo');
                    return false;
                }
            }

            loading_show();
            form.submit();
        }
    });

    $('input[name="ngayden"]').change(function () {
        $("#FormNhapVBDen").valid();
    });
    
    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

    $('select[name="donvi_id"]').change(function () {
        let donviId = $(this).val();
        loadUserDonViDenCheckBox([donviId], '#UserChutriContainer', {checkbox_name: 'user_chutri_ids[]'});
    });

    $('select[name="donvi_phoihop_ids[]"]').change(function () {
        let donviIds = $(this).val();
        let selectedValues = $('#FormNhapVBDen').serializeObject()["user_phoihop_ids[]"];

        loadUserDonViDenCheckBox(donviIds, '#UserPhoihopContainer', {checkbox_name: 'user_phoihop_ids[]', selected_values:selectedValues});
    });

    $('input[name="not_have_chutri"]').click(function () {
        if($(this).is(':checked')) {
            $('select[name="donvi_id"]').val('').attr('disabled', true).trigger('chosen:updated');
            $('#UserChutriContainer').html('');
        }
        else {
            $('select[name="donvi_id"]').attr('disabled', false).trigger('chosen:updated');
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