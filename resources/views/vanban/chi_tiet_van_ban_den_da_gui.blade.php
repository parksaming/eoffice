@extends('templates.lanhdao')
@section('main')
    <style>
        .dropdown-item {
            display: block;
            width: 100%;
            padding: .25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
        }

        .dropdown-item:focus, .dropdown-item:hover {
            color: #16181b;
            text-decoration: none;
            background-color: #f0f0f0;
        }

        .dropdown-menu {
            min-width: 124px !important;
        }
    </style>
    <div class="container-fuild pdt20">
            <div id="exTab1">
                <ul class="nav nav-pills">
                    <li class="active bg_luanchuyen">
                        <a href="#1a" data-toggle="tab">Thông tin về văn bản đến</a>
                    </li>
                </ul>
                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1a">
                        <div class="row">
                            <div class="col-sm-12 pdt20">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <td class="row-left">Số đến</td>
                                        <td class="row-right-1">{{$vanbanden->soden}}</td>
                                        <td class="row-left">Độ khẩn</td>
                                        <td class="row-right-1">
                                            <span style="padding:5px 10px;border-radius: 5px;background: #808184;color:#FFF">{{$combobox[$vanbanden->urgency]}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row-left">Ngày đến</td>
                                        <td>{{$vanbanden->ngayden}}</td>
                                        <td class="row-left">Loại văn bản</td>
                                        <td>
                                            <?php
                                            $loaivanban = App\Loaivanban::where('id', $vanbanden->loaivanban_id)->get()->toArray();
                                            ?>
                                            {{$loaivanban['0']['name']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row-left">
                                            Nơi ban hành
                                        </td>
                                        <td class="row-right-1">
                                            <?php
                                            $noibanhanh = App\Donvi::where('id', $vanbanden->cq_banhanh)->first();
                                            ?>
                                            {{$noibanhanh->name}}
                                        </td>
                                        <td class="row-left">Hạn xử lý</td>
                                        <td class="row-right-1">{{formatdmYY($vanbanden->hanxuly)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="row-left">Số ký hiệu</td>
                                        <td>{{$vanbanden->kyhieu}}</td>
                                        <td class="row-left">Trạng thái</td>
                                        <td>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row-left">Ngày VB</td>
                                        <td class="row-right-1">{{formatdmYY($vanbanden->ngayky)}}</td>
                                        <td class="row-left">Người ký</td>
                                        <td class="row-right-1">{{$vanbanden->nguoiky}}</td>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="row-left">Trích yếu</th>
                                        <th rowspan="2">{{$vanbanden->title}}</th>
                                        <td class="row-left">File văn bản</td>
                                        <td>
                                            <?php
                                            $file = explode(';', $vanbanden->file_dinhkem);
                                            $countfile = count($file);
                                            for ($i = 0;$i < $countfile;$i++){
                                            ?>
                                            <a href="{{route('dowload.file',$file[$i])}}">{{$file[$i]}}</a><br>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="row-left">Ghi chú</td>
                                        <td class="row-right-1">{{$vanbanden->note}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="pull-right">
                                    <button class="btn btnLuanChuyen" onclick="quyTrinhChuyenTiep('{{$vanbanden->id}}','{{session('user')['id']}}')"><img class="imgLC" src="{{url('/img/luong_xu_ly_hover.svg')}}"> Luồng luân chuyển </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
        function quyTrinhChuyenTiep(Id,userId) {
            url = '{{url('vanban/quy_trinh_chuyen_tiep')}}';
            loading_show();
            $.get(url,{'Id':Id,'userId':userId}, function(data) {
                loading_hide();
                $('#QuyTrinhChuyenTiep .modal-body').html(data);

                $('#QuyTrinhChuyenTiep .modal-body .group-btn-approve').show();

                $('#QuyTrinhChuyenTiep').modal('show');
            });
        }
    </script>
@endsection