<form id="Form" action="{{url('vpsx/xem_ke_hoach')}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="report-header" style="background:#0456a2; color: #fff;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="title_xemtruoc" style="text-align: center"><b>Kế hoạch công việc từ ngày {{$start}} đến ngày {{$end}}</b></h4>
    </div>
       <div class="modal-body">
           <div class="noidung "><?php echo $content[0] ?></div>
    </div>


</form>
