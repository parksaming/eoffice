@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Danh sách văn bản đến đã gửi</h4>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
{{--                       <form>--}}
                           <div class="form-row">
                               <input type="hidden" name="_token" value="{{csrf_token()}}" >
                               <div class="col-md-12 vanban">
                                   <div class="row">
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Từ khóa</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   <input type="text" class="form-control" name="tukhoa" id="tukhoa">
                                               </div>
                                           </div>
                                       </div>
                                       <div class="col-md-6">
                                           <div class="row">
                                               <div class="col-md-3">
                                                   <p style="padding-top:7px"><b>Trạng Thái</b></p>
                                               </div>
                                               <div class="col-md-9">
                                                   <select class="form-control" name="trangthai" id="status_search">
                                                       <option value="">Chọn trạng thái</option>
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
                                                   <select class="form-control" name="linhvuc" id="linhvuc_search">
                                                       <option value=""> Tất cả </option>
                                                       @foreach ($linhvucs as $linhvuc)
                                                           <option value="{{$linhvuc->id}}">{{$linhvuc->name}}</option>
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
                                                   <select class="form-control" name="loaivanban" id="loaivanban_search">
                                                       <option value=""> Tất cả </option>
                                                      @foreach ($loaivanbans as $loaivanban)
                                                          <option value="{{$loaivanban->id}}">{{$loaivanban->name}}</option>
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
                                                           <input type="text" class="form-control" name="ngaybanhanhtu" placeholder="Từ ngày" id="ngaybh_tu">
                                                       </div>
                                                       <div class="col-md-6">
                                                           <input type="text" class="form-control" name="ngaybanhanhden" placeholder="Đến ngày" id="ngaybh_den">
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
                                                           <input type="text" class="form-control" name="ngayguitu" placeholder="Từ ngày" id="ngaygui_tu">
                                                       </div>
                                                       <div class="col-md-6">
                                                           <input type="text" class="form-control" name="ngayguiden" placeholder="Đến ngày" id="ngaygui_den">
                                                       </div>
                                                   </div>
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
{{--                       </form>--}}
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th>Số đến</th>
                        <th>Nơi ban hành</th>
                        <th>Số ký hiệu</th>
                        <th>Ngày ban hành</th>
                        <th>Trích yếu</th>
                        <th>Nơi nhận</th>
                        <th>Ngày gửi</th>
                        <th>Trạng thái</th>
                        <th>File</th>
                        <th class="text-center w-10">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($ds_vanbans as $ds)
                    <?php
                    $stt = 1;
                    $stt = ($ds_vanbans->currentPage() - 1) * $ds_vanbans->perPage() + 1;
                    ?>
                    <tr>
                        <td>{{$ds->soden}}</td>
                        <td>
                            {{$ds->tenDonVi}}
                        </td>
                        <td>{{$ds->kyhieu}}</td>
                        <td>{{$ds->ngayky}}</td>
                        <td>{{$ds->title}}</td>
                        <td></td>
                        <td>{{date('d-m-Y', strtotime(str_replace('/', '-', $ds->ngaygui)))}}</td>
                        <td></td>
                        <td>
                            <a href="{{ route('dowload.file', [$ds->file_dinhkem, 'vanban_id' => $ds->id]) }}" target="_blank">
                                <?php echo $ds->file_dinhkem;?>
                            </a>
                        </td>
                        <td class="text-center">
                            <span style="padding:5px 10px"><a href ="{{route('edit_van_ban_da_gui_donvi',$ds->id)}}"><i class="fa fa-pencil"> </i></a></span>
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
    </script>
    @endsection
