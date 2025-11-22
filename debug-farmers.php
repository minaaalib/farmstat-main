<?php
session_start();
require_once 'app/config/config.php';

echo "<h3>🔍 Debugging Farmers Data - Fixed Version</h3>";

try {
    // Use the same connection method as the application
    $host = DB_HOST;
    $dbname = DB_NAME;
    $username = DB_USER;
    $password = DB_PASS;
    
    // Create direct PDO connection (bypassing the Database class)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Database connected successfully<br><br>";
    
    // Get all farmers
    $stmt = $pdo->query("SELECT * FROM farmers");
    $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "📊 Total farmers found: " . count($farmers) . "<br><br>";
    
    if (count($farmers) > 0) {
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
        echo "<th>ID</th><th>Name</th><th>Experience</th><th>Location</th><th>Farm Size</th><th>Method</th>";
        echo "</tr>";
        
        foreach ($farmers as $farmer) {
            echo "<tr>";
            echo "<td style='padding: 8px;'>" . $farmer['id'] . "</td>";
            echo "<td style='padding: 8px;'>" . $farmer['full_name'] . "</td>";
            echo "<td style='padding: 8px;'>" . $farmer['years_experience'] . " years</td>";
            echo "<td style='padding: 8px;'>" . $farmer['farm_location'] . "</td>";
            echo "<td style='padding: 8px;'>" . $farmer['farm_size'] . " hectares</td>";
            echo "<td style='padding: 8px;'>" . $farmer['farming_method'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ No farmers found in database";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
    echo "<br><br>📝 Check these settings in config.php:";
    echo "<br>Host: " . DB_HOST;
    echo "<br>Database: " . DB_NAME;
    echo "<br>User: " . DB_USER;
}
?>