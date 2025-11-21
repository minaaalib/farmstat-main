<?php
$title = 'FarmStat - Rice Farming Intelligence & Crowdfunding';
?>

<style>
/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

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

html, body {
    height: 100%;
    overflow-x: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text);
    background-color: var(--background);
    line-height: 1.6;
}

body {
    overflow-y: auto;
}

#landingPage {
    min-height: 100vh;
    width: 100%;
}

/* Navigation */
.navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--border);
    z-index: 1000;
    height: 70px;
}

.nav-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-dark);
}

.logo {
    font-size: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: var(--border-radius);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-medium), var(--primary-dark));
    color: var(--white);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-outline {
    background: transparent;
    color: var(--primary-dark);
    border: 2px solid var(--primary-dark);
}

.btn-outline:hover {
    background: var(--primary-dark);
    color: var(--white);
    transform: translateY(-2px);
}

/* Hero Section */
.hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6rem 2rem 2rem;
    background: linear-gradient(135deg, var(--background) 0%, var(--white) 100%);
    position: relative;
    overflow: hidden;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    background: linear-gradient(45deg, var(--primary-light) 0%, transparent 100%);
    opacity: 0.1;
}

.hero-content {
    flex: 1;
    max-width: 600px;
    z-index: 2;
}

.hero-content h1 {
    font-size: 3.5rem;
    font-weight: 800;
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.25rem;
    color: var(--text-light);
    margin-bottom: 2.5rem;
    line-height: 1.6;
}

.hero-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 3rem;
}

.impact-stats {
    display: flex;
    gap: 2rem;
}

.impact-stat {
    text-align: center;
}

.impact-number {
    display: block;
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary-dark);
    margin-bottom: 0.25rem;
}

.impact-label {
    font-size: 0.9rem;
    color: var(--text-light);
    font-weight: 500;
}

.hero-visual {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2;
}

.data-card {
    background: var(--white);
    padding: 2rem;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-lg);
    border: 1px solid var(--border);
    max-width: 300px;
}

.card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
}

.card-icon {
    font-size: 1.5rem;
}

.card-header h3 {
    color: var(--primary-dark);
    font-size: 1.25rem;
}

.card-stats {
    display: flex;
    gap: 1.5rem;
}

.stat {
    text-align: center;
}

.stat-value {
    display: block;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--accent-orange);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.85rem;
    color: var(--text-light);
}

/* Mission Section */
.mission-section {
    min-height: 100vh;
    padding: 4rem 2rem;
    background: var(--white);
    display: flex;
    align-items: center;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.mission-content {
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

.mission-content h2 {
    font-size: 2.5rem;
    color: var(--primary-dark);
    margin-bottom: 2rem;
}

.mission-statement {
    font-size: 1.5rem;
    font-style: italic;
    color: var(--text-light);
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
    padding: 2rem;
    background: var(--background);
    border-radius: var(--border-radius);
    text-align: center;
    transition: var(--transition);
}

.pillar:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow);
}

.pillar i {
    font-size: 2.5rem;
    color: var(--primary-medium);
    margin-bottom: 1rem;
}

.pillar h4 {
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.pillar p {
    color: var(--text-light);
    line-height: 1.5;
}

/* Features Section */
.features {
    min-height: 100vh;
    padding: 4rem 2rem;
    background: var(--background);
}

.features h2 {
    text-align: center;
    font-size: 2.5rem;
    color: var(--primary-dark);
    margin-bottom: 3rem;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.feature-card {
    background: var(--white);
    padding: 2.5rem 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border: 1px solid var(--border);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.feature-icon {
    font-size: 3rem;
    margin-bottom: 1.5rem;
}

.feature-card h3 {
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-size: 1.5rem;
}

.feature-card p {
    color: var(--text-light);
    line-height: 1.6;
}

/* Rice Intelligence Section */
.rice-intelligence {
    min-height: 100vh;
    padding: 4rem 2rem;
    background: var(--white);
}

.rice-intelligence h2 {
    text-align: center;
    font-size: 2.5rem;
    color: var(--primary-dark);
    margin-bottom: 3rem;
}

.intelligence-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.intelligence-card {
    background: var(--background);
    padding: 2rem;
    border-radius: var(--border-radius);
    border: 1px solid var(--border);
}

.intelligence-card h3 {
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    font-size: 1.25rem;
}

.intelligence-card ul {
    list-style: none;
    color: var(--text-light);
}

.intelligence-card li {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border);
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
    border-radius: 10px;
    border: 2px solid var(--border);
    transition: var(--transition);
}

.phase.active {
    border-color: var(--primary-medium);
    background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
}

.phase-name {
    font-weight: 600;
    color: var(--primary-dark);
}

.phase-date {
    color: var(--text-light);
    font-size: 0.9rem;
}

/* CTA Section */
.cta-section {
    min-height: 70vh;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-medium) 100%);
    color: var(--white);
    display: flex;
    align-items: center;
}

