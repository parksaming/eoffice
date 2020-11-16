@extends('templates.lanhdao')

@section('main')
<div class="container-fluid" id="daily_report">
	<div class="row">
		<div class="col-md-6">
			@if ( sizeof($check_CheckUser) != 0 ) 
	  			@include('congviecs._viewWork.colum_1')
			@else
				@include('congviecs._viewWork.colum_2')
			@endif
	    </div>
	    <div class="col-md-6">
	  		@if ( sizeof($check_CheckUser) != 0 ) 
	  			@include('congviecs.fullcalendar',["inc_calendar"=>"inc_calendar"])
			@else
				@include('congviecs._viewWork.colum_1')
			@endif
	    </div>
	</div>
</div>
	
<div id="modal_view_dailyReport" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

	$('.btn_view_report').click(function(event) {
		loading_show();
		var report_id = $(this).closest('li').find('dt.btn_view_report').attr('data-id');
		$.ajax({
			url: '{{ url("congviec/view_dailyReport") }}',
			type: 'GET',
			data: {report_id: report_id},
			success: function(data){
				loading_hide();
				$('#modal_view_dailyReport .modal-content').html(data);
				$('#modal_view_dailyReport').modal('show');
			},
			error: function(er){
				alert('Co loi xay ra');
			}
		})						
	});

	$('#form_draft_report input[type=file]').change(function(event) {
		if (!event.target.files[0].name.match(/.(doc|docx|xls|xlsx|ppt|pptx|pdf)$/i) || event.target.files[0].size > 20971520){
			event.target.value = '';
            jAlert('Chỉ upload định dạng file: doc, docx, xls, xlsx, ppt, pptx, pdf với dung lượng < 20M','Thông báo');
		}
	});

	function f_work_search(keyword){
		$('.thumb_work input[name=congviec_user_id]').val('');
		if (keyword == '') {
			$('.list_result_work_search').hide();
			return false;
		}
		$.get(
			'{{ url("congviec/work_search_keyup") }}', 
			{ keyword : keyword, username: "{{ session('user')['username'] }}" },
			function(data) {
				if (data != '') {
					$('.list_result_work_search').html(data).show();
				}else{
					$('.list_result_work_search').hide();
				}
		});
	}

	$('.list_result_work_search').on('click', 'li', function(event) {
		var cv_user_id = $(this).attr('data-id');
		var txt_noidung = $(this).text();
		$(this).closest('.thumb_work').find('input[type=text]').val(txt_noidung);
		$(this).closest('.thumb_work').find('input[type=hidden]').val(cv_user_id);
		$('.list_result_work_search').hide();
		$('.all_work_user').removeClass('active');
	});

	$('#form_draft_report .all_work_user').click(function(event) {
		if ( $(this).hasClass('active') ) {
			$('.list_result_work_search').hide();
			$(this).removeClass('active');
		}else{
			loading_show();
			$(this).addClass('active');
			var username = '{{ session("user")["username"] }}';
			$.get(
				'{{ url("congviec/work_search_all") }}', 
				{ username: "{{ session('user')['username'] }}" },
				function(data) {	
					loading_hide();			
					if (data != '') {
						$('.list_result_work_search').html(data).show();
					}else{
						$('.list_result_work_search').hide();
					}
			});
		}
	});

	$("#form_draft_report").validate({
        rules: {
            content: "required",
        },
        messages: {
            content: "Vui lòng nhập nội dung",
        }
    });

    $(window).on('load scroll resize', function(event) {
    	if ( $(this).width() < 992 ) {
			$('.daily_report_left').removeClass('fixed_report_left');
			$('.daily_report_right').removeClass('col-md-offset-6');
    		return false;
    	}
    	var offset = $('.header').outerHeight() + $('.menu').outerHeight() + 7;
    	if ($(this).scrollTop() > offset) {
    		@if ( sizeof($check_CheckUser) == 0 ) 
    			$('.daily_report_left').addClass('fixed_report_left');
    			$('.daily_report_right').addClass('col-md-offset-6');
    		@endif
    	}else{
    		@if ( sizeof($check_CheckUser) == 0 ) 
    			$('.daily_report_left').removeClass('fixed_report_left');
    			$('.daily_report_right').removeClass('col-md-offset-6');
    		@endif
    	}
    });

    var pathname = window.location.pathname;
    if (pathname.indexOf('/congviec/view_work') != 0) {
    	$('.menu nav ul li').removeClass('active');
    	$('.daily_report').addClass('active');
    }

    $('.summernote').summernote({
        height: 150
    });

    var daily_report_left = $('#daily_report .row .daily_report_left').height();
    var daily_report_right = $('#daily_report .row .daily_report_right').height();
    if ( daily_report_left > daily_report_right ) {
    	$('.daily_report_left').css('border-right', '1px solid #e2e2e2');
    }else{
    	$('.daily_report_right').css('border-left', '1px solid #e2e2e2');
    }

</script>
@endsection



