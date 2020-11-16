@if($select_donvi_of_supervisor == '')
<label>Người phụ trách:</label>
<select class="form-control select-filter-placeholder-03" name="nguoiphutrach[]" multiple>
@endif
	@if( $select_donvi_of_supervisor == 'select_donvi_of_supervisor' )
		<option value="">-- Chọn người giám sát --</option>
	@elseif ($select_donvi_of_supervisor == 'select_donvi_of_supporter')
		<option value="">-- Chọn người phối hợp --</option>
	@endif

	@if( sizeof($resultUsers) > 0 )
		@foreach( $resultUsers as $resultUser )
		<?php $arrUsers[] = $resultUser['User']['username'] ?>
			@if( $resultUser['User']['username'] != $user_logged_username )
			<option value="{{ $resultUser['User']['username'] }}+{{ $resultUser['User']['id'] }}+{{ $resultUser['User']['tennv'] }}">{{ $resultUser['User']['tennv'] }}</option>
			@endif
		@endforeach
	@else
		<?php $arrUsers[] = '' ?>
	@endif

	@if( sizeof($users) > 0 )
		@foreach( $users as $user )
			@if( !in_array($user->username,$arrUsers) && ($user->username != $user_logged_username) )
			<option value="{{ $user->username }}+{{ $user->id}}+{{ $user->fullname }}">{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</option>
			@endif
		@endforeach
	@endif

	@if( sizeof($check_user) > 0 )
		@foreach( $check_user as $item_user )
			@if( !in_array($item_user->username,$arrUsers) && ($item_user->username != $user_logged_username) )
			<option value="{{ $item_user->username }}+{{ $item_user->id}}+{{ $item_user->username }}">{{ $item_user->username }}</option>
			@endif
		@endforeach
	@endif
@if($select_donvi_of_supervisor == '')
</select>

<script>
	$('.select-filter-placeholder-03').multiselect({
        enableFiltering: true,
        filterPlaceholder: 'Tìm kiếm ...'
    });
</script>
@endif