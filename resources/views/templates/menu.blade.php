<?php $user=\Illuminate\Support\Facades\Session::get('user');
use App\Models\CheckUser;
?>
<div class="menu clearfix col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div style="float: left;">
        <nav class="list-menu">
            <ul class="nav nav-tabs">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <li class="dropdown">
                    <a class="dropbtn" style=" border-right: 1px solid #fff;" href="{{url('dashboard')}}" title=""><i class="fa fa-home" aria-hidden="true"></i> &nbsp;Trang chủ</a>
                </li>
                <li class="dropdown" style="display: none;">
                    <a class="dropbtn" style=" border-right: 1px solid #fff;" data-toggle="dropdown" title=""><i class="fa fa-bars" aria-hidden="true"></i> &nbsp;Office 365 </a>
                    <ul class="dropdown-menu multi-column columns-2">
                        <div class="row">
                            <div class="col-sm-12 pd-of">
                                <div class="pull-right text-primary"><a href="http://portal.office.com/">Office 365</a> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></div>
                           </div>
                            <h4 class="pl-40">Apps</h4>
                            <div class="col-sm-6">
                                <ul class="multi-column-dropdown">
                                    <li class="li-office">
                                        <a href="https://outlook.office.com/mail/" target="_blank">
                                            <img src="{{url('/img/icon_header/Outlook.png')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://www.office.com/launch/word/" target="_blank">
                                            <img src="{{url('/img/icon_header/word.PNG')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://www.office.com/launch/powerpoint/" target="_blank">
                                            <img src="{{url('/img/icon_header/PowerPoint.PNG')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://udnedu.sharepoint.com/" target="_blank">
                                            <img src="{{url('/img/icon_header/SharePoint.PNG')}}"/>
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="col-sm-6 ml-15">
                                <ul class="multi-column-dropdown">
                                    <li class="li-office">
                                        <a href="https://udnedu-my.sharepoint.com/_layouts/15/MySite.aspx?MySiteRedirect=AllDocuments" target="_blank">
                                            <img src="{{url('/img/icon_header/OneDrive.PNG')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://www.office.com/launch/excel" target="_blank">
                                            <img src="{{url('/img/icon_header/Excel.PNG')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://udnedu-my.sharepoint.com" target="_blank">
                                            <img src="{{url('/img/icon_header/OneNote.PNG')}}"/>
                                        </a>
                                    </li>
                                    <li class="li-office">
                                        <a href="https://teams.microsoft.com/" target="_blank">
                                            <img src="{{url('/img/icon_header/Teams.PNG')}}"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div> 

<script>
    
    $(document).ready(function(){
        $('.calendar_work').click(function(event) {
            $('#wrappar-calendar').show();
            $.get(
                '{{ url("congviec/fullcalendar") }}', 
                function(data) {
                    $('#container-calendar').html(data);
            });
        });
        $('#wrappar-calendar').click(function(event) {
            if ( event.target.id == 'wrappar-calendar' ) {
                $('#wrappar-calendar').hide();
                $('#container-calendar').html('<div class="loader load_calendar"></div>');
            }
        });
    })

</script>

<div id="wrappar-calendar">
    <div id="container-calendar">
        <div class="loader load_calendar"></div>
    </div>
</div>

<div class="clearfix"></div>
@include('errors.alert')
