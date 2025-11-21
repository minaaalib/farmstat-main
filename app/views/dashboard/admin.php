<?php
$title = 'Admin Dashboard - FarmStats';
require_once VIEWS_PATH . '/layouts/header.php';

// Get data from database (you'll need to connect your actual database here)
// For now, using sample data
$users = [
    ['id' => 1, 'name' => 'Juan Dela Cruz', 'email' => 'juan@email.com', 'role' => 'farmer', 'status' => 'active', 'last_login' => '2024-01-15 14:30:00', 'login_count' => 25],
    ['id' => 2, 'name' => 'Maria Santos', 'email' => 'maria@email.com', 'role' => 'farmer', 'status' => 'active', 'last_login' => '2024-01-15 10:15:00', 'login_count' => 18],
    ['id' => 3, 'name' => 'Admin User', 'email' => 'admin@farmstat.com', 'role' => 'admin', 'status' => 'active', 'last_login' => '2024-01-15 16:45:00', 'login_count' => 102]
];

$farmers = [
    ['id' => 1, 'full_name' => 'Juan Dela Cruz', 'farm_location' => 'Nueva Ecija', 'years_experience' => 10, 'farm_size' => 5.2, 'farming_method' => 'Traditional', 'land_ownership' => 'Owned'],
    ['id' => 2, 'full_name' => 'Maria Santos', 'farm_location' => 'Isabela', 'years_experience' => 8, 'farm_size' => 3.8, 'farming_method' => 'Modern', 'land_ownership' => 'Leased'],
    ['id' => 3, 'full_name' => 'Pedro Reyes', 'farm_location' => 'Tarlac', 'years_experience' => 15, 'farm_size' => 8.5, 'farming_method' => 'Organic', 'land_ownership' => 'Owned']
];

$campaigns = [
    ['id' => 1, 'title' => 'Modern Irrigation System', 'farmer' => 'Juan Dela Cruz', 'goal' => 75000, 'raised' => 68250, 'supporters' => 124, 'status' => 'active'],
    ['id' => 2, 'title' => 'Organic Fertilizer Program', 'farmer' => 'Maria Santos', 'goal' => 25000, 'raised' => 25000, 'supporters' => 89, 'status' => 'completed']
];
?>

