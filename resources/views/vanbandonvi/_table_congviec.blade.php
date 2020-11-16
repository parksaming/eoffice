<table class="table table-hover wrapper-tbl-cv">
	<thead>
		<tr>
			<th style="width: 16px;padding-left: 0;padding-right: 3px;" class="col-stt"><input type="checkbox" class="check" name="" id="checkAll"></th>
			<th style="width: 77px;padding-left: 3px;padding-right: 3px;">Ngày BĐ</th>
			<th style="width: 77px;padding-left: 3px;padding-right: 3px;">Ngày KT</th>
			<th>Tên công việc</th>
			<th style="width: 100px;text-align: left;padding-left: 3px;padding-right: 0px;">Trạng thái</th>
		</tr>
	</thead>
	<tbody>
		@php 
			$congviecIdActive = isset($congviecIdActive)? $congviecIdActive : 0;
			$checkExist = false;
			foreach($congviecs as $cv) {
				if ($cv->id == $congviecIdActive) {
					$checkExist = true;
				}
			}
			if ($checkExist == false) {
				$congviecIdActive = isset($congviecs[0])? $congviecs[0]->id : '';
			}
		@endphp
		@foreach($congviecs as $key => $congviec)
		<tr class="col-stt {{ $congviec->id == $congviecIdActive? 'active' : '' }}" style="cursor: pointer;" data-congviecIds="{{ $congviec->id }}">
			<td style="width: 16px;padding-left: 0;padding-right: 3px;">
				<input {{ $congviec->id == $congviecIdActive ? 'checked' : '' }} class="check" type="checkbox" name="">
			</td>
			<td style="width: 77px;padding-left: 3px;padding-right: 3px;">{{ formatDMY($congviec->ngaybatdau) }}</td>
			<td style="width: 77px;padding-left: 3px;padding-right: 3px;">{{ formatDMY($congviec->ngayketthuc) }}</td>
			<td style="text-align: left;padding-left: 3px;padding-right: 3px;">{{ $congviec->tencongviec }}</td>
			<td style="width: 100px;text-align: left;padding-left: 3px;padding-right: 0px;">{{ $congviec->trangthai_text }}</td>
		</tr>
		@endforeach
	</tbody>

	@if ($congviecIdActive)
		<script>
			$(document).ready(function () {
				axjaxLoadDetail_Congviec({{ $congviecIdActive }});
			})
		</script>
	@endif
</table>
