@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Thêm cơ quan</h4>
        </div>
        <div class="col-sm-12">
            <form id="Form" action="{{route('co_quan.save')}}" method="POST">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Tên cơ quan</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Loại cơ quan</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <input type="text" class="form-control" name="type">
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

<script>
    $(document).ready(function () {
        // validate
        $('#Form').validate({
            rules: {
                name: {
                    required: true
                },
                type: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Hãy nhập tên cơ quan"
                },
                type: {
                    required: "Hãy nhập loại cơ quan"
                }
            },
            submitHandler: function(form) {
                $(form).submit();
            }
        });
    });
</script>
@endsection