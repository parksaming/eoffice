<input type="hidden" value="{{$id_vanbanuser}}" name="id_vanbanuser">
<input type="hidden" value="{{$id}}" name="id">
<div class="row" style="display: flex">
    <div class="col-sm-3" style="position: relative;top: 10px;">Tình trạng: <span style="color: red">(*)</span></div>
    <div class="col-sm-9">
        <select class="browser-default custom-select" id="status" name="status">
            <option value="">Chọn tình trạng</option>
            <option value="1">Chưa xử lý</option>
            <option value="2">Đang xử lý</option>
            <option value="3">Đã xử lý</option>
        </select>
    </div>
</div>
