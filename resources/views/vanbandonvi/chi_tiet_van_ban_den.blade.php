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

        .noidungbutphe::after {
            content: '-------------------------------------------------------';
            margin-bottom: 15px;
            display: block;
        }
    </style>
    <div class="container-fuild pdt20">
        <div id="exTab1">
            <ul class="nav nav-pills">
                <li class="bg_luanchuyen {{ $tab == 0? 'active' : '' }}">
                    <a href="#1a" data-toggle="tab">Thông tin về văn bản đến</a>
                </li>
                <li class="bg_luanchuyen {{ $tab == 1? 'active' : '' }}">
                    <a href="#2a" data-toggle="tab">Thông tin luân chuyển</a>
                </li>
                <li class="bg_luanchuyen {{ $tab == 2? 'active' : '' }}">
                    <a href="#3a" data-toggle="tab">Trao đổi văn bản</a>
                </li>
                <li class="bg_luanchuyen {{ $tab == 3? 'active' : '' }}">
                    <a href="#4a" data-toggle="tab">Công việc</a>
                </li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane {{ $tab == 0? 'active' : '' }}" id="1a">
                    <div class="row">
                        <div class="pull-left" style="padding-left: 18px;"><div style="font-size: 17px;background: yellow;margin-top: 10px;"><i class="fa fa-tag"></i> Văn bản đến</div></div>
                        <div class="pull-right btn-custom" style="display: flex">
                            <a class="color-w btn btn-primary hidden" href="javascript:;" data-toggle="modal" data-target="#ModalTrinhLanhDao" title="Trình lãnh đạo">Trình lãnh đạo</a>
                            @if ($vanbanden->user_id == session('user')['id'])
                                <a class="color-w btn btn-primary mg-l10" href="{{route('edit_vanban_donvi', $vanbanden->id)}}" title="Sửa văn bản"> Sửa văn bản</a>
                                <a class="color-w btn btn-primary mg-l10" href="javascript:;" onclick="showModalGuiLaiMail()" title="Gửi lại mail"> Gửi lại mail</a>
                            @endif
                            <a class="color-w btn btn-primary mg-l10" href="{{route('chuyen_xu_ly_van_ban_donvi', $vanbanden->id)}}" title="Chuyển xử lý văn bản"> Chuyển xử lý văn bản</a>
                            <button class="btn btn-primary mg-l10" onclick="showModalChuyenTrangThaiVanBan({{$vanbanden->idVBUser}})" title="Đã nhận thông tin văn bản"><i class="fa fa-check-circle" aria-hidden="true"> Xử lý văn bản</i></button>
                        </div>
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
                                    <td>{{formatdmYY($vanbanden->ngayden)}}</td>
                                    <td class="row-left">Loại văn bản</td>
                                    <td>
                                        <?php
                                        $loaivanban = App\Loaivanban::where('id', $vanbanden->loaivanban_id)->get()->toArray();
                                        ?>
                                        {{$loaivanban['0']['name']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row-left">Nơi ban hành</td>
                                    <td class="row-right-1">{{ $vanbanden->cq_banhanh }}</td>
                                    <td class="row-left">Hạn xử lý</td>
                                    <td class="row-right-1">{{formatdmYY($vanbanden->hanxuly)}}</td>
                                </tr>
                                <tr>
                                    <td class="row-left">Số ký hiệu</td>
                                    <td>{{$vanbanden->kyhieu}}</td>
                                    <td class="row-left">Trạng thái</td>
                                    <td>
                                        <?php if($vanbanden->trangthai === 1){?>
                                        <span class="doNotAction">Chưa xử lý</span>
                                        <?php } elseif($vanbanden->trangthai === 2){?>
                                        <span class="doingAction">Đang xử lý</span>
                                        <?php } elseif($vanbanden->trangthai === 3){?>
                                        <span class="doneAction">Đã xử lý</span>
                                        <?php }?>
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
                                        @php
                                            $files = explode(';', $vanbanden->file_dinhkem);
                                            foreach($files as $file) {
                                                echo sprintf('<div><a href="%s" target="_blank" title="%s">%s</a></div>', route('dowload.file', [$file, 'vanban_id' => $id]), $file, $file);
                                            }
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row-left">Ghi chú</td>
                                    <td>{{$vanbanden->note}}</td>
                                </tr>
                                <tr>
                                    <td class="row-left">Đơn vị chủ trì</td>
                                    <td class="row-right-1">{{ $vanbanden->donviChuTriName }}</td>
                                    <td class="row-left">Người chủ trì</td>
                                    <td class="row-right-1">
                                        @foreach ($userChuTris as $user)
                                            <span class="item-user">{{ $user->fullname.' - '.$user->donvi->name.' - '.$user->email }}</span>, 
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td class="row-left">Đơn vị phối hợp</td>
                                    <td>
                                        @foreach ($donviPhoihops as $donvi)
                                            <span class="item-donvi">{{ $donvi->name }}</span>, 
                                        @endforeach
                                    </td>
                                    <td class="row-left">Người phối hợp</td>
                                    <td>
                                        @foreach ($userPhoihops as $user)
                                            <span class="item-user">{{ $user->fullname.' - '.$user->donvi->name.' - '.$user->email }}</span>, 
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <td class="row-left" style="background: yellow;color: #000;">Nội dung bút phê</td>
                                    <td colspan="3">
                                        @if (sizeof($vbxuly->butphes))
                                            <div>
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 120px;">Ngày giờ</th>
                                                            <th style="width: 180px;">Người gửi</th>
                                                            <th style="width: 320px;">Người nhận</th>
                                                            <th>Nội dung</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($vbxuly->butphes as $butphe)
                                                            <tr>
                                                                <td>{{ $butphe->created_at_text }}</td>
                                                                <td>{{ $butphe->userTao->fullname }}</td>
                                                                <td>{{ implode(', ', $butphe->userNhans) }}</td>
                                                                <td>{!! nl2br($butphe->noidung) !!}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                
                                </tbody>
                            </table>
                            <div class="pull-right">
                                <button onclick="quyTrinhChuyenTiep('{{$id}}','{{$parentId->id_nhan}}')" class="btn btnLuanChuyen"><img class="imgLC" src="{{url('/img/luong_xu_ly_hover.svg')}}">Luồng luân chuyển</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane {{ $tab == 1? 'active' : '' }}" id="2a">
                    <div class="pull-left" style="margin-bottom: 18px;"><div style="font-size: 17px;background: yellow;margin-top: 10px;"><i class="fa fa-tag"></i> Văn bản đến</div></div>
                    <table class="table table-bordered mg-t20 table-striped">
                        <thead class="head-table">
                        <tr>
                            <th>Người gửi</th>
                            <th>Đơn vị/Cá nhân nhận</th>
                            <th>Thời gian gửi/nhận</th>
                            <th>Trạng thái</th>
                            <th>Minh chứng</th>
                            <th class="text-center">File</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($vb_child as $vanbanxuly):
                        ?>
                            <tr>
                                <td>{{$vanbanxuly->nameUserGui}}</td>
                                <td>{{$vanbanxuly->nameUserNhan}} <br>
                                {{$vanbanxuly->tenDonVi}}</td>
                                <td><i>{{formatDMY($vanbanxuly->ngaygui)}}</i> <br>
                                    <i><b>{{isset($vanbanxuly->ngayxem) ? formatDMY($vanbanxuly->ngayxem):''}}</b></i>
                                </td>
                                <td>
                                    <?php if($vanbanxuly->status == 1){?>
                                    <span class="doNotAction lh36">Chưa xử lý</span>
                                    <?php } elseif($vanbanxuly->status == 2){?>
                                    <span class="doNotAction lh36">Chưa xử lý</span>
                                    <?php } elseif($vanbanxuly->status == 3){?>
                                        <span class="doneAction lh36">Đã xử lý</span><br>
                                        <i>{{formatDateTimeToDisplay($vanbanxuly->ngayxuly)}}</i>
                                    <?php }?>
                                </td>

                                @if ($vanbanxuly->status == 3)
                                    <td>{!! nl2br($vanbanxuly->minhchung) !!}</td>
                                    <td class="text-center">
                                        @if ($vanbanxuly->file_minhchung)
                                            <a href="{{ route('dowload.file', [$vanbanxuly->file_minhchung]) }}" target="_blank" title="{{ $vanbanxuly->file_minhchung }}">
                                                <i class="fa fa-paperclip"></i>
                                            </a>
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <button onclick="quyTrinhChuyenTiep('{{$id}}','{{$parentId->id_nhan}}')" class="btn btnLuanChuyen"><img class="imgLC" src="{{url('/img/luong_xu_ly_hover.svg')}}"> Luồng luân chuyển</button>
                    </div>
                </div>
                <div class="tab-pane {{ $tab == 2? 'active' : '' }}" id="3a">
                    <div class="pull-left" style="margin-bottom: 18px;"><div style="font-size: 17px;background: yellow;margin-top: 10px;"><i class="fa fa-tag"></i> Văn bản đến</div></div>
                    @include('vanbandonvi.chi_tiet_van_ban_den_tab_y_kiens', ['vbxuly' => $vbxuly])
                </div>
                <div class="tab-pane {{ $tab == 3? 'active' : '' }}" id="4a">
                    <div style="margin-bottom: 18px;"><div style="font-size: 17px;background: yellow;margin-top: 10px;display: inline-block;"><i class="fa fa-tag"></i> Văn bản đến</div></div>
                    @include('vanbandonvi._danh_sach_cong_viec', ['vanbanxuly' => $vanBanXuLy])
                </div>
            </div>
        </div>
    </div>

    <div id="XuLyVanBan" class="modal fade" role="dialog">
    </div>

    <div id="QuyTrinhChuyenTiep" class="modal fade  test" role="dialog">
        <div class="modal-dialog" style="width:70%;">
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
    
    <div id="ModalGuiLaiMail" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Gửi lại mail</h4>
                </div>
                <div class="modal-body">
                    <h4>Bạn có muốn gửi lại những mail sau:</h4>
                    <div>
                        @foreach ($userChuTris as $user)
                            <h5>- {{ $user->fullname.' - '.$user->donvi->name.' - '.$user->email }}</h5>
                        @endforeach
                        @foreach ($userPhoihops as $user)
                            <h5>- {{ $user->fullname.' - '.$user->donvi->name.' - '.$user->email }}</h5>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer" style="border-top:0; ">
                    <a href="javascript:;" onclick="guiLaiMail()" class="btn btn-primary">Đồng ý</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModalGuiLaiMail() {
            $('#ModalGuiLaiMail').modal('show');
        }

        function guiLaiMail() {
            loading_show();
            $('#ModalGuiLaiMail').modal('hide');

            $.post("{{ route('gui_lai_mail_donvi', [$vbxuly->vanbanUser_id]) }}", {_token:$('meta[name="csrf-token"]').attr('content')}, function (res) {
                loading_hide();
                if (!res.error) {
                    jAlert('Mail đã được gửi', 'Thông báo');
                }
                else {
                    jAlert('Không thể gửi mail', 'Thông báo');
                }
            });
        }

        function sendInfo($id, $type) {
            alert($type);
            var url = "{{ url('vanban/'.$vanbanden->idVBUser.'/sendInfo_donvi') }}";
            var id = $id;
            var type = $type;
            var token = '{{ csrf_token() }}';

            loading_show();
            $.post(url, {'id': id, 'type': type, '_token': token}, function (data) {
                loading_hide();
                if (data.error == 0) {
                    location.reload(true);
                    jAlert('{!! trans("Cập nhật tình trạng thành công") !!}', '{!! trans("Thông báo") !!}');
                } else {
                    jAlert('{!! trans("Cập nhật thất bại") !!}', '{!! trans("Thông báo") !!}');
                }
            }, 'json');

        }

        function showModalChuyenTrangThaiVanBan(vanbanxulyId) {
            let $modal = $('#XuLyVanBan');
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            loading_show();
            $.post("{{ route('vanban.check_xu_ly_vanban_donvi') }}", { vanbanxuly_id: vanbanxulyId, _token: CSRF_TOKEN }, function(html) {
                loading_hide();
                $modal.html(html);
                $modal.modal('show');
            });
        }

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