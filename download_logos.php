<?php
/**
 * NBA Team Logo Downloader
 * This script downloads all team logos and saves them locally
 * Run this once to set up local logo hosting
 */

// Create images directory if it doesn't exist
$image_dir = 'assets/images/logos/';
if (!is_dir($image_dir)) {
    mkdir($image_dir, 0755, true);
    echo "Created directory: $image_dir\n";
}

// NBA team logos - using reliable sources
$team_logos = [
    'lakers' => 'https://cdn.nba.com/logos/nba/1610612747/primary/L/logo.svg',
    'celtics' => 'https://cdn.nba.com/logos/nba/1610612738/primary/L/logo.svg',
    'warriors' => 'https://cdn.nba.com/logos/nba/1610612744/primary/L/logo.svg',
    'heat' => 'https://cdn.nba.com/logos/nba/1610612748/primary/L/logo.svg',
    'nets' => 'https://cdn.nba.com/logos/nba/1610612751/primary/L/logo.svg',
    'knicks' => 'https://cdn.nba.com/logos/nba/1610612752/primary/L/logo.svg',
    '76ers' => 'https://cdn.nba.com/logos/nba/1610612755/primary/L/logo.svg',
    'raptors' => 'https://cdn.nba.com/logos/nba/1610612761/primary/L/logo.svg',
    'bulls' => 'https://cdn.nba.com/logos/nba/1610612741/primary/L/logo.svg',
    'cavaliers' => 'https://cdn.nba.com/logos/nba/1610612739/primary/L/logo.svg',
    'pistons' => 'https://cdn.nba.com/logos/nba/1610612765/primary/L/logo.svg',
    'pacers' => 'https://cdn.nba.com/logos/nba/1610612754/primary/L/logo.svg',
    'bucks' => 'https://cdn.nba.com/logos/nba/1610612749/primary/L/logo.svg',
    'hawks' => 'https://cdn.nba.com/logos/nba/1610612737/primary/L/logo.svg',
    'hornets' => 'https://cdn.nba.com/logos/nba/1610612766/primary/L/logo.svg',
    'magic' => 'https://cdn.nba.com/logos/nba/1610612753/primary/L/logo.svg',
    'wizards' => 'https://cdn.nba.com/logos/nba/1610612764/primary/L/logo.svg',
    'nuggets' => 'https://cdn.nba.com/logos/nba/1610612743/primary/L/logo.svg',
    'timberwolves' => 'https://cdn.nba.com/logos/nba/1610612750/primary/L/logo.svg',
    'thunder' => 'https://cdn.nba.com/logos/nba/1610612760/primary/L/logo.svg',
    'blazers' => 'https://cdn.nba.com/logos/nba/1610612757/primary/L/logo.svg',
    'jazz' => 'https://cdn.nba.com/logos/nba/1610612762/primary/L/logo.svg',
    'mavericks' => 'https://cdn.nba.com/logos/nba/1610612742/primary/L/logo.svg',
    'rockets' => 'https://cdn.nba.com/logos/nba/1610612745/primary/L/logo.svg',
    'grizzlies' => 'https://cdn.nba.com/logos/nba/1610612763/primary/L/logo.svg',
    'pelicans' => 'https://cdn.nba.com/logos/nba/1610612740/primary/L/logo.svg',
    'spurs' => 'https://cdn.nba.com/logos/nba/1610612759/primary/L/logo.svg',
    'clippers' => 'https://cdn.nba.com/logos/nba/1610612746/primary/L/logo.svg',
    'kings' => 'https://cdn.nba.com/logos/nba/1610612758/primary/L/logo.svg',
    'suns' => 'https://cdn.nba.com/logos/nba/1610612756/primary/L/logo.svg'
];

