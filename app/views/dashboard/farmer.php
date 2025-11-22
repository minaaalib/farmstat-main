<?php
$title = 'Farmer Dashboard - FarmStats';


// Initialize models with proper error handling
try {
    $farmerModel = new Farmer();
    $totalFarmers = $farmerModel->count();
    $allFarmers = $farmerModel->getAll(50);
    
    // For demo purposes - you'll need to create these models
    $totalFunding = 18200000; // Demo data
    $yieldIncrease = 15.6; // Demo data
    
} catch (Exception $e) {
    // Handle error gracefully
    $totalFarmers = 0;
    $allFarmers = [];
    $totalFunding = 0;
    $yieldIncrease = 0;
    error_log("Dashboard error: " . $e->getMessage());
}

// Get user profile data
$userProfile = [];
if (isset($_SESSION['user_id'])) {
    try {
        $userProfile = $farmerModel->findById($_SESSION['user_id']) ?? [];
    } catch (Exception $e) {
        error_log("User profile error: " . $e->getMessage());
    }
}
?>
<style>
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
    --sidebar-width: 280px;
    --header-height: 150px;
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
    background-color: var(--background);
    color: var(--text);
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Typography */
h1, h2, h3, h4 {
    font-weight: 600;
    line-height: 1.2;
    margin-bottom: 1rem;
    color: var(--primary-dark);
}

h1 {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

h2 {
    font-size: 2rem;
}

h3 {
    font-size: 1.375rem;
}

h4 {
    font-size: 1.125rem;
}

p {
    color: var(--text-light);
    margin-bottom: 1rem;
    line-height: 1.7;
}

/* Buttons */
.btn {
    padding: 12px 28px;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    color: var(--white);
    box-shadow: var(--shadow);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(74, 124, 89, 0.3);
}

.btn-outline {
    background: transparent;
    color: var(--primary-medium);
    border: 2px solid var(--primary-medium);
}

.btn-outline:hover {
    background: var(--primary-medium);
    color: var(--white);
    transform: translateY(-2px);
}

.btn-sm {
    padding: 10px 20px;
    font-size: 0.875rem;
}

/* Navigation */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background: var(--white);
    box-shadow: var(--shadow);
    backdrop-filter: blur(10px);
    position: sticky;
    top: 0;
    z-index: 100;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
}

.logo {
    font-size: 2rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.nav-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

/* Enhanced Hero Section */
.hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    padding: 5rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
    align-items: center;
    min-height: 90vh;
    background: linear-gradient(135deg, var(--white) 0%, var(--background) 100%);
}

.hero-content h1 {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    line-height: 1.1;
    background: linear-gradient(135deg, var(--primary-dark), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2.5rem;
    color: var(--text-light);
    line-height: 1.7;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 3rem;
}

.impact-stats {
    display: flex;
    gap: 2rem;
    padding-top: 2rem;
    border-top: 2px solid var(--border);
}

.impact-stat {
    text-align: center;
    flex: 1;
}

.impact-number {
    display: block;
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
}

.impact-label {
    font-size: 0.9rem;
    color: var(--text-light);
    font-weight: 500;
}

.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
}

.data-card {
    background: var(--white);
    border-radius: var(--border-radius);
    padding: 2.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    max-width: 320px;
    position: relative;
    overflow: hidden;
}

.data-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-medium), var(--accent-gold));
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.card-icon {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.card-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.stat {
    text-align: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    transition: var(--transition);
}

.stat:hover {
    transform: translateY(-2px);
    background: var(--primary-light);
}

.stat-value {
    display: block;
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-light);
    font-weight: 500;
}

/* Mission Section */
.mission-section {
    padding: 5rem 2rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
    color: var(--white);
}

.mission-content {
    max-width: 1000px;
    margin: 0 auto;
    text-align: center;
}

.mission-statement {
    font-size: 1.5rem;
    font-style: italic;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.mission-pillars {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.pillar {
    background: rgba(255, 255, 255, 0.1);
    padding: 2rem;
    border-radius: var(--border-radius);
    backdrop-filter: blur(10px);
    transition: var(--transition);
}

.pillar:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
}

.pillar i {
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--accent-gold);
}

.pillar h4 {
    margin-bottom: 1rem;
    color: var(--white);
}

.pillar p {
    color: rgba(255, 255, 255, 0.9);
}

/* Rice Intelligence Section */
.rice-intelligence {
    padding: 5rem 2rem;
    background: var(--white);
}

.intelligence-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.intelligence-card {
    background: var(--background);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 2px solid var(--border);
    transition: var(--transition);
    animation: fadeInUp 0.5s ease-out;
}

.intelligence-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}

.intelligence-card h3 {
    margin-bottom: 1.5rem;
    color: var(--primary-dark);
    font-size: 1.25rem;
}

.intelligence-card ul {
    list-style: none;
}

.intelligence-card li {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border);
    color: var(--text-light);
}

.intelligence-card li:last-child {
    border-bottom: none;
}

.phase-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.phase {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--white);
    border-radius: 8px;
    border: 1px solid var(--border);
}

.phase.active {
    border-color: var(--primary-medium);
    background: rgba(74, 124, 89, 0.05);
}

.phase-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.phase-date {
    color: var(--text-light);
    font-size: 0.9rem;
}

/* Features Section */
.features {
    padding: 5rem 2rem;
    background: var(--background);
}

.features h2 {
    text-align: center;
    margin-bottom: 3rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.feature-card {
    background: var(--white);
    padding: 2.5rem 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    border: 1px solid var(--border);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-medium), var(--accent-gold));
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-lg);
}

.feature-card:hover::before {
    transform: scaleX(1);
}

.feature-icon {
    font-size: 3.5rem;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.feature-card h3 {
    margin-bottom: 1rem;
    font-size: 1.375rem;
}

.feature-card p {
    color: var(--text-light);
    line-height: 1.7;
}

/* CTA Section */
.cta-section {
    padding: 5rem 2rem;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-medium));
    color: var(--white);
    text-align: center;
}

.cta-content h2 {
    color: var(--white);
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.cta-content p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.25rem;
    max-width: 600px;
    margin: 0 auto 2.5rem;
}

.cta-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-section .btn-outline {
    color: var(--white);
    border-color: var(--white);
}

.cta-section .btn-outline:hover {
    background: var(--white);
    color: var(--primary-dark);
}

/* Auth Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content h2 {
    text-align: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--border);
    color: var(--primary-dark);
}

.modal-content {
    background: var(--white);
    border-radius: var(--border-radius);
    width: 90%; /* Use percentage for better responsiveness */
    max-width: 500px;
    box-shadow: var(--shadow-lg);
    position: relative;
    animation: modalAppear 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    margin: auto; /* This centers it */
}

.modal-content.large {
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 2rem 2rem 1rem 2rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--background), var(--white));
    text-align: center;
}

.modal-header h2 {
    margin-bottom: 0;
    color: var(--primary-dark);
    font-size: 1.5rem;
}

.modal-body {
    padding: 0;
}

.modal .form-section {
    margin-bottom: 2.5rem;
    padding: 0 2rem;
    display: block; /* Override grid layout */
}

.modal .form-section h3 {
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}

.modal .form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.modal .form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
}

.modal .form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.95rem;
}

.modal .form-group input,
.modal .form-group select,
.modal .form-group textarea {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: var(--white);
    font-family: inherit;
    box-sizing: border-box;
}

.modal .form-group input:focus,
.modal .form-group select:focus,
.modal .form-group textarea:focus {
    outline: none;
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
}

.modal .form-group select[multiple] {
    height: 120px;
    padding: 12px;
}

.modal .form-group select[multiple] option {
    padding: 8px 12px;
    margin: 2px 0;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
}

.modal .form-group select[multiple] option:hover {
    background: var(--primary-light);
    color: var(--white);
}

.modal .form-group select[multiple] option:checked {
    background: var(--primary-medium);
    color: var(--white);
}

.modal .form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border);
    background: var(--background);
}

.modal .form-actions .btn {
    min-width: 140px;
}

/* Close button positioning */
.modal .close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-light);
    z-index: 10;
    transition: var(--transition);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--white);
    box-shadow: var(--shadow);
}

.modal .close:hover {
    background: var(--background);
    color: var(--primary-dark);
    transform: rotate(90deg);
}

/* Form hints */
.form-hint {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-light);
    font-style: italic;
}

/* Better select dropdown styling */
.modal .form-group select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%234a7c59' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 12px;
    padding-right: 40px;
}

/* Responsive design for modal */
@media (max-width: 768px) {
    .modal {
        padding: 0.5rem;
        align-items: flex-start; /* Start from top on mobile */
    }
    
    .modal-content {
        width: 95%;
        margin: 1rem auto;
    }
    
    .modal-content.large {
        max-height: 85vh;
    }
    
    .modal .form-section {
        padding: 0 1.5rem;
    }
    
    .modal .form-actions {
        flex-direction: column;
    }
    
    .modal .form-actions .btn {
        width: 100%;
    }
    
    .modal-header {
        padding: 1.5rem 1.5rem 1rem 1.5rem;
    }
}

@media (max-width: 480px) {
    .modal-content {
        width: 98%;
        margin: 0.5rem auto;
    }
    
    .modal .form-section {
        padding: 0 1rem;
    }
    
    .modal-header {
        padding: 1.25rem 1rem 0.75rem 1rem;
    }
    
    .modal-header h2 {
        font-size: 1.25rem;
    }
}

/* Animation for modal appearance */
@keyframes modalAppear {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Ensure modal is above everything */
.modal {
    z-index: 10000;
}

.modal-content {
    z-index: 10001;
}

@media (min-width: 768px) {
    .modal .form-row {
        grid-template-columns: 1fr 1fr;
    }
}


@keyframes modalAppear {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-light);
    z-index: 10;
    transition: var(--transition);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.close:hover {
    background: var(--background);
    color: var(--primary-dark);
}

.auth-tabs {
    display: flex;
    border-bottom: 1px solid var(--border);
    background: var(--background);
}

.tab {
    flex: 1;
    padding: 1.25rem;
    text-align: center;
    cursor: pointer;
    color: var(--text-light);
    border-bottom: 3px solid transparent;
    transition: var(--transition);
    font-weight: 500;
}

.tab.active {
    color: var(--primary-medium);
    border-bottom-color: var(--primary-medium);
    background: var(--white);
}

.auth-form {
    padding: 2.5rem;
    display: none;
}

.auth-form.active {
    display: block;
}

.auth-form h2 {
    text-align: center;
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.75rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.95rem;
}

.form-group input, .form-group textarea, .form-group select {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid var(--border);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: var(--white);
    font-family: inherit;
}

.form-group input:focus, .form-group textarea:focus, .form-group select:focus {
    outline: none;
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

@media (min-width: 768px) {
    .form-row {
        grid-template-columns: 1fr 1fr;
    }
}


/* Dashboard Layout */
.dashboard {
    display: flex;
    min-height: 100vh;
    background: var(--background);
}

.sidebar {
    width: var(--sidebar-width);
    background: var(--white);
    box-shadow: var(--shadow);
    position: fixed;
    height: 100vh;
    overflow-y: auto;
    z-index: 100;
    border-right: 1px solid var(--border);
}

.sidebar-header {
    padding: 2rem 1.5rem;
    border-bottom: 1px solid var(--border);
    background: linear-gradient(135deg, var(--white), var(--background));
}

.sidebar-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--primary-dark);
}

.sidebar-nav ul {
    list-style: none;
    padding: 1rem 0;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    cursor: pointer;
    transition: var(--transition);
    color: var(--text-light);
    border-left: 4px solid transparent;
    margin: 0.25rem 0.75rem;
    border-radius: 8px;
}

.nav-item:hover {
    background: var(--background);
    color: var(--primary-medium);
    transform: translateX(4px);
}

.nav-item.active {
    background: linear-gradient(135deg, var(--primary-light), var(--primary-medium));
    color: var(--white);
    border-left-color: var(--primary-dark);
    box-shadow: var(--shadow);
}

.nav-item i {
    width: 20px;
    text-align: center;
    font-size: 1.1rem;
}

.main-content {
    flex: 1;
    margin-left: var(--sidebar-width);
    background-color: var(--background);
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2.5rem;
    background: var(--white);
    box-shadow: var(--shadow);
    height: var(--header-height);
    border-bottom: 1px solid var(--border);
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.user-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-weight: 600;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.user-avatar:hover {
    transform: scale(1.05);
}

/* Enhanced Dashboard */
.season-indicator {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.5rem;
}

.season-badge {
    background: linear-gradient(135deg, var(--accent-gold), var(--accent-orange));
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.progress-text {
    color: var(--text-light);
    font-size: 0.9rem;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: var(--border);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar.small {
    height: 6px;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-medium), var(--accent-gold));
    border-radius: 4px;
    transition: width 0.3s ease;
}

.page-content {
    padding: 2.5rem;
}

.page {
    display: none;
    animation: fadeIn 0.4s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.page.active {
    display: block;
}

.hidden {
    display: none !important;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.75rem;
    margin-bottom: 2.5rem;
}

.stat-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    border: 1px solid var(--border);
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-medium), var(--accent-gold));
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.stat-icon {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(74, 124, 89, 0.1);
}

.stat-content {
    display: flex;
    flex-direction: column;
    flex: 1;
}

.stat-number {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--primary-dark);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-light);
    font-size: 0.95rem;
    font-weight: 500;
}

/* Page Headers */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
}

.page-header h2 {
    margin-bottom: 0;
    font-size: 1.75rem;
}

.header-actions {
    display: flex;
    gap: 1rem;
}

/* Farmers Grid */
.farmers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.farmer-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: var(--transition);
    animation: fadeInUp 0.5s ease-out;
    /* Add proper internal layout */
    display: flex;
    flex-direction: column;
}

.farmer-card-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, var(--primary-light), var(--primary-medium));
    color: var(--white);
    display: flex;
    align-items: center;
    gap: 1rem;
    /* Fix alignment */
    align-items: flex-start;
}

.farmer-basic-info {
    flex: 1;
    /* Ensure proper text alignment */
    min-width: 0; /* Prevents flex overflow */
}

.farmer-basic-info h3 {
    margin-bottom: 0.25rem;
    font-size: 1.25rem;
    /* Ensure consistent spacing */
    line-height: 1.3;
}

.farmer-basic-info p {
    opacity: 0.9;
    font-size: 0.9rem;
    margin-bottom: 0;
    /* Fix line height */
    line-height: 1.4;
}

.farmer-card-body {
    padding: 1.5rem;
    /* Add proper internal grid */
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.farmer-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 0; /* Remove extra margin */
}

.farmer-stat {
    text-align: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    /* Ensure consistent height */
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 80px;
}

.farmer-stat-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.farmer-stat-label {
    font-size: 0.8rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.farmer-details {
    display: grid;
    gap: 0.75rem;
}

.farmer-detail {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border);
}

.farmer-detail:last-child {
    border-bottom: none;
}

.farmer-detail label {
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.9rem;
}

.farmer-detail span {
    color: var(--text-light);
    font-size: 0.9rem;
}

.farmer-card-footer {
    padding: 1rem 1.5rem;
    background: var(--background);
    display: flex;
    gap: 0.75rem;
}

/* Season Phase Tracker */
.season-phase-tracker {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.phase {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--white);
    border-radius: var(--border-radius);
    border: 2px solid var(--border);
    transition: var(--transition);
}

.phase.active {
    border-color: var(--primary-medium);
    background: linear-gradient(135deg, var(--white), rgba(74, 124, 89, 0.05));
}

.phase-icon {
    font-size: 2rem;
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--background);
    border-radius: 50%;
}

.phase-info {
    flex: 1;
}

.phase-info h4 {
    margin-bottom: 0.5rem;
    color: var(--primary-dark);
}

.phase-info p {
    color: var(--text-light);
    margin-bottom: 0.5rem;
}

.phase-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.phase-detail-card {
    padding: 1.5rem;
    border-radius: 8px;
    border: 2px solid var(--border);
}

.phase-detail-card.planting {
    border-color: #4a7c59;
    background: rgba(74, 124, 89, 0.05);
}

.phase-detail-card.growth {
    border-color: #d4af37;
    background: rgba(212, 175, 55, 0.05);
}

.phase-detail-card.harvest {
    border-color: #ff9a3d;
    background: rgba(255, 154, 61, 0.05);
}

.detail-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-top: 1rem;
}

.metric {
    text-align: center;
}

.metric-value {
    display: block;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-dark);
}

.metric-label {
    font-size: 0.8rem;
    color: var(--text-light);
}

/* Rice Monitoring Styles */
.monitoring-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.monitoring-card {
    background: var(--white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.phase-details {
    display: grid;
    gap: 1rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item label {
    font-weight: 600;
    color: var(--primary-dark);
}

.input-tracking {
    margin-top: 1.5rem;
}

.input-tracking h4 {
    margin-bottom: 1rem;
    color: var(--primary-dark);
}

.input-grid {
    display: grid;
    gap: 1rem;
    margin-top: 1rem;
}

.input-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
}

.input-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.input-usage {
    color: var(--text-light);
    font-size: 0.9rem;
}

/* Campaign Cards Enhancement */
.campaigns-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(550px, 1fr));
    gap: 2.5rem;
}

