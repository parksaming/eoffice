<div class="wraper_message">
	<section class="message_container clearfix">
		<div class="loader" style="display: table; margin: 50px auto;"></div>
		<!-- <div class="message_content">
			<div class="thumb_mes clearfix fl-right">
				<div class="message_txt my_mes">
					Noi dung chat cua toi
				</div>
				<div class="message_time fl-right">20/03/1995</div>
			</div>
		</div>
		<div class="message_content">
			<div class="thumb_mes clearfix fl-left marTop_17">
				<span class="fl-left avatars_mes">
					<img src="../avatars/default_avatar.png" width="30px" alt="">
				</span>
				<div class="message_txt other_mes">
					<span class="username_mes">Vo Tien Dung</span>
					Noi dung chat cua nguoi tham gia
				</div>
				<div class="message_time fl-right">20/03/1995</div>
			</div>
		</div> -->
	</section>
	<section class="message_form">
		<form action="">
			{{ csrf_field() }}
			<input type="hidden" name="congviec_id_hidden" value="{{ isset($congviec) ? $congviec->id : '' }}">
			<div class="form-group">
				<div class="enter_message">
					<textarea class="form-control" name="noidung" placeholder="Nhập nội dung..."></textarea>
				</div>
			</div>
			<div class="btn_send_mes">
				<input class="btn btn-default" type="submit" value="Gửi">
			</div>
		</form>
	</section>
</div>

<script>
	
	$(document).ready(function(){
		$('.message_form form input[type=submit]').click(function(event) {
			noidung = $('.message_form form textarea[name=noidung]').val();
			if (noidung == '') {
				jAlert('Bạn chưa nhập nội dung bình luận','Thông báo');
				return false;
			}else{
				$('.message_form form').ajaxForm({
					url: '{{ url("congviec_messages/ajaxSend_WorkMessages") }}',
					type: 'post',
					success: function(data){
						$('.message_container').append(data)
							.animate({scrollTop: $('.message_container .message_content').length * 63}, 0);
						$('.message_form form').resetForm();
					},
					error: function(er){
						alert(' Co loi xay ra ');
					}
				})
			}
		});

		$('nav ul li a[href="#discuss-tab"]').click(function(event) {
			congviec_id = $('.wrapper-tbl-cv tbody tr.active').attr('data-congviecids');
			if ( typeof congviec_id !== 'undefined' ){
				$('.wraper_message').show();
				username = '{{ session("user")["username"] }}';
				var html = '';
	 			$.ajax({
					url: '{{ url("congviec_messages/ajaxList_WorkMessages") }}',
					type: 'get',
					dataType: 'json',
					data: {congviec_id: congviec_id},
					success: function(data){
						$.each(data.congviec_mes, function(index, val) {
							$time = moment(val.ngaygui).fromNow(); 
							$time = $time.replace(/a few seconds ago/gi, "bình luận mới");
							$time = $time.replace(/minutes ago/gi, "phút trước");
							$time = $time.replace(/(a minute ago)|(1 phút trước)/gi,"1 phút trước");
							$time = $time.replace(/an hour ago/gi, "1 giờ trước");
							$time = $time.replace(/hours ago/gi, "giờ trước");
							$time = $time.replace(/(day ago)|(days ago)/gi, "ngày trước");
							$time = $time.replace(/(a ngày trước)|(một ngày trước)/gi, "1 ngày trước");
							$time = $time.replace(/month ago/gi, "tháng trước");
							$time = $time.replace(/year ago/gi, "năm trước");
							html += '<div class="message_content">';
								html += '<div class="thumb_mes clearfix fl-left';
									if (val.user_gui != username) {
									html += ' marTop_17';
									}
									html += '">'; 
										if (val.user_gui != username) {
										html += '<span class="fl-left avatars_mes">';
											html += '<img src="../avatars/default_avatar.png" width="30px" alt="">';
										html += '</span>';
										}
										html += '<div class="message_txt';
										if (val.user_gui != username) {
											html += ' other_mes';
										}else{
											html += ' my_mes';
										}
										html += '">';
											if (val.user_gui != username) {
											html += '<span class="username_mes">'+data.list_username[index]+'</span>';
											}
											html += val.noidung;
										html += '</div>';
										html += '<div class="message_time fl-right">';
										html += $time;
										html += '</div>';
									html += '</div>';
								html += '</div>';
							html += '</div>';
						});
						$('.message_container').html(html)
							.animate({scrollTop: $('.message_container .message_content').length * 63}, 0);
					},
					error: function(er){
						alert(' Co loi xay ra ');
					}
				})
 			}else{
 				$('.wraper_message').hide();
 			}
		});

	})

</script>

			
		