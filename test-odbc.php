<?php

// Database connection settings
$dsn = "sqlsrv:Server=erp.sodabiz.app\\sqlserverprod,3060;Database=esoft_veraneras";
$username = "sys_veraneras";
$password = "netP@ssport7787";

try {
    // Connect to the database
    $dbh = new PDO($dsn, $username, $password);
    
    // Set error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to test the connection (replace with your own query)
    $query = "SELECT TOP 1 * FROM ESoft_User";
    
    // Execute the query
    $stmt = $dbh->query($query);
    
    // Fetch the results
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Output the results
    print_r($result);
    
    // Close the database connection
    $dbh = null;
} catch (PDOException $e) {
    // Handle errors
    echo "Connection failed: " . $e->getMessage();
}
?>
