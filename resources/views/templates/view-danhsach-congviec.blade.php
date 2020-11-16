<div class="col-md-7 wrapper-left-content">
	<div class="col-sm-12 nopadding">
		<form action="" method="GET" accept-charset="utf-8">
			@if( Input::get("type") == 'viec_da_giao' )
			<input type="hidden" name="type" value="viec_da_giao">
			@endif
			<nav class="menu-top">
				<ul class="nav navbar-nav">
					<li>
						<div class="dropdown">
						  <div id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="form-control">
						    <span class="title_work">Việc được giao</span>
						    <span class="caret"></span>
						  </div>
						  <ul class="dropdown-menu" aria-labelledby="dLabel">
						    <li>
						    	<a class="changeLinkWork" >Việc đã giao</a>
						    </li>
						  </ul>
						</div>
					</li>
					<li>
						<input class="form-control" type="text" name="txt_search" placeholder="Từ khóa ..." value="{{ Input::get('txt_search','') }}">
					</li>
					<li>
                    	<div class="date datepicker-top" >
                    		<input class="form-control" name="time_search" type="text" id="datepicker" value="{{ Input::get('time_search','') }}">
                    		<i class="fa fa-calendar icon-date-top" aria-hidden="true"></i>
                    	</div>
					</li>
					<li>
	                    <select name="trangthai_search" class="form-control selectpicker">
				    		<option value="">Chọn trạng thái</option>
				    		<option {{ isset($trangthai_search) && $trangthai_search == 'Chưa thực hiện' ? 'selected' : '' }} value="Chưa thực hiện">Chưa thực hiện</option>
				    		<option {{ isset($trangthai_search) && $trangthai_search == 'Đang thực hiện' ? 'selected' : '' }} value="Đang thực hiện">Đang thực hiện</option>
				    		<option {{ isset($trangthai_search) && $trangthai_search == 'Đã hoàn thành' ? 'selected' : '' }} value="Đã hoàn thành">Đã hoàn thành</option>
				    		<option {{ isset($trangthai_search) && $trangthai_search == 'Tạm dừng' ? 'selected' : '' }} value="Tạm dừng">Tạm dừng</option>
				    		<option {{ isset($trangthai_search) && $trangthai_search == 'Hủy bỏ' ? 'selected' : '' }} value="Hủy bỏ">Hủy bỏ</option>
				    	</select>
					</li>
					<li><button type="submit" class="btn btn-default">Tìm</button></li>
				</ul>
			</nav>
		</form>
	</div>
	<div class="clearfix"></div>
	<div style="float: left;margin-top: 20px;">
		@include('partials._pagination_limit_selector')
	</div>
	<div class="action-create-work">
		<a class="btn btn-primary" href="javascript:;" id="create">
			<i class="glyphicon glyphicon-plus"></i>
			Tạo công việc
		</a>
	</div>
	<div class="table-responsive" id="congviec_table">
		@if( sizeof($congviecs) > 0 )
			@include('congviecs._table_congviec')
		@else
			<em style="display: table; margin: 30px auto;">Không có công việc</em>
		@endif
		@include('partials._pagination',['list'=>$congviecs, 'ajax'=>1, 'container'=>'#congviec_table'])
	</div>
</div>
<?php 
    $congviec = $congviecs->first();