<div id="adminDashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="logo">
                    <i class="fas fa-seedling"></i>
                </div>
                <span class="brand-text">FarmStat</span>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item active" onclick="showSection('dashboard')">
                    <div class="nav-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <span class="nav-text">Dashboard</span>
                </li>
                <li class="nav-item" onclick="showSection('users')">
                    <div class="nav-icon"><i class="fas fa-users"></i></div>
                    <span class="nav-text">Users</span>
                </li>
                <li class="nav-item" onclick="showSection('farmers')">
                    <div class="nav-icon"><i class="fas fa-tractor"></i></div>
                    <span class="nav-text">Farmers</span>
                </li>
                <li class="nav-item" onclick="showSection('campaigns')">
                    <div class="nav-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <span class="nav-text">Campaigns</span>
                </li>
                <li class="nav-item" onclick="showSection('analytics')">
                    <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
                    <span class="nav-text">Analytics</span>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="dashboard-header">
            <div class="header-left">
                <h1 id="pageTitle"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
                <div class="breadcrumb">
                    <span class="breadcrumb-item">Admin</span>
                    <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                    <span class="breadcrumb-item active" id="breadcrumbText">Dashboard</span>
                </div>
            </div>
            <div class="header-right">
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-avatar">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="page-content">
            
            <!-- ==================== -->
            <!-- DASHBOARD SECTION -->
            <!-- ==================== -->
            <div id="dashboard" class="content-section active">
                <div class="section-header">
                    <h2><i class="fas fa-chart-pie"></i> System Overview</h2>
                    <p>Welcome to your FarmStat Admin Dashboard</p>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card primary">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">1,248</h3>
                            <p class="stat-label">Total Users</p>
                        </div>
                        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +12%</div>
                    </div>

                    <div class="stat-card success">
                        <div class="stat-icon">
                            <i class="fas fa-tractor"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">856</h3>
                            <p class="stat-label">Active Farmers</p>
                        </div>
                        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +8%</div>
                    </div>

                    <div class="stat-card warning">
                        <div class="stat-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">₱2.4M</h3>
                            <p class="stat-label">Total Funding</p>
                        </div>
                        <div class="stat-trend up"><i class="fas fa-arrow-up"></i> +23%</div>
                    </div>

                    <div class="stat-card info">
                        <div class="stat-icon">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">42</h3>
                            <p class="stat-label">Active Campaigns</p>
                        </div>
                        <div class="stat-trend down"><i class="fas fa-arrow-down"></i> -3%</div>
                    </div>
                </div>

                <!-- Quick Stats Row -->
                <div class="content-row">
                    <div class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-chart-line"></i> Recent Activity</h3>
                            <span class="badge badge-primary"><i class="fas fa-circle"></i> Live</span>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <p><strong>New farmer registered</strong></p>
                                    <span class="activity-time"><i class="far fa-clock"></i> 2 minutes ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon primary">
                                    <i class="fas fa-donate"></i>
                                </div>
                                <div class="activity-content">
                                    <p><strong>Campaign reached 80% funding</strong></p>
                                    <span class="activity-time"><i class="far fa-clock"></i> 1 hour ago</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon warning">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <div class="activity-content">
                                    <p><strong>New planting season started</strong></p>
                                    <span class="activity-time"><i class="far fa-clock"></i> 3 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        </div>
                        <div class="action-grid">
                            <button class="action-btn" onclick="showSection('users')">
                                <div class="action-icon">
                                    <i class="fas fa-user-cog"></i>
                                </div>
                                <span>Manage Users</span>
                            </button>
                            <button class="action-btn" onclick="showSection('farmers')">
                                <div class="action-icon">
                                    <i class="fas fa-tractor"></i>
                                </div>
                                <span>View Farmers</span>
                            </button>
                            <button class="action-btn" onclick="showSection('campaigns')">
                                <div class="action-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <span>Campaigns</span>
                            </button>
                            <button class="action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span>Reports</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== -->
            <!-- USER MANAGEMENT SECTION -->
            <!-- ==================== -->
            <div id="users" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-users"></i> User Management</h2>
                    <p>Manage all system users and their permissions</p>
                </div>

                <div class="content-card">
                    <div class="card-header with-actions">
                        <h3><i class="fas fa-list"></i> All Users</h3>
                        <div class="header-actions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Search users..." id="userSearch">
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Add New User
                            </button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-id-card"></i> User ID</th>
                                    <th><i class="fas fa-user"></i> Name</th>
                                    <th><i class="fas fa-envelope"></i> Email</th>
                                    <th><i class="fas fa-user-tag"></i> Role</th>
                                    <th><i class="fas fa-circle"></i> Status</th>
                                    <th><i class="fas fa-sign-in-alt"></i> Last Login</th>
                                    <th><i class="fas fa-chart-line"></i> Login Count</th>
                                    <th><i class="fas fa-cog"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>#<?php echo $user['id']; ?></td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar sm">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <?php echo htmlspecialchars($user['name']); ?>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo $user['role'] === 'admin' ? 'danger' : 'success'; ?>">
                                            <i class="fas fa-<?php echo $user['role'] === 'admin' ? 'crown' : 'user'; ?>"></i>
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo $user['status']; ?>">
                                            <i class="fas fa-<?php echo $user['status'] === 'active' ? 'check-circle' : 'times-circle'; ?>"></i>
                                            <?php echo ucfirst($user['status']); ?>
                                        </span>
                                    </td>
                                    <td><i class="far fa-clock"></i> <?php echo date('M j, Y g:i A', strtotime($user['last_login'])); ?></td>
                                    <td><i class="fas fa-sign-in-alt"></i> <?php echo $user['login_count']; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon btn-edit" title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-delete" title="Delete User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="btn-icon btn-view" title="View User">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <div class="table-info">
                            <i class="fas fa-info-circle"></i> Showing 1-<?php echo count($users); ?> of <?php echo count($users); ?> users
                        </div>
                        <div class="pagination">
                            <button class="btn btn-outline btn-sm" disabled><i class="fas fa-chevron-left"></i> Previous</button>
                            <button class="btn btn-primary btn-sm">1</button>
                            <button class="btn btn-outline btn-sm">Next <i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== -->
            <!-- FARMER MANAGEMENT SECTION -->
            <!-- ==================== -->
            <div id="farmers" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-tractor"></i> Farmer Management</h2>
                    <p>Manage farmer profiles and agricultural data</p>
                </div>

                <div class="content-card">
                    <div class="card-header with-actions">
                        <h3><i class="fas fa-users"></i> Registered Farmers</h3>
                        <div class="header-actions">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Search farmers..." id="farmerSearch">
                            </div>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add New Farmer
                            </button>
                        </div>
                    </div>

                    <div class="farmers-grid">
                        <?php foreach ($farmers as $farmer): ?>
                        <div class="farmer-card">
                            <div class="farmer-header">
                                <div class="farmer-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="farmer-info">
                                    <h4><?php echo htmlspecialchars($farmer['full_name']); ?></h4>
                                    <p class="farmer-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($farmer['farm_location']); ?>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="farmer-stats">
                                <div class="stat">
                                    <i class="fas fa-calendar-alt stat-icon-small"></i>
                                    <span class="stat-value"><?php echo $farmer['years_experience']; ?> yrs</span>
                                    <span class="stat-label">Experience</span>
                                </div>
                                <div class="stat">
                                    <i class="fas fa-vector-square stat-icon-small"></i>
                                    <span class="stat-value"><?php echo $farmer['farm_size']; ?> ha</span>
                                    <span class="stat-label">Farm Size</span>
                                </div>
                                <div class="stat">
                                    <i class="fas fa-leaf stat-icon-small"></i>
                                    <span class="stat-value"><?php echo ucfirst($farmer['farming_method']); ?></span>
                                    <span class="stat-label">Method</span>
                                </div>
                            </div>

                            <div class="farmer-details">
                                <div class="detail-item">
                                    <span class="detail-label"><i class="fas fa-landmark"></i> Land Ownership:</span>
                                    <span class="detail-value"><?php echo ucfirst($farmer['land_ownership']); ?></span>
                                </div>
                            </div>

                            <div class="farmer-actions">
                                <button class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> View Profile</button>
                                <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- ==================== -->
            <!-- CAMPAIGN MANAGEMENT SECTION -->
            <!-- ==================== -->
            <div id="campaigns" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-hand-holding-heart"></i> Campaign Management</h2>
                    <p>Monitor and manage crowdfunding campaigns</p>
                </div>

                <div class="content-card">
                    <div class="card-header with-actions">
                        <h3><i class="fas fa-bullhorn"></i> Active Campaigns</h3>
                        <div class="header-actions">
                            <select class="filter-select">
                                <option><i class="fas fa-filter"></i> All Status</option>
                                <option><i class="fas fa-play-circle"></i> Active</option>
                                <option><i class="fas fa-check-circle"></i> Completed</option>
                                <option><i class="fas fa-clock"></i> Pending</option>
                            </select>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Create Campaign
                            </button>
                        </div>
                    </div>

                    <div class="campaigns-list">
                        <?php foreach ($campaigns as $campaign): 
                            $progress = ($campaign['raised'] / $campaign['goal']) * 100;
                            $statusClass = $campaign['status'] === 'completed' ? 'completed' : 'active';
                        ?>
                        <div class="campaign-card">
                            <div class="campaign-header">
                                <h4><?php echo htmlspecialchars($campaign['title']); ?></h4>
                                <span class="campaign-status <?php echo $statusClass; ?>">
                                    <i class="fas fa-<?php echo $campaign['status'] === 'completed' ? 'check-circle' : 'play-circle'; ?>"></i>
                                    <?php echo ucfirst($campaign['status']); ?>
                                </span>
                            </div>
                            
                            <div class="campaign-farmer">
                                <i class="fas fa-user"></i>
                                <?php echo htmlspecialchars($campaign['farmer']); ?>
                            </div>

                            <div class="campaign-progress">
                                <div class="progress-info">
                                    <span><i class="fas fa-money-bill-wave"></i> ₱<?php echo number_format($campaign['raised']); ?> raised</span>
                                    <span><i class="fas fa-chart-line"></i> <?php echo number_format($progress, 1); ?>%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                                </div>
                                <div class="progress-goal">
                                    <i class="fas fa-bullseye"></i> Goal: ₱<?php echo number_format($campaign['goal']); ?>
                                </div>
                            </div>

                            <div class="campaign-meta">
                                <div class="meta-item">
                                    <i class="fas fa-users"></i>
                                    <span><?php echo $campaign['supporters']; ?> supporters</span>
                                </div>
                            </div>

                            <div class="campaign-actions">
                                <button class="btn btn-outline btn-sm"><i class="fas fa-eye"></i> View Details</button>
                                <button class="btn btn-primary btn-sm"><i class="fas fa-cog"></i> Manage</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- ==================== -->
            <!-- ANALYTICS SECTION -->
            <!-- ==================== -->
            <div id="analytics" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-chart-bar"></i> Platform Analytics</h2>
                    <p>Detailed insights and performance metrics</p>
                </div>

                <div class="content-row">
                    <div class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-user-growth"></i> User Growth</h3>
                        </div>
                        <div class="chart-placeholder">
                            <div class="chart-container">
                                <i class="fas fa-chart-line fa-3x"></i>
                                <p>User growth chart would be displayed here</p>
                                <div class="mock-chart">
                                    <div class="chart-bar" style="height: 60%"></div>
                                    <div class="chart-bar" style="height: 80%"></div>
                                    <div class="chart-bar" style="height: 45%"></div>
                                    <div class="chart-bar" style="height: 90%"></div>
                                    <div class="chart-bar" style="height: 75%"></div>
                                    <div class="chart-bar" style="height: 95%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="card-header">
                            <h3><i class="fas fa-globe-asia"></i> Regional Distribution</h3>
                        </div>
                        <div class="chart-placeholder">
                            <div class="chart-container">
                                <i class="fas fa-chart-pie fa-3x"></i>
                                <p>Regional distribution chart would be displayed here</p>
                                <div class="mock-pie-chart">
                                    <div class="pie-segment" style="--segment-size: 60%; --segment-color: #4a7c59;"></div>
                                    <div class="pie-segment" style="--segment-size: 25%; --segment-color: #8db596;"></div>
                                    <div class="pie-segment" style="--segment-size: 15%; --segment-color: #d4af37;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>



