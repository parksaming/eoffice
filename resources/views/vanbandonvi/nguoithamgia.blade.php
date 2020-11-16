<div class="lisUser_joinWork">
	<!-- danh sach tham gia cong viec -->
</div>

<script>
	
	$('.wrapper-right-content ul.nav li a[href="#participant"]').click(function(event) {
		congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
		if ( typeof congviec_id !== 'undefined' ) {
			$.ajax({
				url: '{{ url("congviec_chitiet/axjaxLoadDetail_WorkJoin") }}',
				type: 'POST',
				data: {
					congviec_id: congviec_id,
					_token: '{{ csrf_token() }}'
				},
				success: function(data){
					$('.lisUser_joinWork').html(data);
				},
				error: function(er){
					alert('Co loi xay ra');
				}
			})
		}
		
	});

</script>