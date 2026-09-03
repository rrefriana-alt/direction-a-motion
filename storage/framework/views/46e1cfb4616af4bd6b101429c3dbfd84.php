<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Fugo Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--green-500:#10b981;--green-600:#059669}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;min-height:100vh;display:flex;background:#f9fafb;-webkit-font-smoothing:antialiased}
        .login-left{flex:1;background:linear-gradient(135deg,#0c1222 0%,#1a2332 50%,#0f1923 100%);display:flex;flex-direction:column;justify-content:center;padding:3rem;color:#fff;position:relative;overflow:hidden}
        .login-left::before{content:'';position:absolute;top:-50%;right:-20%;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(16,185,129,.12) 0%,transparent 70%)}
        .login-left::after{content:'';position:absolute;bottom:-30%;left:-10%;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(16,185,129,.08) 0%,transparent 70%)}
        .login-brand{position:relative;z-index:1}
        .login-brand h1{font-size:2.2rem;font-weight:800;letter-spacing:-.03em;margin-bottom:.5rem}
        .login-brand h1 span{color:var(--green-500)}
        .login-brand p{font-size:.9rem;color:#8899b4;max-width:320px;line-height:1.6}
        .login-brand .tagline{margin-top:2rem;padding-top:1.5rem;border-top:1px solid rgba(255,255,255,.08);font-size:.75rem;color:#556677}
        .login-right{width:100%;max-width:480px;display:flex;align-items:center;justify-content:center;padding:2.5rem}
        .login-card{width:100%;max-width:360px}
        .login-card h2{font-size:1.5rem;font-weight:700;color:#111827;margin-bottom:.25rem}
        .login-card .subtitle{font-size:.85rem;color:#6b7280;margin-bottom:2rem}
        .form-label{font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.3rem}
        .form-control{border:1px solid #d1d5db;border-radius:8px;padding:.6rem .85rem;font-size:.85rem;transition:all .2s;font-family:inherit}
        .form-control:focus{border-color:var(--green-500);box-shadow:0 0 0 3px rgba(16,185,129,.1);outline:none}
        .btn-login{background:var(--green-500);border:none;border-radius:8px;padding:.65rem;width:100%;font-weight:600;font-size:.875rem;color:#fff;transition:all .2s;font-family:inherit}
        .btn-login:hover{background:var(--green-600);box-shadow:0 4px 12px rgba(16,185,129,.25)}
        .form-check-label{font-size:.8rem;color:#4b5563}
        .form-check-input:checked{background-color:var(--green-500);border-color:var(--green-500)}
        .form-check-input:focus{box-shadow:0 0 0 3px rgba(16,185,129,.15)}
        .error-alert{background:#fef2f2;color:#b91c1c;padding:.65rem .85rem;border-radius:8px;font-size:.82rem;margin-bottom:1rem;display:flex;align-items:center;gap:.5rem}
        @media(max-width:991.98px){
            .login-left{display:none}
            body{background:#fff}
        }
    </style>
</head>
<body>
    <div class="login-left">
        <div class="login-brand">
            <h1>FUGO<span>.</span></h1>
            <p>Creative group that turns bold ideas into unforgettable experiences. Design, production, events, and merch.</p>
            <div class="tagline">Direction-A-Motion — Admin Panel © 2026</div>
        </div>
    </div>

    <div class="login-right">
        <div class="login-card">
            <h2>Welcome back</h2>
            <p class="subtitle">Sign in to your admin account</p>

            <?php if($errors->any()): ?>
            <div class="error-alert">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?php echo e($errors->first()); ?>

            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login.post')); ?>">
                <?php echo csrf_field(); ?>
                <div style="margin-bottom:1rem">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required autofocus placeholder="admin@fugocreative.com">
                </div>
                <div style="margin-bottom:1rem">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required placeholder="Enter your password">
                </div>
                <div style="margin-bottom:1.5rem">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-login">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH D:\Reyhan\Fugo Creative\direction-a-motion(git)\direction-a-motion\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>