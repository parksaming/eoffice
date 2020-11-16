@extends('templates.lanhdao')
@section('main')
    <style>
        .table thead.head-table tr th {
            vertical-align: middle;
            text-align: center; 
            font-weight:bold;
            border-bottom-width: 1px;
        }
    </style>
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Báo cáo chi tiết tình hình xử lý văn bản đến</h4>
                <span style="display: block; text-align: center; font-weight: bold; margin-bottom: 20px;">Thời điểm xuất báo cáo: {{date('d/m/Y')}}</span>
                <div>
                    <?php
                        $percentDangXuLy = $total->tongSoVBDen? round($total->tongSoVBDangXuLy/$total->tongSoVBDen*100, 2) : 0;
                        $percentChuaXuLy = $total->tongSoVBDen? round($total->tongSoVBChuaXuLy/$total->tongSoVBDen*100, 2) : 0;
                        $percentDaXuLy = $total->tongSoVBDen? 100 - $percentDangXuLy - $percentChuaXuLy : 0;
                    ?>
                    <span style="margin-right: 15px;">Tổng số vb đến: <strong>{{$total->tongSoVBDen}}</strong></span>
                    <span style="margin-right: 15px;">Số vb đang xử lý: <strong>{{$total->tongSoVBDangXuLy.' ('.$percentDangXuLy.'%)'}}</strong></span>
                    <span style="margin-right: 15px;">Số vb chưa xử lý: <strong>{{$total->tongSoVBChuaXuLy.' ('.$percentChuaXuLy.'%)'}}</strong> - trong đó số vb chưa đọc: <strong>{{$total->tongSoVBChuaDoc}}</strong></span>
                    <span style="margin-right: 15px;">Số vb đã xử lý: <strong>{{$total->tongSoVBChuaXuLy.' ('.$percentDaXuLy.'%)'}}</strong></span>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th style="width: 3%;" rowspan="2">TT</th>
                        <th style="width: 7%;" rowspan="2">Ngày nhận</th>
                        <th style="width: 9%;" rowspan="2">Cơ quan ban hành</th>
                        <th style="width: 9%;" rowspan="2">Số/ký hiệu văn bản</th>
                        <th style="width: 7%;" rowspan="2">Ngày văn bản</th>
                        <th style="width: 9%;" rowspan="2">Trích yếu nội dung văn bản</th>
                        <th style="width: 7%;" rowspan="2">Hạn xử lý</th> 
                        <th style="width: 8%;" rowspan="2">Đơn vị chủ trì xử lý</th>
                        <th style="width: 8%;" rowspan="2">Cán bộ/chuyên viên xử lý</th>
                        <th style="width: 5%;" rowspan="2">Trạng thái văn bản đến</th>
                        <th style="width: 5%;" rowspan="2">Tình trạng văn bản đến</th>
                        <th style="width: 20%;" colspan="4">Tình trạng xử lý văn bản của <br> chuyên viên</th> 
                        <th style="width: 3%;" rowspan="2"></th>
                    </tr>
                    <tr>
                        <th style="width: 5%;">Trước hạn</th>
                        <th style="width: 5%;">Đúng hạn</th>
                        <th style="width: 5%;">Còn hạn</th>
                        <th style="width: 5%;">Quá hạn</th>
                    </tr>
                </thead>
                <tbody>
                <?php $stt = ($ds_vanbans->currentPage() - 1) * $ds_vanbans->perPage() + 1 ?>
                @foreach ($ds_vanbans as $ds)
                    <tr>
                        <td style="text-align: center; width: 3%;">{{$stt++}}</td>
                        <td style="text-align: center; width: 7%;">{{$ds->ngaychuyentiepRaw? date('d/m/Y', strtotime($ds->ngaychuyentiepRaw)) : ''}}</td>
                        <td style="width: 9%;">{{$ds->tenDonViBanHanh}}</td>
                        <td style="width: 9%;">{{$ds->kyhieu}}</td>
                        <td style="text-align: center;width: 7%;">{{$ds->ngayky? date('d/m/Y', strtotime($ds->ngayky)) : ''}}</td>
                        <td style="text-align: left;width: 9%;">{{$ds->title}}</td>
                        <td style="text-align: center;width: 7%;">{{$ds->hanxuly? date('d/m/Y', strtotime($ds->hanxuly)) : ''}}</td> 
                        <td style="width: 8%;">{{$ds->tenDonViNhan}}</td>
                        <td style="width: 8%;">{{$ds->fullname}}</td>
                        <td style="width: 5%;">{{ strtotime($ds->hanxuly) > time()? 'Trong hạn' : 'Quá hạn' }}</td>
                        <td style="width: 5%; white-space: nowrap;">{{ $ds->status === 3? 'Đã xử lý' : ($ds->status === 2? 'Đang xử lý' : 'Chưa xử lý') }}</td>
                        <td style="text-align: center;width: 5%;">
                            @if($ds->status == 3 && strtotime($ds->ngayxuly) < strtotime(date('Y-m-d')))
                                <i class="fa fa-check green" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td style="text-align: center;width: 5%;">
                            @if($ds->status == 3 && strtotime($ds->ngayxuly) == strtotime(date('Y-m-d')))
                                <i class="fa fa-check green" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td style="text-align: center;width: 5%;">
                            @if($ds->status != 3 && strtotime($ds->hanxuly) > strtotime(date('Y-m-d')))
                                <i class="fa fa-check green" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td style="text-align: center;width: 5%;">
                            @if($ds->status != 3 && strtotime($ds->hanxuly) <= strtotime(date('Y-m-d')))
                                <i class="fa fa-check green" aria-hidden="true"></i>
                            @endif
                        </td>
                        <td style="width: 3%;">
                            <span style="padding:5px 10px"><a  onclick="quyTrinhChuyenTiep('{{$ds->id}}')" title="Xem quy trình chuyển xử lý"><i class="fa fa-recycle" aria-hidden="true"></i></a></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pull-right">
                @include('pagination', ['paginator' => $ds_vanbans, 'interval' => 5])
            </div>
        </div>
    </div>

    <div id="QuyTrinhChuyenTiep" class="modal fade  test" role="dialog">
        <div class="modal-dialog" style="width: 70%;">
            <div class="modal-content">
                <div class="modal-header " style="background:#01b2d2">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title styleH">Luồng xử lý</h3>
                </div>
                <div id="printHead" class="cssa" style="top: 12px; right: 40px; background-color:#fff;height: 70px;border-bottom: 1px solid #dfe0e1;padding-right:38%;" >
                    <div>
                        <div style="float: right; padding: 25px 5px; font-size: 12px;margin-right:10px;">Đã xử lý</div>
                        <div style="background: #35aa47;width:20px; height:20px; float:right;margin-top:24px;border-radius:3px;"></div>
                    </div>
                    <div>
                        <div style="color: #000000; float: right; padding: 25px 5px; font-size: 12px;margin-right:10px;">Đang xử lý</div>
                        <div style="background: #fbac41;width:20px; height:20px; float:right;margin-top:24px;border-radius:3px;"></div>
                    </div>
                    <div>
                        <div style="color: #000; float: right; padding: 25px 5px; font-size: 12px;margin-right:10px;">Chưa xử lý</div>
                        <div style="background:#e0e0e0; width:20px; height:20px;float:right; margin-top:24px;border-radius:3px;position:relative;"></div>
                    </div>
                    <div>
                        <div style="color: #000; float: right; padding: 25px 5px; font-size: 12px;margin-right:10px;">Chưa đọc</div>
                        <div style="background:#e0e0e0 ; width:20px; height:20px;float:right; margin-top:24px;border-radius:3px;position:relative;"><img src="{{url('/img/dot.svg')}}"style="width:12px !important; font-weight: bold;position: absolute; color: #ee4036;margin-top: -4px;margin-left: -4px;"></div>
                    </div>
                    <div>
                        <div style="color: #000; float: right; padding: 25px 5px; font-size: 12px;margin-right:10px;">Chủ trì</div>
                        <div style="border: 2px dotted #000; background:#e0e0e0 ; width:20px; height:20px;float:right; margin-top:24px;border-radius:3px;position:relative;"></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <!-- Modal content-->
                <div class="modal-body">

                </div>
                <div class="modal-footer" style="border-top:0; ">
                </div>
            </div>
        </div>
    </div>

    <script>

        function quyTrinhChuyenTiep(Id) {
            url = '{{url('vanban/quy_trinh_chuyen_tiep')}}';
            loading_show();
            $.get(url,{'Id':Id}, function(data) {
                loading_hide();
                $('#QuyTrinhChuyenTiep .modal-body').html(data);

                $('#QuyTrinhChuyenTiep .modal-body .group-btn-approve').show();

                $('#QuyTrinhChuyenTiep').modal('show');
            });
        }
    </script>
@endsection