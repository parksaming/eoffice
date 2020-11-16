
<div class="modal-header " style="background:#0456a2;">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title titile_guibaocao" style="color: white">Kế hoạch từ ngày {{formatDMY($plans->start_day)}} đến ngày {{formatDMY($plans->end_day)}}</h4>
</div>
<div class="modal-body">
   <div class="noidung"><?php echo $plans['content'] ?></div>
</div>