.campaign-card {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: var(--transition);
    animation: fadeInUp 0.5s ease-out;
}

.campaign-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.campaign-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.campaign-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
}

.campaign-farmer {
    color: var(--text-light);
    font-size: 0.9rem;
}

.campaign-type {
    background: var(--primary-light);
    color: var(--primary-dark);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.campaign-body {
    padding: 1.5rem;
}

.campaign-description {
    color: var(--text-light);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.campaign-progress {
    margin-bottom: 1.5rem;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.progress-raised {
    font-weight: 600;
    color: var(--primary-dark);
}

.progress-percentage {
    color: var(--text-light);
}

.campaign-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.campaign-meta-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.campaign-meta-label {
    font-size: 0.8rem;
    color: var(--text-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.campaign-meta-value {
    font-weight: 600;
    color: var(--primary-dark);
}

.campaign-footer {
    padding: 1rem 1.5rem;
    background: var(--background);
    display: flex;
    gap: 0.75rem;
}

.campaign-status {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.campaign-status.active {
    background: rgba(74, 124, 89, 0.1);
    color: var(--primary-medium);
}

.campaign-status.completed {
    background: rgba(255, 154, 61, 0.1);
    color: var(--accent-orange);
}

/* Impact Overview */
.impact-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.impact-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: var(--transition);
}

.impact-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.impact-card i {
    font-size: 2.5rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.impact-content h3 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.impact-content p {
    color: var(--text-light);
    font-size: 0.9rem;
}


/* Fertilizer Application Styles */
.fertilizer-section {
    margin-bottom: 2rem;
}

.fertilizer-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    margin-bottom: 0.75rem;
    border-left: 4px solid var(--primary-medium);
}

.fertilizer-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.fertilizer-progress {
    color: var(--text-light);
    font-size: 0.85rem;
}

.fertilizer-details {
    font-size: 0.85rem;
    color: var(--text-light);
    text-align: right;
}

/* Water Management Table */
.water-management table {
    width: 100%;
    border-collapse: collapse;
}

.water-management td {
    padding: 0.75rem;
    border-bottom: 1px solid var(--border);
}

.water-management td:first-child {
    font-weight: 600;
    color: var(--primary-dark);
    width: 40%;
}

/* Community Page Styles */
.community-filters {
    display: flex;
    gap: 1rem;
}

/* Profile Page Specific Styles */
.profile-content {
    padding: 0;
}

.profile-card.comprehensive {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    overflow: hidden;
}

/* Profile Header */
.profile-header {
    display: grid;
    grid-template-columns: auto 1fr;
    gap: 2.5rem;
    align-items: start;
    padding: 3rem;
    background: linear-gradient(135deg, var(--background) 0%, var(--white) 100%);
    border-bottom: 1px solid var(--border);
}

.avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.avatar-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.5rem;
}

.avatar-preview {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 3.5rem;
    box-shadow: var(--shadow-lg);
    border: 6px solid var(--white);
    outline: 3px solid var(--primary-light);
    transition: var(--transition);
}

.avatar-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 32px rgba(26, 77, 46, 0.2);
}

.profile-info {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.profile-info h3 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--primary-dark);
    font-weight: 700;
}

.profile-info p {
    font-size: 1.2rem;
    color: var(--text-light);
    margin-bottom: 1rem;
}

.profile-badges {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}

.badge {
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 2px solid transparent;
    transition: var(--transition);
}

.badge.verified {
    background: linear-gradient(135deg, rgba(74, 124, 89, 0.15), rgba(74, 124, 89, 0.05));
    color: var(--primary-medium);
    border-color: var(--primary-light);
}

.badge.top-performer {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(212, 175, 55, 0.05));
    color: var(--accent-gold);
    border-color: rgba(212, 175, 55, 0.3);
}

.badge.community-leader {
    background: linear-gradient(135deg, rgba(255, 154, 61, 0.15), rgba(255, 154, 61, 0.05));
    color: var(--accent-orange);
    border-color: rgba(255, 154, 61, 0.3);
}

.badge:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

/* Profile Tabs */
.profile-tabs {
    display: flex;
    background: var(--background);
    border-bottom: 1px solid var(--border);
    padding: 0 3rem;
}

.profile-tab {
    flex: 1;
    padding: 1.5rem 2rem;
    text-align: center;
    cursor: pointer;
    border-bottom: 4px solid transparent;
    transition: var(--transition);
    font-weight: 600;
    color: var(--text-light);
    font-size: 1rem;
    position: relative;
    overflow: hidden;
}

.profile-tab::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(74, 124, 89, 0.1), transparent);
    transition: left 0.6s;
}

.profile-tab:hover::before {
    left: 100%;
}

.profile-tab:hover {
    color: var(--primary-medium);
    background: rgba(255, 255, 255, 0.8);
}

.profile-tab.active {
    color: var(--primary-medium);
    border-bottom-color: var(--primary-medium);
    background: var(--white);
    box-shadow: 0 -2px 8px rgba(26, 77, 46, 0.1);
}

/* Tab Content */
.tab-content {
    padding: 3rem;
}

.tab-pane {
    display: none;
    animation: fadeInUp 0.5s ease-out;
}

.tab-pane.active {
    display: block;
}

/* Personal Info Tab */
#personalTab .profile-form {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
    display: flex;
    flex-direction: column;
}

.form-group label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.95rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 14px 16px;
    border: 2px solid var(--border);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: var(--white);
    font-family: inherit;
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 3px rgba(74, 124, 89, 0.1);
}


.form-group textarea {
    resize: vertical;
    min-height: 120px;
    line-height: 1.6;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 1rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border);
}

/* Multi-select styling */
.form-group select[multiple] {
    height: 120px;
    padding: 12px;
}

.form-group select[multiple] option {
    padding: 8px 12px;
    margin: 2px 0;
    border-radius: 4px;
    cursor: pointer;
    transition: var(--transition);
}

.form-group select[multiple] option:hover {
    background: var(--primary-light);
    color: var(--white);
}

.form-group select[multiple] option:checked {
    background: var(--primary-medium);
    color: var(--white);
}


/* Farming Details Tab */
.farming-details {
    display: flex;
    flex-direction: column;
    gap: 2.5rem;
}

.farming-details h4 {
    font-size: 1.5rem;
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--primary-light);
}

.farming-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.farming-item {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.5rem;
    background: var(--background);
    border-radius: var(--border-radius);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.farming-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: var(--primary-light);
}

.farming-item label {
    font-weight: 700;
    color: var(--primary-dark);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.farming-item span {
    color: var(--text-light);
    font-size: 1.1rem;
    font-weight: 500;
}

.variety-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tag {
    background: linear-gradient(135deg, var(--primary-light), var(--primary-medium));
    color: var(--white);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: var(--shadow);
    transition: var(--transition);
}

.tag:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(74, 124, 89, 0.3);
}

/* Season Details */
.season-details {
    background: linear-gradient(135deg, var(--background) 0%, rgba(74, 124, 89, 0.05) 100%);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border);
}

.detail-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border);
}

.detail-row:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.detail-col {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-col strong {
    color: var(--primary-dark);
    font-size: 0.95rem;
    font-weight: 600;
}

.detail-col span {
    color: var(--text-light);
    font-size: 1.1rem;
    font-weight: 500;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(3px);
}

.modal-content {
    background-color: var(--white);
    margin: 2% auto;
    padding: 0;
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    width: 90%;
    max-width: 480px;
    animation: modalSlideIn 0.2s ease-out;
    max-height: 90vh;
    overflow-y: auto;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-medium) 0%, var(--primary-dark) 100%);
    color: var(--white);
    border-radius: 12px 12px 0 0;
    position: sticky;
    top: 0;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.close {
    color: var(--white);
    font-size: 1.3rem;
    font-weight: bold;
    cursor: pointer;
    transition: var(--transition);
    background: none;
    border: none;
    padding: 4px;
    line-height: 1;
}

.close:hover {
    color: var(--accent-gold);
    transform: scale(1.1);
}

.modal-form {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.375rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.85rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 0.85rem;
    transition: var(--transition);
    background: var(--white);
    box-sizing: border-box;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-medium);
    box-shadow: 0 0 0 2px rgba(74, 124, 89, 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
    font-family: inherit;
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.form-actions .btn {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .modal-content {
        margin: 5% auto;
        width: 95%;
        max-width: 400px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .modal-form {
        padding: 1.25rem;
    }
    
    .modal-header {
        padding: 0.875rem 1.25rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .modal-content {
        margin: 2% auto;
        width: 98%;
        max-width: 360px;
    }
    
    .modal-form {
        padding: 1rem;
    }
    
    .modal-header {
        padding: 0.75rem 1rem;
    }
    
    .modal-header h3 {
        font-size: 1rem;
    }
}

/* Scrollbar styling for modal */
.modal-content::-webkit-scrollbar {
    width: 6px;
}

.modal-content::-webkit-scrollbar-track {
    background: var(--background);
}

.modal-content::-webkit-scrollbar-thumb {
    background: var(--primary-light);
    border-radius: 3px;
}

.modal-content::-webkit-scrollbar-thumb:hover {
    background: var(--primary-medium);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .profile-header {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .farming-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-row {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .profile-header {
        padding: 2rem;
    }
    
    .profile-tabs {
        padding: 0 1.5rem;
        flex-direction: column;
    }
    
    .profile-tab {
        padding: 1.25rem;
    }
    
    .tab-content {
        padding: 2rem;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        font-size: 2.5rem;
    }
    
    .profile-info h3 {
        font-size: 1.75rem;
    }
    
    .profile-badges {
        justify-content: center;
    }
    
    .badge {
        padding: 0.6rem 1rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 480px) {
    .profile-header {
        padding: 1.5rem;
    }
    
    .tab-content {
        padding: 1.5rem;
    }
    
    .farming-item {
        padding: 1.25rem;
    }
    
    .season-details {
        padding: 1.5rem;
    }
    
    /* Form Actions Centering */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center; /* Center the buttons */
    margin-top: 2rem;
    padding: 1.5rem 2rem;
    border-top: 1px solid var(--border);
    background: var(--background);
}

.form-actions .btn {
    min-width: 140px; /* Consistent button width */
}

.close {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-light);
    z-index: 10;
    transition: var(--transition);
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--white);
    box-shadow: var(--shadow);
}

.close:hover {
    background: var(--background);
    color: var(--primary-dark);
    transform: rotate(90deg);
}
}

/* Animation for tab transitions */
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

/* Enhanced focus states for accessibility */
.profile-tab:focus,
.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus,
.btn:focus {
    outline: 2px solid var(--primary-medium);
    outline-offset: 2px;
}

/* Loading state for form submission */
.profile-form.loading {
    opacity: 0.7;
    pointer-events: none;
    position: relative;
}

.profile-form.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border: 3px solid var(--border);
    border-top: 3px solid var(--primary-medium);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

.leaderboard-section {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
}

.leaderboard {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1.5rem;
}

.leaderboard-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    transition: var(--transition);
}

.leaderboard-item:hover {
    transform: translateX(5px);
    background: var(--white);
    box-shadow: var(--shadow);
}

.leaderboard-rank {
    width: 30px;
    height: 30px;
    background: var(--accent-gold);
    color: var(--white);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
}

.leaderboard-info {
    flex: 1;
}

.leaderboard-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.leaderboard-details {
    font-size: 0.9rem;
    color: var(--text-light);
}

.leaderboard-yield {
    font-weight: 700;
    color: var(--primary-dark);
}

.knowledge-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.knowledge-item {
    background: var(--white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.knowledge-item:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.knowledge-item h4 {
    margin-bottom: 1rem;
    color: var(--primary-dark);
}

.knowledge-item p {
    color: var(--text-light);
    font-size: 0.9rem;
    line-height: 1.6;
}

/* Enhanced Profile Page */
.profile-card.comprehensive {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.profile-tabs {
    display: flex;
    background: var(--background);
    border-bottom: 1px solid var(--border);
}

.profile-tab {
    flex: 1;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: var(--transition);
    font-weight: 500;
    color: var(--text-light);
}

.profile-tab.active {
    color: var(--primary-medium);
    border-bottom-color: var(--primary-medium);
    background: var(--white);
}

.tab-content {
    padding: 2rem;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
}

.profile-header {
    display: flex;
    gap: 2.5rem;
    margin-bottom: 2.5rem;
    padding-bottom: 2.5rem;
    border-bottom: 1px solid var(--border);
    align-items: flex-start;
}

.avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.25rem;
}

.avatar-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1.25rem;
}

.avatar-preview {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), var(--accent-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 3.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    border: 4px solid var(--white);
    outline: 2px solid var(--primary-light);
}

.avatar-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info h3 {
    margin-bottom: 0.5rem;
    font-size: 1.5rem;
}

.profile-info p {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 1rem;
}

.profile-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

/* Enhanced Badges */
.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge.verified {
    background: rgba(74, 124, 89, 0.1);
    color: var(--primary-medium);
    border: 1px solid var(--primary-light);
}

.badge.top-performer {
    background: rgba(212, 175, 55, 0.1);
    color: var(--accent-gold);
    border: 1px solid rgba(212, 175, 55, 0.3);
}

.badge.community-leader {
    background: rgba(255, 154, 61, 0.1);
    color: var(--accent-orange);
    border: 1px solid rgba(255, 154, 61, 0.3);
}

.farming-details {
    display: grid;
    gap: 2rem;
}

.farming-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.farming-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.farming-item label {
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.9rem;
}

.variety-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tag {
    background: var(--primary-light);
    color: var(--primary-dark);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.season-details {
    background: var(--background);
    padding: 1.5rem;
    border-radius: var(--border-radius);
}

.detail-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.detail-row:last-child {
    margin-bottom: 0;
}

.detail-col {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.detail-col strong {
    color: var(--primary-dark);
    font-size: 0.9rem;
}

.profile-form {
    margin-top: 2rem;
}

/* Form Sections */
/* Fix form layout alignment */
.form-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    align-items: start;
    margin-bottom: 2rem;
    padding: 0 2rem; /* Add padding for better spacing */
}

.form-group {
    margin-bottom: 1.5rem;
    /* Ensure consistent form field alignment */
    display: flex;
    flex-direction: column;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--primary-dark);
    font-size: 0.95rem;
    /* Ensure label alignment */
    width: 100%;
}

.form-group input, 
.form-group textarea, 
.form-group select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--border);
    border-radius: var(--border-radius);
    font-size: 1rem;
    transition: var(--transition);
    background: var(--white);
    font-family: inherit;
    /* Ensure consistent height */
    min-height: 48px;
    box-sizing: border-box;
}

/* Activity List */
.activity-list {
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    overflow: hidden;
}

.activity-item {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: var(--transition);
}

.activity-item:hover {
    background: var(--background);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-light), var(--accent-gold));
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    font-size: 1.25rem;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-weight: 600;
    margin-bottom: 0.375rem;
    color: var(--primary-dark);
}

.activity-time {
    font-size: 0.875rem;
    color: var(--text-light);
}

/* Content Layout Utilities */
.content-row {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    margin-bottom: 2rem;
}

.content-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.content-card.large {
    grid-column: 1 / -1;
}

/* Alert styles */
.alert-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.alert-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    border-radius: 8px;
    border-left: 4px solid;
}

.alert-item.warning {
    background: rgba(255, 154, 61, 0.1);
    border-left-color: var(--accent-orange);
    color: var(--accent-orange);
}

.alert-item.info {
    background: rgba(74, 124, 89, 0.1);
    border-left-color: var(--primary-medium);
    color: var(--primary-medium);
}

.alert-item.safe {
    background: rgba(34, 197, 94, 0.1);
    border-left-color: #22c55e;
    color: #22c55e;
}

/* Prediction styles */
.prediction-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.prediction-card {
    background: var(--background);
    padding: 1.5rem;
    border-radius: 8px;
    text-align: center;
}

.prediction-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
    display: block;
}

.prediction-value.positive {
    color: #22c55e;
}

.prediction-confidence {
    font-size: 0.8rem;
    color: var(--text-light);
    margin-top: 0.5rem;
}

/* Utility Classes */
.hidden {
    display: none !important;
}

.text-center {
    text-align: center;
}

.loading {
    opacity: 0.6;
    pointer-events: none;
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 2px solid var(--border);
    border-top: 2px solid var(--primary-medium);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}

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

