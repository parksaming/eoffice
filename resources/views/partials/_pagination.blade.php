@if (isset($list))
<style>
    .page-item.prev, .page-item.next {
        display:none !important;
    }
    .page-item.first.disabled, .page-item.last.disabled {
        display: none !important;
    }
    .pagination{
        margin-top: 0 !important;
    }
</style>

<nav>
    <ul class="pagination" id="pagination"></ul>
</nav>

<script src="{{ asset('js/jquery.twbsPagination.js')}}" type="text/javascript"></script>
<script type="text/javascript">
    var totalPages = {{ ceil($list->total()/$list->perPage()) }};
    var curPage = {{ $list->currentPage() }};
    var container = "{{ isset($container)? $container : '' }}";
    var defaultOpts = {
        totalPages: totalPages,
        startPage: curPage,
        visiblePages: 5,
        hideOnlyOnePage: true,
        first: "Đầu",
        last: "Cuối({{ ceil($list->total()/$list->perPage()) }})",
        initiateStartPageClick: false,
        onPageClick: function (event, page) {
            // get all params in current link
            params = getURLParameters(window.location.href);
            // reset page
            params.page = page;

            if (page != curPage) {
                @if (isset($ajax))
                    // redirect to link with new page
                    loading_show();
                    params.ajax = 1;
                    $.get(window.location.pathname, params, function(data) {
                        $(container).html(data);
                        curPage = page;
                        loading_hide();
                    });
                @else
                    window.location = createLink(window.location.pathname, params);
                @endif
            }
        }
    };
    
    $pagination = $('#pagination');
    
    $pagination.twbsPagination(defaultOpts);
    
    function reloadAjax(page,type) {
        params = getURLParameters(window.location.href);
        params.ajax = 1;
        if (!page) {
            params.page = curPage;
        }
        else {
            params.page = page;
        }

        if (!type) {
            params.type = 'viec_da_giao';
            $('.title_work').text('Việc đã giao');
            $('.changeLinkWork').text('Việc được giao');
            $('.changeLinkWork').addClass('viec_duoc_giao');
        }else{
            params.type = type;
            $('.title_work').text('Việc được giao');
            $('.changeLinkWork').text('Việc đã giao');
            $('.changeLinkWork').addClass('viec_da_giao');
        }
        
        $.get(window.location.pathname, params, function(data) {
            $(container).html(data);
            
            $pagination.twbsPagination('destroy');
            $pagination.twbsPagination(defaultOpts);
        });
    }
    
    function reload(page) {
        params = getURLParameters(window.location.href);
        if (!page) {
            params.page = curPage;
        }
        else {
            params.page = page;
        }
        window.location = createLink(window.location.pathname, params);
    }
</script>
@endif