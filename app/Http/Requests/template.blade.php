@extends('templates.back.layout')

@section('head')

    {!! HTML::style('ckeditor/plugins/codesnippet/lib/highlight/styles/default.css') !!}

@endsection

@section('main')
    <div class="page-wrapper">
        <div class="top-page-wrapper">
            {{--@include('back.partials.entete', ['title' => trans('back/blog.dashboard'), 'icon' => 'pencil', 'fil' => link_to('blog', trans('back/blog.posts')) . ' / ' . trans('back/blog.creation')])--}}
            <div class="title-page col-md-5 col-sm-5 col-xs-12">
                <h4>QUẢN LÝ CHỨC VỤ</h4>
            </div>
           </div>
        <div class="page-content col-md-12 col-sm-12" style="padding:30px 10px;">
            @yield('form')
            <div class="form-group col-md-8">
                <div class="form-group col-md-12">
                    <label>NameVI</label>
                    <input type="text" class="form-control" name="nameVI" value="">
                </div>
                <div class="form-group col-md-12">
                    <label>NameEN</label>
                    <input type="text" class="form-control" name="nameEN" value="">
                </div>
                <div class="form-group col-md-12">
                    <label>Note</label>
                    <input type="text" class="form-control" name="note" value="">
                </div>
                <div class="form-group col-md-12">
                    <label style="margin-right: 10px;">Status</label>
                    <input type="checkbox" name="status" {{ (isset($position) && $position->status)? 'checked' : '' }} >
                </div>
                <div class="form-group col-md-12">
                    <button class="btn btn-info ">Thêm mới</button>
                </div>

            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')

    {!! HTML::script('ckeditor/ckeditor.js') !!}

    <script>

        var config = {
            codeSnippet_theme: 'Monokai',
            language: '{{ config('app.locale') }}',
            height: 100,
            filebrowserBrowseUrl: '/elfinder/ckeditor',
            toolbarGroups: [
                {name: 'clipboard', groups: ['clipboard', 'undo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
                {name: 'links'},
                {name: 'insert'},
                {name: 'forms'},
                {name: 'tools'},
                {name: 'document', groups: ['mode', 'document', 'doctools']},
                {name: 'others'},
                //'/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi']},
                {name: 'styles'},
                {name: 'colors'}
            ]
        };

        CKEDITOR.replace('summary', config);

        config['height'] = 400;

        CKEDITOR.replace('content', config);

        function removeAccents(str) {
            var accent = [
                /[\300-\306]/g, /[\340-\346]/g, // A, a
                /[\310-\313]/g, /[\350-\353]/g, // E, e
                /[\314-\317]/g, /[\354-\357]/g, // I, i
                /[\322-\330]/g, /[\362-\370]/g, // O, o
                /[\331-\334]/g, /[\371-\374]/g, // U, u
                /[\321]/g, /[\361]/g, // N, n
                /[\307]/g, /[\347]/g // C, c
            ];
            var noaccent = ['A', 'a', 'E', 'e', 'I', 'i', 'O', 'o', 'U', 'u', 'N', 'n', 'C', 'c'];
            for (var i = 0; i < accent.length; ++i) {
                str = str.replace(accent[i], noaccent[i]);
            }
            return str;
        }

        $("#title").keyup(function () {
            var str = removeAccents($(this).val())
                    .replace(/[^a-zA-Z0-9\s]/g, "")
                    .toLowerCase()
                    .replace(/\s/g, '-');
            $("#permalink").val(str);
        });

    </script>

@endsection