/* Responsive Design */
@media (max-width: 1024px) {
    .hero {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 3rem;
    }
    
    .features-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
    
    .mission-pillars {
        grid-template-columns: 1fr;
    }
    
    .intelligence-grid {
        grid-template-columns: 1fr;
    }
    
    .content-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    :root {
        --sidebar-width: 70px;
    }
    
    .hero {
        padding: 3rem 1.5rem;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-actions {
        justify-content: center;
    }
    
    .impact-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .navbar {
        padding: 1rem 1.5rem;
    }
    
    .sidebar-brand span:last-child,
    .nav-item span {
        display: none;
    }
    
    .main-content {
        margin-left: 70px;
    }
    
    .dashboard-header {
        padding: 1rem 1.5rem;
    }
    
    .user-info span {
        display: none;
    }
    
    .page-header {
        flex-direction: column;
        gap: 1.25rem;
        align-items: flex-start;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 2rem;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .page-content {
        padding: 1.5rem;
    }
    
    .community-stats {
        grid-template-columns: 1fr;
    }
    
    .campaigns-grid {
        grid-template-columns: 1fr;
    }
    
    .farmers-grid {
        grid-template-columns: 1fr;
    }
    
    .detail-row {
        grid-template-columns: 1fr;
    }
    
    .community-filters {
        flex-direction: column;
    }
    
    .profile-tabs {
        flex-direction: column;
    }
    
    .farmer-stats {
        grid-template-columns: 1fr;
    }
    
    .campaign-meta {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .hero-content h1 {
        font-size: 2rem;
    }
    
    .hero-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .hero-actions .btn {
        width: 100%;
    }
    
    .cta-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .cta-actions .btn {
        width: 100%;
    }
    
    .modal-content {
    background: var(--white);
    border-radius: var(--border-radius);
    width: 100%;
    max-width: 500px; /* Reduced from 900px for better centering */
    box-shadow: var(--shadow-lg);
    position: relative;
    animation: modalAppear 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    margin: 2rem auto; /* Center the modal */
}
    .auth-form {
        padding: 2rem 1.5rem;
    }
    
    .data-card {
        padding: 2rem;
    }
}

/* Additional missing styles */
.field-conditions {
    margin-top: 1.5rem;
}

.condition-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.condition-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
}

.condition-status {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-optimal {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.status-warning {
    background: rgba(255, 154, 61, 0.1);
    color: var(--accent-orange);
}

.water-management {
    margin-top: 1.5rem;
}

.water-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.water-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
}

.water-label {
    font-weight: 600;
    color: var(--primary-dark);
}

.water-value {
    color: var(--text-light);
}

.pest-overview {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-bottom: 1.5rem;
}

.pest-chart-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.treatment-recommendations ul {
    list-style: none;
    padding-left: 0;
}

.treatment-recommendations li {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border);
    color: var(--text-light);
}

.treatment-recommendations li:last-child {
    border-bottom: none;
}

.harvest-planning {
    margin-top: 1.5rem;
}

.preparation-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.prep-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
}

.prep-label {
    font-weight: 600;
    color: var(--primary-dark);
}

.prep-status {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.prep-status.completed {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.prep-status.in-progress {
    background: rgba(255, 154, 61, 0.1);
    color: var(--accent-orange);
}

.prep-status.pending {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
}

/* Seasonal Tracking Styles */
.seasonal-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.performance-metrics {
    margin-bottom: 2rem;
}

.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.metric-card {
    background: var(--white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-title {
    font-weight: 600;
    color: var(--primary-dark);
}

.metric-trend {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 12px;
}

.metric-trend.positive {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.metric-trend.negative {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
}

.metric-period {
    color: var(--text-light);
    font-size: 0.9rem;
}

.seasonal-comparison {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.comparison-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--primary-medium);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -9px;
    top: 0;
    width: 16px;
    height: 16px;
    background: var(--accent-gold);
    border-radius: 50%;
    border: 3px solid var(--white);
    box-shadow: 0 0 0 2px var(--accent-gold);
}

.timeline-year {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 0.5rem;
}

.timeline-content h4 {
    margin-bottom: 0.5rem;
    color: var(--primary-dark);
}

.timeline-content p {
    color: var(--text-light);
    margin-bottom: 1rem;
}

.timeline-stats {
    display: flex;
    gap: 2rem;
    font-size: 0.9rem;
}

.trend-change {
    font-weight: 600;
}

.change-positive {
    color: #22c55e;
}

.key-achievements {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.achievement-tag {
    background: var(--primary-light);
    color: var(--primary-dark);
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.yield-trend {
    margin-top: 1.5rem;
}

.trend-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
}

.trend-item:last-child {
    border-bottom: none;
}

.climate-impact {
    margin-top: 1.5rem;
}

.climate-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.climate-card {
    background: var(--white);
    padding: 1.5rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    text-align: center;
}

.climate-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-dark);
    margin-bottom: 1rem;
}

.climate-comparison {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    font-size: 0.9rem;
}

.comparison-label {
    color: var(--text-light);
}

.comparison-value {
    font-weight: 600;
    color: var(--primary-dark);
}

.comparison-change {
    font-size: 0.8rem;
    font-weight: 600;
}

.impact-factors {
    margin-top: 1.5rem;
}

.factors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.impact-factor {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
}

.factor-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.factor-impact {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.factor-impact.high {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.factor-impact.medium {
    background: rgba(255, 154, 61, 0.1);
    color: var(--accent-orange);
}

.factor-impact.low {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.tech-timeline {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.tech-phase {
    display: flex;
    gap: 2rem;
    padding: 1.5rem;
    background: var(--white);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
}

.tech-year {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--accent-gold);
    min-width: 80px;
}

.tech-content h4 {
    margin-bottom: 1rem;
    color: var(--primary-dark);
}

.tech-content ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1rem;
}

.tech-content li {
    padding: 0.25rem 0;
    color: var(--text-light);
    position: relative;
    padding-left: 1rem;
}

.tech-content li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--accent-gold);
}

.tech-impact {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border);
}

.impact-value {
    font-weight: 700;
    color: var(--primary-dark);
}

.impact-desc {
    color: var(--text-light);
    font-size: 0.9rem;
}

/* Livestock Styles */
.livestock-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.livestock-overview {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.livestock-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: var(--transition);
}

.livestock-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.livestock-card i {
    font-size: 3rem;
    background: linear-gradient(135deg, var(--primary-medium), var(--accent-gold));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.livestock-content h3 {
    margin-bottom: 0.5rem;
    color: var(--primary-dark);
}

.livestock-content p {
    color: var(--text-light);
    margin-bottom: 1rem;
}

.livestock-stats {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.livestock-stats .stat {
    background: var(--background);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--primary-dark);
}

/* Analytics Page Specific Styles */
.analytics-content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* Chart Cards Enhancement */
.content-card .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}

.card-header h3 {
    margin-bottom: 0;
    font-size: 1.25rem;
}

.card-actions {
    display: flex;
    gap: 0.75rem;
    align-items: center;
}

.chart-filter {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border);
    border-radius: var(--border-radius);
    background: var(--white);
    font-size: 0.9rem;
}

/* Chart Insights */
.chart-insights {
    display: flex;
    gap: 1.5rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.insight-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.insight-label {
    font-size: 0.85rem;
    color: var(--text-light);
    font-weight: 500;
}

.insight-value {
    font-weight: 600;
    color: var(--primary-dark);
}

.insight-value.positive {
    color: #22c55e;
}

.insight-value.negative {
    color: #ef4444;
}

/* Chart Details */
.chart-details {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-label {
    font-size: 0.9rem;
    color: var(--text-light);
    font-weight: 500;
}

.detail-value {
    font-weight: 600;
    color: var(--primary-dark);
}

/* Efficiency Metrics */
.efficiency-metrics {
    margin-top: 1.5rem;
}

.metric-comparison {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.comparison-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: var(--background);
    border-radius: 8px;
}

.comparison-label {
    font-size: 0.9rem;
    color: var(--text-light);
}

.comparison-value {
    font-weight: 600;
    font-size: 0.9rem;
}

.comparison-value.positive {
    color: #22c55e;
}

.comparison-value.negative {
    color: #ef4444;
}

/* Impact Analysis */
.impact-analysis {
    margin-top: 1.5rem;
}

.analysis-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.analysis-card {
    text-align: center;
    padding: 1.5rem;
    background: var(--background);
    border-radius: var(--border-radius);
    border: 1px solid var(--border);
}

.analysis-card h4 {
    margin-bottom: 0.75rem;
    font-size: 1rem;
    color: var(--primary-dark);
}

.analysis-value {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.analysis-value.positive {
    color: #22c55e;
}

.analysis-note {
    font-size: 0.85rem;
    color: var(--text-light);
}

/* Trend Analysis */
.trend-analysis {
    margin-top: 1.5rem;
}

.trend-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
}

.trend-item:last-child {
    border-bottom: none;
}

.trend-period {
    font-size: 0.9rem;
    color: var(--text-light);
}

.trend-value {
    font-weight: 600;
}

.trend-value.positive {
    color: #22c55e;
}

/* Profit Metrics */
.profit-metrics {
    margin-top: 1.5rem;
}

.profit-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border);
}

.profit-item:last-child {
    border-bottom: none;
}

.profit-label {
    font-size: 0.9rem;
    color: var(--text-light);
}

.profit-value {
    font-weight: 600;
}

.profit-value.positive {
    color: #22c55e;
}

/* Insights Grid */
.insights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.insight-card {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border);
    transition: var(--transition);
}

.insight-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.insight-card.positive {
    border-left: 4px solid #22c55e;
    background: rgba(34, 197, 94, 0.05);
}

.insight-card.warning {
    border-left: 4px solid #f59e0b;
    background: rgba(245, 158, 11, 0.05);
}

.insight-card.info {
    border-left: 4px solid #3b82f6;
    background: rgba(59, 130, 246, 0.05);
}

.insight-icon {
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.insight-card.positive .insight-icon {
    color: #22c55e;
}

.insight-card.warning .insight-icon {
    color: #f59e0b;
}

.insight-card.info .insight-icon {
    color: #3b82f6;
}

.insight-content {
    flex: 1;
}

.insight-content h4 {
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
    color: var(--primary-dark);
}

.insight-content p {
    color: var(--text-light);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
}

.insight-impact {
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.insight-card.positive .insight-impact {
    color: #22c55e;
}

.insight-card.warning .insight-impact {
    color: #f59e0b;
}

.insight-card.info .insight-impact {
    color: #3b82f6;
}

/* Badges */
.efficiency-badge,
.trend-badge,
.profit-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.efficiency-badge.positive,
.trend-badge.positive,
.profit-badge.positive {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

/* Stat Trend */
.stat-trend {
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 0.25rem;
}

.stat-trend.positive {
    color: #22c55e;
}

.stat-trend.negative {
    color: #ef4444;
}

/* Responsive Design */
@media (max-width: 768px) {
    .chart-insights {
        flex-direction: column;
        gap: 1rem;
    }
    
    .analysis-grid {
        grid-template-columns: 1fr;
    }
    
    .insights-grid {
        grid-template-columns: 1fr;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .card-actions {
        width: 100%;
        justify-content: flex-start;
    }
}

/* Chart container fixes */
.chart-container {
    position: relative;
    height: 300px;
    width: 100%;
    margin: 1rem 0;
}

canvas {
    max-width: 100%;
    height: auto !important;
}

/* Notification styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    z-index: 10000;
    animation: slideInRight 0.3s ease;
    max-width: 400px;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.notification-success {
    background: #4a7c59;
}

.notification-error {
    background: #e74c3c;
}

.notification-info {
    background: #3498db;
}

@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes slideOutRight {
    from {
        transform: translateX(0);
        opacity: 1;
    }
    to {
        transform: translateX(100%);
        opacity: 0;
    }
}

/* Form section improvements */
.form-section {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 2rem;
    border: 1px solid var(--border);
}

.form-section h3 {
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}

/* Progress overview */
.progress-overview {
    margin-bottom: 2rem;
}

.progress-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.progress-label {
    font-weight: 600;
    color: var(--primary-dark);
    min-width: 120px;
}

.progress-percent {
    font-weight: 600;
    color: var(--primary-medium);
    min-width: 50px;
    text-align: right;
}

/* Water stats grid */
.water-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.water-stat-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    text-align: center;
}

.water-stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-dark);
}

.water-stat-label {
    font-size: 0.8rem;
    color: var(--text-light);
}

/* Field conditions grid */
.field-conditions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.condition-card {
    padding: 1rem;
    background: var(--background);
    border-radius: 8px;
    text-align: center;
    border-left: 4px solid var(--primary-medium);
}

.condition-value {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.condition-desc {
    font-size: 0.8rem;
    color: var(--text-light);
}

/* Missing utility classes */
.flex {
    display: flex;
}

.flex-col {
    flex-direction: column;
}

.items-center {
    align-items: center;
}

.justify-between {
    justify-content: space-between;
}

.gap-2 {
    gap: 0.5rem;
}

.gap-4 {
    gap: 1rem;
}

.mt-2 {
    margin-top: 0.5rem;
}

.mt-4 {
    margin-top: 1rem;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.p-4 {
    padding: 1rem;
}

.w-full {
    width: 100%;
}

.h-full {
    height: 100%;
}

/* Ensure all interactive elements have proper cursor */
button, .btn, .nav-item, .tab, .profile-tab, .close {
    cursor: pointer;
}

/* Focus states for accessibility */
button:focus, .btn:focus, input:focus, textarea:focus, select:focus {
    outline: 2px solid var(--primary-medium);
    outline-offset: 2px;
}


/* Print styles */
@media print {
    .navbar, .sidebar, .dashboard-header, .header-actions, .btn {
        display: none !important;
    }
    
    .main-content {
        margin-left: 0 !important;
    }
    
    .page-content {
        padding: 1rem !important;
    }
    
    .stat-card, .farmer-card, .campaign-card, .monitoring-card {
        break-inside: avoid;
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}
@media (max-width: 768px) {
    .profile-form-grid,
    .registration-form,
    .form-section-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .info-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
    
    .form-full-width {
        grid-column: 1;
    }
    
    .form-section-header {
        grid-column: 1;
    }
}
/* Scrollable form for mobile */
@media (max-width: 768px) {
    .modal-content.large {
        margin: 1rem;
        width: calc(100% - 2rem);
        max-height: 85vh;
    }
    
    .form-section {
        padding: 0 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}
</style>
<div id="dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <span class="logo">🌾</span>
                <span>FarmStat</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active" data-page="overview">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </li>
                <li class="nav-item" data-page="farmers">
                    <i class="fas fa-users"></i>
                    <span>Farmers</span>
                </li>
                <li class="nav-item" data-page="riceMonitoring">
                    <i class="fas fa-seedling"></i>
                    <span>Rice Monitoring</span>
                </li>
                <li class="nav-item" data-page="seasonalTracking">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Seasonal Tracking</span>
                </li>
                <li class="nav-item" data-page="livestock">
                    <i class="fas fa-paw"></i>
                    <span>Livestock</span>
                </li>
                <li class="nav-item" data-page="crowdfunding">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span>Crowdfunding</span>
                </li>
                <li class="nav-item" data-page="analytics">
                    <i class="fas fa-chart-bar"></i>
                    <span>Analytics</span>
                </li>
                <li class="nav-item" data-page="community">
                    <i class="fas fa-users"></i>
                    <span>Community</span>
                </li>
                <li class="nav-item" data-page="profile">
                    <i class="fas fa-user-cog"></i>
                    <span>Profile</span>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-left">
                <h1 id="pageTitle">Rice Farming Intelligence Dashboard</h1>
                <div class="season-indicator">
                    <span class="season-badge">2024 Dry Season</span>
                    <span class="progress-text">68% Complete</span>
                </div>
            </div>
            <div class="header-right">
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-avatar" id="userAvatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span id="userWelcome">Welcome, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline">Logout</a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            <!-- Overview Page -->
            <div id="overviewPage" class="page active">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number" id="totalFarmers"><?php echo $totalFarmers; ?></span>
                            <span class="stat-label">Rice Farmers</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number" id="activeCrops"><?php echo count($allFarmers); ?></span>
                            <span class="stat-label">Active Rice Fields</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number" id="totalFunding">₱<?php echo number_format($totalFunding, 0); ?></span>
                            <span class="stat-label">Community Funding</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-number" id="yieldIncrease"><?php echo $yieldIncrease; ?>%</span>
                            <span class="stat-label">Avg Yield Increase</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-content">
                    <div class="content-row">
                        <div class="content-card large">
                            <h3>Rice Season 2024 Progress</h3>
                            <div class="season-phase-tracker">
                                <div class="phase active">
                                    <div class="phase-icon">🌱</div>
                                    <div class="phase-info">
                                        <h4>Planting Phase</h4>
                                        <p>92% Complete</p>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 92%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="phase active">
                                    <div class="phase-icon">🌿</div>
                                    <div class="phase-info">
                                        <h4>Growth Phase</h4>
                                        <p>68% Complete</p>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 68%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="phase">
                                    <div class="phase-icon">🌾</div>
                                    <div class="phase-info">
                                        <h4>Harvest Phase</h4>
                                        <p>Starts August 2024</p>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="content-card">
                            <h3>Recent Farmer Activities</h3>
                            <div class="activity-list">
                                <?php if (!empty($allFarmers)): ?>
                                    <?php foreach (array_slice($allFarmers, 0, 5) as $farmer): ?>
                                        <div class="activity-item">
                                            <div class="activity-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="activity-content">
                                                <h4><?php echo htmlspecialchars($farmer['full_name'] ?? 'Unknown Farmer'); ?></h4>
                                                <p><?php echo htmlspecialchars($farmer['farm_location'] ?? 'Location not set'); ?></p>
                                                <span class="activity-meta">
                                                    <?php echo htmlspecialchars($farmer['farm_size'] ?? '0'); ?> hectares • 
                                                    <?php echo htmlspecialchars($farmer['years_experience'] ?? '0'); ?> years experience
                                                </span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="activity-item">
                                        <div class="activity-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div class="activity-content">
                                            <p>No farmer activities recorded.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="content-row">
                        <div class="content-card">
                            <h3>My Farm Profile</h3>
                            <div class="farm-profile">
                                <div class="profile-item">
                                    <span class="profile-label">Farmer Name:</span>
                                    <span class="profile-value"><?php echo htmlspecialchars($userProfile['full_name'] ?? $_SESSION['user_name'] ?? 'Not set'); ?></span>
                                </div>
                                <div class="profile-item">
                                    <span class="profile-label">Farm Size:</span>
                                    <span class="profile-value"><?php echo htmlspecialchars($userProfile['farm_size'] ?? 'Not set'); ?> hectares</span>
                                </div>
                                <div class="profile-item">
                                    <span class="profile-label">Location:</span>
                                    <span class="profile-value"><?php echo htmlspecialchars($userProfile['farm_location'] ?? 'Not set'); ?></span>
                                </div>
                                <div class="profile-item">
                                    <span class="profile-label">Farming Experience:</span>
                                    <span class="profile-value"><?php echo htmlspecialchars($userProfile['years_experience'] ?? '0'); ?> years</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="content-card">
                            <h3>Quick Actions</h3>
                            <div class="quick-actions">
                                <button class="action-btn" onclick="showPage('farmers')">
                                    <i class="fas fa-users"></i>
                                    <span>Manage Farmers</span>
                                </button>
                                <button class="action-btn" onclick="showPage('riceMonitoring')">
                                    <i class="fas fa-seedling"></i>
                                    <span>Rice Monitoring</span>
                                </button>
                                <button class="action-btn" onclick="showPage('crowdfunding')">
                                    <i class="fas fa-hand-holding-heart"></i>
                                    <span>Crowdfunding</span>
                                </button>
                                <button class="action-btn" onclick="showPage('profile')">
                                    <i class="fas fa-user-cog"></i>
                                    <span>My Profile</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Farmers Page -->
            <div id="farmersPage" class="page">
                <div class="page-header">
                    <h2>Rice Farmer Management</h2>
                    <div class="header-actions">
                        <button id="addFarmerBtn" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Register Farmer
                        </button>
                        <button class="btn btn-outline" onclick="exportFarmers()">
                            <i class="fas fa-download"></i> Export Data
                        </button>
                    </div>
                </div>
                
                <div class="farmers-grid" id="farmersGrid">
                    <?php if (!empty($allFarmers)): ?>
                        <?php foreach ($allFarmers as $farmer): ?>
                            <div class="farmer-card">
                                <div class="farmer-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="farmer-info">
                                    <h4><?php echo htmlspecialchars($farmer['full_name']); ?></h4>
                                    <p class="farmer-location">📍 <?php echo htmlspecialchars($farmer['farm_location'] ?? 'Location not set'); ?></p>
                                    <div class="farmer-stats">
                                        <span class="stat">
                                            <i class="fas fa-ruler-combined"></i>
                                            <?php echo htmlspecialchars($farmer['farm_size'] ?? '0'); ?> ha
                                        </span>
                                        <span class="stat">
                                            <i class="fas fa-calendar-alt"></i>
                                            <?php echo htmlspecialchars($farmer['years_experience'] ?? '0'); ?> yrs
                                        </span>
                                        <span class="stat">
                                            <i class="fas fa-tractor"></i>
                                            <?php echo htmlspecialchars($farmer['farming_method'] ?? 'Not set'); ?>
                                        </span>
                                    </div>
                                    <?php if (!empty($farmer['varieties'])): ?>
                                        <div class="variety-tags">
                                            <?php 
                                            $varieties = explode(',', $farmer['varieties']);
                                            foreach ($varieties as $variety): 
                                                if (!empty(trim($variety))): ?>
                                                    <span class="tag"><?php echo htmlspecialchars(trim($variety)); ?></span>
                                                <?php endif;
                                            endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="farmer-actions">
                                    <button class="btn-icon" onclick="editFarmer(<?php echo $farmer['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" onclick="viewFarmer(<?php echo $farmer['id']; ?>)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-users fa-3x"></i>
                            <h3>No Farmers Registered</h3>
                            <p>Get started by registering the first farmer in your community.</p>
                            <button id="addFarmerBtnEmpty" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Register First Farmer
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


                <!-- Enhanced Rice Monitoring Page -->
                <div id="riceMonitoringPage" class="page">
                    <div class="page-header">
                        <h2>Rice Farming Monitoring</h2>
                        <div class="season-selector">
                            <select id="seasonSelect">
                                <option value="2024">2024 Dry Season</option>
                                <option value="2023">2023 Wet Season</option>
                                <option value="2023">2023 Dry Season</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="monitoring-content">
                        <!-- Current Season Overview -->
                        <div class="monitoring-card">
                            <h3>🌱 Current Season Overview - 2024 Dry Season</h3>
                            <div class="season-progress">
                                <div class="progress-overview">
                                    <div class="progress-item">
                                        <span class="progress-label">Overall Progress</span>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 68%"></div>
                                        </div>
                                        <span class="progress-percent">68%</span>
                                    </div>
                                </div>
                                <div class="phase-details-grid">
                                    <div class="phase-detail-card planting">
                                        <h4>Planting Phase (Jan-Mar 2024)</h4>
                                        <p>Completed: January 15 - March 20, 2024</p>
                                        <div class="detail-metrics">
                                            <div class="metric">
                                                <span class="metric-value">92%</span>
                                                <span class="metric-label">Fields Planted</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">28.5k</span>
                                                <span class="metric-label">Seedlings Used</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">15 days</span>
                                                <span class="metric-label">Avg Duration</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="phase-detail-card growth">
                                        <h4>Growth Phase (Apr-Jul 2024)</h4>
                                        <p>Current Phase: 68% Complete</p>
                                        <div class="detail-metrics">
                                            <div class="metric">
                                                <span class="metric-value">45-60</span>
                                                <span class="metric-label">Days After Planting</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">85%</span>
                                                <span class="metric-label">Fertilizer Applied</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">72cm</span>
                                                <span class="metric-label">Avg Plant Height</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="phase-detail-card harvest">
                                        <h4>Harvest Phase (Aug-Oct 2024)</h4>
                                        <p>Scheduled: August 15 - October 30, 2024</p>
                                        <div class="detail-metrics">
                                            <div class="metric">
                                                <span class="metric-value">0%</span>
                                                <span class="metric-label">Fields Harvested</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">110</span>
                                                <span class="metric-label">Target Yield/ha</span>
                                            </div>
                                            <div class="metric">
                                                <span class="metric-value">45 days</span>
                                                <span class="metric-label">Est. Duration</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Planting Phase Details -->
                        <div class="monitoring-card">
                            <h3>🌱 Planting Phase Analytics</h3>
                            <div class="phase-details">
                                <div class="detail-item">
                                    <label>Planting Method Distribution:</label>
                                    <span>80% Transplanting, 20% Direct Seeding</span>
                                </div>
                                <div class="detail-item">
                                    <label>Top Varieties Planted:</label>
                                    <span>Jasmine (45%), Sinandomeng (30%), IR64 (25%)</span>
                                </div>
                                <div class="detail-item">
                                    <label>Average Planting Date:</label>
                                    <span>January 15, 2024</span>
                                </div>
                                <div class="detail-item">
                                    <label>Seed Treatment:</label>
                                    <span>92% Used Treated Seeds, 8% Traditional Methods</span>
                                </div>
                                <div class="detail-item">
                                    <label>Planting Density:</label>
                                    <span>Average 20 plants/m², Spacing 20x20cm</span>
                                </div>
                            </div>
                            
                            <div class="field-conditions">
                                <h4>Soil & Field Conditions at Planting</h4>
                                <div class="condition-grid">
                                    <div class="condition-item">
                                        <span>Soil Moisture</span>
                                        <span class="condition-status status-optimal">Optimal</span>
                                    </div>
                                    <div class="condition-item">
                                        <span>Soil pH Level</span>
                                        <span class="condition-status status-optimal">6.2-6.8</span>
                                    </div>
                                    <div class="condition-item">
                                        <span>Organic Matter</span>
                                        <span class="condition-status status-warning">2.1% (Low)</span>
                                    </div>
                                    <div class="condition-item">
                                        <span>Field Preparation</span>
                                        <span class="condition-status status-optimal">95% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Growth Phase Management -->
                        <div class="monitoring-card">
                            <h3>🌿 Growth Phase Management</h3>
                            <div class="input-tracking">
                                <h4>Fertilizer Application Progress</h4>
                                <div class="input-grid">
                                    <div class="input-item">
                                        <span class="input-name">Urea (Nitrogen)</span>
                                        <span class="input-usage">85%</span>
                                        <div class="progress-bar small">
                                            <div class="progress-fill" style="width: 85%"></div>
                                        </div>
                                        <span class="input-details">120 kg/ha, Split Application</span>
                                    </div>
                                    <div class="input-item">
                                        <span class="input-name">Complete (14-14-14)</span>
                                        <span class="input-usage">72%</span>
                                        <div class="progress-bar small">
                                            <div class="progress-fill" style="width: 72%"></div>
                                        </div>
                                        <span class="input-details">90 kg/ha, Basal Application</span>
                                    </div>
                                    <div class="input-item">
                                        <span class="input-name">Organic Fertilizer</span>
                                        <span class="input-usage">45%</span>
                                        <div class="progress-bar small">
                                            <div class="progress-fill" style="width: 45%"></div>
                                        </div>
                                        <span class="input-details">2 tons/ha, Farmyard Manure</span>
                                    </div>
                                    <div class="input-item">
                                        <span class="input-name">Potassium (K₂O)</span>
                                        <span class="input-usage">60%</span>
                                        <div class="progress-bar small">
                                            <div class="progress-fill" style="width: 60%"></div>
                                        </div>
                                        <span class="input-details">60 kg/ha, Panicle Initiation</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="water-management">
                                <h4>Water Management</h4>
                                <div class="water-stats">
                                    <div class="water-item">
                                        <span class="water-label">Irrigation Status</span>
                                        <span class="water-value">85% Fields Adequate</span>
                                    </div>
                                    <div class="water-item">
                                        <span class="water-label">Water Depth</span>
                                        <span class="water-value">3-5 cm maintained</span>
                                    </div>
                                    <div class="water-item">
                                        <span class="water-label">Rainfall</span>
                                        <span class="water-value">450 mm (Season Total)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pest & Disease Management -->
                        <div class="monitoring-card">
                            <h3>🐛 Pest & Disease Management</h3>
                            <div class="pest-overview">
                                <div class="pest-alerts">
                                    <h4>Current Alerts</h4>
                                    <div class="alert-list">
                                        <div class="alert-item warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <span>Brown Planthopper - Moderate Incidence (15% fields)</span>
                                        </div>
                                        <div class="alert-item info">
                                            <i class="fas fa-info-circle"></i>
                                            <span>Rice Blast - Low Incidence (8% fields)</span>
                                        </div>
                                        <div class="alert-item safe">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Stem Borer - Under Control (3% fields)</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="pest-chart-container">
                                    <canvas id="pestChart"></canvas>
                                </div>
                            </div>
                            
                            <div class="treatment-recommendations">
                                <h4>Recommended Actions</h4>
                                <ul>
                                    <li>Apply neem-based biopesticides for planthopper control</li>
                                    <li>Maintain proper water level to discourage pest breeding</li>
                                    <li>Monitor fields twice weekly for early detection</li>
                                    <li>Use yellow sticky traps for monitoring</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Yield Prediction -->
                        <div class="monitoring-card">
                            <h3>📈 Yield Prediction & Harvest Planning</h3>
                            <div class="yield-prediction">
                                <div class="prediction-overview">
                                    <div class="prediction-card">
                                        <h4>Expected Yield</h4>
                                        <div class="prediction-value">4.2 tons/ha</div>
                                        <div class="prediction-confidence">85% Confidence</div>
                                    </div>
                                    <div class="prediction-card">
                                        <h4>Compared to Last Season</h4>
                                        <div class="prediction-value positive">+12%</div>
                                        <div class="prediction-note">Improved practices</div>
                                    </div>
                                    <div class="prediction-card">
                                        <h4>Harvest Readiness</h4>
                                        <div class="prediction-value">32 days</div>
                                        <div class="prediction-note">Until optimal harvest</div>
                                    </div>
                                </div>
                                
                                <div class="harvest-planning">
                                    <h4>Harvest Preparation Status</h4>
                                    <div class="preparation-grid">
                                        <div class="prep-item">
                                            <span class="prep-label">Labor Arranged</span>
                                            <span class="prep-status completed">85%</span>
                                        </div>
                                        <div class="prep-item">
                                            <span class="prep-label">Equipment Ready</span>
                                            <span class="prep-status in-progress">70%</span>
                                        </div>
                                        <div class="prep-item">
                                            <span class="prep-label">Storage Prepared</span>
                                            <span class="prep-status pending">45%</span>
                                        </div>
                                        <div class="prep-item">
                                            <span class="prep-label">Market Linkages</span>
                                            <span class="prep-status completed">90%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Seasonal Tracking Page -->
                <div id="seasonalTrackingPage" class="page">
                    <div class="page-header">
                        <h2>Multi-Season Analytics</h2>
                        <div class="timeframe-selector">
                            <button class="btn btn-outline active">5 Years</button>
                            <button class="btn btn-outline">3 Years</button>
                            <button class="btn btn-outline">Current Year</button>
                        </div>
                    </div>
                    
                    <div class="seasonal-content">
                        <!-- Performance Overview -->
                        <div class="monitoring-card">
                            <h3>📊 Seasonal Performance Overview</h3>
                            <div class="performance-metrics">
                                <div class="metrics-grid">
                                    <div class="metric-card">
                                        <div class="metric-header">
                                            <span class="metric-title">Average Yield</span>
                                            <span class="metric-trend positive">+15%</span>
                                        </div>
                                        <div class="metric-value">4.8 tons/ha</div>
                                        <div class="metric-period">5-Year Average</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="metric-header">
                                            <span class="metric-title">Production Cost</span>
                                            <span class="metric-trend negative">+8%</span>
                                        </div>
                                        <div class="metric-value">₱28,500/ha</div>
                                        <div class="metric-period">Current Season</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="metric-header">
                                            <span class="metric-title">Profit Margin</span>
                                            <span class="metric-trend positive">+22%</span>
                                        </div>
                                        <div class="metric-value">₱16,200/ha</div>
                                        <div class="metric-period">5-Year Improvement</div>
                                    </div>
                                    <div class="metric-card">
                                        <div class="metric-header">
                                            <span class="metric-title">Technology Adoption</span>
                                            <span class="metric-trend positive">+65%</span>
                                        </div>
                                        <div class="metric-value">78%</div>
                                        <div class="metric-period">Since 2020</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="seasonal-comparison">
                            <div class="comparison-card">
                                <h3>Farming Journey Timeline</h3>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-year">2024</div>
                                        <div class="timeline-content">
                                            <h4>Technology Adoption Phase</h4>
                                            <p>Implemented mobile monitoring and precision farming techniques</p>
                                            <div class="timeline-stats">
                                                <span>Yield: 120 cavans/ha</span>
                                                <span class="trend-change change-positive">+15% from 2023</span>
                                            </div>
                                            <div class="key-achievements">
                                                <span class="achievement-tag">Mobile Monitoring</span>
                                                <span class="achievement-tag">Precision Farming</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-year">2023</div>
                                        <div class="timeline-content">
                                            <h4>Community Integration</h4>
                                            <p>Joined FarmStat community and implemented shared best practices</p>
                                            <div class="timeline-stats">
                                                <span>Yield: 104 cavans/ha</span>
                                                <span class="trend-change change-positive">+25% from 2022</span>
                                            </div>
                                            <div class="key-achievements">
                                                <span class="achievement-tag">Community Learning</span>
                                                <span class="achievement-tag">Best Practices</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-year">2022</div>
                                        <div class="timeline-content">
                                            <h4>Input Optimization</h4>
                                            <p>Focused on fertilizer efficiency and water management improvements</p>
                                            <div class="timeline-stats">
                                                <span>Yield: 83 cavans/ha</span>
                                                <span class="trend-change change-positive">+18% from 2021</span>
                                            </div>
                                            <div class="key-achievements">
                                                <span class="achievement-tag">Fertilizer Optimization</span>
                                                <span class="achievement-tag">Water Management</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-year">2021</div>
                                        <div class="timeline-content">
                                            <h4>Traditional Methods</h4>
                                            <p>Primarily used traditional farming methods with limited technology</p>
                                            <div class="timeline-stats">
                                                <span>Yield: 70 cavans/ha</span>
                                                <span class="trend-change change-positive">+8% from 2020</span>
                                            </div>
                                            <div class="key-achievements">
                                                <span class="achievement-tag">Baseline Established</span>
                                                <span class="achievement-tag">Traditional Methods</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comparison-card">
                                <h3>Season-over-Season Comparison</h3>
                                <canvas id="seasonComparisonChart"></canvas>
                                <div class="yield-trend">
                                    <h4>Yield Trend Analysis</h4>
                                    <div class="trend-item">
                                        <span>2020-2024 Growth</span>
                                        <span class="trend-change change-positive">+71%</span>
                                    </div>
                                    <div class="trend-item">
                                        <span>Best Performing Season</span>
                                        <span>2024 Dry Season (120 cavans/ha)</span>
                                    </div>
                                    <div class="trend-item">
                                        <span>Most Improved</span>
                                        <span>2023 (+25% from previous)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Charts -->
                        <div class="content-row">
                            <div class="content-card">
                                <h3>Seasonal Yield Trends</h3>
                                <canvas id="yieldTrendChart"></canvas>
                            </div>
                            <div class="content-card">
                                <h3>Technology Adoption Progress</h3>
                                <canvas id="technologyAdoptionChart"></canvas>
                            </div>
                        </div>

                        <!-- Climate Impact Analysis -->
                        <div class="monitoring-card">
                            <h3>🌦️ Climate Impact Analysis</h3>
                            <div class="climate-impact">
                                <div class="climate-metrics">
                                    <div class="climate-card">
                                        <h4>Rainfall Pattern</h4>
                                        <div class="climate-value">1,250 mm</div>
                                        <div class="climate-comparison">
                                            <span class="comparison-label">5-Year Average:</span>
                                            <span class="comparison-value">1,180 mm</span>
                                            <span class="comparison-change change-positive">+6%</span>
                                        </div>
                                    </div>
                                    <div class="climate-card">
                                        <h4>Temperature Impact</h4>
                                        <div class="climate-value">28.5°C Avg</div>
                                        <div class="climate-comparison">
                                            <span class="comparison-label">Optimal Range:</span>
                                            <span class="comparison-value">25-30°C</span>
                                            <span class="comparison-change change-positive">Within Range</span>
                                        </div>
                                    </div>
                                    <div class="climate-card">
                                        <h4>Extreme Events</h4>
                                        <div class="climate-value">2 Events</div>
                                        <div class="climate-comparison">
                                            <span class="comparison-label">This Season:</span>
                                            <span class="comparison-value">Minor Impact</span>
                                            <span class="comparison-change change-positive">Managed Well</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="impact-factors">
                                    <h4>Key Climate Impact Factors</h4>
                                    <div class="factors-grid">
                                        <div class="impact-factor">
                                            <span class="factor-name">Rainfall Distribution</span>
                                            <span class="factor-impact high">High Impact</span>
                                        </div>
                                        <div class="impact-factor">
                                            <span class="factor-name">Temperature Fluctuation</span>
                                            <span class="factor-impact medium">Medium Impact</span>
                                        </div>
                                        <div class="impact-factor">
                                            <span class="factor-name">Typhoon Events</span>
                                            <span class="factor-impact low">Low Impact (2024)</span>
                                        </div>
                                        <div class="impact-factor">
                                            <span class="factor-name">Dry Spells</span>
                                            <span class="factor-impact medium">Medium Impact</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rainfall Impact Chart -->
                        <div class="content-card large">
                            <h3>Rainfall Impact Analysis</h3>
                            <canvas id="rainfallImpactChart"></canvas>
                        </div>

                        <!-- Technology Adoption Timeline -->
                        <div class="monitoring-card">
                            <h3>🔧 Technology Adoption Journey</h3>
                            <div class="tech-timeline">
                                <div class="tech-phase">
                                    <div class="tech-year">2024</div>
                                    <div class="tech-content">
                                        <h4>Digital Transformation</h4>
                                        <ul>
                                            <li>Mobile field monitoring implementation</li>
                                            <li>Precision agriculture tools adoption</li>
                                            <li>Real-time data analytics integration</li>
                                        </ul>
                                        <div class="tech-impact">
                                            <span class="impact-value">+15% Efficiency</span>
                                            <span class="impact-desc">Yield improvement</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tech-phase">
                                    <div class="tech-year">2023</div>
                                    <div class="tech-content">
                                        <h4>Community Integration</h4>
                                        <ul>
                                            <li>Joined FarmStat platform</li>
                                            <li>Implemented community best practices</li>
                                            <li>Started digital record keeping</li>
                                        </ul>
                                        <div class="tech-impact">
                                            <span class="impact-value">+25% Yield</span>
                                            <span class="impact-desc">From previous season</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tech-phase">
                                    <div class="tech-year">2022</div>
                                    <div class="tech-content">
                                        <h4>Input Optimization</h4>
                                        <ul>
                                            <li>Soil testing implementation</li>
                                            <li>Precision fertilizer application</li>
                                            <li>Improved water management</li>
                                        </ul>
                                        <div class="tech-impact">
                                            <span class="impact-value">-18% Input Cost</span>
                                            <span class="impact-desc">With same output</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Livestock Page -->
                <div id="livestockPage" class="page">
                    <div class="page-header">
                        <h2>Livestock Integration Management</h2>
                        <div class="header-actions">
                            <button id="addLivestockBtn" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Livestock
                            </button>
                        </div>
                    </div>
                    
                    <div class="livestock-content">
                        <div class="livestock-overview">
                            <div class="livestock-card">
                                <i class="fas fa-horse-head"></i>
                                <div class="livestock-content">
                                    <h3>Carabaos</h3>
                                    <p>Draft Animals for Farming</p>
                                    <div class="livestock-stats">
                                        <span class="stat">Total: 342</span>
                                        <span class="stat">Active: 298</span>
                                        <span class="stat">Health Score: 92%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="livestock-card">
                                <i class="fas fa-kiwi-bird"></i>
                                <div class="livestock-content">
                                    <h3>Poultry</h3>
                                    <p>Rice Field Integration</p>
                                    <div class="livestock-stats">
                                        <span class="stat">Total: 1,245</span>
                                        <span class="stat">Farms: 156</span>
                                        <span class="stat">Integration Rate: 78%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="livestock-card">
                                <i class="fas fa-piggy-bank"></i>
                                <div class="livestock-content">
                                    <h3>Other Livestock</h3>
                                    <p>Additional Farm Animals</p>
                                    <div class="livestock-stats">
                                        <span class="stat">Pigs: 89</span>
                                        <span class="stat">Goats: 67</span>
                                        <span class="stat">Cattle: 42</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Crowdfunding Page -->
                <div id="crowdfundingPage" class="page">
                    <div class="page-header">
                        <h2>Community Support & Funding</h2>
                        <button id="createCampaignBtn" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Campaign
                        </button>
                    </div>
                    
                    <div class="crowdfunding-content">
                        <div class="impact-overview">
                            <div class="impact-card">
                                <i class="fas fa-hand-holding-heart"></i>
                                <div class="impact-content">
                                    <h3>₱18.2M</h3>
                                    <p>Total Community Funding</p>
                                </div>
                            </div>
                            <div class="impact-card">
                                <i class="fas fa-tractor"></i>
                                <div class="impact-content">
                                    <h3>156%</h3>
                                    <p>Average Yield Increase</p>
                                </div>
                            </div>
                            <div class="impact-card">
                                <i class="fas fa-users"></i>
                                <div class="impact-content">
                                    <h3>8,452</h3>
                                    <p>Active Supporters</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="campaigns-section">
                            <h3>Active Rice Farming Campaigns</h3>
                            <div class="campaigns-grid" id="campaignsGrid">
                                <!-- Campaigns will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Analytics Page -->
<div id="analyticsPage" class="page">
    <div class="page-header">
        <h2>Advanced Analytics & Insights</h2>
        <div class="timeframe-selector">
            <button class="btn btn-outline active">Current Season</button>
            <button class="btn btn-outline">Yearly Comparison</button>
            <button class="btn btn-outline">Regional Analysis</button>
        </div>
    </div>
    
    <div class="analytics-content">
        <!-- Key Metrics Overview -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">4.8</span>
                    <span class="stat-label">Avg Yield (tons/ha)</span>
                    <span class="stat-trend positive">+12% vs 2023</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">₱28.5K</span>
                    <span class="stat-label">Avg Production Cost/ha</span>
                    <span class="stat-trend negative">+8% vs 2023</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">78%</span>
                    <span class="stat-label">Tech Adoption Rate</span>
                    <span class="stat-trend positive">+15% vs 2023</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tint"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">1,250</span>
                    <span class="stat-label">Rainfall (mm)</span>
                    <span class="stat-trend positive">+6% vs avg</span>
                </div>
            </div>
        </div>

        <!-- First Row: Cost Analysis & Regional Yield -->
        <div class="content-row">
            <div class="content-card">
                <div class="card-header">
                    <h3>Production Cost Breakdown</h3>
                    <div class="card-actions">
                        <select class="chart-filter">
                            <option>2024 Season</option>
                            <option>2023 Season</option>
                            <option>5-Year Avg</option>
                        </select>
                    </div>
                </div>
                <canvas id="costAnalysisChart"></canvas>
                <div class="chart-insights">
                    <div class="insight-item">
                        <span class="insight-label">Largest Cost:</span>
                        <span class="insight-value">Labor (42%)</span>
                    </div>
                    <div class="insight-item">
                        <span class="insight-label">Cost Reduction:</span>
                        <span class="insight-value positive">-8% in Fertilizer</span>
                    </div>
                </div>
            </div>
            
            <div class="content-card">
                <div class="card-header">
                    <h3>Regional Yield Comparison</h3>
                    <div class="card-actions">
                        <select class="chart-filter">
                            <option>Current Season</option>
                            <option>Last Season</option>
                            <option>Yearly Avg</option>
                        </select>
                    </div>
                </div>
                <canvas id="regionalYieldChart"></canvas>
                <div class="chart-insights">
                    <div class="insight-item">
                        <span class="insight-label">Top Region:</span>
                        <span class="insight-value">Central Luzon (5.2t/ha)</span>
                    </div>
                    <div class="insight-item">
                        <span class="insight-label">Growth Leader:</span>
                        <span class="insight-value positive">Mindanao (+18%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: Technology Adoption & Input Efficiency -->
        <div class="content-row">
            <div class="content-card large">
                <div class="card-header">
                    <h3>Technology Adoption Timeline</h3>
                    <div class="card-actions">
                        <button class="btn btn-sm btn-outline">5 Years</button>
                        <button class="btn btn-sm btn-outline active">3 Years</button>
                        <button class="btn btn-sm btn-outline">Current</button>
                    </div>
                </div>
                <canvas id="technologyAdoptionChart"></canvas>
                <div class="chart-details">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <span class="detail-label">Mobile Monitoring</span>
                            <span class="detail-value">85% adoption</span>
                            <div class="progress-bar small">
                                <div class="progress-fill" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Precision Farming</span>
                            <span class="detail-value">72% adoption</span>
                            <div class="progress-bar small">
                                <div class="progress-fill" style="width: 72%"></div>
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Digital Records</span>
                            <span class="detail-value">68% adoption</span>
                            <div class="progress-bar small">
                                <div class="progress-fill" style="width: 68%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-card">
                <div class="card-header">
                    <h3>Input Efficiency</h3>
                    <div class="card-actions">
                        <span class="efficiency-badge positive">+15%</span>
                    </div>
                </div>
                <canvas id="inputEfficiencyChart"></canvas>
                <div class="efficiency-metrics">
                    <div class="metric-comparison">
                        <div class="comparison-item">
                            <span class="comparison-label">Water Usage</span>
                            <span class="comparison-value positive">-12%</span>
                        </div>
                        <div class="comparison-item">
                            <span class="comparison-label">Fertilizer</span>
                            <span class="comparison-value positive">-8%</span>
                        </div>
                        <div class="comparison-item">
                            <span class="comparison-label">Labor Hours</span>
                            <span class="comparison-value positive">-15%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Row: Rainfall Impact & Pest Analysis -->
        <div class="content-row">
            <div class="content-card large">
                <div class="card-header">
                    <h3>Rainfall Impact Analysis</h3>
                    <div class="card-actions">
                        <select class="chart-filter">
                            <option>2024 Season</option>
                            <option>2023 Season</option>
                            <option>5-Year Trend</option>
                        </select>
                    </div>
                </div>
                <canvas id="rainfallImpactChart"></canvas>
                <div class="impact-analysis">
                    <div class="analysis-grid">
                        <div class="analysis-card">
                            <h4>Optimal Rainfall</h4>
                            <div class="analysis-value">1,100-1,400mm</div>
                            <div class="analysis-note">Ideal for rice growth</div>
                        </div>
                        <div class="analysis-card">
                            <h4>Current Season</h4>
                            <div class="analysis-value positive">1,250mm</div>
                            <div class="analysis-note">Within optimal range</div>
                        </div>
                        <div class="analysis-card">
                            <h4>Yield Correlation</h4>
                            <div class="analysis-value">R² = 0.78</div>
                            <div class="analysis-note">Strong positive correlation</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fourth Row: Seasonal Trends & Profitability -->
        <div class="content-row">
            <div class="content-card">
                <div class="card-header">
                    <h3>Seasonal Yield Trends</h3>
                    <div class="card-actions">
                        <span class="trend-badge positive">↑ 12%</span>
                    </div>
                </div>
                <canvas id="seasonalTrendChart"></canvas>
                <div class="trend-analysis">
                    <div class="trend-item">
                        <span class="trend-period">Dry Season 2024</span>
                        <span class="trend-value positive">4.8t/ha</span>
                    </div>
                    <div class="trend-item">
                        <span class="trend-period">Wet Season 2023</span>
                        <span class="trend-value">4.3t/ha</span>
                    </div>
                </div>
            </div>
            
            <div class="content-card">
                <div class="card-header">
                    <h3>Profitability Analysis</h3>
                    <div class="card-actions">
                        <span class="profit-badge positive">+22%</span>
                    </div>
                </div>
                <canvas id="profitabilityChart"></canvas>
                <div class="profit-metrics">
                    <div class="profit-item">
                        <span class="profit-label">Revenue/ha</span>
                        <span class="profit-value">₱44,700</span>
                    </div>
                    <div class="profit-item">
                        <span class="profit-label">Cost/ha</span>
                        <span class="profit-value">₱28,500</span>
                    </div>
                    <div class="profit-item">
                        <span class="profit-label">Net Profit</span>
                        <span class="profit-value positive">₱16,200</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fifth Row: Detailed Insights -->
        <div class="content-row">
            <div class="content-card large">
                <h3>Key Insights & Recommendations</h3>
                <div class="insights-grid">
                    <div class="insight-card positive">
                        <div class="insight-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="insight-content">
                            <h4>Technology Adoption Success</h4>
                            <p>Farmers using mobile monitoring show 25% higher yields than traditional methods</p>
                            <span class="insight-impact">Impact: High</span>
                        </div>
                    </div>
                    <div class="insight-card warning">
                        <div class="insight-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="insight-content">
                            <h4>Labor Cost Optimization</h4>
                            <p>Labor remains the largest cost component at 42%. Consider mechanization options</p>
                            <span class="insight-impact">Impact: Medium</span>
                        </div>
                    </div>
                    <div class="insight-card info">
                        <div class="insight-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="insight-content">
                            <h4>Regional Best Practices</h4>
                            <p>Central Luzon farmers achieve highest yields through precision water management</p>
                            <span class="insight-impact">Impact: High</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                <!-- Community Page -->
                <div id="communityPage" class="page">
                    <div class="page-header">
                        <h2>Farmer Community & Knowledge Sharing</h2>
                        <div class="community-filters">
                            <select id="regionFilter">
                                <option value="">All Regions</option>
                                <option value="luzon">Luzon</option>
                                <option value="visayas">Visayas</option>
                                <option value="mindanao">Mindanao</option>
                            </select>
                            <select id="yieldFilter">
                                <option value="">All Yield Levels</option>
                                <option value="high">High Yield (100+ cavans/ha)</option>
                                <option value="medium">Medium Yield (70-99 cavans/ha)</option>
                                <option value="low">Low Yield (below 70 cavans/ha)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="community-content">
                        <div class="leaderboard-section">
                            <h3>Community Leaderboard</h3>
                            <div class="leaderboard" id="leaderboard">
                                <!-- Leaderboard will be loaded here -->
                            </div>
                        </div>
                        
                        <div class="knowledge-section">
                            <h3>Shared Best Practices</h3>
                            <div class="knowledge-grid" id="knowledgeGrid">
                                <!-- Knowledge items will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Profile Page -->
            <div id="profilePage" class="page">
                <div class="page-header">
                    <h2>Farmer Profile & Settings</h2>
                </div>
                
                    <div class="profile-content">
                        <div class="profile-card comprehensive">
                            <div class="profile-header">
                                <div class="avatar-section">
                                    <div class="avatar-upload">
                                        <div class="avatar-preview" id="avatarPreview">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <input type="file" id="avatarInput" accept="image/*" class="hidden">
                                        <button class="btn btn-outline" id="changeAvatarBtn">Update Photo</button>
                                    </div>
                                </div>
                            <div class="profile-info">
                                <h3 id="profileName"><?php echo htmlspecialchars($userProfile['full_name'] ?? $_SESSION['user_name'] ?? 'User'); ?></h3>
                                <p id="profileRole">Rice Farmer - <?php echo htmlspecialchars($userProfile['years_experience'] ?? '0'); ?> years experience</p>
                                <div class="profile-badges">
                                    <span class="badge verified">Verified Farmer</span>
                                    <?php if (($userProfile['years_experience'] ?? 0) > 10): ?>
                                        <span class="badge expert">Expert Farmer</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                             <div class="profile-tabs">
                                <div class="profile-tab active" data-tab="personal">Personal Info</div>
                                <div class="profile-tab" data-tab="farming">Farming Details</div>
                                <div class="profile-tab" data-tab="settings">Settings</div>
                            </div>   
                        <div class="profile-details">
                            <h4>Farm Information</h4>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Farm Location:</label>
                                    <span><?php echo htmlspecialchars($userProfile['farm_location'] ?? 'Not set'); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Farm Size:</label>
                                    <span><?php echo htmlspecialchars($userProfile['farm_size'] ?? '0'); ?> hectares</span>
                                </div>
                                <div class="detail-item">
                                    <label>Farming Method:</label>
                                    <span><?php echo htmlspecialchars($userProfile['farming_method'] ?? 'Not specified'); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Land Ownership:</label>
                                    <span><?php echo htmlspecialchars($userProfile['land_ownership'] ?? 'Not specified'); ?></span>
                                </div>
                                <div class="detail-item">
                                    <label>Rice Varieties:</label>
                                    <span><?php echo htmlspecialchars($userProfile['varieties'] ?? 'Not specified'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Add Farmer Modal -->
<div id="addFarmerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Register New Farmer</h2>
            <span class="close">&times;</span>
        </div>
        <form id="addFarmerForm" action="<?php echo BASE_URL; ?>/farmers/add" method="POST">
            <div class="form-group">
                <label for="farmerName">Full Name *</label>
                <input type="text" id="farmerName" name="full_name" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="farmerExperience">Years of Experience</label>
                    <input type="number" id="farmerExperience" name="years_experience" min="0" max="50">
                </div>
                <div class="form-group">
                    <label for="farmSize">Farm Size (hectares) *</label>
                    <input type="number" id="farmSize" name="farm_size" step="0.1" min="0" required>
                </div>
            </div>
            <div class="form-group">
                <label for="farmerLocation">Farm Location *</label>
                <input type="text" id="farmerLocation" name="farm_location" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="farmingMethod">Farming Method</label>
                    <select id="farmingMethod" name="farming_method">
                        <option value="">Select Method</option>
                        <option value="Traditional">Traditional</option>
                        <option value="Organic">Organic</option>
                        <option value="Modern">Modern</option>
                        <option value="Hybrid">Hybrid</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="landOwnership">Land Ownership</label>
                    <select id="landOwnership" name="land_ownership">
                        <option value="">Select Ownership</option>
                        <option value="Owned">Owned</option>
                        <option value="Leased">Leased</option>
                        <option value="Rented">Rented</option>
                        <option value="Ancestral">Ancestral</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="riceVarieties">Rice Varieties (comma-separated)</label>
                <input type="text" id="riceVarieties" name="varieties" placeholder="e.g., Jasmine, Sinandomeng, IR64">
            </div>
            <div class="form-actions">
                <button type="button" id="cancelFarmer" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Register Farmer</button>
            </div>
        </form>
    </div>
</div>
    <!-- Add Farmer Modal -->
    <div id="addFarmerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Register New Farmer</h2>
                <span class="close">&times;</span>
            </div>
            <form id="addFarmerForm">
                <div class="form-group">
                    <label for="farmerName">Full Name *</label>
                    <input type="text" id="farmerName" name="farmerName" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="farmerExperience">Years of Experience</label>
                        <input type="number" id="farmerExperience" name="farmerExperience" min="0" max="50">
                    </div>
                    <div class="form-group">
                        <label for="farmSize">Farm Size (hectares) *</label>
                        <input type="number" id="farmSize" name="farmSize" step="0.1" min="0" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="farmerLocation">Farm Location *</label>
                    <input type="text" id="farmerLocation" name="farmerLocation" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="farmingMethod">Farming Method</label>
                        <select id="farmingMethod" name="farmingMethod">
                            <option value="">Select Method</option>
                            <option value="Traditional">Traditional</option>
                            <option value="Organic">Organic</option>
                            <option value="Modern">Modern</option>
                            <option value="Hybrid">Hybrid</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="landOwnership">Land Ownership</label>
                        <select id="landOwnership" name="landOwnership">
                            <option value="">Select Ownership</option>
                            <option value="Owned">Owned</option>
                            <option value="Leased">Leased</option>
                            <option value="Rented">Rented</option>
                            <option value="Ancestral">Ancestral</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="riceVarieties">Rice Varieties</label>
                    <select id="riceVarieties" name="riceVarieties" multiple>
                        <option value="IR64">IR64</option>
                        <option value="Sinandomeng">Sinandomeng</option>
                        <option value="Jasmine">Jasmine</option>
                        <option value="Hybrid">Hybrid</option>
                        <option value="Traditional">Traditional</option>
                    </select>
                    <small>Hold Ctrl/Cmd to select multiple varieties</small>
                </div>
                <div class="form-actions">
                    <button type="button" id="cancelFarmer" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Register Farmer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Create Campaign Modal -->
<div id="campaignModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Create New Campaign</h3>
            <span class="close">&times;</span>
        </div>
        <form id="campaignForm" class="modal-form">
            <div class="form-group">
                <label for="campaignTitle">Campaign Title *</label>
                <input type="text" id="campaignTitle" name="title" required placeholder="e.g., Rice Farming Expansion Project">
            </div>
            
            <div class="form-group">
                <label for="campaignDescription">Description *</label>
                <textarea id="campaignDescription" name="description" required placeholder="Describe your campaign goals and how funds will be used..." rows="4"></textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="campaignType">Campaign Type *</label>
                    <select id="campaignType" name="campaign_type" required>
                        <option value="">Select Type</option>
                        <option value="Equipment">Equipment</option>
                        <option value="Infrastructure">Infrastructure</option>
                        <option value="Seeds">Seeds & Inputs</option>
                        <option value="Irrigation">Irrigation</option>
                        <option value="Expansion">Farm Expansion</option>
                        <option value="Sustainability">Sustainability</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fundingGoal">Funding Goal (₱) *</label>
                    <input type="number" id="fundingGoal" name="funding_goal" required min="1000" step="1000" placeholder="50000">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="campaignDeadline">Deadline *</label>
                    <input type="date" id="campaignDeadline" name="deadline" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>
                
                <div class="form-group">
                    <label for="farmerSelect">Associated Farmer</label>
                    <select id="farmerSelect" name="farmer_id">
                        <option value="">Select Farmer</option>
                        <!-- Farmers will be populated dynamically -->
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn btn-outline" id="cancelCampaign">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create Campaign
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Data Storage and State Management
let appState = {
    currentUser: null,
    farmers: [],
    campaigns: [],
    activities: [],
    currentPage: 'overview',
    isAuthenticated: false,
    seasonalData: {},
    monitoringData: {},
    analyticsData: {}
};

// Chart instances storage
const chartInstances = {};

// Initialize the application
function initApp() {
    console.log('Initializing FarmStat application...');
    setupEventListeners();
    
    // Check if user is logged in (demo mode)
    if (localStorage.getItem('farmstat_user')) {
        const userData = JSON.parse(localStorage.getItem('farmstat_user'));
        appState.currentUser = userData;
        appState.isAuthenticated = true;
        showDashboard();
    } else {
        showLandingPage();
    }
    
    // Load initial data
    loadInitialData();
}

// Setup event listeners
function setupEventListeners() {
    // Auth Modal
    document.getElementById('showLogin')?.addEventListener('click', () => showAuthModal('login'));
    document.getElementById('showSignup')?.addEventListener('click', () => showAuthModal('signup'));
    
    // Auth Tabs
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', (e) => {
            const tabName = e.target.getAttribute('data-tab');
            switchAuthTab(tabName);
        });
    });
    
    // Auth Forms
    document.getElementById('loginForm')?.addEventListener('submit', handleLogin);
    document.getElementById('signupForm')?.addEventListener('submit', handleSignup);
    
    // Navigation
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', (e) => {
            const page = e.currentTarget.getAttribute('data-page');
            switchPage(page);
        });
    });
    
    // Logout
    document.getElementById('logoutBtn')?.addEventListener('click', handleLogout);
    
    // Farmer Management
    document.getElementById('addFarmerBtn')?.addEventListener('click', () => showModal('addFarmerModal'));
    document.getElementById('addFarmerBtnEmpty')?.addEventListener('click', () => showModal('addFarmerModal'));
    document.getElementById('addFarmerForm')?.addEventListener('submit', handleAddFarmer);
    
    // Campaign Management
    document.getElementById('createCampaignBtn')?.addEventListener('click', () => showModal('createCampaignModal'));
    document.getElementById('createCampaignForm')?.addEventListener('submit', handleCreateCampaign);
    
    // Modal Close Events
    document.querySelectorAll('.modal .close').forEach(closeBtn => {
        closeBtn.addEventListener('click', (e) => {
            const modal = e.target.closest('.modal');
            hideModal(modal.id);
        });
    });
    
    // Modal Cancel Buttons
    document.getElementById('cancelFarmer')?.addEventListener('click', () => hideModal('addFarmerModal'));
    document.getElementById('cancelCampaign')?.addEventListener('click', () => hideModal('createCampaignModal'));
    
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal(modal.id);
            }
        });
    });
    
    // Landing Page CTA Buttons
    document.getElementById('heroSignup')?.addEventListener('click', () => showAuthModal('signup'));
    document.getElementById('heroDemo')?.addEventListener('click', showDemo);
    document.getElementById('ctaFarmer')?.addEventListener('click', () => showAuthModal('signup'));
    document.getElementById('ctaSupporter')?.addEventListener('click', () => showAuthModal('signup'));
    
    // Profile Page Tabs
    document.querySelectorAll('.profile-tab').forEach(tab => {
        tab.addEventListener('click', (e) => {
            const tabName = e.target.getAttribute('data-tab');
            switchProfileTab(tabName);
        });
    });
    
    // Profile Form
    document.getElementById('profileForm')?.addEventListener('submit', handleProfileUpdate);
    
    // Avatar Upload
    document.getElementById('changeAvatarBtn')?.addEventListener('click', () => {
        document.getElementById('avatarInput').click();
    });
    
    document.getElementById('avatarInput')?.addEventListener('change', handleAvatarUpload);

    // Season Selector
    document.getElementById('seasonSelect')?.addEventListener('change', function() {
        loadSeasonalData(this.value);
    });

    // Timeframe Selector
    document.querySelectorAll('.timeframe-selector .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.timeframe-selector .btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadAnalyticsData(this.textContent.toLowerCase());
        });
    });
}

