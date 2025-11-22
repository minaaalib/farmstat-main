<?php
$title = 'Admin Dashboard - FarmStats';

// Include database connection
require_once APP_PATH . '/config/database.php';

try {
    // Get database connection
    $db = Database::getConnection();

    // Fetch users data
    $users_query = "SELECT * FROM users ORDER BY created_at DESC LIMIT 10";
    $users_stmt = $db->prepare($users_query);
    $users_stmt->execute();
    $users = $users_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch farmers data
    $farmers_query = "SELECT * FROM farmers ORDER BY created_at DESC";
    $farmers_stmt = $db->prepare($farmers_query);
    $farmers_stmt->execute();
    $farmers = $farmers_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch campaigns data
    $campaigns_query = "SELECT c.*, f.full_name as farmer_name 
                       FROM campaigns c 
                       LEFT JOIN farmers f ON c.farmer_id = f.id 
                       ORDER BY c.created_at DESC";
    $campaigns_stmt = $db->prepare($campaigns_query);
    $campaigns_stmt->execute();
    $campaigns = $campaigns_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch dashboard statistics
    $stats_query = "
        SELECT 
            (SELECT COUNT(*) FROM users) as total_users,
            (SELECT COUNT(*) FROM farmers) as total_farmers,
            (SELECT COUNT(*) FROM campaigns) as total_campaigns,
            (SELECT COALESCE(SUM(amount_raised), 0) FROM campaigns) as total_funding,
            (SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()) as new_users_today,
            (SELECT COUNT(*) FROM campaigns WHERE status = 'active') as active_campaigns
    ";
    $stats_stmt = $db->prepare($stats_query);
    $stats_stmt->execute();
    $stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch recent activities
    $activities_query = "
        SELECT a.*, f.full_name as farmer_name 
        FROM activities a 
        LEFT JOIN farmers f ON a.farmer_id = f.id 
        ORDER BY a.created_at DESC 
        LIMIT 5
    ";
    $activities_stmt = $db->prepare($activities_query);
    $activities_stmt->execute();
    $activities = $activities_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch user activities
    $user_activities_query = "
        SELECT ua.*, u.name as user_name 
        FROM user_activities ua 
        LEFT JOIN users u ON ua.user_id = u.id 
        ORDER BY ua.created_at DESC 
        LIMIT 5
    ";
    $user_activities_stmt = $db->prepare($user_activities_query);
    $user_activities_stmt->execute();
    $user_activities = $user_activities_stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $exception) {
    error_log("Database Error: " . $exception->getMessage());
    // Fallback to empty data if database fails
    $users = [];
    $farmers = [];
    $campaigns = [];
    $stats = [
        'total_users' => 0, 
        'total_farmers' => 0, 
        'total_campaigns' => 0, 
        'total_funding' => 0,
        'new_users_today' => 0,
        'active_campaigns' => 0
    ];
    $activities = [];
    $user_activities = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FarmStats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --gradient-primary: linear-gradient(135deg, var(--primary-medium) 0%, var(--primary-dark) 100%);
            --gradient-gold: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-orange) 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
        }

        /* ===== MAIN LAYOUT ===== */
        #adminDashboard {
            display: flex;
            min-height: 100vh;
        }

        /* ===== ENHANCED SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--white);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: var(--shadow);
            border-right: 1px solid var(--border);
            z-index: 1000;
            transition: var(--transition);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, var(--white) 0%, #f8fbf8 100%);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary-dark);
            padding: 8px 0;
        }

        .logo {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .logo:hover {
            transform: rotate(-5deg) scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        .brand-text {
            color: var(--primary-dark);
            font-weight: 800;
            letter-spacing: -0.5px;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-nav {
            padding: 16px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 24px;
            cursor: pointer;
            transition: var(--transition);
            border-left: 3px solid transparent;
            margin: 2px 12px;
            border-radius: 12px;
            color: var(--text-light);
            font-weight: 500;
        }

        .nav-item:hover {
            background: var(--background);
            color: var(--primary-dark);
            transform: translateX(2px);
        }

        .nav-item.active {
            background: var(--gradient-primary);
            color: var(--white);
            border-left-color: var(--accent-gold);
            box-shadow: var(--shadow);
        }

        .nav-item.active .nav-icon {
            color: var(--white);
        }

        .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            color: var(--text-light);
            transition: var(--transition);
        }

        .nav-item:hover .nav-icon {
            color: var(--primary-dark);
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background: var(--background);
            transition: var(--transition);
        }

        .dashboard-header {
            background: var(--white);
            padding: 20px 32px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-left h1 {
            margin: 0 0 6px 0;
            font-size: 1.5rem;
            color: var(--primary-dark);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 0.85rem;
        }

        .breadcrumb-separator {
            color: var(--primary-light);
            font-size: 0.7rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: var(--shadow);
        }

        .page-content {
            padding: 24px;
            position: relative;
        }

        /* ===== CONTENT SECTIONS ===== */
        .content-section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-header {
            margin-bottom: 24px;
        }

        .section-header h2 {
            margin: 0 0 8px 0;
            font-size: 1.7rem;
            color: var(--primary-dark);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header p {
            margin: 0;
            color: var(--text-light);
            font-size: 1rem;
        }

        /* ===== ENHANCED STATS CARDS ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary-medium);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            opacity: 0;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card.primary { border-left-color: var(--primary-dark); }
        .stat-card.success { border-left-color: var(--primary-medium); }
        .stat-card.warning { border-left-color: var(--accent-gold); }
        .stat-card.info { border-left-color: var(--accent-orange); }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow);
            flex-shrink: 0;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary-dark);
            margin: 0;
            line-height: 1;
        }

        .stat-label {
            color: var(--text-light);
            margin: 6px 0 0 0;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-trend {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 16px;
            background: var(--background);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat-trend.up {
            background: #e8f5e8;
            color: var(--primary-medium);
            border-color: #d4e8d4;
        }

        .stat-trend.down {
            background: #fde8e8;
            color: #e53e3e;
            border-color: #fbd5d5;
        }

        /* ===== ENHANCED CONTENT CARDS ===== */
        .content-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .content-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            border: 1px solid var(--border);
        }

        .content-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
        }

        .card-header.with-actions {
            padding: 18px 24px;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--primary-dark);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            color: var(--primary-light);
            z-index: 2;
        }

        .search-box input {
            padding: 8px 12px 8px 36px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.85rem;
            width: 200px;
            background: var(--white);
            transition: var(--transition);
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-medium);
            box-shadow: 0 0 0 2px rgba(74, 124, 89, 0.1);
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.85rem;
            background: var(--white);
            color: var(--text);
            transition: var(--transition);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-medium);
            box-shadow: 0 0 0 2px rgba(74, 124, 89, 0.1);
        }

        /* ===== ENHANCED BUTTONS ===== */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #143824 100%);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-medium);
            border: 1px solid var(--primary-medium);
            font-weight: 600;
        }

        .btn-outline:hover {
            background: var(--primary-medium);
            color: var(--white);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
        }

        .btn-icon {
            background: none;
            border: none;
            padding: 8px;
            border-radius: 10px;
            cursor: pointer;
            color: var(--text-light);
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--background);
            color: var(--primary-dark);
            transform: scale(1.1);
        }

        .btn-edit:hover {
            color: var(--primary-medium);
            background: #e8f5e8;
        }

        .btn-delete:hover {
            color: #e53e3e;
            background: #fde8e8;
        }

        .btn-view:hover {
            color: var(--primary-dark);
            background: #e8f5e8;
        }

        /* ===== FIXED TABLE STYLES ===== */
        .table-container {
            overflow-x: auto;
            border-radius: 0 0 var(--border-radius) var(--border-radius);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--white);
        }

        .data-table thead {
            background: linear-gradient(135deg, #f8fbf8 0%, #e8f5e8 100%);
        }

        .data-table th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 700;
            color: var(--primary-dark);
            border-bottom: 2px solid var(--border);
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .data-table th i {
            font-size: 0.8rem;
            opacity: 0.7;
            margin-right: 6px;
        }

        .data-table td {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
            color: var(--text);
            vertical-align: middle;
        }

        .data-table tr {
            transition: var(--transition);
        }

        .data-table tr:hover {
            background: #f8fbf8;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar.sm {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .table-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fbf8;
        }

        .table-info {
            color: var(--text-light);
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pagination {
            display: flex;
            gap: 10px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        /* ===== ENHANCED BADGES ===== */
        .badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-primary {
            background: linear-gradient(135deg, var(--primary-light) 0%, var(--primary-medium) 100%);
            color: var(--white);
        }

        .badge-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: var(--white);
        }

        .badge-danger {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: var(--white);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status-active {
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            color: #22543d;
        }

        .status-inactive {
            background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
            color: #4a5568;
        }

        /* ===== ENHANCED FARMER CARDS ===== */
        .farmers-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            padding: 24px;
        }

        .farmer-card {
            background: var(--white);
            border: 2px solid var(--border);
            border-radius: var(--border-radius);
            padding: 24px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .farmer-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .farmer-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-6px);
            border-color: var(--primary-light);
        }

        .farmer-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .farmer-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow);
            flex-shrink: 0;
        }

        .farmer-info h4 {
            margin: 0 0 6px 0;
            font-size: 1.2rem;
            color: var(--primary-dark);
            font-weight: 700;
        }

        .farmer-location {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .farmer-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat {
            text-align: center;
            padding: 12px;
            background: var(--background);
            border-radius: 14px;
            border: 1px solid var(--border);
            transition: var(--transition);
            position: relative;
        }

        .stat:hover {
            background: var(--white);
            box-shadow: var(--shadow);
        }

        .stat-icon-small {
            font-size: 1rem;
            color: var(--primary-medium);
            margin-bottom: 8px;
        }

        .stat-value {
            display: block;
            font-weight: 800;
            color: var(--primary-dark);
            font-size: 0.95rem;
        }

        .stat-label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-top: 4px;
            font-weight: 600;
        }

        .farmer-details {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--background);
            border-radius: 14px;
            border: 1px solid var(--border);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 8px;
            align-items: center;
        }

        .detail-label {
            color: var(--text-light);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .detail-value {
            color: var(--primary-dark);
            font-weight: 700;
        }

        .farmer-actions {
            display: flex;
            gap: 10px;
        }

        /* ===== ENHANCED CAMPAIGN CARDS ===== */
        .campaigns-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 24px;
        }

        .campaign-card {
            background: var(--white);
            border: 2px solid var(--border);
            border-radius: var(--border-radius);
            padding: 24px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .campaign-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-gold);
        }

        .campaign-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
            border-color: var(--accent-gold);
        }

        .campaign-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .campaign-header h4 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--primary-dark);
            flex: 1;
            font-weight: 700;
        }

        .campaign-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .campaign-status.active {
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            color: #22543d;
        }

        .campaign-status.completed {
            background: linear-gradient(135deg, #bee3f8 0%, #90cdf4 100%);
            color: #2a4365;
        }

        .campaign-farmer {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .campaign-progress {
            margin-bottom: 20px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--primary-dark);
        }

        .progress-info span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .progress-bar {
            height: 10px;
            background: var(--border);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-fill {
            height: 100%;
            background: var(--gradient-primary);
            border-radius: 10px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .progress-fill::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .progress-goal {
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .campaign-meta {
            margin-bottom: 20px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            color: var(--text-light);
            font-weight: 500;
        }

        .campaign-actions {
            display: flex;
            gap: 10px;
        }

        /* ===== ENHANCED ACTIVITY & ACTIONS ===== */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 0 24px 20px 24px;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 16px;
            border-radius: 16px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .activity-item:hover {
            background: var(--background);
            border-color: var(--border);
            transform: translateX(4px);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
            box-shadow: var(--shadow);
        }

        .activity-icon.success { 
            background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
            color: #22543d;
        }
        .activity-icon.primary { 
            background: linear-gradient(135deg, #bee3f8 0%, #90cdf4 100%);
            color: #2a4365;
        }
        .activity-icon.warning { 
            background: linear-gradient(135deg, #fef3c7 0%, #fbd38d 100%);
            color: #744210;
        }

        .activity-content p {
            margin: 0 0 6px 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .activity-time {
            font-size: 0.85rem;
            color: var(--text-light);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            padding: 0 24px 20px 24px;
        }

        .action-btn {
            background: var(--white);
            border: 2px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            text-align: center;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .action-btn:hover {
            background: var(--gradient-primary);
            color: var(--white);
            transform: translateY(-4px);
            border-color: var(--primary-medium);
            box-shadow: var(--shadow-lg);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            background: var(--gradient-primary);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .action-btn:hover .action-icon {
            background: var(--white);
            color: var(--primary-medium);
            transform: scale(1.1);
        }

        /* ===== ENHANCED CHARTS ===== */
        .chart-placeholder {
            padding: 24px;
        }

        .chart-container {
            height: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--background);
            border-radius: var(--border-radius);
            border: 2px dashed var(--border);
            color: var(--text-light);
            font-weight: 500;
        }

        .mock-chart {
            display: flex;
            align-items: end;
            gap: 10px;
            height: 120px;
            margin-top: 20px;
        }

        .chart-bar {
            width: 35px;
            background: var(--gradient-primary);
            border-radius: 8px 8px 0 0;
            transition: height 0.3s ease;
            box-shadow: var(--shadow);
        }

        .mock-pie-chart {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: conic-gradient(
                var(--segment-color) 0% var(--segment-size),
                var(--border) var(--segment-size) 100%
            );
            margin-top: 20px;
            box-shadow: var(--shadow);
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 1200px) {
            .content-row {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .farmers-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .nav-text {
                display: none;
            }
            
            .sidebar-brand .brand-text {
                display: none;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .farmers-grid {
                grid-template-columns: 1fr;
            }
            
            .page-content {
                padding: 16px;
            }
            
            .dashboard-header {
                padding: 16px;
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
            
            .header-actions {
                flex-direction: column;
                gap: 10px;
                width: 100%;
            }
            
            .search-box input {
                width: 100%;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--background);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-medium);
        }
    </style>
</head>
<body>
    <div id="adminDashboard">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <div class="logo">
                        🌱
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
                            <span>Welcome, Admin</span>
                        </div>
                        <a href="#" class="btn btn-outline btn-sm">
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
                                        <td>#<?php echo htmlspecialchars($user['id']); ?></td>
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
                                $progress = ($campaign['amount_raised'] / $campaign['funding_goal']) * 100;
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
                                    <?php echo htmlspecialchars($campaign['farmer_name']); ?>
                                </div>

                                <div class="campaign-progress">
                                    <div class="progress-info">
                                        <span><i class="fas fa-money-bill-wave"></i> ₱<?php echo number_format($campaign['amount_raised']); ?> raised</span>
                                        <span><i class="fas fa-chart-line"></i> <?php echo number_format($progress, 1); ?>%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?php echo $progress; ?>%"></div>
                                    </div>
                                    <div class="progress-goal">
                                        <i class="fas fa-bullseye"></i> Goal: ₱<?php echo number_format($campaign['funding_goal']); ?>
                                    </div>
                                </div>

                                <div class="campaign-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-users"></i>
                                        <span><?php echo $campaign['supporters_count']; ?> supporters</span>
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
            
            // Show new section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
            
            // Update active nav item
            const clickedNav = Array.from(navItems).find(item => {
                return item.getAttribute('onclick')?.includes(sectionId);
            });
            
            if (clickedNav) {
                clickedNav.classList.add('active');
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
            
            const sectionIcons = {
                'dashboard': 'fa-tachometer-alt',
                'users': 'fa-users', 
                'farmers': 'fa-tractor',
                'campaigns': 'fa-hand-holding-heart',
                'analytics': 'fa-chart-bar'
            };
            
            if (breadcrumbText && sectionTitles[sectionId]) {
                breadcrumbText.textContent = sectionTitles[sectionId];
            }
            
            if (pageTitle && sectionTitles[sectionId] && sectionIcons[sectionId]) {
                pageTitle.innerHTML = `<i class="fas ${sectionIcons[sectionId]}"></i> ${sectionTitles[sectionId]}`;
            }
        }

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Admin Dashboard initialized');
            
            // Add search functionality
            const userSearch = document.getElementById('userSearch');
            if (userSearch) {
                userSearch.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('#users .data-table tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }

            const farmerSearch = document.getElementById('farmerSearch');
            if (farmerSearch) {
                farmerSearch.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const cards = document.querySelectorAll('#farmers .farmer-card');
                    
                    cards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        card.style.display = text.includes(searchTerm) ? '' : 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>
<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?>