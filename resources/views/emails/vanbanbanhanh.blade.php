<div>
        <div>
        <span>Tên văn bản: {{$data['name']}}</span>
    </div>
    <div>
        <span>Cơ quan ban hành: {{$data['tenCoQuanBanHanh']}}</span>
    </div>
    <div>
        <span>Đơn vị nhận: {{$data['tenDonviNhan']}}</span>
    </div>
    <div>
        <span>Người nhận: {{implode(', ', $data['tenUserNhans'])}}</span>
    </div>
    <div>
       <span>Thời gian ban hành: {{date('d/m/Y H:i', strtotime($data['thoigian_banhanh']))}}</span>
    </div>
    @if ($data['file'])
    <div>
        <span>File đính kèm: <a href="{{$data['fileDinhKem']}}">{{$data['file']}}</a></span>
    </div>
    @endif
</div>
