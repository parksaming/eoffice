@extends('templates.lanhdao')
@section('main')
<div class="container container-list">
    <div class="row">
        <div class="col-md-12">
            <h4 style="text-align: center">Danh sách văn bản đi</h4>
        </div>

        <div class="col-md-12" style="display: flex;justify-content: flex-end;padding: 0;margin-bottom: 10px;">
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
            $linhvucId = isset($_GET['linhvuc'])? $_GET['linhvuc'] : '';
            $loaivanbanId = isset($_GET['loaivanban'])? $_GET['loaivanban'] : '';
            $ngaybanhanhtu = isset($_GET['ngaybanhanhtu'])? $_GET['ngaybanhanhtu'] : '';
            $ngaybanhanhden = isset($_GET['ngaybanhanhden'])? $_GET['ngaybanhanhden'] : '';
            $ngayguitu = isset($_GET['ngayguitu'])? $_GET['ngayguitu'] : '';
            $ngayguiden = isset($_GET['ngayguiden'])? $_GET['ngayguiden'] : '';
        @endphp
        <div class="container container-search {{ ($tukhoa === '' && $linhvucId === '' && $loaivanbanId === '' && $ngaybanhanhtu === '' && $ngaybanhanhden === '' && $ngayguitu === '' && $ngayguiden === '')? 'hidden' : '' }}">
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('danhsach.vanbandi_donvi') }}">
                        <div class="form-row">
                           <div class="col-md-12 vanban">
                               <div class="row">
                                   <div class="col-md-6">
                                       <div class="row">
                                           <div class="col-md-3">
                                               <p style="padding-top:7px"><b>Từ khóa</b></p>
                                           </div>
                                           <div class="col-md-9">
                                               @php $tukhoa = isset($_GET['tukhoa'])? $_GET['tukhoa'] : '' @endphp
                                               <input type="text" class="form-control" name="tukhoa" value={{ $tukhoa }}>
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
        <table class="table table-bordered" style="margin-top: 20px">
            <thead class="head-table">
                <tr>
                    <th>Đơn vị soạn thảo</th>
                    <th>Số văn bản</th>
                    <th>Ký hiệu</th>
                    <th>Ngày ban hành</th>
                    <th>Trích yếu</th>
                    <th>File</th>
                    <th class="col-stt"></th>
                    <th class="col-stt"></th>
                    <th class="col-stt"></th>
                </tr>
            </thead>
            <tbody>
                @if (sizeof($vanbans))
                    @foreach($vanbans as $vanban) 
                    <tr>
                        <td>{{$vanban->donviSoan? $vanban->donviSoan->name : ''}}</td>
                        <td>
                            <a href="{{ route('chi_tiet_van_ban_di_donvi', $vanban->id) }}">{{$vanban->sovb}}</a>
                        </td>
                        <td>
                            <a href="{{ route('chi_tiet_van_ban_di_donvi', $vanban->id) }}">{{$vanban->kyhieu}}</a>
                        </td>
                        <td>{{$vanban->ngayky}}</td>
                        <td>{{$vanban->title}}</td>
                        <td>
                            <div style="display: flex;flex-direction: column;">
                                @php
                                    $files = explode(';', $vanban->file_vbdis);
                                    foreach($files as $file) {
                                        echo sprintf('<a href="%s" target="_blank" title="%s">%s</a>', route('dowload.file', [$file]), $file, $file);
                                    }
                                @endphp
                            </div>
                        </td>
                        <td class="col-stt">
                            <span style="padding:5px 10px"><a href="javascript:;" onclick="showModalSendMail({{ $vanban->id }})" title="Gửi mail"><i class="fa fa-envelope"></i></a></span>
                        </td>
                        <td class="col-stt">
                            @if ($vanban->user_id == session('user')['id'])
                                <span style="padding:5px 10px"><a href="{{ route('edit_vanban_di_donvi', $vanban->id) }}" title="Sửa văn bản"><i class="fa fa-edit"></i></a></span>
                            @endif
                        </td>
                        <td class="col-stt">
                            @if ($vanban->user_id == session('user')['id'])
                                <span style="padding:5px 10px"><a href="javascript:;" onclick="deleteVanBan({{ $vanban->id }})" title="Xóa văn bản"><i class="fa fa-times red"></i></a></span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else 
                    <tr><td colspan="8" style="text-align: center">Không có dữ liệu</td></tr>
                @endif
            </tbody>
        </table>
        <div class="pull-right">
            @include('pagination', ['paginator' => $vanbans, 'interval' => 5])
        </div>
    </div>
