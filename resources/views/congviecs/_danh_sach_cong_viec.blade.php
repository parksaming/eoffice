<div class="col-md-7 wrapper-left-content">
	<div class="col-sm-12 nopadding" style="display: flex;justify-content: space-between;">
		<form id="FormSearchCongViec" action="" method="GET" accept-charset="utf-8">
			@if( Input::get("type") == 'viec_da_giao' )
			<input type="hidden" name="type" value="viec_da_giao">
			@endif
			<nav class="menu-top">
				<ul class="nav navbar-nav">
					<li>
	                    <select id="SelectCVStatus" name="trangthai_search" class="form-control selectpicker">
							<option value="">Chọn trạng thái</option>
							<option value="0" {{ isset($trangthai_search) && $trangthai_search == 0? 'selected' : '' }}>Đang thực hiện</option>
							<option value="1" {{ isset($trangthai_search) && $trangthai_search == 1? 'selected' : '' }}>Đã hoàn thành</option>
							<option value="2" {{ isset($trangthai_search) && $trangthai_search == 2? 'selected' : '' }}>Tạm dừng</option>
							<option value="3" {{ isset($trangthai_search) && $trangthai_search == 3? 'selected' : '' }}>Hủy bỏ</option>
				    	</select>
					</li>
					<li><button type="submit" class="btn btn-default btn-search-cong-viec">Tìm</button></li>
				</ul>
			</nav>
		</form>

		<div class="action-create-work" style="margin: 0;">
			<a class="btn btn-primary" href="javascript:;" id="create">
				<i class="glyphicon glyphicon-plus"></i>
				Tạo công việc
			</a>
		</div>
	</div>
	<div class="clearfix" style="margin-bottom: 20px;"></div>

	<div class="table-responsive" id="congviec_table">
		@if( sizeof($congviecs) > 0 )
			@include('congviecs._table_congviec')
		@else
			<em style="display: table; margin: 30px auto;">Không có công việc</em>
		@endif
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
@include('congviecs.them-cv', ['vanbanxuly' => isset($vanbanxuly)? $vanbanxuly : null])
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

	$('#FormSearchCongViec').submit(function (e) {
		e.preventDefault();

		let congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');

		let params = {
			get_view: 1,
			vanban_id: "{{isset($vanbanxuly)? $vanbanxuly->vanbanUser_id : ''}}",
			type: $('#SelectCVType').val(),
			search: $('#InputCVSearch').val(),
			date: $('#InputCVDate').val(),
			status: $('#SelectCVStatus').val(),
			congviec_id_active: congviec_id
		};

		$.get("{{route('congviec.danhsach')}}", params, function(data) {
			$('#congviec_table').html(data);
		});
	});
	
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
	});
</script>