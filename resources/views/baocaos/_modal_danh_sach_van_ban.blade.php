<style type="text/css">
  .badge-success{
    color: #fff;
    background-color: #28a745;
    padding: 3px 5px;
    border-radius: 3px;
  }
  .badge-warning{
    color: #212529;
    background-color: #ffc107;
    padding: 3px 5px;
    border-radius: 3px;
  }
  .badge-secondary{
    color: #fff;
    background-color: #6c757d;
    padding: 3px 5px;
    border-radius: 3px;
  }
</style>
<div class="modal fade" id="list-docs" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col" style="width: 425px">Tên văn bản</th>
              <th scope="col">Ngày gửi</th>
              <th scope="col">Ngày xử lý</th>
              <th scope="col">Trạng thái</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>