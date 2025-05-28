<!-- Modal xem chi tiết đánh giá -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết đánh giá</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Sản phẩm:</label>
                    <p id="product-name"></p>
                </div>

                <div class="form-group">
                    <label>Khách hàng:</label>
                    <p id="customer-name"></p>
                </div>

                <div class="form-group">
                    <label>Đánh giá:</label>
                    <p id="rating"></p>
                </div>

                <div class="form-group">
                    <label>Nội dung đánh giá:</label>
                    <p id="comment"></p>
                </div>

                <div class="form-group">
                    <label>Ngày đánh giá:</label>
                    <p id="created-at"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success approve-review">Duyệt</button>
                <button type="button" class="btn btn-danger reject-review">Từ chối</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>