// Profile Tab Switching
function switchProfileTab(tabName) {
    // Update active tab
    document.querySelectorAll('.profile-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
    
    // Update active content
    document.querySelectorAll('.tab-pane').forEach(pane => {
        pane.classList.remove('active');
    });
    document.getElementById(`${tabName}Tab`).classList.add('active');
}

// Profile Handlers
function handleProfileUpdate(e) {
    e.preventDefault();
    
    if (appState.currentUser) {
        const formData = {
            name: document.getElementById('profileFullName').value,
            email: document.getElementById('profileEmailInput').value,
            phone: document.getElementById('profilePhone').value,
            location: document.getElementById('profileLocation').value,
            bio: document.getElementById('profileBio').value
        };
        
        // Update user data in localStorage
        const updatedUser = { ...appState.currentUser, ...formData };
        localStorage.setItem('farmstat_user', JSON.stringify(updatedUser));
        appState.currentUser = updatedUser;
        
        updateUserWelcome();
        showNotification('Profile updated successfully!', 'success');
    }
}

function handleAvatarUpload(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const avatarPreview = document.getElementById('avatarPreview');
            avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Profile Avatar">`;
            showNotification('Profile picture updated!', 'success');
            
            // Update user data
            if (appState.currentUser) {
                const updatedUser = { ...appState.currentUser, avatar: e.target.result };
                localStorage.setItem('farmstat_user', JSON.stringify(updatedUser));
                appState.currentUser = updatedUser;
            }
        };
        reader.readAsDataURL(file);
    }
}