.cta-content {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.cta-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.cta-content p {
    font-size: 1.25rem;
    margin-bottom: 2.5rem;
    opacity: 0.9;
}

.cta-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero {
        flex-direction: column;
        text-align: center;
        padding: 5rem 1rem 2rem;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .impact-stats {
        justify-content: center;
    }
    
    .mission-pillars,
    .features-grid,
    .intelligence-grid {
        grid-template-columns: 1fr;
    }
    
    .navbar {
        padding: 1rem;
    }
    
    .nav-brand {
        font-size: 1.25rem;
    }
}

/* Smooth Scrolling */
html {
    scroll-behavior: smooth;
}
</style>

<div id="landingPage">
    <header>
        <nav class="navbar">
            <div class="nav-brand">
                <span class="logo">🌾</span>
                <span>FarmStat</span>
            </div>
            <div class="nav-actions">
                <button id="getStartedBtn" class="btn btn-primary">Get Started</button>
            </div>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Rice Farming Intelligence</h1>
                <p class="hero-subtitle">Empowering Filipino rice farmers with digital profiling and community-backed funding while creating the most detailed agricultural database in the Philippines.</p>
                <div class="hero-actions">
                    <button id="heroGetStarted" class="btn btn-primary">Start Your Journey</button>
                    <button id="heroDemo" class="btn btn-outline">See Platform in Action</button>
                </div>
                <div class="impact-stats">
                    <div class="impact-stat">
                        <span class="impact-number">2,847</span>
                        <span class="impact-label">Rice Farmers</span>
                    </div>
                    <div class="impact-stat">
                        <span class="impact-number">₱18.2M</span>
                        <span class="impact-label">Community Funding</span>
                    </div>
                    <div class="impact-stat">
                        <span class="impact-number">156%</span>
                        <span class="impact-label">Avg. Yield Increase</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="data-card">
                    <div class="card-header">
                        <span class="card-icon">📊</span>
                        <h3>Season 2024 Progress</h3>
                    </div>
                    <div class="card-stats">
                        <div class="stat">
                            <span class="stat-value">68%</span>
                            <span class="stat-label">In Growth Phase</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value">24%</span>
                            <span class="stat-label">Ready for Harvest</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission Section -->
        <section class="mission-section">
            <div class="container">
                <div class="mission-content">
                    <h2>Our Mission</h2>
                    <p class="mission-statement">"Empowering every Filipino rice farmer with digital profiling and community-backed funding while creating the most detailed agricultural database in the Philippines."</p>
                    <div class="mission-pillars">
                        <div class="pillar">
                            <i class="fas fa-database"></i>
                            <h4>Comprehensive Data</h4>
                            <p>Detailed agricultural monitoring and intelligence</p>
                        </div>
                        <div class="pillar">
                            <i class="fas fa-hand-holding-heart"></i>
                            <h4>Community Support</h4>
                            <p>Transparent crowdfunding with impact tracking</p>
                        </div>
                        <div class="pillar">
                            <i class="fas fa-chart-line"></i>
                            <h4>Performance Analytics</h4>
                            <p>Multi-season comparison and improvement tracking</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <div class="container">
                <h2>Revolutionizing Rice Farming</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">👨‍🌾</div>
                        <h3>Farmer Profiles 2.0</h3>
                        <p>Complete agricultural journey tracking with GPS mapping, farming experience, and family involvement documentation</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🌱</div>
                        <h3>Seasonal Monitoring</h3>
                        <p>Comprehensive rice farming analytics from planting to harvest with real-time progress tracking</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📈</div>
                        <h3>Historical Analytics</h3>
                        <p>5-year farming timeline with yield trends, climate impact analysis, and technology adoption journey</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🤝</div>
                        <h3>Community Intelligence</h3>
                        <p>Compare yields, share best practices, and learn from successful techniques across the community</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💰</div>
                        <h3>Impact Crowdfunding</h3>
                        <p>Project-based funding with transparent ROI tracking from donation to harvest results</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📱</div>
                        <h3>Mobile Field Monitoring</h3>
                        <p>Photo documentation, pest reporting, and offline capability for remote farming areas</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rice Farming Intelligence Section -->
        <section class="rice-intelligence">
            <div class="container">
                <h2>Rice Farming Intelligence System</h2>
                <div class="intelligence-grid">
                    <div class="intelligence-card">
                        <h3>🌾 Rice Varieties & Methods</h3>
                        <ul>
                            <li>Primary varieties: Jasmine, Sinandomeng, IR64</li>
                            <li>Farming methods: Traditional, Modern, Organic</li>
                            <li>Land ownership tracking</li>
                            <li>Soil health assessment</li>
                        </ul>
                    </div>
                    <div class="intelligence-card">
                        <h3>📅 Seasonal Monitoring</h3>
                        <div class="phase-timeline">
                            <div class="phase active">
                                <span class="phase-name">Planting</span>
                                <span class="phase-date">Jan-Mar 2024</span>
                            </div>
                            <div class="phase active">
                                <span class="phase-name">Growth</span>
                                <span class="phase-date">Apr-Jul 2024</span>
                            </div>
                            <div class="phase">
                                <span class="phase-name">Harvest</span>
                                <span class="phase-date">Aug-Oct 2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="intelligence-card">
                        <h3>🐄 Livestock Integration</h3>
                        <ul>
                            <li>Carabao/draft animal management</li>
                            <li>Rice-poultry synergy systems</li>
                            <li>Feed sources and care tracking</li>
                            <li>Integration with rice fields</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Join the Agricultural Revolution</h2>
                    <p>Be part of creating a future where every Filipino rice farmer has the tools, community support, and financial backing to thrive.</p>
                    <div class="cta-actions">
                        <button id="ctaGetStarted" class="btn btn-primary">Get Started Now</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get Started button handlers
    const getStartedButtons = [
        document.getElementById('getStartedBtn'),
        document.getElementById('heroGetStarted'),
        document.getElementById('ctaGetStarted')
    ];

    getStartedButtons.forEach(button => {
        if (button) {
            button.addEventListener('click', function() {
                window.location.href = '<?php echo BASE_URL; ?>/login';
            });
        }
    });

    // Demo button handler
    const demoButton = document.getElementById('heroDemo');
    if (demoButton) {
        demoButton.addEventListener('click', function() {
            // Scroll to features section for demo
            document.querySelector('.features').scrollIntoView({ 
                behavior: 'smooth' 
            });
        });
    }
});
</script>

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>