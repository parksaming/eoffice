@extends('templates.lanhdao')
@section('main')
    <div class="container container-list">
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <h4 style="text-align: center">Lịch sử các lần bút phê</h4>
            </div>
            <table class="table table-bordered">
                <thead class="head-table">
                    <tr>
                        <th>Nơi gửi</th>
                        <th>Nơi nhận</th>
                        <th>Nội dung</th>
                        <th>Ngày gửi</th>
                        <th>Hạn xử lý</th>
                        <th>File đính kèm</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($dataLog as $log)
                    <?php
                    $stt = 1;
                    ?>
                    <tr>
                        <td>{{$log->tenDViBanHanh}}</td>
                        <td>{{$log->tenDonViNhan}}</td>
                        <td>{{$log->content}}</td>
                        <td>{{$log->ngaygui}}</td>
                        <td>{{$log->hanxuly}}</td>
                        <td>
                            <a href="{{ route('dowload.file', [$log->file_dinhkem]) }}" target="_blank">
                                <?php echo $log->file_dinhkem;?>
                            </a>
                        </td>
                        <td>{{$log->status == 1 ? 'Chưa xem' : 'Đã xem'}}</td>
                        <td class="text-center"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endsection
