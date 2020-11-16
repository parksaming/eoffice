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
            <td width="120">Số ký hiệu</td>
            <td>&nbsp;{{$data['kyhieu']}}</td>
            <td width="120">Ngày ban hành</td>
            <td colspan="3">&nbsp;{{$data['ngayden']}}</td>
        </tr>
        <tr>
            <td width="120">Loại văn bản</td>
            <td>&nbsp;{{$data['loaivanban_id']}}</td>
            <td width="124">Lĩnh vực văn bản</td>
            <td width="195">&nbsp;{{$data['linhvuc_id']}}</td>
        </tr>
        <tr>
            <td width="120">Nơi ban hành</td>
            <td>&nbsp;{{$data['cq_banhanh']}}</td>
            <td width="124">Loại VB</td>
            <td width="195">&nbsp;{{$data['loai']}}</td>
        </tr>
        <!-- nội dung bút phê -->
        @if (isset($data['noidung_butphe']))
            <tr>
                <td width="120">Nội dung bút phê</td>
                <td colspan="3">{!!nl2br($data['noidung_butphe'])!!}</td>
            </tr>
        @endif
        </tbody>
    </table>
    <br>
    Xem thêm web: <a href="{{$data['link']}}" target="_blank">Link</a>
    <br>
    Download File:
    @php
        $files = explode(';', $data['file_dinhkem']);
        foreach($files as $file) {
            echo sprintf('<div><a href="%s" target="_blank" title="%s">%s</a></div>', route('dowload.file', [$file, 'vanban_id' => $data['id']]), $file, $file);
        }
    @endphp
</div>