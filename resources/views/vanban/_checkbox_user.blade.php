<style>
    .checkbox-group {
        margin-bottom: 5px;
    }
    .checkbox-l {
        font-weight: bold;
    }
    .checkbox-c {
        padding: 0 0 0 15px;
    }
    .checkbox-c label {
        font-weight: normal;
    }
    .checkbox-c input {
        margin-right: 5px;
    }
</style>

@if (sizeof($data))
    @foreach ($data as $donviName => $users)
        <div class="checkbox-group">
            <div class="checkbox-l">
                <label><input type="checkbox" class="check-all"> <span> {{ $donviName }}</span></label>
            </div>
            <div class="checkbox-c">
                @foreach ($users as $user)
                    <div><label><input type="checkbox" value="{{ $user->id }}" name="{{ $checkboxName }}" {{ in_array($user->id, $selectedUserIds)? 'checked' : '' }}> <span>{{ $user->fullname.' - '.$user->chucdanh.' - '.$user->email }}</span></label></div>
                @endforeach
            </div>
        </div>
    @endforeach
@else
    Không có dữ liệu
@endif