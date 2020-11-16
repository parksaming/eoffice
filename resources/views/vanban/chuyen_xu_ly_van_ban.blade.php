@extends('templates.lanhdao')
@section('main')
    <div class="container-fuild">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-text">Chuyển xử lý văn bản đến</h4>
            </div>
            <form action="{{route('luu_xu_ly_van_ban')}}" id="xulyvanban" method="POST" enctype="multipart/form-data">
                <input type="hidden" value="{{$vanbanden->id}}" name="id">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="col-sm-12">
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
                            <td> {{$vanbanden->tenLoaiVanBan}}</td>
                        </tr>
                        <tr>
                            <td class="row-left">Nơi ban hành</td>
                            <td class="row-right-1">{{$vanbanden->cq_banhanh}}</td>
                            <td class="row-left">Hạn xử lý</td>
                            <td class="row-right-1">{{$vanbanden->hanxuly}}</td>
                        </tr>
                        <tr>
                            <td class="row-left">Số ký hiệu</td>
                            <td>{{$vanbanden->kyhieu}}</td>
                            <td class="row-left">Trạng thái</td>
                            <td>
                                @if ($vanbanden->trangthai === 1)
                                    <span class="doNotAction lh36">Chưa xử lý</span>
                                @elseif($vanbanden->trangthai === 3)
                                    <span class="doneAction lh36">Đã xử lý</span>
                                @else
                                    <span class="doNotAction lh36">Chưa xử lý</span>
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td class="row-left">Ngày VB</td>
                            <td class="row-right-1">{{$vanbanden->ngayky}}</td>
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
                            <td class="row-left">Nội dung bút phê</td>
                            <td colspan="3">
                                 <textarea class="form-control" name="conten_butphe" id="conten_butphe" autofocus
                                           rows="5"></textarea>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <div style="display: flex;">
                        <div style="display: flex;color: red;font-size: 15px;font-style: italic;flex-direction: column;justify-content: flex-end;">
                            <span>Những user màu xanh đã có trong luồng văn bản</span>
                        </div>
                        <div style="display: flex;justify-content: flex-end;flex: 1;">
                            <a href="{{ route('chitiet_vanban', [$vanbanden->id, 'tab' => 2]) }}" class="btn btnLuanChuyen" style="margin-right: 15px;"><i class="fa fa-envelope-open" style="color: #26a9e0"></i> Trao đổi văn bản</a>
                            <a href="javascript:;" class="btn btnLuanChuyen" onclick="quyTrinhChuyenTiep('{{$vanbanden->id}}')"><img class="imgLC" src="{{url('/img/luong_xu_ly_hover.svg')}}"> Luồng luân chuyển </a>
                        </div>
                    </div>

                    <div class="col-md-12 treeview table-bordered " style="margin-top: 20px">
                        <div class="form">
                            <div class="col-md-6">
                                <h4>Tên Phòng, Ban, Khoa,...</h4>
                                <div id="selection-treeview">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Phòng, Ban, Khoa,... được chọn</h4>
                                <div id="checked-items"></div>
                            </div>  
                        </div> 
                    </div> 
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="button" class="btn btn-primary btn-add" style="margin-top:10px">Xử lý văn bản
                        </button>
                    </div>
                </div>
            </form>
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

    <style>
        .dx-item.dx-treeview-item.has-selected {
            color: blue;
        }
    </style>
    <script>
        $('.btn-add').click(function () {
            if ($('#conten_butphe').val() == '') {
                jAlert("{!! trans('Vui lòng nhập nội dung bút phê') !!}", "{!! trans('Thông báo') !!}");
                return false;
            }

            $('#xulyvanban').submit();
        });

        // tree view
        $(function() {
            var phongban = <?php echo json_encode($dataTreeview) ?>;
            var checkedItems = [];
            
            var checkedItemsList = $("#checked-items").dxList({
                width: 430,
                items: checkedItems,
                itemTemplate: function(data) {
                    let id = data.key.split('_')[1];
                    return `<div><input type="hidden" checked="true" name="users[]" value="${id}" /><span>${data.text}</span></div>`;
                }
            }).dxList("instance");

            $("#selection-treeview").dxTreeView({
                items: phongban,
                width: 320,
                searchEnabled: true,
                showCheckBoxesMode: "normal",
                onItemSelectionChanged: function(e) {
                    var item = e.node;
            
                    if(isPhongban(item)) {
                        processPhongban($.extend({category: item.parent.text}, item));
                    } else {
                        $.each(item.items, function(index, phongban) {
                            processPhongban($.extend({category: item.text}, phongban));
                        });
                    }
                    checkedItemsList.option("items", checkedItems);
                },
                itemTemplate: function(data) {
                    return "<div>" + data.text + "</div>";
                },
                onItemRendered: function(e) {
                    if (e.itemData.has_selected) {
                        e.itemElement.addClass('has-selected');
                    }
                }
            });
            
            function isPhongban(data) {
                return data.key.toString().includes('_');
            }
            
            function processPhongban(phongban) {
                var itemIndex = -1;
            
                $.each(checkedItems, function (index, item) {
                    if (item.key === phongban.key) {
                        itemIndex = index;
                        return false;
                    }
                });
            
                if(phongban.selected && itemIndex === -1) {
                    checkedItems.push(phongban);
                } else if (!phongban.selected){
                    checkedItems.splice(itemIndex, 1);
                }    
            }
        })

        function quyTrinhChuyenTiep(Id) {
            url = "{{url('vanban/quy_trinh_chuyen_tiep')}}";
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