?>
<div class="col-md-5 wrapper-right-content" style="margin-top: 20px;">

	<nav>
		<ul class="nav nav-tabs">
			<li class="li-style active">
				<a data-toggle="tab" href="#detail-tab" rel="detail-tab" title="">Chi tiết</a>
			</li>
			<li class="li-style">
				<a data-toggle="tab" href="#document-tab" rel="document-tab" title="">Tài liệu 
				{!! sizeof($congviec) > 0 ? '<span class="badge">'.( ($count_cvFile =  $congviec->congviecFile->count()) > 0 ? $count_cvFile : '' ).'</span>' : '' !!}
				</a>
			</li>
			<li class="li-style">
				<a data-toggle="tab" href="#discuss-tab" rel="discuss-tab" title="">Thảo luận
				{!! sizeof($congviec) > 0 ? '<span class="badge">'.( ($count_cvMessage = $congviec->congviecMessage->count()) > 0 ? $count_cvMessage : '' ).'</span>' : '' !!}
				</a>
			</li>
			<li class="li-style">
				<a data-toggle="tab" href="#report-tab" rel="report-tab" title="">Báo cáo
				{!! sizeof($congviec) > 0 ? '<span class="badge">'.( ( $count_cvBaocao = $congviec->congviecBaocao->count() > 0 ) ? $count_cvBaocao : '' ).'</span>' : '' !!}
				</a>
			</li>
			<li class="li-style">
				<a data-toggle="tab" href="#participant" rel="participant" title="">Người tham gia
				{!! sizeof($congviec) > 0 ? '<span class="badge">'.( ($count_cvChitiet = $congviec->congviecChitiet->count()) > 0 ? $count_cvChitiet : '' ).'</span>' : '' !!}
				</a>
			</li>
		</ul>
	</nav>

	<div class="tab-content" id="list-content">
		<div id="detail-tab" class="tab-pane fade in active">
			<div class="container-work-detali">
				@include('tabs.chitiet')
			</div>
		</div>
		<div id="document-tab" class="tab-pane fade">
			@include('tabs.tailieu')
		</div>
		<div id="discuss-tab" class="tab-pane fade">
			@include('tabs.thaoluan')
		</div>
		<div id="report-tab" class="tab-pane fade">
			@include('tabs.baocao')
		</div>
		<div id="participant" class="tab-pane fade">
			@include('tabs.nguoithamgia')
		</div>
		
	</div>
</div>
@include('congviecs.them-cv')
@include('congviecs.capnhat_cv')
<script>
	var congviecId = <?php echo (isset($_GET['congviec_id']) && $_GET['congviec_id'])? $_GET['congviec_id'] : isset($congviec)? $congviec->id : 0 ?>;
	if (congviecId) {
		axjaxLoadDetail_Congviec(congviecId);

		let $tr = $(`.wrapper-tbl-cv tr[data-congviecids="${congviecId}"]`);

		$('.wrapper-tbl-cv tbody tr,.wrapper-right-content nav ul li,.wrapper-right-content nav ul li a,#list-content.tab-content .tab-pane.fade').removeClass('active');
		$('.wrapper-right-content nav ul li:eq(0), .wrapper-right-content nav ul li:eq(0) a,#detail-tab').addClass('active');
		$tr.addClass('active');

		$('.wrapper-tbl-cv tbody tr td input[type=checkbox]').prop('checked', false);
		$tr.find('td input[type=checkbox]').prop('checked', true);
	}
	
	$(document).ready(function(){
		$('#congviec_table').on('click', '.wrapper-tbl-cv tbody tr', function(event) {
			$('.wrapper-tbl-cv tbody tr,.wrapper-right-content nav ul li,.wrapper-right-content nav ul li a,#list-content.tab-content .tab-pane.fade').removeClass('active');
			$('.wrapper-right-content nav ul li:eq(0), .wrapper-right-content nav ul li:eq(0) a,#detail-tab').addClass('active');
			$('#detail-tab,#list-content.tab-content .tab-pane.fade').addClass('in');
			$(this).addClass('active');
			$('.wrapper-tbl-cv tbody tr td input[type=checkbox]').prop('checked', false);
			$(this).find('td input[type=checkbox]').prop('checked', true);
			
			congviec_id = $(this).attr('data-congviecids');
			loading_show();
			axjaxLoadDetail_Congviec(congviec_id);
		});

		var get_type = '{{ Input::get("type") }}';

		if (get_type == 'viec_da_giao') {
			$('.title_work').text('Việc đã giao');
			$('.changeLinkWork').text('Việc được giao');
		}else{
			$('.title_work').text('Việc được giao');
			$('.changeLinkWork').text('Việc đã giao');
		}

		$('.changeLinkWork').click(function(event) {
			event.preventDefault();

			if ($(this).hasClass('viec_duoc_giao')) {
				get_type = 'viec_duoc_giao';
			}else if ($(this).hasClass('viec_da_giao')) {
				get_type = 'viec_da_giao';
			}else{
				get_type == 'viec_da_giao' ? (get_type = 'viec_duoc_giao') : get_type = 'viec_da_giao';
			}
			
			window.location = window.location.pathname+'?type='+get_type;
		});

	});

</script>