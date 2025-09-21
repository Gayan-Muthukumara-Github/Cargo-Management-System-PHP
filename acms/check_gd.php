<?php
echo "<h2>PHP GD Extension Check</h2>";
echo "<hr>";

// Check if GD extension is loaded
if (extension_loaded('gd')) {
    echo "<p style='color: green; font-weight: bold;'>✅ GD Extension is ENABLED</p>";
    
    // Get GD info
    $gd_info = gd_info();
    echo "<h3>GD Information:</h3>";
    echo "<ul>";
    foreach ($gd_info as $key => $value) {
        if (is_bool($value)) {
            $value = $value ? 'Yes' : 'No';
        }
        echo "<li><strong>$key:</strong> $value</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ GD Extension is NOT ENABLED</p>";
    echo "<h3>How to Enable GD Extension:</h3>";
    echo "<ol>";
    echo "<li>Open <code>C:\\xampp\\php\\php.ini</code> in a text editor</li>";
    echo "<li>Find the line: <code>;extension=gd</code></li>";
    echo "<li>Remove the semicolon to make it: <code>extension=gd</code></li>";
    echo "<li>Save the file</li>";
    echo "<li>Restart Apache in XAMPP Control Panel</li>";
    echo "</ol>";
}

echo "<hr>";
echo "<h3>PHP Version: " . phpversion() . "</h3>";
echo "<h3>PHP Configuration File: " . php_ini_loaded_file() . "</h3>";

// Check if specific GD functions exist
echo "<h3>GD Function Availability:</h3>";
$functions = ['imagecreatefromjpeg', 'imagecreatefrompng', 'imagejpeg', 'imagepng', 'imagescale'];
foreach ($functions as $func) {
    if (function_exists($func)) {
        echo "<p style='color: green;'>✅ $func() - Available</p>";
    } else {
        echo "<p style='color: red;'>❌ $func() - Not Available</p>";
    }
}
?>
