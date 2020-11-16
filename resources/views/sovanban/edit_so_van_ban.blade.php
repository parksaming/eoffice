@extends('templates.lanhdao')
@section('main')
<div class="container-fuild pdt20">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="title-text">Sửa sổ văn bản</h4>
        </div>
        <div class="col-sm-12">
            <form id="Form" action="{{route('sovanban.save')}}" method="POST">
                <div class="form-row">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{ $soVanBan->id }}">

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Tên</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <input type="text" class="form-control" name="name" value="{{ $soVanBan->name }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Chức năng</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <select name="type" class="form-control">
                                    <option value="">Hãy chọn chức năng</option>
                                    <option value="1" {{ $soVanBan->type == 1? 'selected' : '' }}>Văn bản đến</option>
                                    <option value="2" {{ $soVanBan->type == 2? 'selected' : '' }}>Văn bản đi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex">
                                <p style="padding-top:7px;">Mô tả</p>
                            </div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <textarea class="form-control" name="description" value="{{ $soVanBan->description }}" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 vanban">
                        <div class="row" style="display: flex">
                            <div class="col-md-2" style="display: flex"></div>
                            <div class="col-md-10" style="display: flex; flex-direction: column;">
                                <label for="CheckboxStatus"><input id="CheckboxStatus" type="checkbox" name="status" value="1" {{ $soVanBan->status == 1? 'checked' : '' }}> Sử dụng</label>
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
                    required: "Hãy nhập tên sổ văn bản"
                },
                type: {
                    required: "Hãy chọn chức năng sổ văn bản"
                }
            },
            submitHandler: function(form) {
                $(form).submit();
            }
        });
    });
</script>
@endsection