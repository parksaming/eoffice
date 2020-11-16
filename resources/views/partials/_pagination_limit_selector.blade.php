<div class="pagination_select">
    <label>Hiển thị</label>
    <select id="ViewLimit" onchange="changeViewLimit();">
        <?php $limit = isset($limit)? $limit : 10 ?>
        <option value="10" {{ ($limit == 10)? 'selected' : '' }} >10</option>
        <option value="30" {{ ($limit == 30)? 'selected' : '' }} >30</option>
        <option value="50" {{ ($limit == 50)? 'selected' : '' }} >50</option>
        <option value="100" {{ ($limit == 100)? 'selected' : '' }} >100</option>
        <option value="200" {{ ($limit == 200)? 'selected' : '' }} >200</option>
    </select>
    <label>hàng</label>
</div>

<script>
    function changeViewLimit() {
        loading_show();
        
        // get limit
        limit = $('#ViewLimit').val();

        // change params
        parasOnLink = getURLParameters(window.location.href);
        parasOnLink.limit = limit;
        // parasOnLink.page = 1;

        // redirect to link with new params
        window.location.href = createLink(window.location.pathname, parasOnLink);
    }
    
    $(document).ready(function () {
        if ($('tbody td').length == 1) {
            $('.pagination_select').hide();
        }
    });
</script>
