<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh;">
    <div style="background-color: #232326; border-radius: 20px; padding: 35px; width: 340px; box-shadow: 0 10px 25px rgba(0,0,0,0.5); text-align: center;">
        
        <!-- User Icon Header -->
        <div style="margin-bottom: 10px;">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#cccccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>

        <h2 style="color: #ffffff; margin-top: 0; margin-bottom: 25px; font-weight: 700; letter-spacing: 1px;">REGISTRASI</h2>

        <?php if (!empty($error)): ?>
            <div style="background-color: #721c24; color: #f8d7da; padding: 10px; border-radius: 8px; font-size: 13px; margin-bottom: 15px;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form action="index.php?action=register" method="POST" style="text-align: left;">
            <div style="margin-bottom: 15px;">
                <input type="text" name="nama" placeholder="Nama Lengkap" required 
                       style="width: 100%; padding: 14px 18px; border-radius: 12px; border: none; background-color: #aeaeae; color: #111; font-size: 15px; box-sizing: border-box; outline: none;">
            </div>

            <div style="margin-bottom: 15px;">
                <input type="email" name="email" placeholder="Email" required 
                       style="width: 100%; padding: 14px 18px; border-radius: 12px; border: none; background-color: #aeaeae; color: #111; font-size: 15px; box-sizing: border-box; outline: none;">
            </div>

            <div style="margin-bottom: 8px; position: relative;">
                <input type="password" id="reg_password" name="password" placeholder="Password" required 
                       style="width: 100%; padding: 14px 18px; border-radius: 12px; border: none; background-color: #aeaeae; color: #111; font-size: 15px; box-sizing: border-box; outline: none;">
                
                <!-- Icon Toggle Password View -->
                <span onclick="togglePassword()" style="position: absolute; right: 15px; top: 14px; cursor: pointer; color: #333;">
                    <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </span>
            </div>

            <div style="text-align: right; margin-bottom: 25px;">
                <a href="index.php?action=login" style="color: #3897f0; text-decoration: none; font-size: 13px; font-weight: 600;">Sudah punya akun</a>
            </div>

            <div style="text-align: center;">
                <button type="submit" style="background-color: #55555d; color: #ffffff; border: 2px solid #6c6c75; padding: 12px 35px; border-radius: 25px; font-size: 15px; font-weight: 700; cursor: pointer; width: 100%; letter-spacing: 1px;">
                    REGISTRASI
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const pwdInput = document.getElementById('reg_password');
    if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
    } else {
        pwdInput.type = 'password';
    }
}
</script>