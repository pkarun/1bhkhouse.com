<?php
/**
 * This script removes duplicate <a> tag patterns and updates the 
 * anchor text/href to a user-provided domain.
 * run this script after changing absolute links to relative links in the HTML files.
 */

echo "Enter the folder path: ";
$target_dir = trim(fgets(STDIN));

echo "Enter the domain to use (e.g., https://1bhkhouse.com): ";
$domain = trim(fgets(STDIN));

$files = glob($target_dir . '/*.html');

foreach ($files as $file) {
    $content = file_get_contents($file);

    // 1. Regex to find the duplicate <a> tag pattern
    // It looks for: <a ...></a><a ...>Target</a>
    // We replace the whole block with a single clean <a> tag
    $pattern = '/<a[^>]*?href="[^"]*?"[^>]*?><\/a><a[^>]*?href="[^"]*?"[^>]*?>(.*?)<\/a>/is';
    $replacement = '<a href="' . $domain . '" target="_blank" rel="noreferrer noopener">' . $domain . '</a>';
    
    $newContent = preg_replace($pattern, $replacement, $content);

    // 2. Fix the specific "P.S." case where the anchor text is just '/'
    // We replace any stray '/' inside or after an anchor with the domain
    $newContent = str_replace('></a>/', '>' . $domain . '</a>', $newContent);

    if ($newContent !== $content) {
        file_put_contents($file, $newContent);
        echo "Cleaned duplicate links in: " . basename($file) . "\n";
    }
}
echo "Process complete.\n";
?>