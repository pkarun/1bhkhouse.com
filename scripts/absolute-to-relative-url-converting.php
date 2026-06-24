<?php
/**
 * This script prompts for a path and converts absolute links 
 * (https://domain.com/path) into relative paths (/path).
 */

// 1. Get the folder path from the user
echo "Enter the full path of the folder to scan (e.g., /var/www/html/1bhkhouse.com): ";
$target_dir = trim(fgets(STDIN));

if (!is_dir($target_dir)) {
    die("Error: The path '$target_dir' does not exist.\n");
}

// 2. Get the domain to replace
echo "Enter the domain to strip out (e.g., 1bhkhouse.com): ";
$live_domain = trim(fgets(STDIN));

// 3. Scan the directory
$files = glob($target_dir . '/*.*'); 

foreach ($files as $file) {
    // Skip the script itself
    if (basename($file) == basename(__FILE__)) continue;

    $content = file_get_contents($file);

    // Regex: Looks for https://(www.)?domain.com/ and replaces with /
    $pattern = '/https?:\/\/(www\.)?' . preg_quote($live_domain, '/') . '/i';
    
    $newContent = preg_replace($pattern, '', $content);

    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated links in: " . basename($file) . "\n";
    }
}
echo "Process complete.\n";
?>