// Enhanced Chart Initialization with Error Handling
function initCharts() {
    // Only initialize charts for visible elements
    const chartInitializers = {
        varietyChart: createVarietyChart,
        pestChart: createPestChart,
        seasonComparisonChart: createSeasonComparisonChart,
        yieldTrendChart: createYieldTrendChart,
        costAnalysisChart: createCostAnalysisChart,
        regionalYieldChart: createRegionalYieldChart,
        technologyAdoptionChart: createTechnologyAdoptionChart,
        rainfallImpactChart: createRainfallImpactChart
    };

    Object.entries(chartInitializers).forEach(([chartId, initializer]) => {
        const canvas = document.getElementById(chartId);
        if (canvas && canvas.getContext) {
            try {
                // Destroy existing chart if it exists
                if (chartInstances[chartId]) {
                    chartInstances[chartId].destroy();
                }
                chartInstances[chartId] = initializer();
            } catch (error) {
                console.warn(`Failed to initialize chart ${chartId}:`, error);
            }
        }
    });
}

// Page-specific chart initializers
function initOverviewCharts() {
    createVarietyChart();
    createRegionalYieldChart();
}

function initSeasonalCharts() {
    createSeasonComparisonChart();
    createYieldTrendChart();
    createTechnologyAdoptionChart();
    createRainfallImpactChart();
}

