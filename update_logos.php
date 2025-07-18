<?php
// Update Team Logos Script
// Group 13 - NBA Teams Database
// Run this script once to update all team logos in your existing database

require_once 'config/database.php';

$logo_updates = [
    'Lakers' => 'https://logoeps.com/wp-content/uploads/2013/03/los-angeles-lakers-vector-logo.png',
    'Celtics' => 'https://logoeps.com/wp-content/uploads/2013/03/boston-celtics-vector-logo.png',
    'Warriors' => 'https://logoeps.com/wp-content/uploads/2013/03/golden-state-warriors-vector-logo.png',
    'Heat' => 'https://logoeps.com/wp-content/uploads/2013/03/miami-heat-vector-logo.png',
    'Nets' => 'https://logoeps.com/wp-content/uploads/2013/03/brooklyn-nets-vector-logo.png',
    'Knicks' => 'https://logoeps.com/wp-content/uploads/2013/03/new-york-knicks-vector-logo.png',
    '76ers' => 'https://logoeps.com/wp-content/uploads/2013/03/philadelphia-76ers-vector-logo.png',
    'Raptors' => 'https://logoeps.com/wp-content/uploads/2013/03/toronto-raptors-vector-logo.png',
    'Bulls' => 'https://logoeps.com/wp-content/uploads/2013/03/chicago-bulls-vector-logo.png',
    'Cavaliers' => 'https://logoeps.com/wp-content/uploads/2013/03/cleveland-cavaliers-vector-logo.png',
    'Pistons' => 'https://logoeps.com/wp-content/uploads/2013/03/detroit-pistons-vector-logo.png',
    'Pacers' => 'https://logoeps.com/wp-content/uploads/2013/03/indiana-pacers-vector-logo.png',
    'Bucks' => 'https://logoeps.com/wp-content/uploads/2013/03/milwaukee-bucks-vector-logo.png',
    'Hawks' => 'https://logoeps.com/wp-content/uploads/2013/03/atlanta-hawks-vector-logo.png',
    'Hornets' => 'https://logoeps.com/wp-content/uploads/2013/03/charlotte-hornets-vector-logo.png',
    'Magic' => 'https://logoeps.com/wp-content/uploads/2013/03/orlando-magic-vector-logo.png',
    'Wizards' => 'https://logoeps.com/wp-content/uploads/2013/03/washington-wizards-vector-logo.png',
    'Nuggets' => 'https://logoeps.com/wp-content/uploads/2013/03/denver-nuggets-vector-logo.png',
    'Timberwolves' => 'https://logoeps.com/wp-content/uploads/2013/03/minnesota-timberwolves-vector-logo.png',
    'Thunder' => 'https://logoeps.com/wp-content/uploads/2013/03/oklahoma-city-thunder-vector-logo.png',
    'Blazers' => 'https://logoeps.com/wp-content/uploads/2013/03/portland-trail-blazers-vector-logo.png',
    'Jazz' => 'https://logoeps.com/wp-content/uploads/2013/03/utah-jazz-vector-logo.png',
    'Mavericks' => 'https://logoeps.com/wp-content/uploads/2013/03/dallas-mavericks-vector-logo.png',
    'Rockets' => 'https://logoeps.com/wp-content/uploads/2013/03/houston-rockets-vector-logo.png',
    'Grizzlies' => 'https://logoeps.com/wp-content/uploads/2013/03/memphis-grizzlies-vector-logo.png',
    'Pelicans' => 'https://logoeps.com/wp-content/uploads/2013/03/new-orleans-pelicans-vector-logo.png',
    'Spurs' => 'https://logoeps.com/wp-content/uploads/2013/03/san-antonio-spurs-vector-logo.png',
    'Kings' => 'https://logoeps.com/wp-content/uploads/2013/03/sacramento-kings-vector-logo.png',
    'Clippers' => 'https://logoeps.com/wp-content/uploads/2013/03/los-angeles-clippers-vector-logo.png',
    'Suns' => 'https://logoeps.com/wp-content/uploads/2013/03/phoenix-suns-vector-logo.png'
];

echo "<h2>🏀 NBA Teams Logo Update Script</h2>";
echo "<p>Updating team logos in the database...</p>";

$updated_count = 0;
$failed_count = 0;

foreach ($logo_updates as $team_name => $logo_url) {
    try {
        $query = "UPDATE nba_teams SET logo_url = ? WHERE team_name = ?";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $logo_url);
        $stmt->bindParam(2, $team_name);
        
        if ($stmt->execute()) {
            $updated_count++;
            echo "<p>✅ Updated {$team_name} logo</p>";
        } else {
            $failed_count++;
            echo "<p>❌ Failed to update {$team_name} logo</p>";
        }
    } catch (PDOException $e) {
        $failed_count++;
        echo "<p>❌ Error updating {$team_name}: " . $e->getMessage() . "</p>";
    }
}

echo "<hr>";
echo "<h3>📊 Update Summary</h3>";
echo "<p><strong>✅ Successfully updated:</strong> {$updated_count} teams</p>";
echo "<p><strong>❌ Failed to update:</strong> {$failed_count} teams</p>";

if ($updated_count > 0) {
    echo "<p><strong>🎉 Success!</strong> Team logos have been updated. You can now see beautiful team logos on all cards!</p>";
    echo "<p><a href='index.php'>👀 View Updated Teams</a></p>";
} else {
    echo "<p><strong>⚠️ Warning:</strong> No teams were updated. Please check your database connection and table structure.</p>";
}

echo "<hr>";
echo "<p><em>You can delete this file (update_logos.php) after running it successfully.</em></p>";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update NBA Team Logos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #f5f5f5;
        }
        h2 { color: #2c3e50; }
        h3 { color: #34495e; }
        p { margin: 10px 0; }
        a { color: #3498db; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
</body>
</html> 