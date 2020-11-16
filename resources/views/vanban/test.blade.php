<form action="{{route('test')}}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="file" name="file">
    <input type="submit" value="Gửi">
</form>
<?php
phpinfo();

