<?php  
	$dailyReports = App\DailyReport::class;
	if ( sizeof($check_CheckUser) != 0 ) {
			$dailyReports = $dailyReports::where('donvi_id',$check_CheckUser->madonvi);
	    if ( $date_star && $date_end ) {
	        $dailyReports = $dailyReports->whereBetween('reportday', [$date_star, $date_end]);
	    }
	}else{
		$dailyReports = $dailyReports::where('username',$user['username']); 
	}
	$dailyReports = $dailyReports->orderBy('id','DESC')->paginate(5);
?>
  	<div class="head_work">
  		<h3 {{ sizeof($check_CheckUser) == 0 ? 'style=float:none' : '' }}>
	  		<span>{{ sizeof($check_CheckUser) != 0 ? 'Danh sách báo cáo của nhân viên gửi' : 'Danh sách báo cáo đã gửi' }}</span>
	  	</h3>
	  	@if ( sizeof($check_CheckUser) != 0 )
	  	<div class="box_search_work_user clearfix">
  			<form action="" method="GET" class="form_search_work_user">
  				<label>Từ ngày</label>
  				<input class="form-control datepicker" name="date_star" value='{{ ($date_star != "") ? formatDMY($date_star) : date("d-m-Y") }}' type="text">
  				<label>Đến ngày</label>
  				<input class="form-control datepicker" name="date_end" value='{{ $date_end != "" ? formatDMY($date_end) : date("d-m-Y") }}' type="text">
  				<input type="submit" value="Tìm" class="btn-default btn">
  			</form>
  			<i title="Tìm kiếm" data-toggle="tooltip" class="fa fa-search btn_search_work" aria-hidden="true"></i>
  		</div>
  		@endif
  	</div>
    @if( sizeof($dailyReports) > 0 )
	    <ul class="work_report_list">
	    	@foreach( $dailyReports as $dailyReport )
	    	<li>
	    		<dl>
	    			<dt class="btn_view_report" data-id="{{$dailyReport->id}}">
					<?php  
						echo substr($dailyReport->content,0,150);
						if ( strlen($dailyReport->content) > 150 ) {
							echo ' ...';
						}
					?>
	    			</dt>
	    			@if ( sizeof($check_CheckUser) != 0 )
	    			<dd>			    			
	    				<i class="fa fa-user-o"></i>
	    				{{ $dailyReport->fullname }}
	    			</dd>
	    			@endif
	    			<dd>
	    				Ngày báo cáo: 
	    				<?php  
							echo date('d/m/Y H:i', strtotime($dailyReport->reportday));
	    				?>
	    			</dd>
	    		</dl>
	    		<button class="btn_view_report btn btn-default" data-toggle="tooltip" title="Xem chi tiết">Xem</button>
	    	</li>
	    	@endforeach
	    </ul>
    @else
		<em>Không có báo cáo nào</em>
    @endif
@include('partials._pagination',['list' => $dailyReports])