<div>
    <p>
        <span style="color:#ff0000">
            <strong>
                {{$data['title']}}
            </strong>
        </span>
    </p>
    <table border="1" width="100%" style="border-collapse:collapse">
        <tbody>
            <tr>
                <td width="120">Loại văn bản</td>
                <td>{{ $data['loai_vanban'] }}</td>
                <td width="124">Ngày ký</td>
                <td width="195">{{ $data['ngayky'] }}</td>
            </tr>
            <tr>
                <td width="120">Số ký hiệu</td>
                <td>{{ $data['kyhieu'] }}</td>
                <td width="124">Đơn vị soạn</td>
                <td width="195">{{ $data['donvi_nhan_vbdi'] }}</td>
            </tr>
            <tr>
                <td width="120">Lĩnh vực</td>
                <td>{{ $data['linhvuc_name'] }}</td>
                <td width="124">Người ký</td>
                <td width="195">{{ $data['nguoiky'] }}</td>
            </tr>

            <tr>
                <td width="120">Publish</td>
                <td>{{ $data['public'] }}</td>
                <td width="124">Độ khẩn</td>
                <td width="195">{{ $data['dokhan'] }}</td>
            </tr>
            <tr>
                <td width="120">Đơn vị nhận</td>
                <td colspan="3">{{ $data['donvi_nhan_vbdi'] }}</td>
            </tr> 
            <tr>
                <td width="120">Ghi chú</td>
                <td colspan="3">{!!nl2br($data['note'])!!}</td>
            </tr>
        </tbody>
    </table>
    <br>

    <div>
        Xem thêm web: <a href="{{ $data['link'] }}" target="_blank">Link</a>
    </div>
    <br>

    <div>
        <div>Download  File:</div>
        <div>
            @php
                $files = explode(';', $data['file_vbdis']);
                foreach($files as $key => $file) {
                    echo sprintf('<div><a href="%s" target="_blank" title="%s">%s</a></div>', route('dowload.file', [$file,'vanban_id' => $data['id'],'numberFile' => $key]), $file, $file);
                }
            @endphp
        </div>
    </div>
</div>