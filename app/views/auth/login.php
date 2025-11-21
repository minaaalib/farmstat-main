<?php
$title = 'Login - FarmStats';

?>

<style>
/* Login Page Modern Styles */
:root {
    --primary-dark: #1a4d2e;
    --primary-medium: #4a7c59;
    --primary-light: #8db596;
    --accent-gold: #d4af37;
    --accent-orange: #ff9a3d;
    --background: #f5f9f7;
    --white: #ffffff;
    --text: #2d3a2d;
    --text-light: #5a6c5a;
    --border: #dde8e0;
    --shadow: 0 4px 12px rgba(26, 77, 46, 0.08);
    --shadow-lg: 0 8px 24px rgba(26, 77, 46, 0.12);
    --border-radius: 20px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--background) 50%, var(--white) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    line-height: 1.6;
    color: var(--text);
}

.login-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    padding: 3rem;
    width: 100%;
    max-width: 480px;
    position: relative;
    overflow: hidden;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-gold), var(--accent-orange));
}

.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow);
    position: relative;
}

.logo::after {
    content: '';
    position: absolute;
    inset: -2px;
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    border-radius: 50%;
    z-index: -1;
    opacity: 0.7;
}

.logo i {
    font-size: 2rem;
    color: var(--white);
}

.login-header h1 {
    font-size: 2.25rem;
    font-weight: 800;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.login-header p {
    color: var(--text-light);
    font-size: 1.1rem;
}

/* User Type Selector */
.user-type-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 2rem;
}

.user-type-option {
    position: relative;
}

.user-type-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.user-type-label {
    display: block;
    padding: 1.5rem 1rem;
    background: var(--background);
    border: 2px solid var(--border);
    border-radius: 16px;
    text-align: center;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.user-type-label::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.5s;
}

.user-type-label:hover::before {
    left: 100%;
}

.user-type-label:hover {
    transform: translateY(-2px);
    border-color: var(--primary-light);
    box-shadow: var(--shadow);
}

.user-type-option input[type="radio"]:checked + .user-type-label {
    background: linear-gradient(135deg, var(--primary-light) 0%, var(--white) 100%);
    border-color: var(--primary-medium);
    box-shadow: var(--shadow);
}

.user-type-option input[type="radio"]:checked + .user-type-label .user-type-icon {
    transform: scale(1.1);
    color: var(--primary-dark);
}

.user-type-icon {
    width: 50px;
    height: 50px;
    margin: 0 auto 0.75rem;
    background: var(--white);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: var(--transition);
    box-shadow: var(--shadow);
}

.admin-icon {
    color: var(--accent-orange);
}

.client-icon {
    color: var(--primary-medium);
}

.user-type-name {
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.user-type-desc {
    font-size: 0.85rem;
    color: var(--text-light);
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.95rem;
}

.input-with-icon {
    position: relative;
    transition: var(--transition);
}

.input-with-icon i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-medium);
    transition: var(--transition);
    z-index: 2;
}

.input-with-icon input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid var(--border);
    border-radius: 12px;
    font-size: 1rem;
    background: var(--white);
    transition: var(--transition);
    position: relative;
    z-index: 1;
}

.input-with-icon input:focus {
    outline: none;
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 3px rgba(77, 124, 89, 0.1);
    transform: translateY(-1px);
}

.input-with-icon input:focus + i {
    color: var(--primary-dark);
    transform: translateY(-50%) scale(1.1);
}

.input-with-icon::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--accent-gold), var(--accent-orange));
    transition: width 0.3s ease;
}

.input-with-icon:focus-within::after {
    width: 100%;
}

/* Button Styles */
.btn {
    width: 100%;
    padding: 1rem 2rem;
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 700;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    color: var(--white);
    box-shadow: var(--shadow);
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Error Message */
.error-message {
    background: linear-gradient(135deg, #fee, #fff5f5);
    border: 1px solid rgba(220, 38, 38, 0.2);
    color: #dc2626;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    box-shadow: var(--shadow);
}

.error-message i {
    font-size: 1.1rem;
}

/* Register Link */
.register-link {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

.register-link p {
    color: var(--text-light);
}

.register-link a {
    color: var(--primary-medium);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition);
    position: relative;
}

.register-link a::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--accent-orange);
    transition: width 0.3s ease;
}

.register-link a:hover {
    color: var(--primary-dark);
}

.register-link a:hover::after {
    width: 100%;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-container {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive Design */
@media (max-width: 480px) {
    body {
        padding: 1rem;
    }
    
    .login-container {
        padding: 2rem 1.5rem;
    }
    
    .user-type-selector {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .login-header h1 {
        font-size: 1.75rem;
    }
    
    .logo {
        width: 60px;
        height: 60px;
    }
    
    .logo i {
        font-size: 1.5rem;
    }
}

/* Loading State */
.btn.loading {
    pointer-events: none;
    opacity: 0.8;
}

.btn.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Enhanced focus states */
input:focus-visible {
    outline: 2px solid var(--primary-medium);
    outline-offset: 2px;
}

/* Custom radio button check animation */
.user-type-option input[type="radio"]:checked + .user-type-label .user-type-icon::before {
    content: '✓';
    position: absolute;
    top: -5px;
    right: -5px;
    background: var(--accent-gold);
    color: var(--white);
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow);
}
</style>

<div class="login-container">
    <div class="login-header">
        <div class="logo">
            <i class="fas fa-seedling"></i>
        </div>
        <h1>Welcome to FarmStats</h1>
        <p>Sign in to your account</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-circle"></i>
            <?php 
            echo htmlspecialchars($_SESSION['error']); 
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo BASE_URL; ?>/login">
        <div class="user-type-selector">
            <div class="user-type-option">
                <input type="radio" id="admin" name="user_type" value="admin" required>
                <label for="admin" class="user-type-label">
                    <div class="user-type-icon admin-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="user-type-name">Administrator</div>
                    <div class="user-type-desc">System Management</div>
                </label>
            </div>
            
            <div class="user-type-option">
                <input type="radio" id="farmer" name="user_type" value="farmer" required checked>
                <label for="farmer" class="user-type-label">
                    <div class="user-type-icon client-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-type-name">Farmer</div>
                    <div class="user-type-desc">Campaign Farmer</div>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-with-icon">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
        </button>
    </form>

    <div class="register-link">
        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/register">Create one here</a></p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    });

    const userTypeRadios = document.querySelectorAll('input[name="user_type"]');
    let hasSelection = false;
    userTypeRadios.forEach(radio => {
        if (radio.checked) hasSelection = true;
    });
    
    if (!hasSelection && userTypeRadios.length > 0) {
        userTypeRadios[0].checked = true;
    }
});
</script>

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>

