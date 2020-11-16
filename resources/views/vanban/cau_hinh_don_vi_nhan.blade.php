@extends('templates.lanhdao')
@section('main')
    <?php
    function tree($id,$i)
    {
        $i= $i.'---';
        $parents = App\Donvi::where('parent_id',$id)->get();
        $tree = '';
        foreach ($parents as $parent){
            $parent2 = App\Donvi::where('parent_id',$parent->id)->get();
            echo '<option value="'.$parent->id.'">'.$i.$parent->name.'</option>';
            if (count($parent2) > 0){
                tree($parent->id,$i);
            }
        }
        echo $tree;
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4 class="title-text">Cấu hình đơn vị nhận</h4>
            </div>
            @if (session('success'))
            <div class="col-sm-12">
                <div class="alert alert-success show" role="alert">
                    <strong>Chúc mừng!!!</strong>{{session('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            @endif
            <div class="col-sm-12">
                <form action="{{route('add.cauhinh')}}" method="POST" id="form-cauhinh-vanban">
                    <div class="form-row">
                        <input type="hidden" name="_token" value="{{csrf_token()}}" >
                        <div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p style="padding-top:7px">1.<b>Cấu hình</b></p>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="loaivanban_id" id="loaivanban">
                                                <option value="">Chọn loại cấu hình</option>
                                                @foreach ($books as $book)
                                                    <option value="{{$book->id}}">{{$book->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p style="padding-top:7px">2.<b>Đơn vị:</b></p>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control" name="donvi_cauhinh" id="donvi_cauhinh">
                                                <option value="">Chọn đơn vị</option>
                                                <?php
                                                foreach ($donvischa as $donvi):
                                                $parent = App\Donvi::where('parent_id',$donvi->id)->get();
                                                $i = '';?>
                                                <option value="{{$donvi->madonvi}}"><b>{{$donvi->name}}</b></option>
                                                <?php if (count($parent) > 0):
                                                    tree($donvi->id,$i);
                                                endif;endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><div class="col-md-12 vanban">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p style="padding-top:7px">3.<b>Email đơn vị:</b></p>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="email" data-role="tagsinput" name="emaildonvi" id="emaildonvi" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p style="padding-top:7px">4.<b>Người nhận</b></p>
                                        </div>
                                        <div class="col-md-10">
                                            <select class="form-control chosen-select" name="signer[]" id="signer" multiple>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" style="margin-top:10px" >Xác Nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        $('#form-cauhinh-vanban').validate({
            ignore:":hidden:not(select)",
            rules:{
                'loaivanban_id' : 'required',
                'donvi_cauhinh[]': 'required',
                'emaildonvi'    : 'required',
                'signer[]'        :  'required'
            },
            messages:{
                'loaivanban_id' : 'Vui lòng chọn loại công văn',
                'donvi_cauhinh[]': 'Nhập đơn vị',
                'emaildonvi'    :   'Nhập Email đơn vị',
                'signer[]'        :   'Nhập người đùng'
            }
        });
        $('#donvi_cauhinh').change(function(){
           var donvi = $(this).val();
           var cauhinh = $('#loaivanban').val();
           var token = '{{csrf_token()}}';
           var url = '{{route('check.donvi')}}';
           $.post(url,{'donvi':donvi,'_token':token,'cauhinh':cauhinh},function(data){
               var check = jQuery.parseJSON(data);
                if (check.success == false){
                    $('#donvi_cauhinh').val('');
                    alert('Đơn vị đã được cấu hình, xin chọn đơn vị khác!!!');
                }
           });
        });
    </script>
@endsection
