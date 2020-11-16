<div class="pagination-container"></div>

<script>
    var optionPagination = {
        url: {{ isset($url)? $url : 'window.location.pathname' }},
        container: '{{ $container }}',
        curPage: {{ isset($curPage)? $curPage : 1 }},
        totalPage: {{ isset($totalPage)? $totalPage : 0 }},
        maxVisible: {{ isset($maxVisible)? $maxVisible : 5 }},
        scrollToTop: {{ isset($scrollToTop)? $scrollToTop : 0 }},
        handleOldData: '{{ isset($handleOldData)? $handleOldData : 'replace' }}', // 'replace', 'hide'
        params: getURLParameters(window.location.href)
    }
    
    $(document).ready(function () {
        initPagination();
    });
    
    function initPagination() {
        if (optionPagination.totalPage > 1) {
            // if hide old data, 
            if (optionPagination.handleOldData == 'hide') {
                // create data wrapper
                dataWrapper = 'data-pagination-'+optionPagination.curPage;
                $('body').append('<div class="data-pagination '+dataWrapper+'"></div>');
                // move child of container to wrapper
                $(optionPagination.container).children().appendTo('.'+dataWrapper);
                // move wrapper to container
                $('.'+dataWrapper).appendTo(optionPagination.container);
            }
            
            // create pagination
            $('.pagination-container').bootpag({
                total: optionPagination.totalPage,
                page: optionPagination.curPage,
                next: 'Tiếp',
                prev: 'Trước',
                maxVisible: optionPagination.maxVisible
            }).on('page', function(event, num){
                // reset current page
                curPage = num;
                // change params
                optionPagination.curPage = curPage;
                optionPagination.params.page = num;
                optionPagination.params.ajax = 1;
                // load data
                loading_show();
                loadPageAjax();
                loading_hide();
            });
        }
        else {
            $('.pagination').html('');
        }
    }
    
    function loadPageAjax() {
        wrapperCurrent = 'data-pagination-'+optionPagination.curPage;
        if ($('.'+wrapperCurrent).length) {
            $('.data-pagination').hide();
            $('.data-pagination.'+wrapperCurrent).show();
            
            if (optionPagination.scrollToTop) {
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }
        }
        else {
            $.get(optionPagination.url, optionPagination.params , function(data) {
                if (optionPagination.handleOldData == 'hide') {
                    $('.data-pagination').hide();
                    $(optionPagination.container).append('<div class="data-pagination '+wrapperCurrent+'">'+data+'</div>');
                }

                if (optionPagination.handleOldData == 'replace') {
                    $(optionPaginationinputs.container).html(data);
                }

                if (optionPagination.scrollToTop) {
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                }
            });
        }
    }
</script>