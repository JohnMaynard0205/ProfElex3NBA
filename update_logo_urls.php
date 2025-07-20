<?php
/**
 * Update NBA Team Logo URLs in Database
 * This script updates all team logo URLs to use local images
 * Run this after downloading logos with download_logos.php
 */

require_once 'config/database.php';

echo "<h2>NBA Team Logo URL Updater</h2>";

// Mapping of team names to logo filenames
$logo_mapping = [
    'Lakers' => 'lakers',
    'Celtics' => 'celtics', 
    'Warriors' => 'warriors',
    'Heat' => 'heat',
    'Nets' => 'nets',
    'Knicks' => 'knicks',
    '76ers' => '76ers',
    'Raptors' => 'raptors',
    'Bulls' => 'bulls',
    'Cavaliers' => 'cavaliers',
    'Pistons' => 'pistons',
    'Pacers' => 'pacers',
    'Bucks' => 'bucks',
    'Hawks' => 'hawks',
    'Hornets' => 'hornets',
    'Magic' => 'magic',
    'Wizards' => 'wizards',
    'Nuggets' => 'nuggets',
    'Timberwolves' => 'timberwolves',
    'Thunder' => 'thunder',
    'Blazers' => 'blazers',
    'Trail Blazers' => 'blazers',
    'Jazz' => 'jazz',
    'Mavericks' => 'mavericks',
    'Rockets' => 'rockets',
    'Grizzlies' => 'grizzlies',
    'Pelicans' => 'pelicans',
    'Spurs' => 'spurs',
    'Clippers' => 'clippers',
    'Kings' => 'kings',
    'Suns' => 'suns'
];

// Check what logo files actually exist
$logo_dir = 'assets/images/logos/';
$available_logos = [];

if (is_dir($logo_dir)) {
    $files = scandir($logo_dir);
    foreach ($files as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['png', 'svg', 'jpg'])) {
            $team_key = pathinfo($file, PATHINFO_FILENAME);
            $available_logos[$team_key] = $file;
        }
    }
} else {
    die("<p>❌ Logo directory not found. Please run download_logos.php first!</p>");
}

echo "<p>Found " . count($available_logos) . " logo files in $logo_dir</p>";

try {
    // Get all teams from database
    $stmt = $db->prepare("SELECT id, team_name, logo_url FROM nba_teams ORDER BY team_name");
    $stmt->execute();
    $teams = $stmt->fetchAll();
    
    echo "<h3>Updating Logo URLs:</h3>";
    
    $updated_count = 0;
    $total_teams = count($teams);
    
    foreach ($teams as $team) {
        $team_name = $team['team_name'];
        $current_url = $team['logo_url'];
        
        echo "<p><strong>$team_name:</strong> ";
        
        // Find corresponding logo file
        $logo_file = null;
        if (isset($logo_mapping[$team_name])) {
            $logo_key = $logo_mapping[$team_name];
            if (isset($available_logos[$logo_key])) {
                $logo_file = $available_logos[$logo_key];
            }
        }
        
        if ($logo_file) {
            $new_url = "assets/images/logos/$logo_file";
            
            // Update database
            $update_stmt = $db->prepare("UPDATE nba_teams SET logo_url = ? WHERE id = ?");
            if ($update_stmt->execute([$new_url, $team['id']])) {
                echo "✅ Updated to $new_url</p>";
                $updated_count++;
            } else {
                echo "❌ Database update failed</p>";
            }
        } else {
            echo "⚠️ No local logo found, keeping: $current_url</p>";
        }
    }
    
    echo "<hr>";
    echo "<h3>Update Summary:</h3>";
    echo "<p>✅ Successfully updated: $updated_count/$total_teams team logos</p>";
    
    if ($updated_count > 0) {
        echo "<div style='background-color: #d4edda; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin: 10px 0;'>";
        echo "<h4>✅ Success!</h4>";
        echo "<p>Your team logos should now load properly on your website!</p>";
        echo "<p><strong>Next steps:</strong></p>";
        echo "<ol>";
        echo "<li>Test your main website to verify logos are displaying</li>";
        echo "<li>Delete this update_logo_urls.php file for security</li>";
        echo "<li>Delete download_logos.php file for security</li>";
        echo "</ol>";
        echo "</div>";
    }
    
    // Show a sample of updated URLs
    echo "<h3>Sample Updated Logo URLs:</h3>";
    $sample_stmt = $db->prepare("SELECT team_name, logo_url FROM nba_teams LIMIT 5");
    $sample_stmt->execute();
    $samples = $sample_stmt->fetchAll();
    
    echo "<ul>";
    foreach ($samples as $sample) {
        echo "<li><strong>{$sample['team_name']}:</strong> {$sample['logo_url']}</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "<p>❌ <strong>Database Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p>Make sure your database connection is working properly.</p>";
} catch (Exception $e) {
    echo "<p>❌ <strong>Error:</strong> " . $e->getMessage() . "</p>";
}
?> 