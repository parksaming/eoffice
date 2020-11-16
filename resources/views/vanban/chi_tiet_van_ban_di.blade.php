@extends('templates.lanhdao')
@section('main')

<div class="container-fuild">
    <h3>Chi tiết văn bản đi<div></div></h3>
    <div class="row">
        <div class="col-sm-12 pdt20">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="row-left">Trích yếu</td>
                        <td class="row-right-1">{{ $vanban->title }}</td>
                        <td class="row-left">Độ khẩn</td>
                        <td class="row-right-1">
                            <span style="padding:5px 10px;border-radius: 5px;background: #808184;color:#FFF">{{ $vanban->urgency_text}}</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="row-left">Loại văn bản</td>
                        <td>{{ $vanban->loaivanban? $vanban->loaivanban->name : '' }}</td>
                        <td class="row-left">Ngày ký</td>
                        <td>{{ $vanban->ngayky }}</td>
                    </tr>
                    <tr>
                        <td class="row-left">Số ký hiệu</td>
                        <td class="row-right-1">{{ $vanban->kyhieu }}</td>
                        <td class="row-left">Đơn vị soạn</td>
                        <td class="row-right-1">{{ $vanban->donviSoan? $vanban->donviSoan->name : '' }}</td>
                    </tr>
                    <tr>
                        <td class="row-left">Lĩnh vực</td>
                        <td>{{ $vanban->linhvuc? $vanban->linhvuc->name : '' }}</td>
                        <td class="row-left">Người ký</td>
                        <td>{{ $vanban->nguoiky }}</td>
                    </tr>
                    <tr>
                        <td class="row-left">Publish</td>
                        <td class="row-right-1">{{ $vanban->publish_text }}</td>
                        <td class="row-left">Đơn vị nhận</td>
                        <td class="row-right-1">{{ $vanban->donvi_nhan_vbdi }}</td>
                    </tr>
                    <tr>
                        <td class="row-left">Ghi chú</td>
                        <td colspan="3">{{ $vanban->note }}</td>
                    </tr>
                    <tr>
                        <td class="row-left">File đính kèm</td>
                        <td class="row-right-1" colspan="3">
                            @php
                                $files = explode(';', $vanban->file_vbdis);
                                foreach($files as $file) {
                                    echo sprintf('<div><a href="%s" target="_blank" title="%s">%s</a></div>', route('dowload.file', [$file]), $file, $file);
                                }
                            @endphp
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection