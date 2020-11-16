@extends('templates.lanhdao')
@section('main')

    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách văn bản đến</h4>
            </div>

            <div class="col-md-12" style="display: flex;justify-content: space-between;padding: 0;margin-bottom: 18px;">
                <ul class="nav nav-pills">
                    <li class="bg_luanchuyen {{ $status == 'chuaxuly'? 'active' : '' }}">
                        <a href="{{ route('danhsach.vanbanden', ['status' => 'chuaxuly']) }}">Chưa xử lý</a>
                    </li>
                    <li class="bg_luanchuyen {{ $status == 'dangxuly'? 'active' : '' }}">
                        <a href="{{ route('danhsach.vanbanden', ['status' => 'dangxuly']) }}">Đang xử lý</a>
                    </li>
                    <li class="bg_luanchuyen {{ $status == 'daxuly'? 'active' : '' }}">
                        <a href="{{ route('danhsach.vanbanden', ['status' => 'daxuly']) }}">Đã xử lý</a>
                    </li>
                    <li class="bg_luanchuyen {{ $status == 'ganhethan'? 'active' : '' }}">
                        <a href="{{ route('danhsach.vanbanden', ['status' => 'ganhethan']) }}">Báo hết hạn</a>
                    </li>
                    <li class="bg_luanchuyen {{ (!$status || $status == 'all')? 'active' : '' }}">
                        <a href="{{ route('danhsach.vanbanden', ['status' => 'all']) }}">Tất cả</a>
                    </li>
                </ul>
                <div>
                    <a href="javascript:;" title="Tìm kiếm" class="btn btn-primary btn-show-container-search" style="width: 35px;height: 35px;display: flex;align-items: center;justify-content: center;padding: 0;">
                        <i class="fa fa-search" style="position: relative;font-size: 20px;right: unset;"></i>
                    </a>
                    <script>
                        $(document).ready(function() {
                            $('.btn-show-container-search').click(function () {
                                $('.container-search').toggleClass('hidden');
                            })
                        })
                    </script>
                </div>
            </div>

            @php
                $tukhoa = isset($_GET['tukhoa'])? $_GET['tukhoa'] : '';
                $trangthai = isset($_GET['trangthai'])? $_GET['trangthai'] : '';
                $linhvucId = isset($_GET['linhvuc'])? $_GET['linhvuc'] : '';
                $loaivanbanId = isset($_GET['loaivanban'])? $_GET['loaivanban'] : '';
                $ngaybanhanhtu = isset($_GET['ngaybanhanhtu'])? $_GET['ngaybanhanhtu'] : '';
                $ngaybanhanhden = isset($_GET['ngaybanhanhden'])? $_GET['ngaybanhanhden'] : '';
                $ngayguitu = isset($_GET['ngayguitu'])? $_GET['ngayguitu'] : '';
                $ngayguiden = isset($_GET['ngayguiden'])? $_GET['ngayguiden'] : '';
            @endphp
            <div class="container container-search {{ ($tukhoa === '' && $trangthai === '' && $linhvucId === '' && $loaivanbanId === '' && $ngaybanhanhtu === '' && $ngaybanhanhden === '' && $ngayguitu === '' && $ngayguiden === '')? 'hidden' : '' }}">
                <div class="row">
                    <div class="col-md-12">
                        <form method="GET" action="{{ route('danhsach.vanbanden') }}">
                            <input type="hidden" name="status" value="{{ $status }}">
                            <div class="form-row row">
                               <div class="col-md-12 vanban">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Số ký hiệu/Trích yếu</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   @php $tukhoa = isset($_GET['tukhoa'])? $_GET['tukhoa'] : '' @endphp
                                                   <input type="text" class="form-control" name="tukhoa" value={{ $tukhoa }}>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Trạng Thái</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                    @php $trangthai = isset($_GET['trangthai'])? $_GET['trangthai'] : '' @endphp
                                                   <select class="form-control" name="trangthai" id="status_search">
                                                       <option value="">Chọn trạng thái</option>
                                                       <option value="daxuly" {{ $trangthai == 'daxuly'? 'selected' : '' }}>Đã xử lý</option>
                                                       <option value="dangxuly" {{ $trangthai == 'dangxuly'? 'selected' : '' }}>Đang xử lý</option>
                                                       <option value="chuaxuly" {{ $trangthai == 'chuaxuly'? 'selected' : '' }}>Chưa xử lý</option>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-12 vanban">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Lĩnh vực</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                    @php $linhvucId = isset($_GET['linhvuc'])? $_GET['linhvuc'] : '' @endphp
                                                   <select class="form-control" name="linhvuc" id="linhvuc_search">
                                                       <option value=""> Tất cả </option>
                                                       @foreach ($linhvucs as $linhvuc)
                                                           <option value="{{$linhvuc->id}}" {{ $linhvucId == $linhvuc->id? 'selected' : '' }}>{{$linhvuc->name}}</option>
                                                           @endforeach
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Loại văn bản</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                    @php $loaivanbanId = isset($_GET['loaivanban'])? $_GET['loaivanban'] : '' @endphp
                                                   <select class="form-control" name="loaivanban" id="loaivanban_search">
                                                       <option value=""> Tất cả </option>
                                                      @foreach ($loaivanbans as $loaivanban)
                                                          <option value="{{$loaivanban->id}}" {{ $loaivanbanId == $loaivanban->id? 'selected' : '' }}>{{$loaivanban->name}}</option>
                                                          @endforeach
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-12 vanban">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Ngày ban hành</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   <div class="row">
                                                       <div class="col-md-6">
                                                            @php $ngaybanhanhtu = isset($_GET['ngaybanhanhtu'])? $_GET['ngaybanhanhtu'] : '' @endphp
                                                           <input autocomplete="off" type="text" class="form-control" name="ngaybanhanhtu" placeholder="Từ ngày" id="ngaybh_tu" value="{{ $ngaybanhanhtu }}">
                                                       </div>
                                                       <div class="col-md-6">
                                                            @php $ngaybanhanhden = isset($_GET['ngaybanhanhden'])? $_GET['ngaybanhanhden'] : '' @endphp
                                                           <input autocomplete="off" type="text" class="form-control" name="ngaybanhanhden" placeholder="Đến ngày" id="ngaybh_den" value="{{ $ngaybanhanhden }}">
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Ngày gửi</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   <div class="row">
                                                       <div class="col-md-6">
                                                            @php $ngayguitu = isset($_GET['ngayguitu'])? $_GET['ngayguitu'] : '' @endphp
                                                           <input autocomplete="off" type="text" class="form-control" name="ngayguitu" placeholder="Từ ngày" id="ngaygui_tu" value="{{ $ngayguitu }}">
                                                       </div>
                                                       <div class="col-md-6">
                                                            @php $ngayguiden = isset($_GET['ngayguiden'])? $_GET['ngayguiden'] : '' @endphp
                                                           <input autocomplete="off" type="text" class="form-control" name="ngayguiden" placeholder="Đến ngày" id="ngaygui_den" value="{{ $ngayguiden }}">
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-12 vanban hidden">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Hiển thị</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   <select class="form-control" name="hienthi" id="hienthi_search">
                                                        <option value="">Sắp theo ngày ký</option>
                                                   </select>
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                       </div>
                                   </div>
                               </div>
                               <div class="col-md-12" style="margin-bottom: 10px;">
                                   <div class="row" style="text-align: center">
                                       <button type="submit" class="btn btn-primary" style="margin-top:10px" id="search">Tìm kiếm</button>
                                   </div>
                               </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

             <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th>STT</th>
                        <th>Số đến</th>
                        <th>Loại văn bản</th>
                        <th>Đơn vị chủ trì</th>
                        <th>Số ký hiệu</th>
                        <th>Ngày ban hành</th>
                        <th>Trích yếu</th>
                        <th>Hạn xử lý</th>
                        <th>Trạng thái</th>
                        <th>File</th>
                        <th class="text-center">Luồng VB</th>
                        <th class="text-center">Chuyển</th>
                        <th class="text-center">Xem</th>
                    </tr>
                </thead>
                <tbody>
                @if(sizeof($vanbans))
                    @php $stt = ($vanbans->currentPage() - 1) * $vanbans->perPage() + 1 @endphp
                    @foreach ($vanbans as $val)
                        <tr>
                            <td class="col-stt">{{$stt++}}</td>
                            <td><a href="{{route('chitiet_vanban',$val->vanbanUser_id)}}">{{$val->vanban->soden}}</a>{!! !$val->ngayxem? '<br><i style="font-size:11px;color:red;">Chưa đọc</i>' : '' !!}</td>
                            <td>{{$val->vanban->loaivanban? $val->vanban->loaivanban->name : ''}}</td>
                            <td>{{$val->vanban->donviChuTri? $val->vanban->donviChuTri->name : ''}}</td>
                            <td>
                                <a href="{{route('chitiet_vanban',$val->vanbanUser_id)}}" title="{{$val->vanban->kyhieu}}">{{$val->vanban->kyhieu}}</a>
                            </td>
                            <td>{{$val->vanban->ngayky}}</td>
                            <td>{{$val->vanban->title}}</td>
                            <td>{{$val->vanban->hanxuly }}<br>
                                @if( $status == 'ganhethan')
                                   <?php
                                    $date1 = new DateTime(formatYMD($val->vanban->hanxuly));
                                    $date2 = new DateTime(date('Y-m-d'));
                                    $interval = $date1->diff($date2);
                                    $tgquahan = $interval->m > 0 ? $interval->m . " tháng, " . $interval->d . " ngày" : $interval->d . " ngày";?>
                                    @if($interval->m > 0 || $interval->format('%R%d') > 0)
                                        <span class="text-quahanxuly"> (Quá hạn <?php echo $tgquahan;?>)</span>
                                    @else
                                        <span class="text-conhanxuly"> (Còn <?php echo $tgquahan;?>)</span>
                                    @endif
                                @endif</td>
                            <td>
                                @if ($val->status == 1)
                                    <a href="javascript:;" onclick="showModalChuyenTrangThaiVanBan({{$val->id}})" class="<?php echo $status == 'ganhethan'  ? 'disabled' : ''?> doNotAction lh36">Chưa xử lý</a>
                                @elseif ($val->status == 2)
                                    <a href="javascript:;" onclick="showModalChuyenTrangThaiVanBan({{$val->id}})" class="<?php echo $status == 'ganhethan'  ? 'disabled' : ''?> doingAction lh36">Đang xử lý</a>
                                @elseif ($val->status == 3)
                                    <a href="javascript:;" onclick="showModalChuyenTrangThaiVanBan({{$val->id}})" class="<?php echo $status == 'ganhethan'  ? 'disabled' : ''?> doneAction lh36">Đã xử lý</a>
                                @endif
                            </td>
                            <td>
                                @if ($val->vanban->file_dinhkem)
                                    <div style="display: flex;flex-direction: column;">
                                        @php
                                            $files = explode(';', $val->vanban->file_dinhkem);
                                            foreach($files as $key => $file) {
                                                echo sprintf('<a href="%s" target="_blank" title="%s">%s</a>', route('dowload.file', [$file, 'vanban_id' => $val->vanbanUser_id,'numberFile' => $key]), $file, $file);
                                            }
                                        @endphp
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span style="padding:5px 10px"><a class="" href="javascript:;" onclick="quyTrinhChuyenTiep('{{$val->vanbanUser_id}}')" title="Xem quy trình chuyển xử lý"><img src="{{ asset('img/workflow.png') }}" alt="Xem chuyển xử lý" style="width: 16px; height: 16px;"></a></span>
                            </td>
                            <td class="text-center">
                                <span style="padding:5px 10px">
                                    @if( $status == 'ganhethan')
                                        <a class="disabled" href="javascript:;"><i class="fa fa-paper-plane"></i></a>
                                     @else
                                        <a href="{{route('chuyen_xu_ly_van_ban',$val->vanbanUser_id)}}" title="Chuyển xử lý văn bản"><i class="fa fa-paper-plane"></i></a>
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                <span style="padding:5px 10px"><a href="{{route('chitiet_vanban',$val->vanbanUser_id)}}" title="Xem chi tiết"><i class="fa fa-eye"> </i></a></span>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="14" align="center"><i> Không có văn bản đến cần xử lý</i></td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="pull-right">
                @include('pagination', ['paginator' => $vanbans, 'interval' => 5])
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
                <div class="modal-body scroll_xuly" style="    min-width: 100%;
    max-width: 100%;
    overflow: auto;">

                </div>
                <div class="modal-footer" style="border-top:0; ">
                </div>
            </div>
        </div>
    </div>
    
    <div id="XuLyVanBan" class="modal fade" role="dialog">
        
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
            var url = '{{route('ajax_dsvanban')}}';
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
            url = '{{url('vanban/quy_trinh_chuyen_tiep')}}';
            loading_show();
            $.get(url,{'Id':Id,'userId':userId}, function(data) {
                loading_hide();
                $('#QuyTrinhChuyenTiep .modal-body').html(data);

                $('#QuyTrinhChuyenTiep .modal-body .group-btn-approve').show();

                $('#QuyTrinhChuyenTiep').modal('show');
            });
        }

        function showModalChuyenTrangThaiVanBan(vanbanxulyId) {
            let $modal = $('#XuLyVanBan');
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            loading_show();
            $.post("{{ route('vanban.check_xu_ly_vanban') }}", { vanbanxuly_id: vanbanxulyId, _token: CSRF_TOKEN }, function(html) {
                loading_hide();
                $modal.html(html);
                $modal.modal('show');
            });
        }
    </script>
@endsection
