<div>
    <div>
        <span>Loại: {{$data['type'] == 1? 'Lịch tuần Đại học Đà Nẵng' : 'Lịch tuần cơ quan'}}</span>
    </div>
    <div>
        <span>Địa điểm: {{$data['tenphong']}}</span>
    </div>
    <div>
        <span>Thời gian: {{date('d/m/Y H:i', strtotime($data['time']))}}</span>
    </div>
    <div>
        <span>Nội dung: {!! $data['noidung'] !!}</span>
    </div>
    <div>
        <span>Thành phần: {!! $data['thanhphan'] !!}</span>
    </div>
    <div>
        <span>Chủ trì: {{$data['chutri']}}</span>
    </div>
    <div>
        <span>Số người tham gia: {{$data['songuoithamgia']}}</span>
    </div>
    <div>
        <span>Người đăng ký: {{$data['nguoidangky']}}</span>
    </div>
    <div>
        <span>Đơn vị: {{$data['donvi']}}</span>
    </div>
    <div>
        <span>Số điện thoại: {{$data['sodienthoai']}}</span>
    </div>
    <div>
        <span>Email: {{$data['email']}}</span>
    </div>
</div>