function initMonitoringCharts() {
    createPestChart();
}

function initAnalyticsCharts() {
    createCostAnalysisChart();
    createRegionalYieldChart();
    createTechnologyAdoptionChart();
    createRainfallImpactChart();
}

// Individual Chart Creation Functions with Demo Data
function createVarietyChart() {
    const ctx = document.getElementById('varietyChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Jasmine Rice', 'Sinandomeng', 'IR64', 'Hybrid Varieties', 'Traditional'],
            datasets: [{
                data: [45, 30, 15, 8, 2],
                backgroundColor: [
                    '#4a7c59',
                    '#8db596',
                    '#d4af37',
                    '#ff9a3d',
                    '#1a4d2e'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                title: {
                    display: true,
                    text: 'Rice Variety Distribution',
                    font: { size: 16 }
                }
            },
            cutout: '60%'
        }
    });
}

function createPestChart() {
    const ctx = document.getElementById('pestChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Brown Planthopper', 'Rice Blast', 'Stem Borer', 'Leaf Folder'],
            datasets: [{
                label: 'Incidence Rate (%)',
                data: [15, 8, 3, 12],
                backgroundColor: [
                    '#ff9a3d',
                    '#d4af37',
                    '#4a7c59',
                    '#8db596'
                ],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 20,
                    title: {
                        display: true,
                        text: 'Incidence Rate (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Pest Type'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Current Pest Incidence',
                    font: { size: 16 }
                }
            }
        }
    });
}

function createSeasonComparisonChart() {
    const ctx = document.getElementById('seasonComparisonChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['2020', '2021', '2022', '2023', '2024'],
            datasets: [
                {
                    label: 'Yield (tons/ha)',
                    data: [3.2, 3.5, 4.1, 4.8, 5.2],
                    borderColor: '#4a7c59',
                    backgroundColor: 'rgba(74, 124, 89, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y'
                },
                {
                    label: 'Production Cost (₱ thousands)',
                    data: [22, 24, 26, 27, 28.5],
                    borderColor: '#d4af37',
                    backgroundColor: 'rgba(212, 175, 55, 0.1)',
                    tension: 0.4,
                    fill: false,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Yield (tons/ha)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Cost (₱ thousands)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Yield vs Cost Over 5 Years',
                    font: { size: 16 }
                }
            }
        }
    });
}

