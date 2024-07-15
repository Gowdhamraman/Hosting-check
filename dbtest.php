<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>MySQL Connection Test</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">
#wrapper {
    width: 600px;
    margin: 20px auto 0;
    font: 1.2em Verdana, Arial, sans-serif;
}
input {
    font-size: 1em;
}
#submit {
    padding: 4px 8px;
}
</style>
</head>
 
<body>
 
<div id="wrapper">
 
<?php
    $action = isset($_GET['action']) ? htmlspecialchars($_GET['action'], ENT_QUOTES) : '';
?>
 
<?php if ($action !== "test") { ?>
 
    <h1>MySQL connection test</h1>
 
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=test" id="mail" method="post">
 
    <table cellpadding="2">
        <tr>
            <td>Hostname</td>
            <td><input type="text" name="hostname" id="hostname" value="" size="30" tabindex="1" /></td>
            <td>(usually "localhost")</td>
        </tr>
        <tr>
            <td>Username</td>
            <td><input type="text" name="username" id="username" value="" size="30" tabindex="2" /></td>
            <td></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" name="password" id="password" value="" size="30" tabindex="3" /></td>
            <td></td>
        </tr>
        <tr>
            <td>Database</td>
            <td><input type="text" name="database" id="database" value="" size="30" tabindex="4" /></td>
            <td>(optional)</td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" id="submit" value="Test Connection" tabindex="5" /></td>
            <td></td>
        </tr>
    </table>
 
</form>
 
<?php } ?>
 
<?php if ($action === "test") {
 
    $hostname = trim($_POST['hostname']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $database = trim($_POST['database']);
 
    $link = mysqli_connect($hostname, $username, $password);
    
    if (!$link) {
        echo "<p>Could not connect to the server '" . htmlspecialchars($hostname, ENT_QUOTES) . "'</p>";
        echo mysqli_connect_error();
    } else {
        echo "<p>Successfully connected to the server '" . htmlspecialchars($hostname, ENT_QUOTES) . "'</p>";
    }

    if ($link && !$database) {
        echo "<p>No database name was given. Available databases:</p>";
        $result = mysqli_query($link, "SHOW DATABASES");
        echo "<pre>";
        while ($row = mysqli_fetch_array($result)) {
            echo htmlspecialchars($row['Database'], ENT_QUOTES) . "\n";
        }
        echo "</pre>";
    }
    
    if ($database) {
        $dbcheck = mysqli_select_db($link, $database);
        if (!$dbcheck) {
            echo mysqli_error($link);
        } else {
            echo "<p>Successfully connected to the database '" . htmlspecialchars($database, ENT_QUOTES) . "'</p>";
            // Check tables
            $sql = "SHOW TABLES FROM `" . mysqli_real_escape_string($link, $database) . "`";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<p>Available tables:</p>";
                echo "<pre>";
                while ($row = mysqli_fetch_row($result)) {
                    echo htmlspecialchars($row[0], ENT_QUOTES) . "\n";
                }
                echo "</pre>";
            } else {
                echo "<p>The database '" . htmlspecialchars($database, ENT_QUOTES) . "' contains no tables.</p>";
                echo mysqli_error($link);
            }
        }
    }
    
    mysqli_close($link);
}
?>
 
</div><!-- end #wrapper -->
</body>
</html>
