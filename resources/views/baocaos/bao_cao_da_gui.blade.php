@extends('templates.lanhdao')
@section('main')
    <div class="search-page-form col-md-12 col-sm-12" style="margin-top: 30px;">
        <div class="filter-page col-md-12 col-sm-12 form-group">
            {!! Form::open(['url' => 'baocao/bao_cao_da_gui', 'method' => 'post']) !!}
            {{--<div class="col-md-2">--}}
                {{--<input type="text" class="date_filter_pc form-control col-md-10 form-day" id="tungay" name="day" value="{{formatDMY($start_date)}}">--}}
            {{--</div>--}}
            <div class='col-sm-2 dayto'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="day" class="form-control day" value="{{formatDMY($start_date)}}" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
                <div class="col-md-2 search">

                    <button type="submit" class="btn btn-primary " id="timkiem">Tìm kiếm</button>
                </div>
            {!! Form::close() !!}
        </div>
        <div class="page-content col-md-12 col-sm-12">
            <div class="table-baocaodagui">
                <div class="" style="float:left; width:100%">
                    @if(sizeof($reports))
                        <h4 class="header_report" style="text-align: center;"><b>Nội dung báo cáo của bạn ngày {{formatDMY($start_date)}} </b></h4>

                        <table class="table table-hover">
                            <tbody>

                            <tr style="border: 1px solid gainsboro;">
                                <td class="noidung">
                                    <?php echo $reports['content'] ?>
                                </td>
                                <td>
                                    @if(formatDMY($start_date) == date('d/m/Y'))
                                        <a href="{{url('baocao/sua_bao_cao/' . $reports->id)}}" title="Sửa kế hoạch"><i class="fa fa-pencil"></i></a>
                                    @else
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <h4 class="header_report" style="text-align: center;">Bạn không có báo cáo cho ngày <?php echo formatDMY($start_date);?></h4>
                    @endif
                </div>
            </div>
        </div>
    <script type="text/javascript">
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'DD/MM/YYYY',
                useCurrent: false,

            });
//            $('#datetimepicker1').data("DateTimePicker").show();
        });
    </script>
@endsection