<script>
function showSection(sectionId) {
    console.log('Switching to section:', sectionId);
    
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Update navigation
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => item.classList.remove('active'));
    
    const clickedNav = Array.from(navItems).find(item => {
        return item.getAttribute('onclick')?.includes(sectionId);
    });
    
    if (clickedNav) clickedNav.classList.add('active');
    
    // Show new section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    updateSectionTitles(sectionId);
    
    // Scroll to top smoothly
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateSectionTitles(sectionId) {
    const breadcrumbText = document.getElementById('breadcrumbText');
    const pageTitle = document.getElementById('pageTitle');
    
    const sectionTitles = {
        'dashboard': 'Dashboard',
        'users': 'User Management', 
        'farmers': 'Farmer Management',
        'campaigns': 'Campaign Management',
        'analytics': 'Analytics'
    };
    
    if (breadcrumbText && sectionTitles[sectionId]) {
        breadcrumbText.textContent = sectionTitles[sectionId];
    }
    
    if (pageTitle && sectionTitles[sectionId]) {
        pageTitle.textContent = sectionTitles[sectionId];
    }
}

// Initialize the dashboard
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard initialized');
    
    // Add smooth transitions to all interactive elements
    const interactiveElements = document.querySelectorAll('.btn, .nav-item, .stat-card, .content-card');
    interactiveElements.forEach(element => {
        element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
    });
});
</script>

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>