</div>

<div id="ModalGuiMail" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Gửi mail</h4>
            </div>
            <div class="modal-body">
                <form id="FormGuiMail">
                    <input type="hidden" name="vanban_id" value="">

                    {{-- đơn vị nhận --}}
                    <div style="margin-bottom: 10px;">Đơn vị nhận</div>
                    <div style="margin-bottom: 15px;">
                        <select name="donvi_ids[]" class="form-control chosen" multiple>
                            @foreach ($donviGuiMails as $donvi)
                                <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- user nhận --}}
                    <div style="margin-bottom: 10px;">Người nhận</div>
                    <div style="margin-bottom: 15px;display: flex;flex-direction: column-reverse;">
                        <select name="user_ids[]" class="form-control chosen" multiple></select>
                    </div>

                    <div style="text-align: right;margin-top: 15px;">
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showModalSendMail(vanbanId) {
            $('#FormGuiMail input[name="vanban_id"]').val(vanbanId);
            $('#FormGuiMail select[name="donvi_ids[]"]').val('').trigger('chosen:updated');
            $('#FormGuiMail select[name="user_ids[]"]').val('').trigger('chosen:updated');

            $('#ModalGuiMail').modal('show');
        }

        function loadUserDonViDiOption(donviIds, options, callback) {
            options = options || {};

            let url = '{{url("load_user_donvidi_option")}}';
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            let params = {
                _token: CSRF_TOKEN,
                selected_values: options.selected_values || [],
                donvi_ids: donviIds
            };

            loading_show();
            $.post(url, params, (res) => {
                loading_hide();
                callback(res);
            });
        }
        
        $(document).ready(function () {
            $('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});

            $('#FormGuiMail select[name="donvi_ids[]"]').change(function () {
                const donviIds = $(this).val();
                const $selectUsers = $('#FormGuiMail select[name="user_ids[]"]');
                const selectedValues = $selectUsers.val();

                loadUserDonViDiOption(donviIds, {selected_values:selectedValues}, (htmlOptions) => {
                    $selectUsers.html(htmlOptions).trigger('chosen:updated');
                });
            });
            
            $('#FormGuiMail').validate({
                rules: {
                    'user_ids[]': 'required'
                },
                messages: {
                    'user_ids[]': 'Hãy chọn người nhận mail'
                },
                submitHandler: function(form) {
                    loading_show();

                    const url = "{{ route('guimailvbdi_donvi') }}";
                    const vanbanId = $('#FormGuiMail input[name="vanban_id"]').val();
                    const userIds = $('#FormGuiMail select[name="user_ids[]"]').val();
                    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.post(url, {vanban_id:vanbanId, user_ids:userIds, _token:CSRF_TOKEN}, () => {
                        loading_hide();
                        jAlert('Gửi mail thành công', 'Thông báo');
                    }, 'json');
                }
            });
        });
    </script>
</div>

<script type="text/javascript">
    function deleteVanBan(id) {
        jConfirm('Bạn có muốn xóa văn bản?', 'Thông báo', function (r) {
            if (r) {
                loading_show();
                
                let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.post("{{ route('vanban.delete_donvi') }}", {ids:[id], _token:CSRF_TOKEN}, () => {
                    location.reload();
                }, 'json');
            }
        });
    }
    
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
