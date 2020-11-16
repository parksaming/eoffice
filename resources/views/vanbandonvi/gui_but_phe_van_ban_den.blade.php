@extends('templates.lanhdao')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-text">Gửi bút phê</h4>
            </div>
            <form action="{{route('save_but_phe_van_ban_den_donvi')}}" method="POST" enctype="multipart/form-data">
                <input type="hidden" value="{{$vanbanden->id}}" name="id">
                <input type="hidden" name="_token" value="{{csrf_token()}}" >
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
                            <td> {{ $vanbanden->tenLoaiVanBan }}</td>
                        </tr>
                        <tr>
                            <td class="row-left">
                                Nơi ban hành
                            </td>
                            <td class="row-right-1">{{ $vanbanden->donviName }}</td>
                            <td class="row-left">Hạn xử lý</td>
                            <td class="row-right-1">{{$vanbanden->hanxuly}}</td>
                        </tr>
                        <tr>
                            <td class="row-left">Số ký hiệu</td>
                            <td>{{$vanbanden->kyhieu}}</td>
                            <td class="row-left">Trạng thái</td>
                            <td>
                                <span style="padding:5px 10px;border-radius: 5px;background: #F6921E;color:#FFF">
                                @if ($vanbanden->status == 0)
                                    Đang xử lý
                                    @elseif($vanbanden->status == 1)
                                    Đã xử lý
                                    @else
                                    Chưa xử lý
                                    @endif
                                </span>
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
                                    $file = explode(';',$vanbanden->file_dinhkem);
                                    $countfile = count($file);
                                    for ($i=0;$i<$countfile;$i++){
                                    ?>
                                    <a href="{{route('dowload.file',$file[$i])}}">{{$file[$i]}}</a><br>
                                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="row-left">Ghi chú</td>
                            <td class="row-right-1">{{$vanbanden->note}}</td>
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
                <div class="col-md-12" style="margin-top:20px">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">STT</th>
                            <th>Tên phòng,ban,khoa,...</th>
                            <th>Nơi nhận</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $stt=1;?>
                        @if (sizeof($book_detail)>0)
                        @foreach ($book_detail as $detail)
                            <tr>
                                <td class="text-center">{{$stt++}}</td>
                                <td>
                                    <strong>{{$detail->tendonvi}}</strong>
                                </td>
                                <td>
                                    <input type="checkbox" class="check_all" donvi_id="input{{$detail->donvi_id}}" name="noinhan[]" value="{{$detail->donvi_id}}">
                                </td>
                                <td class="email_color">{{$detail->donvi_email}}</td>
                            </tr>
                            @if ($detail->user_id)
                                <?php
                                $user_arr = explode(';',$detail->user_id);
                                $users = App\User::whereIN('id',$user_arr)->get();
                                ?>
                                @foreach ($users as $user)
                                    <tr>
                                        <td></td>
                                        <td>&nbsp;&nbsp;{{$user->fullname}}</td>
                                        <td>
                                            <input type="checkbox" parentid="input{{$detail->donvi_id}}" name="usernhan[]" value="{{$user->id}}">
                                        </td>
                                        <td>{{$user->email}}</td>
                                        @endforeach
                                    </tr>
                                    @endif
                                @endforeach
                        </tbody>
                        @else
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu</td>
                            </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-12 vanban" style="text-align: center">
                    <button type="submit" class="btn btn-primary" style="margin-top:10px" >Gửi bút phê</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(".check_all").click(function () {
            let id = $(this).attr('donvi_id');
            $('input[parentid="'+id+'"]').prop('checked', true)
        });

    </script>
@endsection