
<div class="listtree" id="printDiv1" style="margin-top: 10px;">
    <ul class="ulroot">
        @if (isset($vanBanXuLy))
            <li class="li-flex">
                <div>
                    <div class="title {{ ($vanBanXuLy->type == 1? 'item-chutri ' : '').($vanBanXuLy->status == 1? 'item-chuaxuly' : ($vanBanXuLy->status == 2? 'item-dangxuly' : 'item-daxuly')) }}">
                        @if (isset($vanBanXuLy))
                            <span class="{{ ($vanBanXuLy->id_nhan == session('user')['id'] ? 'colorblu' : '') }}">{{$vanBanXuLy->fullname}}</span><br>
                            <span>{{formatDateTimeToDisplay($vanBanXuLy->ngaychuyentiep_view)}}</span>
                        @endif
                    </div>
                </div>
                {!! $vb_child !!}
                <div class="clear"></div>
            </li>
        @endif
    </ul>
</div>
