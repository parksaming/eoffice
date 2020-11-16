<style>
    .lang-wrapper.top-bar {
        display: inline-block;
        padding: 18px 0;
    }
    .lang-wrapper.home-page {
        position: absolute;
        right: 20px;
        top: 20px;
    }
    .lang-select {
        display: inline-block;
        margin-right: 10px;
    }
    .lang-option {
        display: inline-block;
    }
</style>

<div class="lang-select">
    <div class="lang-option" style="margin-right: 4px;"><a href="{{ url('language/en') }}"><image style="width: 30px;height: 21px;" src="{{asset('img/flag_en.jpg')}}"></image></a></div>
    <div class="lang-option"><a href="{{ url('language/vi') }}"><image style="width: 30px;height: 21px;" src="{{asset('img/vi-flag.png')}}"></image></a></div>
</div>