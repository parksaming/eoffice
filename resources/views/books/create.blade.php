@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Thêm đơn vị vào cơ quan {{ $book->name }}</h4>
        </div>
        <div class="col-sm-12">
            <form id="Form" action="{{route('co_quan.save_don_vi')}}" method="POST">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Đơn vị:</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column-reverse;">
                                <select class="form-control" name="donvi_id">
                                    <option value="">Chọn đơn vị</option>
                                    @foreach ($donvis as $donvi)
                                        <option value="{{$donvi->id}}">{{$donvi->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Danh sách email:</p>
                            </div>
                            <div class="col-md-10" style="display: flex; height: 120px; flex-direction: column-reverse;">
                                <input type="text" class="form-control" name="donvi_email" data-role="tagsinput">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Danh sách cán bộ:</b></p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column-reverse;">
                                <select name="user_id[]" class="form-control" multiple data-placeholder="Chọn cán bộ">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ sprintf('%s - %s - %s', $user->fullname, $user->email, $user->donvi_name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12 vanban" style="text-align: center">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px">Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bootstrap-tagsinput {
        height: 100%;
    }
</style>

<script>
    var userEmails = <?php echo json_encode($users->pluck('email')->toArray()) ?>;

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        
        if (!pattern.test(emailAddress)) {
            return false;
        }

        if (userEmails.includes(emailAddress)) {
            jAlert('Email đã tồn tại, xin vui lòng chọn cán bộ!', 'Thông báo');
            return false;
        }
        
        return true;
    }

    $(document).ready(function () {
        // đơn vị
        $('select[name="donvi_id"]').chosen({
            search_contains: true,
            width: "100%"
        });
        
        // email
        $('input[name="donvi_email"]').on('beforeItemAdd', function(e) {
            if (!isValidEmailAddress(e.item)) {
                e.cancel = true;
            }
        });

        // user
        $('select[name="user_id[]"]').chosen({
            search_contains: true,
            width: "100%"
        });

        // validate
        $('#Form').validate({
            rules: {
                donvi_id: {
                    required: true
                },
                donvi_email: {
                    required: true
                },
                'user_id[]': {
                    required: true
                }
            },
            messages: {
                donvi_id: {
                    required: "Hãy chọn đơn vị"
                },
                donvi_email: {
                    required: "Hãy nhập mail"
                },
                'user_id[]': {
                    required: "Hãy nhập cán bộ"
                }
            },
            submitHandler: function(form) {
                $(form).submit();
            }
        });
    });
</script>
@endsection