@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div style="margin-bottom: 40px;" class="col-sm-12">
            <h4 class="title-text">Quản lý nhập lương - thuế</h4>
        </div>

        <div class="col-sm-9" style="padding: 0px; margin-left: 10%">
            <p class="col-sm-5"><button style="text-align:center" onclick="showImportExcell_4()" type="button" class="btn btn-primary btn-block"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import excel thanh toán lương và phụ cấp</button></p>
            <p class="col-sm-5"><button style="text-align:center" onclick="showImportExcell()" type="button" class="btn btn-primary btn-block"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import excel tổng hợp thu nhập</button></p>
            <p class="col-sm-2"><button style="text-align:center" onclick="showImportExcellThuNhapKhac()" type="button" class="btn btn-primary btn-block"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Thu nhập khác</button></p>
        </div>
        {{--  <div class="col-sm-2"></div>  --}}

        <div class="col-md-12" style="display: flex;justify-content: space-between;margin: 60px 0px 15px;">
            <ul class="nav nav-pills">
                <li class="bg_luanchuyen {{$status == 'luongvaphucap' ? 'active' : ''}} ">
                    <a href="{{ route('import_luong', ['status' => 'luongvaphucap']) }}">Danh sách lương và phụ cấp</a>
                </li>
                <li class="bg_luanchuyen {{$status == 'tonghopthunhap' ? 'active' : ''}} ">
                    <a href="{{ route('import_luong', ['status' => 'tonghopthunhap']) }}">Danh sách tổng hợp thu nhập thuế</a>
                </li>
                <li class="bg_luanchuyen {{$status == 'tonghopthunhapkhac' ? 'active' : ''}} ">
                    <a href="{{ route('import_luong', ['status' => 'tonghopthunhapkhac']) }}">Danh sách tổng hợp thu nhập khác</a>
                </li>
            </ul>
        </div>

        <div class="col-sm-12">
            <table class="table table-bordered">
                <thead class="head-table">
                <tr>
                    <th class="text-center">STT</th>
                    <th class="text-center">Tháng - năm</th>
                    <th class="text-center">Ngày nhập</th>
                    <th class="text-center">Người nhập</th>
                    <th class="text-center">Số lượng</th>
                    <th class="text-center">Gửi Mail</th>
                    <th class="text-center">Xem</th>
                </tr>
                </thead>
                <tbody>

                @if (count($result) > 0)
                    @php $stt = 1; @endphp
                @foreach ($result as $value)
                    <?php $dateMonth = $value['date'];?>
                    <tr>
                        <td class="text-center">{{$stt++}}</td>
                        <td class="text-center">{{date_format (new DateTime($value['date']), 'm-Y')}}</td>
                        <td class="text-center">{{date_format (new DateTime($value['created_at']), 'd-m-Y')}}</td>
                        <td class="text-center">{{$value['fullname']}}</td>
                        <td class="text-center">
                            <?php foreach ($numberUser as $key => $sl):?>
                            <?php if($key == $value['date']): echo $sl;?>
                            <?php endif;?>
                            <?php endforeach;?>
                        </td>
                        <td class="text-center">
                            @if($value['sendMail'] == 1)
                                <a style="pointer-events: none;" href="javascript:;" onclick="showModalSendMail('{{$status}}', '{{$dateMonth}}')" title="Gửi mail"><i class="fa fa-envelope <?php echo $value['sendMail'] == 1 ? 'colorSendMail':''?>" aria-hidden="true"></i></a>
                            @else
                                <a href="javascript:;" onclick="showModalSendMail('{{$status}}', '{{$dateMonth}}')" title="Gửi mail"><i class="fa fa-envelope <?php echo $value['sendMail'] == 1 ? 'colorSendMail':''?>" aria-hidden="true"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                           <a href="{{route($path, $value['date'])}}" title="Xem chi tiết"><i class="fa fa-eye"> </i></a>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr>
                        <td colspan="12">{{ trans('common.txt_no_data') }}</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="ImportExcell" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 35%;">
        <div class="modal-content">
            <div class="modal-header " style="background:#1d589e;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" style="color: white">Import thuế</h3>
            </div>
            <div class="modal-body">
                {{--  Form thu thuế  --}}
                <form id="ImportExcell" action="{{url('import_update_thu_thue')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <label for="date">Chọn tháng</label>
                    <input  type="text" name="date" class="form-control input-date" id="date" value="{{$date}}">
                    <div style="margin-top: 20px;">
                        <label>{{trans('common.str_select_file_excel')}}
                            <a href={{url('app/webroot/phpexcel/mau/mau_thunhapthue.xlsx')}} target="_blank" title="Click để dowload mẫu" style="color: blue">mẫu tại đây</a>
                        </label>
                    </div>
                    <div style="margin-top: 15px">
                        <input name="file3" id="file3" style="display: none;" class="inputfile3" accept=".xlsx" type="file">
                        <label for="file3" style="width: 100%; display: flex; cursor: pointer;">
                            <strong style="margin-right: 10px;">
                                <svg width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                </svg> {{ trans('common.txt_select_file') }}
                            </strong>
                            <span style="flex: 1;padding: 3px 10px;background-color: #ddd;text-align: left;"></span>
                        </label>
                    </div>
                    <div class="text-center" style="margin-top: 50px">
                        <button type="submit" class="btn btn-primary btn-import">{{trans('common.txt_import')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="ImportExcell_4" class="modal fade" role="dialog">
        <div class="modal-dialog" style="width: 35%;">
            <div class="modal-content">
                <div class="modal-header " style="background:#1d589e;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" style="color: white">Import lương và phụ cấp</h3>
                </div>
                <div class="modal-body">
                    {{--  Form thanh toán lương và phụ cấp  --}}
                    <form id="ImportExcell_4" action="{{url('import_update_luong_phu_cap')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
                        <label for="date_4">Chọn tháng </label>
                        <input  type="text" name="date_4" class="form-control input-date" id="date_4" value="{{$date}}">
                        <div style="margin-top: 20px;">
                            <label>{{trans('common.str_select_file_excel')}}
                                <a href={{url('app/webroot/phpexcel/mau/mau_phucaptienluong.xlsx')}} target="_blank" title="Click để dowload mẫu" style="color: blue">mẫu tại đây</a>
                            </label>
                        </div>
                        <div style="margin-top: 15px">
                            <input name="file4" id="file4" style="display: none;" class="inputfile4" accept=".xlsx" type="file">
                            <label for="file4" style="width: 100%; display: flex; cursor: pointer;">
                                <strong style="margin-right: 10px;">
                                    <svg width="20" height="17" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                    </svg> {{ trans('common.txt_select_file') }}
                                </strong>
                                <span style="flex: 1;padding: 3px 10px;background-color: #ddd;text-align: left;"></span>
                            </label>
                        </div>
                        <div class="text-center" style="margin-top: 50px">
                            <button type="submit" class="btn btn-primary btn-import">{{trans('common.txt_import')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<div id="showImportExcellThuNhapKhac" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 35%;">
        <div class="modal-content">
            <div class="modal-header " style="background:#1d589e;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title" style="color: white">Import Thu nhập khác</h3>
            </div>
            <div class="modal-body">
                {{--  Form thanh toán lương và phụ cấp  --}}
                <form id="showImportExcellThuNhapKhac" action="{{url('import_update_thu_nhap_khac')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <label for="date_5">Chọn tháng </label>
                    <input  type="text" name="date_5" class="form-control input-date" id="date_5" value="{{$date}}">
                    <div style="margin-top: 20px;">
                        <label>{{trans('common.str_select_file_excel')}}
                            <a href="{{url('app/webroot/phpexcel/mau/mau_thunhapkhac.xlsx')}}" target="_blank" title="Click để dowload mẫu" style="color: blue">mẫu tại đây</a>
                        </label>
                    </div>
                    <div style="margin-top: 15px">
                        <input name="file5" id="file5" style="display: none;" class="inputfile5" accept=".xlsx" type="file">
                        <label for="file5" style="width: 100%; display: flex; cursor: pointer;">
                            <strong style="margin-right: 10px;">
                                <svg width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                </svg> {{ trans('common.txt_select_file') }}
                            </strong>
                            <span style="flex: 1;padding: 3px 10px;background-color: #ddd;text-align: left;"></span>
                        </label>
                    </div>
                    <div class="text-center" style="margin-top: 50px">
                        <button type="submit" class="btn btn-primary btn-import">{{trans('common.txt_import')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Hàm hiển thị ra form import thuế
    function showImportExcell(){
        $('#ImportExcell').modal('show');
    }
    // Hàm hiển thị ra form import lương và phụ cấp
    function showImportExcell_4(){
        $('#ImportExcell_4').modal('show');
    }

    // Hàm hiển thị ra form import lương thu nhập khác
    function showImportExcellThuNhapKhac(){
        $('#showImportExcellThuNhapKhac').modal('show');
    }

    // Submit form import thuế
    $('#ImportExcell').submit(function () {
        if($("#date").val() == ''){
            jAlert('Vui lòng chọn tháng','Thông báo');
            return false;
        }
        if($("#file3").val() == ''){
            jAlert('Vui lòng chọn file excel cần nhập','Thông báo');
            return false;
        }else {
            $(".btn-import").prop('disabled', true);
        }

        if($("#file3").val().split('.').pop() !== "xlsx"){
            jAlert('Vui lòng chọn đúng định dạng đuôi ".xlsx"','Thông báo');
            return false;
        } 
    });

    // Submit form import lương và phụ cấp
    $('#ImportExcell_4').submit(function () {
        if($("#date_4").val() == ''){
            jAlert('Vui lòng chọn tháng','Thông báo');
            return false;
        }
        if($("#file4").val() == ''){
            jAlert('Vui lòng chọn file excel cần nhập','Thông báo');
            return false;
        }else {
            $(".btn-import").prop('disabled', true);
        }

        if($("#file4").val().split('.').pop() !== "xlsx"){
            jAlert('Vui lòng chọn đúng định dạng đuôi ".xlsx"','Thông báo');
            return false;
        } 
    });

    // Submit form import thu nhập khác
    $('#showImportExcellThuNhapKhac').submit(function () {
        if($("#date_5").val() == ''){
            jAlert('Vui lòng chọn tháng','Thông báo');
            return false;
        }
        if($("#file5").val() == ''){
            jAlert('Vui lòng chọn file excel cần nhập','Thông báo');
            return false;
        }else {
            $(".btn-import").prop('disabled', true);
        }

        if($("#file5").val().split('.').pop() !== "xlsx"){
            jAlert('Vui lòng chọn đúng định dạng đuôi ".xlsx"','Thông báo');
            return false;
        }
    });

    // Xử lý khi thay đổi file để hiển thị đuôi file (form thuế)
    $('.inputfile3').change(function () {
        resetFilePickerCustom3();
    });
    function resetFilePickerCustom3() {
        files = $('.inputfile3').prop('files');
        if (files && files.length > 0) {
            $('.inputfile3 + label > span').text(files[0].name);
        }
        else {
            $('.inputfile3 + label > span').text('');
        }
    }
    resetFilePickerCustom3();


    // Xử lý khi thay đổi file để hiển thị đuôi file (form lương và phụ cấp)
    $('.inputfile4').change(function () {
        resetFilePickerCustom4();
    });
    function resetFilePickerCustom4() {
        files = $('.inputfile4').prop('files');
        if (files && files.length > 0) {
            $('.inputfile4 + label > span').text(files[0].name);
        }
        else {
            $('.inputfile4 + label > span').text('');
        }
    }
    resetFilePickerCustom4();

    // Xử lý khi thay đổi file để hiển thị đuôi file (form thu nhập khác)
    $('.inputfile5').change(function () {
        resetFilePickerCustom5();
    });
    function resetFilePickerCustom5() {
        files = $('.inputfile5').prop('files');
        if (files && files.length > 0) {
            $('.inputfile5 + label > span').text(files[0].name);
        }
        else {
            $('.inputfile5 + label > span').text('');
        }
    }
    resetFilePickerCustom5();

    // ngày tháng năm
    $('.input-date').datetimepicker({
        format: 'MM/YYYY',
        useCurrent: false,
        maxDate : 'now'
    });

    function showModalSendMail(status,date) {
        jConfirm('Bạn có muốn gửi mail lương đến từng CBVC?', 'Thông báo', function (r) {
            if (r) {
                loading_show();

                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.post("{{ route('gui_mail_luong') }}", {status:status,date:date, _token:CSRF_TOKEN}, () => {
                    jAlert('Gửi mail thông báo lương thành công!', 'Thông báo', function (r) {
                       // location.reload();
                        loading_hide();
                    });

                }, 'json');
            }
        });
    }

</script>
{{--disable--}}
{{--<script>--}}
{{--    $(".btn-import").click(function(){--}}
{{--            //$(".btn-import").prop('disabled', true);--}}
{{--    });--}}
{{--</script>--}}
@endsection