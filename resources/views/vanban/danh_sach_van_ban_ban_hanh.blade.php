@extends('templates.lanhdao')
@section('main')
<div class="container container-list">
    @include('flash::message')
    <div class="row">
        <div class="row">
            <h3 class="col-md-9 text-left">Danh sách văn bản ban hành</h3>
            <div class="col-md-3 text-right" style="margin-top: 15px">
                <a class="btn btn-primary" style="margin-bottom: 15px;" href="{{ route('nhap_vanban_banhanh') }}"><i class="fa fa-pencil-square-o"></i> Nhập văn bản ban hành</a>
            </div>
        </div>

        <div class="col-md-12" style="display: flex;justify-content: space-between;padding: 0;margin-bottom: 18px;">
            <ul class="nav nav-pills">
                <li class="bg_luanchuyen {{ (!$type || $type == 'nhanvanban')? 'active' : '' }}">
                    <a href="{{ route('danhsach_vanban_banhanh', ['type' => 'nhanvanban']) }}">VB Ban hành đã nhận</a>
                </li>
                <li class="bg_luanchuyen {{ $type == 'guivanban'? 'active' : '' }}">
                    <a href="{{ route('danhsach_vanban_banhanh', ['type' => 'guivanban']) }}">VB ban hành đã gửi</a>
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
        
        <div class="container-search hidden">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-filter" method="GET" action="{{ route('danhsach_vanban_banhanh') }}">
                        <input type="hidden" name="type" value="{{ $type? $type : 'nhanvanban' }}">
                        <div class="form-item">
                            <span class="form-item-l">Tìm kiếm</span>
                            <div class="form-item-c">
                                @php $tukhoa = isset($_GET['tukhoa'])? $_GET['tukhoa'] : '' @endphp
                                <input class="form-control" name="tukhoa" value="{{ $tukhoa }}" />
                            </div>
                        </div>
                        <div class="form-item">
                            <span class="form-item-l">Ngày ban hành từ</span>
                            <div class="form-item-c">
                                @php $ngaybanhanhtu = isset($_GET['ngaybanhanhtu']) && $_GET['ngaybanhanhtu']? date('d-m-Y', strtotime($_GET['ngaybanhanhtu'])) : '' @endphp
                                <input class="date-picker form-control" type="text" name="ngaybanhanhtu" value="{{ $ngaybanhanhtu }}" />
                            </div>
                        </div>
                        <div class="form-item">
                            <span class="form-item-l">Ngày ban hành đến</span>
                            <div class="form-item-c">
                                @php $ngaybanhanhden = isset($_GET['ngaybanhanhden']) && $_GET['ngaybanhanhden']? date('d-m-Y', strtotime($_GET['ngaybanhanhden'])) : '' @endphp
                                <input class="date-picker form-control" type="text" name="ngaybanhanhden" value="{{ $ngaybanhanhden }}" />
                            </div>
                        </div>
                        <div class="form-item">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead class="head-table">
                <tr>
                    <th>STT</th>
                    <th>Tên văn bản</th>
                    <th>Cơ quan ban hành</th>
                    <th>Đơn vị nhận</th>
                    <th>Người nhận</th>
                    <th style="text-align: center; width: 200px;">Thời gian ban hành</th>
                    <th style="text-align: center; width: 40px;">File</th>
                </tr>
            </thead>
            <tbody>
            @if(sizeof($vanbans))
                @php $stt = ($vanbans->currentPage() - 1) * $vanbans->perPage() + 1 @endphp
                @foreach ($vanbans as $val)
                    <tr>
                        <td class="col-stt">{{ $stt++ }}</td>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->donviBanhanh? $val->donviBanhanh->name : '' }}</td>
                        <td><?php
                            $strDV = '';
                            $dvIds = explode(';', trim($val->donvi_nhan_id, ';'));
                            foreach($dvIds as $dvId) {
                                if (isset($donvis[$dvId])) {
                                    $strDV .= ', '.$donvis[$dvId]->name;
                                }
                            }

                            echo trim($strDV, ', ');
                            ?></td>
                        <td>
                            <?php
                                $strNames = '';
                                $userIds = explode(';', trim($val->user_nhan_ids, ';'));
                                foreach($userIds as $userId) {
                                    if (isset($users[$userId])) {
                                        $strNames .= ', '.$users[$userId]->fullname;
                                    }
                                }

                                echo trim($strNames, ', ');
                            ?>
                        </td>
                        <td style="text-align: center; width: 200px;">{{ $val->thoigian_banhanh_display }}</td>
                        <td class="text-center" style="text-align: center; width: 40px;">
                            @if ($val->file)
                                <a href="{{ route('dowload.file', [$val->file]) }}" target="_blank" title="{{ $val->file }}">
                                    <i class="fa fa-paperclip"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" align="center"><i> Không có dữ liệu</i></td>
                </tr>
            @endif
            </tbody>
        </table>

        <div class="pull-right">
            @include('pagination', ['paginator' => $vanbans, 'interval' => 5])
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date-picker').datetimepicker({
        format: 'DD-MM-YYYY',
        useCurrent: true
    });
</script>
@endsection