function createYieldTrendChart() {
    const ctx = document.getElementById('yieldTrendChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['2020 Dry', '2021 Dry', '2022 Dry', '2023 Dry', '2024 Dry'],
            datasets: [{
                label: 'Yield (tons/ha)',
                data: [3.2, 3.5, 4.1, 4.8, 5.2],
                backgroundColor: ['#8db596', '#8db596', '#8db596', '#8db596', '#4a7c59'],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Yield (tons/ha)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Seasonal Yield Performance',
                    font: { size: 16 }
                }
            }
        }
    });
}

function createCostAnalysisChart() {
    const ctx = document.getElementById('costAnalysisChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Seeds', 'Fertilizers', 'Labor', 'Equipment', 'Others'],
            datasets: [{
                data: [4500, 8500, 12000, 4500, 3500],
                backgroundColor: [
                    '#4a7c59',
                    '#8db596',
                    '#d4af37',
                    '#ff9a3d',
                    '#1a4d2e'
                ],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20
                    }
                },
                title: {
                    display: true,
                    text: 'Production Cost Breakdown',
                    font: { size: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const percentages = [16, 30, 42, 16, 12];
                            const label = context.label;
                            const value = context.raw;
                            const percentage = percentages[context.dataIndex];
                            return `${label}: ₱${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

function createRegionalYieldChart() {
    const ctx = document.getElementById('regionalYieldChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Nueva Ecija', 'Isabela', 'Tarlac', 'Pangasinan', 'Bulacan', 'Pampanga'],
            datasets: [{
                label: 'Average Yield (tons/ha)',
                data: [4.8, 4.2, 5.1, 3.9, 4.1, 4.3],
                backgroundColor: ['#4a7c59', '#8db596', '#4a7c59', '#8db596', '#4a7c59', '#8db596'],
                borderWidth: 0,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Yield (tons/ha)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Regional Yield Comparison',
                    font: { size: 16 }
                }
            }
        }
    });
}

function createTechnologyAdoptionChart() {
    const ctx = document.getElementById('technologyAdoptionChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: [2020, 2021, 2022, 2023, 2024],
            datasets: [{
                label: 'Technology Adoption Rate (%)',
                data: [15, 22, 45, 65, 78],
                borderColor: '#ff9a3d',
                backgroundColor: 'rgba(255, 154, 61, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Adoption Rate (%)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Technology Adoption Timeline',
                    font: { size: 16 }
                }
            }
        }
    });
}

function createRainfallImpactChart() {
    const ctx = document.getElementById('rainfallImpactChart');
    if (!ctx || !ctx.getContext) return null;
    
    return new Chart(ctx, {
        type: 'scatter',
        data: {
            datasets: [{
                label: 'Rainfall vs Yield',
                data: [
                    { x: 1100, y: 3.2 },
                    { x: 1050, y: 3.5 },
                    { x: 1200, y: 4.1 },
                    { x: 1180, y: 4.8 },
                    { x: 1250, y: 5.2 }
                ],
                backgroundColor: '#4a7c59',
                pointRadius: 8,
                pointHoverRadius: 10
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Rainfall (mm)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Yield (tons/ha)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Rainfall Impact on Yield',
                    font: { size: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const years = [2020, 2021, 2022, 2023, 2024];
                            const point = context.raw;
                            const year = years[context.dataIndex];
                            return `${year}: ${point.y} tons/ha at ${point.x}mm rainfall`;
                        }
                    }
                }
            }
        }
    });
}

// Enhanced Page Rendering Functions
function renderSeasonalTracking() {
    const container = document.getElementById('seasonalTrackingPage');
    if (!container) return;
    
    const metricsContainer = container.querySelector('.metrics-grid');
    if (metricsContainer) {
        metricsContainer.innerHTML = `
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-title">Average Yield</span>
                    <span class="metric-trend positive">+15%</span>
                </div>
                <div class="metric-value">4.8 tons/ha</div>
                <div class="metric-period">5-Year Average</div>
            </div>
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-title">Production Cost</span>
                    <span class="metric-trend negative">+8%</span>
                </div>
                <div class="metric-value">₱28,500/ha</div>
                <div class="metric-period">Current Season</div>
            </div>
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-title">Profit Margin</span>
                    <span class="metric-trend positive">+22%</span>
                </div>
                <div class="metric-value">₱16,200/ha</div>
                <div class="metric-period">5-Year Improvement</div>
            </div>
            <div class="metric-card">
                <div class="metric-header">
                    <span class="metric-title">Technology Adoption</span>
                    <span class="metric-trend positive">+65%</span>
                </div>
                <div class="metric-value">78%</div>
                <div class="metric-period">Since 2020</div>
            </div>
        `;
    }
}

function renderRiceMonitoring() {
    const container = document.getElementById('riceMonitoringPage');
    if (!container) return;
    
    // Update fertilizer progress
    const inputGrid = container.querySelector('.input-grid');
    if (inputGrid) {
        inputGrid.innerHTML = `
            <div class="input-item">
                <span class="input-name">Urea (Nitrogen)</span>
                <span class="input-usage">85% applied</span>
                <div class="progress-bar small">
                    <div class="progress-fill" style="width: 85%"></div>
                </div>
                <span class="input-details">120 kg/ha, Split Application</span>
            </div>
            <div class="input-item">
                <span class="input-name">Complete (14-14-14)</span>
                <span class="input-usage">72% applied</span>
                <div class="progress-bar small">
                    <div class="progress-fill" style="width: 72%"></div>
                </div>
                <span class="input-details">90 kg/ha, Basal Application</span>
            </div>
            <div class="input-item">
                <span class="input-name">Organic Fertilizer</span>
                <span class="input-usage">45% applied</span>
                <div class="progress-bar small">
                    <div class="progress-fill" style="width: 45%"></div>
                </div>
                <span class="input-details">2 tons/ha, Farmyard Manure</span>
            </div>
            <div class="input-item">
                <span class="input-name">Potassium (K₂O)</span>
                <span class="input-usage">60% applied</span>
                <div class="progress-bar small">
                    <div class="progress-fill" style="width: 60%"></div>
                </div>
                <span class="input-details">60 kg/ha, Panicle Initiation</span>
            </div>
        `;
    }
    
    // Update pest alerts
    const alertList = container.querySelector('.alert-list');
    if (alertList) {
        alertList.innerHTML = `
            <div class="alert-item warning">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Brown Planthopper - Moderate Incidence (15% fields)</span>
            </div>
            <div class="alert-item info">
                <i class="fas fa-info-circle"></i>
                <span>Rice Blast - Low Incidence (8% fields)</span>
            </div>
            <div class="alert-item safe">
                <i class="fas fa-check-circle"></i>
                <span>Stem Borer - Under Control (3% fields)</span>
            </div>
        `;
    }
    
    // Update yield prediction
    const predictionOverview = container.querySelector('.prediction-overview');
    if (predictionOverview) {
        predictionOverview.innerHTML = `
            <div class="prediction-card">
                <h4>Expected Yield</h4>
                <div class="prediction-value">4.2 tons/ha</div>
                <div class="prediction-confidence">85% Confidence</div>
            </div>
            <div class="prediction-card">
                <h4>Compared to Last Season</h4>
                <div class="prediction-value positive">+12%</div>
                <div class="prediction-note">Improved practices</div>
            </div>
            <div class="prediction-card">
                <h4>Harvest Readiness</h4>
                <div class="prediction-value">32 days</div>
                <div class="prediction-note">Until optimal harvest</div>
            </div>
        `;
    }
}

// Utility Functions
function getAlertIcon(status) {
    const icons = {
        warning: 'exclamation-triangle',
        info: 'info-circle',
        safe: 'check-circle'
    };
    return icons[status] || 'info-circle';
}

// Auth Modal Functions
function showAuthModal(tab = 'login') {
    document.getElementById('authModal').style.display = 'flex';
    switchAuthTab(tab);
}

function hideAuthModal() {
    document.getElementById('authModal').style.display = 'none';
}

function switchAuthTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
    
    document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
    document.getElementById(`${tab}Form`).classList.add('active');
}

// Auth Handlers
function handleLogin(e) {
    e.preventDefault();
    console.log('Login attempt...');
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    // Demo authentication - in real app, this would be a server call
    if (email && password) {
        const userData = {
            id: 1,
            name: email.split('@')[0],
            email: email,
            role: 'farmer'
        };
        
        appState.currentUser = userData;
        appState.isAuthenticated = true;
        
        // Save to localStorage for persistence
        localStorage.setItem('farmstat_user', JSON.stringify(userData));
        
        showNotification('Login successful!', 'success');
        hideAuthModal();
        showDashboard();
    } else {
        showNotification('Please enter email and password', 'error');
    }
}

function handleSignup(e) {
    e.preventDefault();
    
    const name = document.getElementById('signupName').value;
    const email = document.getElementById('signupEmail').value;
    const password = document.getElementById('signupPassword').value;
    const confirmPassword = document.getElementById('signupConfirm').value;
    const role = document.getElementById('signupRole').value;
    
    if (password !== confirmPassword) {
        showNotification('Passwords do not match', 'error');
        return;
    }
    
    // Demo registration
    const userData = {
        id: Date.now(),
        name: name,
        email: email,
        role: role
    };
    
    appState.currentUser = userData;
    appState.isAuthenticated = true;
    
    // Save to localStorage for persistence
    localStorage.setItem('farmstat_user', JSON.stringify(userData));
    
    showNotification('Account created successfully!', 'success');
    hideAuthModal();
    showDashboard();
}

function handleLogout() {
    appState.currentUser = null;
    appState.isAuthenticated = false;
    localStorage.removeItem('farmstat_user');
    showLandingPage();
    showNotification('Logged out successfully', 'success');
}

// Update user welcome message
function updateUserWelcome() {
    if (appState.currentUser) {
        const userWelcome = document.getElementById('userWelcome');
        const profileName = document.getElementById('profileName');
        const profileFullName = document.getElementById('profileFullName');
        const profileEmailInput = document.getElementById('profileEmailInput');
        
        if (userWelcome) {
            userWelcome.textContent = `Welcome, ${appState.currentUser.name}`;
        }
        if (profileName) {
            profileName.textContent = appState.currentUser.name;
        }
        if (profileFullName) {
            profileFullName.value = appState.currentUser.name;
        }
        if (profileEmailInput) {
            profileEmailInput.value = appState.currentUser.email;
        }
        
        console.log('Updated user welcome for:', appState.currentUser.name);
    }
}

function loadInitialData() {
    if (appState.isAuthenticated) {
        loadDashboardData();
        loadFarmersData();
        loadCampaignsData();
    }
}

// Page Navigation
function switchPage(page) {
    // Remove active class from all nav items and pages
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
    });
    document.querySelectorAll('.page').forEach(pageElement => {
        pageElement.classList.remove('active');
    });
    
    // Add active class to clicked nav item and corresponding page
    const targetNav = document.querySelector(`[data-page="${page}"]`);
    if (targetNav) {
        targetNav.classList.add('active');
    }
    
    const targetPageElement = document.getElementById(page + 'Page');
    if (targetPageElement) {
        targetPageElement.classList.add('active');
    }
    
    // Update page title
    const pageTitles = {
        overview: 'Rice Farming Intelligence Dashboard',
        farmers: 'Rice Farmer Management',
        riceMonitoring: 'Rice Farming Monitoring',
        seasonalTracking: 'Multi-Season Analytics',
        livestock: 'Livestock Integration Management',
        crowdfunding: 'Community Support & Funding',
        analytics: 'Advanced Analytics & Insights',
        community: 'Farmer Community & Knowledge Sharing',
        profile: 'Farmer Profile & Settings'
    };
    
    document.getElementById('pageTitle').textContent = pageTitles[page] || 'FarmStat Dashboard';
    appState.currentPage = page;
    
    // Load page-specific data and charts with delay to ensure DOM is ready
    setTimeout(() => {
        switch (page) {
            case 'overview':
                loadDashboardData();
                initOverviewCharts();
                break;
            case 'farmers':
                loadFarmersData();
                break;
            case 'crowdfunding':
                loadCampaignsData();
                break;
            case 'community':
                loadCommunityData();
                break;
            case 'profile':
                loadProfileData();
                break;
            case 'seasonalTracking':
                renderSeasonalTracking();
                initSeasonalCharts();
                break;
            case 'riceMonitoring':
                renderRiceMonitoring();
                initMonitoringCharts();
                break;
            case 'analytics':
                loadAnalyticsData();
                initAnalyticsCharts();
                break;
        }
    }, 100);
}

// Dashboard Functions
function showDashboard() {
    console.log('Showing dashboard for user:', appState.currentUser);
    document.getElementById('landingPage').classList.add('hidden');
    document.getElementById('dashboard').classList.remove('hidden');
    
    updateUserWelcome();
    loadDashboardData();
    
    // Initialize charts with a delay to ensure DOM is ready
    setTimeout(() => {
        initCharts();
    }, 500);
}

function showLandingPage() {
    document.getElementById('landingPage').classList.remove('hidden');
    document.getElementById('dashboard').classList.add('hidden');
}

function showDemo() {
    // Demo mode with sample data
    appState.currentUser = {
        id: 999,
        name: 'Demo Farmer',
        email: 'demo@farmstat.com',
        role: 'farmer'
    };
    appState.isAuthenticated = true;
    
    // Save demo user to localStorage
    localStorage.setItem('farmstat_user', JSON.stringify(appState.currentUser));
    
    showDashboard();
    showNotification('Demo mode activated!', 'success');
}

// Data Loading Functions
function loadDashboardData() {
    // Demo data for dashboard
    const dashboardData = {
        total_farmers: 156,
        active_crops: 68,
        total_funding: 18200000,
        yield_increase: '156%',
        activities: [
            {
                activity_type: 'user',
                description: 'New farmer Juan Dela Cruz registered',
                created_at: new Date(Date.now() - 2 * 60 * 60 * 1000).toISOString()
            },
            {
                activity_type: 'campaign',
                description: 'Seed funding campaign reached 75% of goal',
                created_at: new Date(Date.now() - 5 * 60 * 60 * 1000).toISOString()
            },
            {
                activity_type: 'system',
                description: 'Season progress updated to 68% complete',
                created_at: new Date(Date.now() - 24 * 60 * 60 * 1000).toISOString()
            }
        ]
    };
    
    updateDashboardStats(dashboardData);
    renderActivities(dashboardData.activities);
}

function loadFarmersData() {
    console.log('Loading farmers data...');
    
    // Demo farmers data
    const demoFarmers = [
        {
            id: 1,
            full_name: 'Juan Dela Cruz',
            location: 'Nueva Ecija',
            experience_years: 15,
            farm_size: 5.2,
            rice_varieties: 'Jasmine, Sinandomeng',
            farming_method: 'Modern',
            land_ownership: 'Owned',
            current_yield: '4.8 tons/ha'
        },
        {
            id: 2,
            full_name: 'Maria Santos',
            location: 'Isabela',
            experience_years: 8,
            farm_size: 3.5,
            rice_varieties: 'IR64, Hybrid',
            farming_method: 'Organic',
            land_ownership: 'Leased',
            current_yield: '4.2 tons/ha'
        },
        {
            id: 3,
            full_name: 'Pedro Reyes',
            location: 'Tarlac',
            experience_years: 20,
            farm_size: 8.1,
            rice_varieties: 'Traditional, Jasmine',
            farming_method: 'Traditional',
            land_ownership: 'Ancestral',
            current_yield: '3.9 tons/ha'
        },
        {
            id: 4,
            full_name: 'Ana Lim',
            location: 'Pangasinan',
            experience_years: 12,
            farm_size: 4.3,
            rice_varieties: 'Hybrid, IR64',
            farming_method: 'Modern',
            land_ownership: 'Owned',
            current_yield: '5.1 tons/ha'
        }
    ];
    
    appState.farmers = demoFarmers;
    renderFarmers();
}

function loadCampaignsData() {
    // Demo campaigns data
    const demoCampaigns = [
        {
            id: 1,
            title: 'Modern Rice Mill Equipment',
            type: 'Equipment',
            goal_amount: 500000,
            current_amount: 375000,
            description: 'Funding for modern rice milling equipment to improve processing efficiency and quality.',
            farmer_name: 'Juan Dela Cruz',
            supporters: 45,
            deadline: new Date(Date.now() + 30 * 24 * 60 * 60 * 1000).toISOString(),
            status: 'active'
        },
        {
            id: 2,
            title: 'Organic Fertilizer Program',
            type: 'Seeds',
            goal_amount: 250000,
            current_amount: 187500,
            description: 'Support for organic fertilizer distribution to promote sustainable farming practices.',
            farmer_name: 'Maria Santos',
            supporters: 32,
            deadline: new Date(Date.now() + 45 * 24 * 60 * 60 * 1000).toISOString(),
            status: 'active'
        },
        {
            id: 3,
            title: 'Irrigation System Upgrade',
            type: 'Infrastructure',
            goal_amount: 750000,
            current_amount: 450000,
            description: 'Modern irrigation system to ensure consistent water supply during dry seasons.',
            farmer_name: 'Community Project',
            supporters: 67,
            deadline: new Date(Date.now() + 60 * 24 * 60 * 60 * 1000).toISOString(),
            status: 'active'
        }
    ];
    
    appState.campaigns = demoCampaigns;
    renderCampaigns();
}

function loadCommunityData() {
    const communityData = {
        leaderboard: [
            { name: 'Juan Dela Cruz', location: 'Nueva Ecija', experience: 15, yield: 120 },
            { name: 'Ana Lim', location: 'Pangasinan', experience: 12, yield: 115 },
            { name: 'Maria Santos', location: 'Isabela', experience: 8, yield: 110 },
            { name: 'Pedro Reyes', location: 'Tarlac', experience: 20, yield: 105 }
        ],
        knowledge: [
            { title: 'Water Management Best Practices', description: 'Learn how to optimize water usage during different growth phases.', author: 'Juan Dela Cruz' },
            { title: 'Organic Pest Control Methods', description: 'Natural ways to control common rice pests without chemicals.', author: 'Maria Santos' },
            { title: 'Soil Health Improvement', description: 'Techniques to improve soil quality for better yields.', author: 'Ana Lim' }
        ]
    };
    
    renderLeaderboard(communityData.leaderboard);
    renderKnowledge(communityData.knowledge);
}

function loadAnalyticsData() {
    // Analytics data is loaded by individual charts
}

function loadProfileData() {
    if (appState.currentUser) {
        // Use demo profile data
        const profileData = {
            name: appState.currentUser.name,
            email: appState.currentUser.email,
            role: appState.currentUser.role,
            experience: '15',
            phone: '+63 912 345 6789',
            location: 'Nueva Ecija, Philippines',
            bio: 'Third-generation rice farmer with 15 years of experience in modern and traditional farming methods. Passionate about sustainable agriculture and community development.'
        };
        
        const profileName = document.getElementById('profileName');
        const profileRole = document.getElementById('profileRole');
        const profileFullName = document.getElementById('profileFullName');
        const profileEmailInput = document.getElementById('profileEmailInput');
        const profilePhone = document.getElementById('profilePhone');
        const profileLocation = document.getElementById('profileLocation');
        const profileBio = document.getElementById('profileBio');
        
        if (profileName) profileName.textContent = profileData.name;
        if (profileRole) profileRole.textContent = `${profileData.role.charAt(0).toUpperCase() + profileData.role.slice(1)} - ${profileData.experience} years experience`;
        if (profileFullName) profileFullName.value = profileData.name;
        if (profileEmailInput) profileEmailInput.value = profileData.email;
        if (profilePhone) profilePhone.value = profileData.phone;
        if (profileLocation) profileLocation.value = profileData.location;
        if (profileBio) profileBio.value = profileData.bio;
    }
}

// Stats and Data Rendering
function updateDashboardStats(data) {
    if (document.getElementById('totalFarmers')) {
        document.getElementById('totalFarmers').textContent = data.total_farmers || 0;
    }
    if (document.getElementById('activeCrops')) {
        document.getElementById('activeCrops').textContent = data.active_crops || 0;
    }
    if (document.getElementById('totalFunding')) {
        document.getElementById('totalFunding').textContent = `₱${((data.total_funding || 0) / 1000000).toFixed(1)}M`;
    }
    if (document.getElementById('yieldIncrease')) {
        document.getElementById('yieldIncrease').textContent = data.yield_increase || '156%';
    }
}

function renderFarmers() {
    const farmersGrid = document.getElementById('farmersGrid');
    if (!farmersGrid) return;
    
    farmersGrid.innerHTML = appState.farmers.map(farmer => `
        <div class="farmer-card" data-farmer-id="${farmer.id}">
            <div class="farmer-card-header">
                <div class="farmer-avatar">
                    ${farmer.full_name ? farmer.full_name.split(' ').map(n => n[0]).join('').toUpperCase() : 'FF'}
                </div>
                <div class="farmer-basic-info">
                    <h3>${farmer.full_name || 'Unknown Farmer'}</h3>
                    <p>${farmer.location || 'Unknown Location'} • ${farmer.experience_years || 0} years experience</p>
                </div>
            </div>
            <div class="farmer-card-body">
                <div class="farmer-stats">
                    <div class="farmer-stat">
                        <span class="farmer-stat-value">${farmer.farm_size || 0} ha</span>
                        <span class="farmer-stat-label">Farm Size</span>
                    </div>
                    <div class="farmer-stat">
                        <span class="farmer-stat-value">${farmer.current_yield || 'N/A'}</span>
                        <span class="farmer-stat-label">Yield/ha</span>
                    </div>
                </div>
                <div class="farmer-details">
                    <div class="farmer-detail">
                        <label>Rice Varieties:</label>
                        <span>${farmer.rice_varieties || 'Not specified'}</span>
                    </div>
                    <div class="farmer-detail">
                        <label>Farming Method:</label>
                        <span>${farmer.farming_method || 'Not specified'}</span>
                    </div>
                    <div class="farmer-detail">
                        <label>Land Ownership:</label>
                        <span>${farmer.land_ownership || 'Not specified'}</span>
                    </div>
                </div>
            </div>
            <div class="farmer-card-footer">
                <button class="btn btn-primary btn-sm" onclick="viewFarmerDetails(${farmer.id})">
                    <i class="fas fa-eye"></i> View Details
                </button>
                <button class="btn btn-outline btn-sm" onclick="supportFarmer(${farmer.id})">
                    <i class="fas fa-hand-holding-heart"></i> Support
                </button>
            </div>
        </div>
    `).join('');
}

function renderCampaigns() {
    const campaignsGrid = document.getElementById('campaignsGrid');
    if (!campaignsGrid) return;
    
    campaignsGrid.innerHTML = appState.campaigns.map(campaign => {
        const progress = (campaign.current_amount / campaign.goal_amount) * 100;
        const daysLeft = Math.ceil((new Date(campaign.deadline) - new Date()) / (1000 * 60 * 60 * 24));
        
        return `
            <div class="campaign-card" data-campaign-id="${campaign.id}">
                <div class="campaign-header">
                    <div>
                        <div class="campaign-title">${campaign.title}</div>
                        <div class="campaign-farmer">by ${campaign.farmer_name || 'Community'}</div>
                    </div>
                    <span class="campaign-type">${campaign.type}</span>
                </div>
                <div class="campaign-body">
                    <p class="campaign-description">${campaign.description}</p>
                    
                    <div class="campaign-progress">
                        <div class="progress-info">
                            <span class="progress-raised">₱${campaign.current_amount.toLocaleString()} raised</span>
                            <span class="progress-percentage">${Math.round(progress)}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: ${progress}%"></div>
                        </div>
                    </div>
                    
                    <div class="campaign-meta">
                        <div class="campaign-meta-item">
                            <span class="campaign-meta-label">Goal</span>
                            <span class="campaign-meta-value">₱${campaign.goal_amount.toLocaleString()}</span>
                        </div>
                        <div class="campaign-meta-item">
                            <span class="campaign-meta-label">Supporters</span>
                            <span class="campaign-meta-value">${campaign.supporters || 0}</span>
                        </div>
                        <div class="campaign-meta-item">
                            <span class="campaign-meta-label">Deadline</span>
                            <span class="campaign-meta-value">${new Date(campaign.deadline).toLocaleDateString()}</span>
                        </div>
                        <div class="campaign-meta-item">
                            <span class="campaign-meta-label">Days Left</span>
                            <span class="campaign-meta-value">${daysLeft}</span>
                        </div>
                    </div>
                </div>
                <div class="campaign-footer">
                    <span class="campaign-status ${campaign.status}">${campaign.status}</span>
                    <button class="btn btn-primary btn-sm" onclick="supportCampaign(${campaign.id})" style="margin-left: auto;">
                        <i class="fas fa-donate"></i> Support
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

function renderActivities(activities = []) {
    const activityList = document.getElementById('activityList');
    if (!activityList) return;
    
    activityList.innerHTML = activities.map(activity => `
        <div class="activity-item">
            <div class="activity-icon">
                <i class="fas fa-${getActivityIcon(activity.activity_type)}"></i>
            </div>
            <div class="activity-content">
                <div class="activity-title">${activity.description}</div>
                <div class="activity-time">${formatTimeElapsed(activity.created_at)}</div>
            </div>
        </div>
    `).join('');
}

function renderLeaderboard(leaderboard = []) {
    const leaderboardElement = document.getElementById('leaderboard');
    if (!leaderboardElement) return;
    
    leaderboardElement.innerHTML = leaderboard.map((farmer, index) => `
        <div class="leaderboard-item">
            <div class="leaderboard-rank">${index + 1}</div>
            <div class="leaderboard-info">
                <div class="leaderboard-name">${farmer.name}</div>
                <div class="leaderboard-details">${farmer.location} • ${farmer.experience} years experience</div>
            </div>
            <div class="leaderboard-yield">${farmer.yield} cavans/ha</div>
        </div>
    `).join('');
}

function renderKnowledge(knowledge = []) {
    const knowledgeGrid = document.getElementById('knowledgeGrid');
    if (!knowledgeGrid) return;
    
    knowledgeGrid.innerHTML = knowledge.map(item => `
        <div class="knowledge-item">
            <h4>${item.title}</h4>
            <p>${item.description}</p>
            <div class="knowledge-author">Shared by ${item.author}</div>
        </div>
    `).join('');
}

// Modal Functions
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
    }
}

function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
}

