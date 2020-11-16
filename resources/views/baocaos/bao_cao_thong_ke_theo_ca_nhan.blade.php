@extends('templates.lanhdao')
@section('main')
<style>
    .table thead.head-table tr th {
        vertical-align: middle;
        text-align: center; 
        font-weight:bold;
        border-bottom-width: 1px;
    }
    .nav-tabs {
        border-bottom: 1px solid #ddd;
    }
</style>
<div class="container container-list report-statistic">
    @include('flash::message')
    <div class="row">
        <div class="box-head">
            <h3>Báo cáo thống kê văn bản - <small>Thời điểm xuất báo cáo: {{date('d/m/Y')}}</small></h3>
            <i class="fa fa-search btn-filter-statistic btn btn-primary" aria-hidden="true"></i>
        </div>
        <form class="form-filter-bao-cao justify-content-end" action="" method="GET" style="{{ ($donvi_id || $start_time || $end_time) ? '' : 'display: none' }}">
            <div class="d-flex justify-content-center">
                <div class="mr-15">
                    <span style="margin-right: 5px">Đơn vị</span>
                    <select name="donvi_id" class="chosen">
                        <option value="">-- Chọn đơn vị --</option>
                        @foreach($donvis as $donvi)
                        <option {{ $donvi->id == $donvi_id ? 'selected' : '' }} value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mr-15">
                    Từ ngày <input class="ml-5" id="ngaybd" type="text" name="start_time" value="{{ formatdmYY($start_time) }}">
                </div>
                <div class="mr-15">
                    Đến ngày <input class="ml-5" id="ngaykt" type="text" name="end_time" value="{{ formatdmYY($end_time) }}">
                </div>
                <button class="btn btn-primary" type="submit"><i class="fa fa-filter"></i> Thống kê</button>
            </div>
        </form>
        <ul class="nav nav-tabs">
            <li class="active"><a href="{{ route('baocaothongke.canhan') }}">Theo cá nhân</a></li>
            <li><a href="{{ route('baocaothongke.donvi') }}">Theo đơn vị</a></li>
        </ul>
        <br>
        <table class="table table-bordered">
            <thead class="head-table">
                <tr>
                    <th class="col-stt" rowspan="2">TT</th>
                    <th rowspan="2">Cán bộ</th>
                    <th rowspan="2">Văn bản chủ trì</th>
                    <th rowspan="2">Văn bản phối hợp</th>
                    <th colspan="3">Tình trạng</th>
                </tr>
                <tr>
                    <th>Hoàn thành đúng hạn</th>
                    <th>Hoàn thành quá hạn</th>
                    <th>Chưa hoàn thành</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = ($data->currentPage() - 1) * $data->perPage() + 1 ?>
                @foreach ($data as $val)
                <tr data-user-id="{{ $val->user_id }}">
                    <td class="col-stt">{{ $stt++ }}</td>
                    <td>{{ $val->fullname }}</td>
                    <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer ds-bao-cao" data-type="1">{{ $val->tongVBChuTri }}</td>
                    <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer ds-bao-cao" data-type="2">{{ $val->tongVBPhoiHop }}</td>
                    <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-success ds-bao-cao" data-type="3">{{ $val->tongVBHoanThanhDungHan }}</td>
                    <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-warning ds-bao-cao" data-type="4">{{ $val->tongVBHoanThanhQuaHan }}</td>
                    <td data-toggle="tooltip" title="Bấm vào để xem danh sách văn bản" class="cursor-pointer bg-danger ds-bao-cao" data-type="5">{{ $val->tongVBChuaHoanThanh }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="pull-right">
            @include('pagination', ['paginator' => $data, 'interval' => 5])
        </div>
    </div>
</div>

<!-- Modal -->
@include('baocaos._modal_danh_sach_van_ban')

<script type="text/javascript">

    $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '200px', search_contains:true});

    $('.btn-filter-statistic').click(function(event) {
        $('.form-filter-bao-cao').slideToggle();
    });

    $('.ds-bao-cao').click(function(event) {
        let user_id = $(this).closest('tr').data('user-id');
        let type = $(this).data('type');
        let start_time = $('.form-filter-bao-cao input[name="start_time"]').val();
        let end_time = $('.form-filter-bao-cao input[name="end_time"]').val();

        if(type == 1) $('#list-docs .modal-title').text('Danh sách văn bản chủ trì - cá nhân');
        else if(type == 2) $('#list-docs .modal-title').text('Danh sách văn bản phối hợp - cá nhân');
        else if(type == 3) $('#list-docs .modal-title').text('Danh sách văn bản hoàn thành đúng hạn - cá nhân');
        else if(type == 4) $('#list-docs .modal-title').text('Danh sách văn bản hàn thành quá hạn - cá nhân');
        else if(type == 5) $('#list-docs .modal-title').text('Danh sách văn bản chưa hoàn thành - cá nhân');
        loading_show();

        $.getJSON('{{ route("baocaothongke.danhsach") }}', {user_id: user_id, type: type, start_time: start_time, end_time: end_time}, function(json, textStatus) {
            loading_hide();
            if(textStatus !== 'success') return alert('Có lổi phía máy chủ!');
            let tr = '';
            if(json.length == 0) {
                tr += '<tr><td colspan="5">Không có dữ liệu</td></tr>';
            }else{
                $.each(json, function(index, val) {
                    tr += `
                    <tr>
                    <th scope="row">${++index}</th>
                    <td><a href="files/vanban/${val.file_dinhkem}" download>${val.title}</a></td>
                    <td>${val.ngaychuyentiep}</td>
                    <td>${val.ngayxuly}</td>
                    <td>
                    <span class="badge-${val.status == 1 ? 'secondary' : (val.status == 2 ? 'warning' : 'success')}">
                    ${ val.status == 1 ? 'Chưa xử lý' : (val.status == 2 ? 'Đang xử lý' : (val.status == 3 ? 'Đã xử lý' : 'N/A')) }
                    </span>
                    </td>
                    </tr>
                    `;
                });
            }
            $('#list-docs table tbody').html(tr);
            $('#list-docs').modal('show');
        });
    });
</script>
@endsection