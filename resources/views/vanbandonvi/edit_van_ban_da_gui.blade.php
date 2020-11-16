@extends('templates.lanhdao')
@section('main')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-text">Nhập văn bản đến</h4>
            </div>
            <div class="col-sm-12">
                <form action="{{route('edit_vanban_luu_donvi')}}" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <input type="hidden" name="id" value="{{$vanbans->id}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="loai" value="Đến">
                        <input type="hidden" name="book_id" value="1">
                        <div class="col-md-12 vanban">
                            <p><b>I.THÔNG TIN VĂN BẢN</b></p>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px"><b>Upload file:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" class="btn btn-success" accept=".jpg,.png,.gif,.pdf"
                                                   style="width: 100%" id="upload_file">
                                        </div>
                                        <div class="col-md-6">
                                            <div id="upload_status_file">
                                                <p style="padding-top:7px;color: red"><i>Chỉ cho upload định dạng file:
                                                        jpg, png, gif, pdf với dung lượng < 20M</i></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row" style="display: flex">
                                <div class="col-md-2" style="display: flex">
                                    <p style="padding-top:7px;line-height: 100px">1.<b>*Tiêu đề:</b></p>
                                </div>
                                <div class="col-md-10" style="display: flex">
                                    <textarea class="form-control" name="title" id="name"
                                              rows="5">{{$vanbans->title}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">2.<b>*Loại văn bản:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="loaivanban_id" id="loaivanban">
                                                <option value="">Chọn loại văn bản</option>
                                                @foreach ($loaivanbans as $loaivanban)
                                                    @if ($loaivanban->id == $vanbans->loaivanban_id)
                                                        <option value="{{$loaivanban->id}}"
                                                                selected>{{$loaivanban->name}}</option>
                                                    @else
                                                        <option value="{{$loaivanban->id}}">{{$loaivanban->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p style="padding-top:7px">3.<b>*Ngày đến:</b></p>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="ngayden"
                                                           id="startngayden" value="{{formatdmYY($vanbans->ngayden)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">4.<b>*Số đến:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="soden" id="soden"
                                                   value="{{$vanbans->soden}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p style="padding-top:7px">5.<b>Ký hiệu:</b></p>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="kyhieu" id="kyhieu"
                                                           value="{{$vanbans->kyhieu}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">6.<b>CQ ban hành:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="cq_banhanh" id="cqbanhanh">
                                                @foreach($donvis as $donvi)
                                                    @if ($donvi->id == $vanbans->cq_banhanh)
                                                        <option value="{{$donvi->id}}"
                                                                selected>{{$donvi->name}}</option>
                                                    @else
                                                        <option value="{{$donvi->id}}">{{$donvi->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p style="padding-top:7px">7.<b>*Ngày ký:</b></p>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="ngayky" id="ngayky"
                                                           value="{{formatdmYY($vanbans->ngayky)}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">8.<b>Lĩnh vực:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" id="" name="linhvuc_id">
                                                <option value="">Chọn lĩnh vực</option>
                                                @foreach ($linhvucs as $linhvuc)
                                                    @if ($linhvuc->id == $vanbans->linhvuc_id)
                                                        <option value="{{$linhvuc->id}}"
                                                                selected>{{$linhvuc->name}}</option>
                                                    @else
                                                        <option value="{{$linhvuc->id}}">{{$linhvuc->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p style="padding-top:7px">9.<b>Người ký:</b></p>
                                                </div>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nguoiky"
                                                           value="{{$vanbans->nguoiky}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">10.<b>Hạn xử lý:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="hanxuly" id="hanxuly"
                                                   value="{{formatdmYY($vanbans->hanxuly)}}">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <p style="padding-top:7px">11.<b>Publish:</b></p>
                                                </div>
                                                <div class="col-md-9">
                                                    <select class="form-control" name="publish">
                                                        <option value="">Chọn publish</option>
                                                        <?php
                                                        $stt = 1;
                                                        ?>
                                                        @foreach ($publishs as $publish)
                                                            @if ($publish->id == $vanbans->publish_id)
                                                                <option value="{{$publish->id}}"
                                                                        selected>{{$stt++ . '.'.$publish->name}}</option>
                                                            @else
                                                                <option value="{{$publish->id}}">{{$stt++ . '.'.$publish->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-2">
                                    <p style="padding-top:7px">12.<b>Độ khẩn:</b></p>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="urgency" id="urgency">
                                                @for ($i=1;$i <= $countcombo; $i++)
                                                    @if ($i == $vanbans->urgency)
                                                        <option value="{{$i}}" selected>{{$combobox[$i]}}</option>
                                                    @else
                                                        <option value="{{$i}}">{{$combobox[$i]}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <div class="row" style="display: flex">
                                <div class="col-md-2" style="display: flex">
                                    <p style="padding-top:7px;line-height: 100px">13.<b>Ghi chú:</b></p>
                                </div>
                                <div class="col-md-10" style="display: flex">
                                    <textarea class="form-control" name="note" id="note"
                                              rows="5">{{$vanbans->note}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <input type="checkbox" name="save" value="1"><b>Chỉ để lưu</b>
                            </div>
                        </div>
                        <div class="col-md-12 vanban">
                            <label>File đính kèm</label>
                            <p><i>Chỉ cho upload định dạng file: <span style="color: green;">doc, docx, xls, xlsx, ppt, pptx, pdf</span>
                                    với dung lượng < 20M</i></p>
                            <div id="file_list">
                                <?php
                                $file = explode(';', $vanbans->file_dinhkem);
                                $count = count($file);
                                $i = 0;
                                $row = 0;
                                if (sizeof($file) > 1):
                                for ($i;$i < $count;$i++):
                                ?>
                                <div class="item" id="row{{$row}}">
                                    <div style="float:left">
                                        {{$file[$i]}}
                                    </div>
                                    <div style="float:right">
                                        <a href="javascript:void(0)" id="{{$file[$i]}}" onClick="remove_file(this)"
                                           rel="{{$row}}">
                                            <img src="{{asset('img/closelabel.png')}}" title="Remove file">
                                        </a>
                                    </div>
                                    <div style="clear:both"></div>
                                    <input type="hidden" name="file_dinhkem[]" value="{{$file[$i]}}">
                                </div>
                                <?php
                                $row++;
                                endfor; endif;
                                ?>
                            </div>
                            <div id="upload_status"></div>
                            <a class="submit attach" href="javascript:;" id="btn-attachfile">Đính kèm file</a>
                            <?php if($vanbans->file_dinhkem){?>
                            <div class="item">
                                <a href="{{ route('dowload.file', [$vanbans->file_dinhkem]) }}" target="_blank">
                                    <?php echo $vanbans->file_dinhkem;?>
                                </a>
                            </div>
                            <?php }?>


                        </div>
                        <div class="col-md-12" style="margin-top:20px">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phòng,ban,khoa,...</th>
                                    <th>Nơi nhận</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $stt = 1; ?>
                                @foreach ($book_detail as $book)
                                    <tr>
                                        <td>{{$stt++}}</td>
                                        <td>
                                            <strong>{{$book->TenDonVi}}</strong>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="check_all" donvi_id="input{{$book->donvi_id}}" name="noinhan[{{$book->donvi_id}}][donvi]"
                                                   {{ in_array($book->donvi_id,$arrDv)? 'checked' : '' }}
                                                   value="{{$book->idDonVi}}">
                                        </td>
                                        <td class="email_color">{{$book->donvi_email}}</td>
                                    </tr>
                                    @if ($book->user_id)
                                        <?php
                                        $user_arr = explode(';', $book->user_id);
                                        $users = App\User::whereIN('id', $user_arr)->get();
                                        ?>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td></td>
                                                <td>&nbsp;&nbsp;{{$user->fullname}}</td>
                                                <td>
                                                    <input type="checkbox" parentid="input{{$book->idDonVi}}" name="noinhan[{{$user->donvi_id}}][user][]"
                                                           {{ in_array($user->id,$userid)? 'checked' : '' }}
                                                           value="{{$user->id}}">
                                                </td>
                                                <td>{{$user->email}}</td>
                                                @endforeach
                                            </tr>
                                            @endif
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 vanban" style="text-align: center">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px">Cập nhật văn bản</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(".check_all").click(function () {
            let id = $(this).attr('donvi_id');
            $('input[parentid="' + id + '"]').prop('checked', true)
        });
    </script>
@endsection