@extends('templates.lanhdao')
@section('main')

@php
	$user = (object) session('user');
	$donvi = App\Models\Donvi::find($user->donvi_id);
@endphp

<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="title-text">Đăng ký lịch tuần</h3>
		</div>
		<div class="col-sm-12 table-bordered" style="margin-top: 20px">
			<div style="text-align: center; margin-top: 20px">
				<i><label>Lưu ý:</label> Các trường có dấu <em class="flag-require">*</em> bắt buộc nhập thông tin</i>
			</div>
			<form id="FormDangKy" class="form" action="{{ route('phonghop.savedangkylichtuan') }}" method="POST" style="margin-top: 20px">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<!-- thông tin lịch -->
				<div class="form-row">
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:10px; text-align: right;">Loại</label>
								</div>
								<div class="col-md-10">
									<div class="radio">
										<label><input type="radio" name="type" value="1" checked>Lịch tuần Đại học Đà Nẵng</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="type" value="2">Lịch tuần Cơ quan</label>
									</div>
								</div>
							</div>
						</div>
					</div>
						
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Thời gian</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<input type="text" class="form-control date-picker" name="time" id="tungay">
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px; text-align: right;">Địa điểm</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10">
									<div>
										<input type="text" class="form-control" name="diadiem"/>
									</div>
									<div class="hidden" style="display: flex; flex-direction: column-reverse;">
										<select class="chosen form-control" disabled name="phonghop_id">
											<option value="">Hãy chọn phòng họp</option>
											@foreach ($phonghops as $val)
												<option value="{{ $val->id }}">{{ $val->tenphonghop }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Nội dung</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<textarea class="form-control" name="noidung" id="noidung" cols="30" rows="5" placeholder="Nội dung cuộc họp"></textarea>
								</div>
							</div> 
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Thành phần</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-10" >
									<textarea class="form-control" name="thanhphan" id="thanhphan" cols="30" rows="5" placeholder="Nhập thành phần tham gia"></textarea>
								</div>
							</div> 
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Chủ trì</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="chutri" id="chutri" placeholder="Nhập người chủ trì">
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Số người tham gia</label>
								</div>
								<div class="col-md-4">
									<input type="number" class="form-control" name="songuoithamgia" id="songuoithamgia" min="1" placeholder="Nhập số người tham gia">
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- thông tin người đăng ký -->
				<div class="form-row">
					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px; text-align: right;">Người đăng ký</label>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="nguoidangky" id="nguoidangky" value="{{ $user->fullname }}" placeholder="Nhập tên người đăng ký">
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Đơn vị</label>
								</div>
								<div class="col-md-4">
									<input type="text" class="form-control" name="donvi" id="donvi" value="{{ $donvi->name }}" placeholder="Nhập đơn vị">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban">
						<div class="row">
							<div class="col-md-12">
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Số điện thoại</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4" >
									<input type="digits" class="form-control" name="sodienthoai" id="sodienthoai" value="{{ $user->phone }}" placeholder="Nhập số điện thoại">
								</div>
								<div class="col-md-2" style="text-align: right;">
									<label style="padding-top:7px;">Email</label><em class="flag-require">*</em>
								</div>
								<div class="col-md-4" >
									<input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" placeholder="Nhập Email">
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 vanban" style="text-align: right; margin-top: 25px;">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary" style="margin-bottom: 15px" href="{{ route('phonghop.dangkylichtuan') }}">
								<span class="glyphicon glyphicon-floppy-saved"></span> Thêm mới
							</button>
							<a class="btn btn-danger" style="margin-bottom: 15px;" href="{{ route('phonghop.danhsachphonghop') }}"><i class="glyphicon glyphicon glyphicon-remove"></i> Thoát</a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	 $(document).ready(function() {
		$('.chosen').chosen({no_results_text: 'Không tìm thấy kết quả', width: '100%', search_contains:true});
		
	 	$('#FormDangKy').validate({
	 		rules: {
				phonghop_id: {
					required: true
				},
				diadiem: {
					required: true
				},
	 			sodienthoai: {
	 				required: true
	 			},
	 			email: {
	 				required: true
	 			},
	 			time: {
	 				required: true
	 			},
	 			noidung: {
	 				required: true
	 			},
	 			chutri: {
	 				required: true
	 			},
	 			thanhphan: {
	 				required: true
	 			}
	 		},
	 		messages: {
				phonghop_id: {
					required: "Hãy chọn phòng họp"
				},
				diadiem: {
	 				required: "Hãy nhập địa điểm"
	 			},
	 			sodienthoai: {
	 				required: "Hãy nhập só điện thoại"
	 			},
	 			email: {
	 				required: "Hãy nhập email"
	 			},
	 			time: {
	 				required: "Hãy nhập thời gian"
	 			},
	 			noidung: {
	 				required: "Hãy nhập nội dung"
	 			},
	 			chutri: {
	 				required: "Hãy nhập người chủ trì"
	 			},
	 			thanhphan: {
	 				required: "Hãy  nhập thành phần tham gia"
	 			}
	 		},
	 		submitHandler: function(form) {
	 			loading_show();
	 			form.submit();
	 		}
	 	});
	});

	$('.date-picker').datetimepicker({
		format: 'DD-MM-YYYY HH:mm',
		useCurrent: false
	});

	$('input[name="type"]').click(function () {
		if ($(this).val() == 1) {
			$('select[name="phonghop_id"]').attr('disabled', true).closest('div').addClass('hidden');
			$('input[name="diadiem"]').attr('disabled', false).closest('div').removeClass('hidden');
		}
		else {
			$('input[name="diadiem"]').attr('disabled', true).closest('div').addClass('hidden');
			$('select[name="phonghop_id"]').attr('disabled', false).closest('div').removeClass('hidden');
		}

		$('select[name="phonghop_id"]').trigger("chosen:updated");
	});
</script>
@endsection