// Form Handlers
function handleAddFarmer(e) {
    e.preventDefault();
    console.log('Adding new farmer...');
    
    const formData = {
        full_name: document.getElementById('farmerName').value,
        experience_years: parseInt(document.getElementById('farmerExperience').value) || 0,
        location: document.getElementById('farmerLocation').value,
        farm_size: parseFloat(document.getElementById('farmSize').value) || 0,
        rice_varieties: document.getElementById('riceVarieties').value,
        farming_method: document.getElementById('farmingMethod').value,
        land_ownership: document.getElementById('landOwnership').value
    };
    
    console.log('Form data:', formData);
    
    // Add the new farmer to the farmers array
    const newFarmer = {
        id: Date.now(),
        ...formData,
        current_yield: 'N/A'
    };
    
    appState.farmers.push(newFarmer);
    renderFarmers();
    
    hideModal('addFarmerModal');
    showNotification('Farmer registered successfully!', 'success');
    e.target.reset();
}   

function handleCreateCampaign(e) {
    e.preventDefault();
    
    const formData = {
        title: document.getElementById('campaignTitle').value,
        type: document.getElementById('campaignType').value,
        goal_amount: parseInt(document.getElementById('campaignGoal').value) || 0,
        description: document.getElementById('campaignDescription').value,
        deadline: document.getElementById('campaignDeadline').value
    };
    
    // Add the new campaign
    const newCampaign = {
        id: Date.now(),
        ...formData,
        current_amount: 0,
        supporters: 0,
        farmer_name: appState.currentUser?.name || 'Community',
        status: 'active'
    };
    
    appState.campaigns.push(newCampaign);
    renderCampaigns();
    
    hideModal('createCampaignModal');
    showNotification('Campaign created successfully!', 'success');
    e.target.reset();
}

// Utility Functions
function getActivityIcon(activityType) {
    const icons = {
        'login': 'sign-in-alt',
        'user': 'user-plus',
        'campaign': 'hand-holding-usd',
        'system': 'chart-line',
        'alert': 'exclamation-triangle'
    };
    return icons[activityType] || 'circle';
}

function formatTimeElapsed(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffMs = now - date;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMins / 60);
    const diffDays = Math.floor(diffHours / 24);
    
    if (diffMins < 1) return 'just now';
    if (diffMins < 60) return `${diffMins} minutes ago`;
    if (diffHours < 24) return `${diffHours} hours ago`;
    if (diffDays < 7) return `${diffDays} days ago`;
    return date.toLocaleDateString();
}

function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles for notification
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4a7c59' : type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Action Functions (called from HTML onclick)
function viewFarmerDetails(farmerId) {
    const farmer = appState.farmers.find(f => f.id === farmerId);
    if (farmer) {
        showNotification(`Viewing details for ${farmer.full_name}`, 'info');
        // In a real app, this would open a detailed view modal
    }
}

function supportFarmer(farmerId) {
    const farmer = appState.farmers.find(f => f.id === farmerId);
    if (farmer) {
        showNotification(`Support options for ${farmer.full_name}`, 'info');
        // In a real app, this would open support options
    }
}

function supportCampaign(campaignId) {
    const campaign = appState.campaigns.find(c => c.id === campaignId);
    if (campaign) {
        showNotification(`Supporting campaign: ${campaign.title}`, 'info');
        // In a real app, this would open a payment/donation modal
    }
}

// Navigation function
window.showPage = function(targetPage) {
    switchPage(targetPage);
};

// Modal functionality
window.openModal = function(modalId) {
    showModal(modalId);
};

window.closeModal = function(modalId) {
    hideModal(modalId);
};

// Demo functions
window.editFarmer = function(id) {
    showNotification('Edit farmer functionality will be implemented.', 'info');
};

window.viewFarmer = function(id) {
    showNotification('View farmer functionality will be implemented.', 'info');
};

window.exportFarmers = function() {
    showNotification('Export functionality will be implemented.', 'info');
};

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .notification-content i {
        font-size: 1.2rem;
    }
`;
document.head.appendChild(style);

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', initApp);
// Campaign Creation Functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('campaignModal');
    const createBtn = document.getElementById('createCampaignBtn');
    const closeBtn = document.querySelector('.close');
    const cancelBtn = document.getElementById('cancelCampaign');
    const campaignForm = document.getElementById('campaignForm');
    const farmerSelect = document.getElementById('farmerSelect');

    // Load farmers for dropdown
    loadFarmers();

    // Open modal
    createBtn.addEventListener('click', function() {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    });

    // Close modal
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        campaignForm.reset();
    }

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Form submission
    campaignForm.addEventListener('submit', function(e) {
        e.preventDefault();
        createCampaign();
    });

    // Load farmers from database
    async function loadFarmers() {
        try {
            const response = await fetch('<?php echo BASE_URL; ?>/api/get-farmers');
            const farmers = await response.json();
            
            farmerSelect.innerHTML = '<option value="">Select Farmer</option>';
            farmers.forEach(farmer => {
                const option = document.createElement('option');
                option.value = farmer.id;
                option.textContent = farmer.full_name + ' - ' + farmer.farm_location;
                farmerSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error loading farmers:', error);
            showNotification('Error loading farmers list', 'error');
        }
    }

    // Create campaign function
    async function createCampaign() {
        const formData = new FormData(campaignForm);
        const campaignData = {
            title: formData.get('title'),
            description: formData.get('description'),
            campaign_type: formData.get('campaign_type'),
            funding_goal: parseFloat(formData.get('funding_goal')),
            deadline: formData.get('deadline'),
            farmer_id: formData.get('farmer_id') || null,
            status: 'active'
        };

        // Validation
        if (!campaignData.title || !campaignData.description || !campaignData.campaign_type || 
            !campaignData.funding_goal || !campaignData.deadline) {
            showNotification('Please fill in all required fields', 'error');
            return;
        }

        if (campaignData.funding_goal < 1000) {
            showNotification('Funding goal must be at least ₱1,000', 'error');
            return;
        }

        try {
            const response = await fetch('<?php echo BASE_URL; ?>/api/create-campaign', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(campaignData)
            });

            const result = await response.json();

            if (result.success) {
                showNotification('Campaign created successfully!', 'success');
                closeModal();
                loadCampaigns(); // Refresh the campaigns list
            } else {
                showNotification(result.message || 'Error creating campaign', 'error');
            }
        } catch (error) {
            console.error('Error creating campaign:', error);
            showNotification('Error creating campaign. Please try again.', 'error');
        }
    }

    // Notification function
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button onclick="this.parentElement.remove()">&times;</button>
        `;

        // Add notification styles if not already added
        if (!document.querySelector('#notification-styles')) {
            const styles = document.createElement('style');
            styles.id = 'notification-styles';
            styles.textContent = `
                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 1rem 1.5rem;
                    border-radius: 8px;
                    color: white;
                    z-index: 1001;
                    display: flex;
                    align-items: center;
                    gap: 1rem;
                    box-shadow: var(--shadow-lg);
                    animation: slideInRight 0.3s ease-out;
                }
                .notification-success { background: var(--primary-medium); }
                .notification-error { background: #e53e3e; }
                .notification-info { background: var(--primary-dark); }
                .notification button {
                    background: none;
                    border: none;
                    color: white;
                    font-size: 1.2rem;
                    cursor: pointer;
                    padding: 0;
                }
                @keyframes slideInRight {
                    from { transform: translateX(100%); }
                    to { transform: translateX(0); }
                }
            `;
            document.head.appendChild(styles);
        }

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
});
</script>

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>