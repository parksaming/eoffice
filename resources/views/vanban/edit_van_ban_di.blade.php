@extends('templates.lanhdao')
@section('main')
<?php
    function tree($donviIds, $id, $i)
    {
        $i= $i.'---';
        $parents = App\Donvi::where('parent_id',$id)->whereIn('id', $donviIds)->get();
        $tree = '';
        foreach ($parents as $parent){
            $parent2 = App\Donvi::where('parent_id',$parent->id)->get();
            echo '<option value="'.$parent->id.'">'.$i.$parent->name.'</option>';
            if (count($parent2) > 0){
                tree($donviIds, $parent->id,$i);
            }
        }
        echo $tree;
    }
?>
<div class="container" style="padding-bottom: 50px;">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Sửa văn bản đi</h4>
        </div>
        <div class="col-sm-12">
            <form id="FormNhapVB" action="{{route('add.vanban.di')}}" class="form-input" method="POST" enctype="multipart/form-data">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" >
                    <input type="hidden" name="loai" value="Đi">
                    <input type="hidden" name="book_id" value="2">
                    <input type="hidden" name="vanban_id" value="{{ $vanban->id }}">

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

                        <!-- ngày ký -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Ngày ký:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="ngayky" value="{{ date('d-m-Y', strtotime($vanban->ngaykyVal)) }}" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <!-- ký hiệu -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Ký hiệu:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="text" class="form-control" name="kyhieu" value="{{ $vanban->kyhieu }}">
                                </div>
                            </div>
                        </div>

                        <!-- số văn bản -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>*Số văn bản:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <input type="number" class="form-control" name="sovb" value="{{ $vanban->sovb }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban">
                        <!-- Đơn vị soạn -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Đơn vị soạn:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control chosen" name="cq_banhanh" id="donvisoan">
                                        <option value="">Chọn đơn vị</option>
                                        @php
                                            foreach ($donvischa as $donvi) {
                                                echo sprintf('<option value="%d" %s>%s</option>', $donvi->id, ($donvi->id == $vanban->cq_banhanh? 'selected' : ''), $donvi->name);

                                                $parent = App\Donvi::where('parent_id', $donvi->id)->get();
                                                if (count($parent) > 0) {
                                                    $i = '';
                                                    tree($donviIds, $donvi->id, $i);
                                                }
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Lĩnh vực -->
                        <div class="col-sm-6" style="padding-right: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Lĩnh vực:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control" name="linhvuc_id" id="linhvuc_di">
                                        <option value="">Chọn lĩnh vực</option>
                                        @foreach($linhvucs as $linhvuc)
                                            <option value="{{$linhvuc->id}}" {{ ($vanban->linhvuc_id == $linhvuc->id)? 'selected' : '' }}>{{$linhvuc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Người ký -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>Người ký:</b></p>
                            </div>
                            <div class="form-item-c">
                                <input type="text" class="form-control" name="nguoiky" value="{{ $vanban->nguoiky }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban">
                        <!-- Publish -->
                        <div class="col-sm-6" style="padding-left: 0;">
                            <div class="form-item">
                                <div class="form-item-l">
                                    <p style="padding-top:7px"><b>Publish:</b></p>
                                </div>
                                <div class="form-item-c">
                                    <select class="form-control" name="is_publish">
                                        <option value="1" {{ $vanban->is_publish == 1? 'selected' : '' }}>Public</option>
                                        <option value="0" {{ $vanban->is_publish == 0? 'selected' : '' }}>Không publish</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Độ khẩn -->
                        <div class="col-sm-6" style="padding-right: 0;">
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
                                <textarea class="form-control" name="note" id="note" rows="5">{!! nl2br($vanban->note) !!}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- file cũ -->
                    <div class="col-md-12 vanban">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:7px"><b>File đính kèm đã có</b></p>
                            </div>
                            <div class="form-item-c" style="display: flex;flex-direction: column;">
                                @php
                                    $files = explode(';', $vanban->file_vbdis)
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

                    <!-- đơn vị nhận -->
                    <div class="col-md-12 vanban" style="margin-top: 20px;">
                        <div class="form-item">
                            <div class="form-item-l">
                                <p style="padding-top:10px;"><b>Đơn vị nhận:</b></p>
                            </div>
                            <div class="form-item-c" style="display: flex; flex-direction: column-reverse;">
                                <textarea name="donvi_nhan_vbdi" class="form-control">{!! nl2br($vanban->donvi_nhan_vbdi) !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px">Sửa văn bản</button>
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

    $('#FormNhapVB').validate({
        ignore: [],
        rules: {
            'title': 'required',
            'loaivanban_id': 'required',
            'ngayky': 'required',
            'kyhieu': 'required',
            'sovb': 'required'
        },
        messages: {
            'title': 'Tiêu đề không được để trống',
            'loaivanban_id': 'Hãy chọn loại văn bản',
            'ngayky': 'Hãy chọn ngày ký',
            'kyhieu': 'Hãy nhập ký hiệu',
            'sovb': 'Hãy nhập số văn bản'
        },
        submitHandler: function(form) {
            loading_show();
            form.submit();
        }
    });

    $('input[name="ngayky"]').datepicker({
        dateFormat: 'dd-mm-yy',
    });

    $('select[name="donvi_id"]').change(function () {
        let donviId = $(this).val();
    });

    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

    $('input[name="kyhieu"]').change(function () {
        const kyhieu = $(this).val();
        const sovanban = kyhieu.split('/');
        $('input[name="sovb"]').val(sovanban[0]);
    });
</script>
@endsection
