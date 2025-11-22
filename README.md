 HEAD
=======
# 🌾 FarmStat - Rice Farming Intelligence & Crowdfunding Platform

**FarmStat** is a comprehensive web-based platform designed to empower Filipino rice farmers through digital profiling, community-backed funding, and agricultural intelligence. The platform aims to create the most detailed agricultural database in the Philippines while providing essential tools for farmer management, seasonal tracking, crowdfunding campaigns, and analytics.

![FarmStat Dashboard](https://github.com/user-attachments/assets/a52eb8c3-7610-4052-9958-782fdfe721d6)

## 🛠️ Installation & Setup

This project uses a custom PHP Model-View-Controller (MVC) architecture. To run it locally, follow these steps:

### Prerequisites
- XAMPP (or similar LAMP/WAMP stack like Laragon or MAMP)
- PHP 8.0 or higher
- MySQL 5.7 or higher

### Installation Steps

1. **Clone or Download the Project**
   ```bash
   # Place the farmstat-main folder in your XAMPP htdocs directory
   C:\xampp\htdocs\farmstat-main\
   ```

2. **Start XAMPP Services**
   - Open your XAMPP Control Panel and ensure both Apache and MySQL services are running.

3. **Create the Database**
   - Open phpMyAdmin in your browser: `http://localhost/phpmyadmin/`
   - Import the provided database schema file: `farmstats_db.sql`
   - This creates the database (`farmstats_db`) and populates it with sample user data (Admin/Farmer)

4. **Configure the Database Connection**
   - Edit the database credentials in the main configuration file:
   - Open the file: `app/config/config.php`
   - Edit the lines for your database connection details:
   ```php
   // Database configuration
   define('DB_HOST', '127.0.0.1:3306');  // Change port if needed (e.g., to 3325)
   define('DB_NAME', 'farmstats_db');
   define('DB_USER', 'root');           // Default XAMPP user
   define('DB_PASS', '');               // Default XAMPP password (often blank)
   ```
   - **Note:** If your MySQL port is not the standard 3306, you must change it here (e.g., to `127.0.0.1:3325`)

5. **Access the Application**
   - Open your web browser and navigate to the project's URL:
   - `http://localhost/farmstat-main/`
   - You should now see the landing page.

## 🏗️ Application Architecture (MVC)

The project follows a strong Model-View-Controller (MVC) pattern for better scalability and maintainability:

| Component | Directory | Function |
|-----------|-----------|----------|
| **Controllers** | `app/controllers/` | Process user input, handle business logic, and route requests (e.g., `AuthController.php`, `AdminController.php`) |
| **Models** | `app/models/` | Handle data operations and database interactions (e.g., `User.php`, `Farmer.php`) |
| **Views** | `app/views/` | Present data to users with clean HTML templates (e.g., `auth/login.php`, `dashboard/admin.php`) |
| **Core** | `app/core/` | Contains base classes for the framework, including the custom `Router.php` for clean URL handling |
| **Entry Point** | `index.php` | The single point of entry for all application requests, managed by the router |

### Key Improvements
- **Clean URLs:** Uses a custom router and an `.htaccess` file for friendly URLs (e.g., `/login`, `/admin/users`)
- **Separation of Concerns:** Logic, presentation, and data are strictly isolated
- **Role-Based Security:** Authentication and access control are handled at the controller level

## 👥 User Roles & Sample Credentials

The application is set up with two primary roles for testing:

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| **Admin** | `admin@farmstat.com` | `password` | Full system management (User, Farmer, Campaign CRUD) |
| **Farmer** | `farmer@farmstat.com` | `password` | Personal dashboard, seasonal tracking, community features |

## 🛠️ Development Workflow: Adding New Features

To add any new feature to FarmStat, you must touch three main areas of the MVC pattern: the Controller (logic), the Model (data), and the View (presentation).

### 1. The Model: Handling Data (Database) 💾

The Model handles the data structure and interaction with the `farmstats_db` database.

**A. Database Preparation**
- **Action:** Create the necessary table in your database (e.g., `livestock`)
- **Example:** A table with columns for `id`, `farmer_id`, `type`, `count`, `created_at`
- **Tool:** Use phpMyAdmin or a MySQL client to run your `CREATE TABLE` script

**B. Create the New Model File**
- **Location:** `app/models/`
- **Action:** Create a new PHP class file for the feature (e.g., `Livestock.php`)
- **Content:** This file contains methods to interact with the new table (`livestock`)

```php
// app/models/Livestock.php
class Livestock extends Database
{
    // Method to fetch all livestock for a given farmer
    public function getLivestockByFarmer($farmer_id)
    {
        $sql = "SELECT * FROM livestock WHERE farmer_id = :farmer_id";
        return $this->select($sql, ['farmer_id' => $farmer_id]);
    }

    // Method to insert new livestock data
    public function addLivestock($data)
    {
        // ... SQL INSERT logic using prepared statements ...
    }
    // ... Other methods (update, delete) ...
}
```

### 2. The Controller: Routing and Logic 🎯

The Controller handles user input, executes the necessary model methods, and decides which view to load.

**A. Define the Route**
- **Location:** `index.php` (or your dedicated router file, `app/core/Router.php`)
- **Action:** Define a new clean URL endpoint for the feature (e.g., `/farmer/livestock`)

**B. Create or Update the Controller File**
- **Location:** `app/controllers/`
- **Action:** Update the existing `FarmerController.php` or create a new dedicated controller
- **Content:** Write a new public method that handles the feature logic

```php
// app/controllers/FarmerController.php
public function livestock()
{
    // 1. Authorization check (ensures only farmers can access)
    if ($_SESSION['user_role'] !== 'farmer') {
        header("Location: " . BASE_URL . "/login");
        exit;
    }

    // 2. Load the model and fetch data
    $livestockModel = $this->model('Livestock');
    $data['livestock'] = $livestockModel->getLivestockByFarmer($_SESSION['user_id']);

    // 3. Load the view, passing the data
    $this->view('farmer/livestock', $data);
}
```

### 3. The View: User Interface (UI) 🎨

The View is where the HTML, CSS, and JavaScript reside to display the data fetched by the Controller.

**A. Create the New View File**
- **Location:** `app/views/farmer/`
- **Action:** Create the new view file (e.g., `livestock.php`)
- **Content:** Write the HTML structure for the feature interface

```php
// app/views/farmer/livestock.php
<?php include_once 'layouts/header.php'; ?>

<h2>Livestock Management</h2>
<table>
    <thead>
        <tr><th>Type</th><th>Count</th><th>Actions</th></tr>
    </thead>
    <tbody>
        <?php foreach ($data['livestock'] as $item): ?>
            <tr>
                <td><?php echo $item['type']; ?></td>
                <td><?php echo $item['count']; ?></td>
                <td><button>Edit</button></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once 'layouts/footer.php'; ?>
```

**B. Update Navigation/Layouts**
- **Location:** `app/views/layouts/header.php` or main dashboard view
- **Action:** Add a link to the new feature in the sidebar menu

```html
<a href="<?php echo BASE_URL; ?>/farmer/livestock">
    <i class="fas fa-cow"></i>
    <span>Livestock Management</span>
</a>
```

### Summary of File Changes

To deploy a new "Livestock Management" feature, you would modify and add files in these locations:

| File Type | Location | Action |
|-----------|----------|--------|
| **Model** | `app/models/Livestock.php` | Add new file with database functions |
| **Controller** | `app/controllers/FarmerController.php` | Update with the new `livestock()` method |
| **View** | `app/views/farmer/livestock.php` | Add new file for the UI display |
| **Layout** | `app/views/layouts/header.php` | Update to add the new navigation link |
| **Database** | `farmstats_db` | Add a new `livestock` table |

---

*FarmStat - Empowering Filipino Farmers Through Technology* 🌱
 48645cc2ff43352c76c2d9ad5cd4d8ac320966c4
