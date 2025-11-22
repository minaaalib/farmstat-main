<?php
$title = 'Login - FarmStats';
require_once VIEWS_PATH . '/layouts/header.php';
?>

<div class="login-container">
    <div class="login-header">
        <div class="logo">
            🌱
        </div>
        <h1>Welcome to FarmStats</h1>
        <p>Sign in to your account</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            ⚠️
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
                        🛡️
                    </div>
                    <div class="user-type-name">Administrator</div>
                    <div class="user-type-desc">System Management</div>
                </label>
            </div>
            
            <div class="user-type-option">
                <input type="radio" id="farmer" name="user_type" value="farmer" required checked>
                <label for="farmer" class="user-type-label">
                    <div class="user-type-icon client-icon">
                        👨‍🌾
                    </div>
                    <div class="user-type-name">Farmer</div>
                    <div class="user-type-desc">Campaign Farmer</div>
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <div class="input-with-icon">
                <span class="input-icon">✉️</span>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
                <span class="input-icon">🔒</span>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            <span class="btn-icon">🔑</span>
            Sign In
        </button>
    </form>

    <div class="register-link">
        <p>Don't have an account? <a href="<?php echo BASE_URL; ?>/register">Create one here</a></p>
    </div>
</div>

<style>
 /* Login Page Modern Styles - Beautiful Minimalist Version */
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
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
    background: linear-gradient(135deg, 
        #1a4d2e 0%, 
        #2d6a4f 25%, 
        #40916c 50%, 
        #52b788 75%, 
        #74c69d 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    line-height: 1.4;
    color: var(--text);
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(255, 154, 61, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(141, 181, 150, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.login-container {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: 
        var(--shadow-lg),
        0 0 0 1px rgba(255, 255, 255, 0.3);
    padding: 1.5rem 1.25rem; /* Even more compact */
    width: 100%;
    max-width: 380px; /* Even smaller */
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-gold), var(--accent-orange));
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

.login-header {
    text-align: center;
    margin-bottom: 2rem;
}

.logo {
    width: 70px;
    height: 70px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, 
        rgba(74, 124, 89, 0.9), 
        rgba(208, 253, 226, 0.9));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 
        0 8px 32px rgba(26, 77, 46, 0.4),
        inset 0 2px 4px rgba(255, 255, 255, 0.3),
        inset 0 -2px 4px rgba(0, 0, 0, 0.2);
    font-size: 1.75rem;
    color: var(--white);
    border: 2px solid rgba(255, 255, 255, 0.5);
    position: relative;
    z-index: 2;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3); /* Add shadow to emoji */
}

/* No pseudo-elements that might cover the content */

.logo::after {
    content: '';
    position: absolute;
    top: 10%;
    left: 10%;
    right: 10%;
    bottom: 10%;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    filter: blur(5px);
}

.login-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.login-header p {
    color: var(--text-light);
    font-size: 0.9rem;
    font-weight: 500;
}

/* User Type Selector */
.user-type-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
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
    padding: 1rem 0.75rem;
    background: var(--white);
    border: 2px solid var(--border);
    border-radius: 12px;
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
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
    opacity: 0;
    transition: var(--transition);
}

.user-type-label:hover {
    border-color: var(--primary-light);
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.user-type-label:hover::before {
    opacity: 0.1;
}

.user-type-option input[type="radio"]:checked + .user-type-label {
    background: linear-gradient(135deg, var(--white), var(--white));
    border-color: var(--primary-medium);
    box-shadow: var(--shadow);
    transform: translateY(-1px);
}

.user-type-option input[type="radio"]:checked + .user-type-label::before {
    opacity: 0.2;
}

.user-type-icon {
    width: 40px;
    height: 40px;
    margin: 0 auto 0.5rem;
    background: var(--white);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    transition: var(--transition);
    box-shadow: var(--shadow);
    position: relative;
    z-index: 1;
}

.admin-icon {
    color: var(--accent-orange);
}

.client-icon {
    color: var(--primary-medium);
}

.user-type-name {
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
    font-size: 0.85rem;
    position: relative;
    z-index: 1;
}

.user-type-desc {
    font-size: 0.75rem;
    color: var(--text-light);
    line-height: 1.2;
    position: relative;
    z-index: 1;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.9rem;
}

.input-with-icon {
    position: relative;
    transition: var(--transition);
    display: flex;
    align-items: center;
    border: 2px solid var(--border);
    border-radius: 10px;
    background: var(--white);
    overflow: hidden;
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: var(--primary-medium);
    transition: var(--transition);
    z-index: 2;
    font-size: 1rem;
    pointer-events: none;
}

.input-with-icon input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: none;
    border-radius: 10px;
    font-size: 0.9rem;
    background: transparent;
    transition: var(--transition);
    position: relative;
    z-index: 1;
    outline: none;
}

.input-with-icon input:focus {
    background: rgba(141, 181, 150, 0.05);
}

.input-with-icon:focus-within {
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
    transform: translateY(-1px);
}

.input-with-icon:focus-within .input-icon {
    color: var(--primary-dark);
    transform: scale(1.1);
}

/* Button Styles */
.btn {
    width: 100%;
    padding: 1rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
    opacity: 0;
    transition: var(--transition);
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    color: var(--white);
    box-shadow: var(--shadow);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:hover::before {
    opacity: 1;
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-icon {
    font-size: 1.1rem;
    transition: var(--transition);
}

.btn-primary:hover .btn-icon {
    transform: scale(1.1);
}

/* Error Message */
.error-message {
    background: linear-gradient(135deg, #fee, #fff5f5);
    border: 1px solid rgba(220, 38, 38, 0.2);
    color: #dc2626;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    font-size: 0.9rem;
    box-shadow: var(--shadow);
    border-left: 4px solid #dc2626;
}

/* Register Link */
.register-link {
    text-align: center;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.register-link p {
    color: var(--text-light);
    font-size: 0.9rem;
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
    background: var(--primary-medium);
    transition: var(--transition);
}

.register-link a:hover {
    color: var(--primary-dark);
}

.register-link a:hover::after {
    width: 100%;
}

/* Responsive Design */
@media (max-width: 480px) {
    .login-container {
        padding: 2rem 1.5rem;
        margin: 0.5rem;
        max-width: 380px;
    }
    
    .user-type-selector {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .login-header h1 {
        font-size: 1.5rem;
    }
    
    .logo {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }
    
    .user-type-icon {
        font-size: 1.1rem;
    }
}

/* Animation for subtle entrance */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.login-container {
    animation: fadeInUp 0.6s ease-out;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
            this.parentElement.style.borderColor = '#4a7c59';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
            this.parentElement.style.borderColor = '#dde8e0';
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