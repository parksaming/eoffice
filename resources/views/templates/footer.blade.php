<script>
    $(document).ready(function(){
        $(".scroll_detail_salary").scroll(function(){

        });
    });
    var lastScrollTop = 0;
    $('.scroll_detail_salary').scroll(function(event){
        var st = $(this).scrollTop();
        if (st > lastScrollTop){
            $(".add_down").addClass("scroll_down head-table");
            $(".add_down_two").addClass("scroll_top  head-table");
            $(".scroll_top_one").addClass("top_head_scroll  head-table");
        } else {
            if (st === 0 ){
                $(".add_down").removeClass("scroll_down");
            }
        }
        lastScrollTop = st;
    });


</script>

<div class="footer-fixed">
        <div class="col-sm-12 text-center" style="background: #2a528c">
            <div style="color: #fff; padding: 10px;">
                Bản quyền &copy 2019 thuộc Đại học Đà Nẵng
            <br/>
                Mr. Hùng (hỗ trợ): 0935.888.256<br/>
                <i class="fa fa-phone" aria-hidden="true" id="footer_icon"></i>Điện thoại:(84-236) 3822041&nbsp;&nbsp;  <i id="footer_icon" class="fa fa-fax" aria-hidden="true"></i>Fax:(84-236) 3823683<i style="font-size: 14px; color: #fff"></i>
                <i id="footer_icon" class="fa fa-home" aria-hidden="true"></i>41 Lê Duẩn, Quận Hải Châu, Thành phố Đà Nẵng&nbsp;&nbsp; <i id="footer_icon" class="fa fa-envelope" aria-hidden="true"></i>Email: webmaster@ac.udn.vn 
            </div>

        </div>
</div>