// Fallback PNG logos if SVG doesn't work
$fallback_logos = [
    'lakers' => 'https://i.imgur.com/2z1bOzL.png',
    'celtics' => 'https://i.imgur.com/cDkjbgK.png',
    'warriors' => 'https://i.imgur.com/V9hKIgR.png',
    'heat' => 'https://i.imgur.com/mTg2tqd.png',
    'nets' => 'https://i.imgur.com/bBxYhDb.png',
    'knicks' => 'https://i.imgur.com/YLKVLbH.png',
    '76ers' => 'https://i.imgur.com/NVVgYTM.png',
    'raptors' => 'https://i.imgur.com/QCo0acn.png',
    'bulls' => 'https://i.imgur.com/vmaDHzQ.png',
    'cavaliers' => 'https://i.imgur.com/K0k4LcU.png',
    'pistons' => 'https://i.imgur.com/2zt6Glb.png',
    'pacers' => 'https://i.imgur.com/dkTJvYp.png',
    'bucks' => 'https://i.imgur.com/8y3Vnaj.png',
    'hawks' => 'https://i.imgur.com/h8gy21b.png',
    'hornets' => 'https://i.imgur.com/gf2jKf2.png',
    'magic' => 'https://i.imgur.com/0NhKqvU.png',
    'wizards' => 'https://i.imgur.com/q4XNwWL.png',
    'nuggets' => 'https://i.imgur.com/VqCq0bF.png',
    'timberwolves' => 'https://i.imgur.com/tZxNKBH.png',
    'thunder' => 'https://i.imgur.com/Z7ATL1v.png',
    'blazers' => 'https://i.imgur.com/hvLd32Q.png',
    'jazz' => 'https://i.imgur.com/6V9t1nt.png',
    'mavericks' => 'https://i.imgur.com/4h5xJ8v.png',
    'rockets' => 'https://i.imgur.com/X7fv8g5.png',
    'grizzlies' => 'https://i.imgur.com/KnCIWtg.png',
    'pelicans' => 'https://i.imgur.com/4Q7u9Wk.png',
    'spurs' => 'https://i.imgur.com/YFPHMfP.png',
    'clippers' => 'https://i.imgur.com/AMLR2NF.png',
    'kings' => 'https://i.imgur.com/3gHgmg3.png',
    'suns' => 'https://i.imgur.com/WRP7J6u.png'
];

// Function to download image
function downloadImage($url, $filepath) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        ]
    ]);
    
    $imageData = file_get_contents($url, false, $context);
    if ($imageData === false) {
        return false;
    }
    
    return file_put_contents($filepath, $imageData) !== false;
}

// Download all logos
$success_count = 0;
$total_count = count($team_logos);

echo "<h2>NBA Team Logo Downloader</h2>";
echo "<p>Downloading $total_count team logos...</p>";

foreach ($team_logos as $team => $url) {
    $filename = $team . '.svg';
    $filepath = $image_dir . $filename;
    
    echo "<p>Downloading $team logo... ";
    
    // Try primary URL first
    if (downloadImage($url, $filepath)) {
        echo "✅ Success (SVG)</p>";
        $success_count++;
    } else {
        // Try fallback PNG
        $png_filename = $team . '.png';
        $png_filepath = $image_dir . $png_filename;
        
        if (isset($fallback_logos[$team]) && downloadImage($fallback_logos[$team], $png_filepath)) {
            echo "✅ Success (PNG fallback)</p>";
            $success_count++;
        } else {
            echo "❌ Failed</p>";
        }
    }
    
    // Small delay to be respectful to servers
    usleep(200000); // 0.2 seconds
}

echo "<hr>";
echo "<h3>Download Summary:</h3>";
echo "<p>✅ Successfully downloaded: $success_count/$total_count logos</p>";

if ($success_count > 0) {
    echo "<h3>Next Steps:</h3>";
    echo "<ol>";
    echo "<li>Update your database to use local logo URLs</li>";
    echo "<li>Run the update_logo_urls.php script</li>";
    echo "<li>Delete this download_logos.php file for security</li>";
    echo "</ol>";
    
    echo "<h3>Local Logo URLs:</h3>";
    echo "<p>Your logos are now available at:</p>";
    echo "<code>assets/images/logos/[team_name].svg</code> or <code>.png</code>";
}

// List downloaded files
$files = scandir($image_dir);
$image_files = array_filter($files, function($file) {
    return in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'jpg', 'svg']);
});

if (!empty($image_files)) {
    echo "<h3>Downloaded Files:</h3>";
    echo "<ul>";
    foreach ($image_files as $file) {
        echo "<li>$file</li>";
    }
    echo "</ul>";
}
?> 