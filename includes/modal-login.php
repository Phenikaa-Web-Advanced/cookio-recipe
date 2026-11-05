<dialog id="loginModal" class="login-modal" style="width: min(92vw, 440px); border: none; border-radius: 24px; padding: 2.25rem 2rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); background: #ffffff; position: relative;">
    <button type="button" class="close-modal" data-close-modal aria-label="Đóng" style="position: absolute; top: 1.25rem; right: 1.25rem; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; color: #64748b; cursor: pointer; transition: all 0.2s;">&times;</button>
    
    <!-- Modal Header -->
    <div class="login-modal-header" style="text-align: center; margin-bottom: 1.5rem;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%); border-radius: 18px; margin-bottom: 0.85rem; border: 1.5px solid #fed7aa; box-shadow: 0 4px 12px rgba(234, 88, 12, 0.12);">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/>
                <line x1="6" y1="17" x2="18" y2="17"/>
            </svg>
        </div>
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin: 0 0 0.35rem; letter-spacing: -0.02em;">Cookio Xin Chào!</h2>
        <p style="font-size: 0.9rem; color: #64748b; margin: 0; line-height: 1.45;">Khám phá & chia sẻ công thức nấu ăn ngon cùng cộng đồng bếp gia đình</p>
    </div>

    <!-- Segmented Auth Tabs -->
    <div class="auth-tabs" style="display: flex; gap: 0.35rem; margin-bottom: 1.5rem; background: #f1f5f9; padding: 4px; border-radius: 14px;">
        <button type="button" class="auth-tab active" data-auth-tab="login" onclick="switchAuthTab('login')" style="flex: 1; padding: 0.65rem; border-radius: 11px; border: none; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s;">Đăng nhập</button>
        <button type="button" class="auth-tab" data-auth-tab="register" onclick="switchAuthTab('register')" style="flex: 1; padding: 0.65rem; border-radius: 11px; border: none; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s;">Đăng ký mới</button>
    </div>

    <!-- FORM LOGIN -->
    <form id="formLogin" method="post" action="<?= BASE_URL ?>/actions/auth_action.php" onsubmit="handleLoginSubmit(event)" style="display: flex; flex-direction: column; gap: 1rem;">
        <input type="hidden" name="action" value="login">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="redirect_to" id="loginRedirectTo" value="">
        
        <div>
            <label for="loginUsernameInput" style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">Tên đăng nhập</label>
            <div style="position: relative; display: flex; align-items: center;">
                <span style="position: absolute; left: 1rem; color: #94a3b8; display: flex; align-items: center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                </span>
                <input type="text" id="loginUsernameInput" name="username" placeholder="Nhập tên tài khoản (vd: admin1111)" required style="width: 100%; padding: 0.8rem 1rem 0.8rem 2.75rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; transition: border-color 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
            </div>
        </div>
        
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                <label for="loginPasswordInput" style="font-size: 0.86rem; font-weight: 700; color: #334155;">Mật khẩu</label>
                <a href="javascript:void(0)" onclick="alert('Vui lòng liên hệ quản trị viên qua email admin@cookio.vn để hỗ trợ cấp lại mật khẩu.')" style="font-size: 0.8rem; color: #ea580c; text-decoration: none; font-weight: 600;">Quên mật khẩu?</a>
            </div>
            <div style="position: relative; display: flex; align-items: center;">
                <span style="position: absolute; left: 1rem; color: #94a3b8; display: flex; align-items: center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </span>
                <input type="password" id="loginPasswordInput" name="password" placeholder="Nhập mật khẩu" required style="width: 100%; padding: 0.8rem 2.75rem 0.8rem 2.75rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; transition: border-color 0.2s; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
                <button type="button" onclick="togglePasswordVisibility('loginPasswordInput', this)" style="position: absolute; right: 0.85rem; background: none; border: none; color: #94a3b8; cursor: pointer; padding: 0.25rem; display: flex; align-items: center;" aria-label="Hiện/ẩn mật khẩu">
                    <svg class="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center;">
            <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.86rem; cursor: pointer; color: #64748b; user-select: none;">
                <input type="checkbox" id="chkRememberAccount" checked style="width: 17px; height: 17px; accent-color: #ea580c; cursor: pointer;">
                <span>Ghi nhớ đăng nhập</span>
            </label>
        </div>

        <button type="submit" class="button button-create" style="width: 100%; padding: 0.85rem; font-weight: 700; font-size: 1rem; border-radius: 14px; background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35); transition: all 0.2s; margin-top: 0.5rem;" onmouseover="this.style.transform='translateY(-1px)';" onmouseout="this.style.transform='none';">
            Đăng nhập vào Cookio
        </button>
    </form>

    <!-- FORM REGISTER -->
    <form id="formRegister" class="hidden" method="post" action="<?= BASE_URL ?>/actions/auth_action.php" style="display: none; flex-direction: column; gap: 0.9rem;">
        <input type="hidden" name="action" value="register">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        <input type="hidden" name="redirect_to" id="registerRedirectTo" value="">
        
        <div>
            <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Tên tài khoản</label>
            <input type="text" name="username" placeholder="Ví dụ: bep_nha_minh" required style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
        </div>

        <div>
            <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Số điện thoại (tùy chọn)</label>
            <input type="tel" name="phone" placeholder="0901234567" style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
        </div>

        <div>
            <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Mật khẩu</label>
            <input type="password" id="regPasswordInput" name="password" placeholder="Tối thiểu 6 ký tự" required style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
        </div>

        <div>
            <label style="display: block; font-size: 0.86rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Xác nhận mật khẩu</label>
            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu" required style="width: 100%; padding: 0.8rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 14px; font-size: 0.92rem; outline: none; background: #f8fafc;" onfocus="this.style.borderColor='#ea580c'; this.style.background='#ffffff';" onblur="this.style.borderColor='#e2e8f0'; this.style.background='#f8fafc';">
        </div>
        
        <button type="submit" class="button button-create" style="width: 100%; padding: 0.85rem; font-weight: 700; font-size: 1rem; border-radius: 14px; background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); color: #ffffff; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(234, 88, 12, 0.35); transition: all 0.2s; margin-top: 0.5rem;">
            Tạo tài khoản mới
        </button>
    </form>

    <!-- Modal Footer Policies -->
    <div style="margin-top: 1.5rem; text-align: center; font-size: 0.78rem; color: #94a3b8; line-height: 1.5;">
        Bằng việc đăng nhập, bạn đồng ý với <a href="#" style="color: #64748b; text-decoration: underline;">Điều khoản Cookio</a> & <a href="#" style="color: #64748b; text-decoration: underline;">Chính sách bảo mật</a>.
    </div>
</dialog>

<script>
function togglePasswordVisibility(inputId, btn) {
    const inp = document.getElementById(inputId);
    if (!inp) return;
    if (inp.type === 'password') {
        inp.type = 'text';
        btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>`;
    } else {
        inp.type = 'password';
        btn.innerHTML = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>`;
    }
}
</script>
