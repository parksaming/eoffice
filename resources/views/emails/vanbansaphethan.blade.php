<h3>Kính gửi: {{implode(', ', $data['tenUserNhans'])}}</h3>
<div>
    <p>
        <span style="color:#ff0000">
            <strong> Văn bản
                {{$data['title']}} sẽ hết hạn vào ngày {{$data['hanxuly']}} (Còn 2 ngày)
            </strong>
        </span>
    </p>
    <p>Kính mong quý đơn vị quan tâm xem xét xử lý văn bản sớm.</p><br>
    <strong>Văn phòng ĐHĐN</strong>
    <br>
    Xem thêm web: <a href="{{$data['link']}}" target="_blank">Link</a>
    <br>
</div>