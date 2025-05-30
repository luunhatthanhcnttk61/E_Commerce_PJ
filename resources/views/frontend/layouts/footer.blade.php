<footer class="footer bg-light mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4">
                <h5>Về chúng tôi</h5>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque.</p>
                <div class="social-links">
                    <a href="#" class="text-dark me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-dark me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="col-md-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('client.home') }}" class="text-decoration-none text-dark">Trang chủ</a></li>
                    <li><a href="{{ route('client.product.index') }}" class="text-decoration-none text-dark">Sản phẩm</a></li>
                    <li><a href="{{ route('client.cart.index') }}" class="text-decoration-none text-dark">Giỏ hàng</a></li>
                    <li><a href="{{ route('client.contact.index') }}" class="text-decoration-none text-dark">Liên hệ</a></li>
                </ul>
            </div>
            
            <div class="col-md-4">
                <h5>Thông tin liên hệ</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt me-2"></i> 123 Street, City, Country</li>
                    <li><i class="fas fa-phone me-2"></i> +1 234 567 890</li>
                    <li><i class="fas fa-envelope me-2"></i> info@example.com</li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="bottom-footer py-3 bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="#" class="text-light me-3">Điều khoản sử dụng</a>
                    <a href="#" class="text-light">Chính sách bảo mật</a>
                </div>
            </div>
        </div>
    </div>
</footer>