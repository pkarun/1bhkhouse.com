<?php
/**
 * This script performs a literal, case-insensitive string replacement 
 * for the exact HTML block you provided.
 */

echo "Enter the folder path: ";
$target_dir = trim(fgets(STDIN));

$files = glob($target_dir . '/*.html');

foreach ($files as $file) {
    $content = file_get_contents($file);

    // This is the exact string you want to find
    $search = '<a
      href="/" target="_blank" rel="noreferrer noopener"></a><a
      href="/" target="_blank" rel="nofollow noopener
      noreferrer">/</a>';
    
    // This is the exact string you want to replace it with
    $replace = '<a
      href="/" target="_blank" rel="nofollow noopener
      noreferrer">https://1bhkhouse.com</a>';

    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Successfully updated link in: " . basename($file) . "\n";
    }
}
echo "Process complete.\n";
?>