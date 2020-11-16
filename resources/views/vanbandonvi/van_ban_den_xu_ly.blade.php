@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách văn bản đến cần xử lý</h4>
            </div>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th>Số đến</th>
                        <th>Nơi ban hành</th>
                        <th>Số ký hiệu</th>
                        <th> Ngày ban hành</th>
                        <th>Trích yếu</th>
                        <th> Nơi nhận</th>
                        <th> Nội dung bút phê</th>
                        <th> Trạng thái</th>
                        <th>File</th>
                        <th class="text-center w-15">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($vanbanxulys))
                @foreach ($vanbanxulys as $vanbanxuly)
                    <?php
                    $stt = 1;
                    $stt = ($vanbanxulys->currentPage() - 1) * $vanbanxulys->perPage() + 1;
                    ?>
                    <tr>
                        <td>{{$vanbanxuly->soden}}</td>
                        <td>{{$vanbanxuly->tenDonViBanHanh}}</td>
                        <td>{{$vanbanxuly->kyhieu}}</td>
                        <td>{{$vanbanxuly->ngayky}}</td>
                        <td>{{$vanbanxuly->title}}</td>
                        <td>{{$vanbanxuly->fullname }}</td>
                        <td>{{$vanbanxuly->noidung_butphe}}</td>
                        <td>
                            <?php if($vanbanxuly->trangthai == 1){?>
                            <span class="doNotAction lh36">Chưa xử lý</span>
                            <?php } elseif($vanbanxuly->trangthai == 2){?>
                            <span class="doNotAction lh36">Chưa xử lý</span>
                            <?php } elseif($vanbanxuly->trangthai == 3){?>
                            <span class="doneAction lh36">Đã xử lý</span>
                            <?php }?>
                        </td>
                        <td>
                            <a href="{{ route('dowload.file', [$vanbanxuly->file_dinhkem]) }}" target="_blank">
                                <?php echo $vanbanxuly->file_dinhkem;?>
                            </a>
                        </td>
                        <td class="text-center">
                            <span style="padding:5px 10px"><a href="{{route('chuyen_xu_ly_van_ban_donvi',$vanbanxuly->vanbanUser_id)}}" title="Chuyển xử lý văn bản"><i class="fa fa-share" aria-hidden="true"></i></a></span>
{{--                            <span style="padding:5px 10px"><a href="{{route('gui_but_phe_van_ban_den',$vanbanxuly->id)}}" title="Gửi bút phê"><i class="fa fa-paper-plane" aria-hidden="true"> </i></a></span>--}}
                            <span style="padding:5px 10px"><a href="{{route('chitiet_vanban_donvi',$vanbanxuly->vanbanUser_id)}}" title="Xem chi tiết"><i class="fa fa-eye"> </i></a></span>
{{--                            <span style="padding:5px 10px"><a href="{{route('view_log',$vanbanxuly->IdVanBanUser)}}" target="_blank" title="Xem log"><i class="fa fa-low-vision" aria-hidden="true"></i></a></span>--}}
{{--                            <span style="padding:5px 10px"><a  onclick="quyTrinhChuyenTiep({{$vanbanxuly->IdVanBanUser}})" title="Xem quy trình chuyển xử lý"><i class="fa fa-recycle" aria-hidden="true"></i></a></span>--}}
                            <span style="padding:5px 10px"><a onclick="quyTrinhChuyenTiep('{{$vanbanxuly->vanbanUser_id}}','{{$vanbanxuly->usernhan}}')" title="Xem quy trình chuyển xử lý"><i class="fa fa-recycle" aria-hidden="true"></i></a></span>

                            {{--<span style="padding:5px 10px"><a href="{{route('gui_lai_mail_van_ban_den',$ds->id)}}" title="Gửi lại Mail"><i class="fa fa-envelope"> Gửi lại mail </i></a></span>--}}
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" align="center"><i> Không có văn bản đến cần xử lý</i></td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include('pagination', ['paginator' => $vanbanxulys, 'interval' => 5])
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
    <script type="text/javascript">
        $('#search').click(function(){
            var tukhoa = $('#tukhoa').val();
            var timtheo = $('#timtheo').val();
            var linhvuc = $('#linhvuc_search').val();
            var loaivanban = $('#loaivanban_search').val();
            var ngaybh_tu = $('#ngaybh_tu').val();
            var ngaybh_den = $('#ngaybh_den').val();
            var hienthi = $('#hienthi_search').val();
            var status = $('#status_search').val();
            var token = '{{csrf_token()}}';
            var url = '{{route('ajax_dsvanban_donvi')}}';
            $.post(url,{
                'tukhoa' : tukhoa,
                'timtheo': timtheo,
                'linhvuc': linhvuc,
                'loaivanban' : loaivanban,
                'ngaybh_tu' : ngaybh_tu,
                'ngaybh_den' : ngaybh_den,
                'hienthi' : hienthi,
                'status' :status,
                '_token' : token
            },function(data){

            });
        });
        $('div.alert').not('.alert-important').delay(2000).fadeOut(350);


        function quyTrinhChuyenTiep(Id,userId) {
            url = '{{url('vanban/quy_trinh_chuyen_tiep_donvi')}}';
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
