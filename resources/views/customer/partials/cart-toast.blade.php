<div id="cart-toast" style="display:none">
    <div class="cart-toast-overlay">
        <div class="cart-toast-card">
            <div class="toast-head">
                <span class="toast-title"></span>
                <button type="button" class="toast-close" aria-label="Đóng">×</button>
            </div>
            <div class="toast-body"></div>
            <div class="toast-actions">
                <a class="toast-btn primary" href="{{ route('checkout') }}">Thanh toán</a>
                <a class="toast-btn" href="{{ route('cart.index') }}">Xem giỏ hàng</a>
            </div>
        </div>
    </div>
</div>

<style>
    .cart-toast-overlay {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, .35);
        z-index: 1050
    }

    .cart-toast-card {
        width: min(480px, 92vw);
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        overflow: hidden
    }

    .toast-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        background: #e9f7ec;
        color: #2e7d32;
        font-weight: 600
    }

    .toast-head.error {
        background: #fdecea;
        color: #c62828
    }

    .toast-body {
        padding: 14px 16px
    }

    .toast-body .row {
        display: flex;
        gap: 12px;
        align-items: center
    }

    .toast-body img {
        width: 56px;
        height: 56px;
        border-radius: 10px;
        object-fit: cover
    }

    .toast-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        padding: 12px 16px 16px
    }

    .toast-btn {
        display: inline-block;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #ddd;
        text-decoration: none
    }

    .toast-btn.primary {
        background: #ef6c00;
        color: #fff;
        border-color: #ef6c00
    }

    .toast-close {
        background: none;
        border: 0;
        font-size: 20px;
        cursor: pointer
    }
</style>