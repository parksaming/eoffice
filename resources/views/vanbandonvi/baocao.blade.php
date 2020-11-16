
<script>

    $(document).ready(function(){
		
		$('.wrapper-right-content nav ul li a[href="#report-tab"]').click(function(event) {
			type = '{{ Input::get("type") }}';
			url = '{{ url("baocao/commonBaocao_congviecs") }}';
			congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
			$.ajax({
				url: url,
				type: 'GET',
				data: {
					congviec_id: congviec_id,
					type: type,
				},
				success: function(data){
					$('#report-tab').html(data);
				},
				error: function(er){
					console.log('co loi xay ra');
				}
			})
		});

    })

</script>