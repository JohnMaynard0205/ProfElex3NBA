<?php
// NBA Teams Database - Main Application
// Group 13 - NBA Teams

// Include required files
require_once 'config/database.php';
require_once 'classes/NBATeam.php';

// Create NBA Team instance
$nbaTeam = new NBATeam($db);

// Get search parameters
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$conference_filter = isset($_GET['conference']) ? $_GET['conference'] : '';
$division_filter = isset($_GET['division']) ? $_GET['division'] : '';
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';

// Get teams based on filters
$teams = [];
if (!empty($search_query)) {
    $result = $nbaTeam->searchTeams($search_query);
} elseif (!empty($conference_filter)) {
    $result = $nbaTeam->getTeamsByConference($conference_filter);
} elseif (!empty($division_filter)) {
    $result = $nbaTeam->getTeamsByDivision($division_filter);
} elseif ($sort_by === 'championships') {
    $result = $nbaTeam->getTeamsByChampionships();
} else {
    $result = $nbaTeam->getAllTeams();
}

// Fetch all teams
while ($row = $result->fetch()) {
    $teams[] = $row;
}

// Get statistics
$total_teams = $nbaTeam->getTeamCount();
$conferences = $nbaTeam->getConferences();
$divisions = $nbaTeam->getDivisions();

// Calculate stats
$total_championships = 0;
$eastern_teams = 0;
$western_teams = 0;
$oldest_team_year = date('Y');

foreach ($teams as $team) {
    $total_championships += $team['championships'];
    if ($team['conference'] === 'Eastern') $eastern_teams++;
    if ($team['conference'] === 'Western') $western_teams++;
    if ($team['founded_year'] < $oldest_team_year) $oldest_team_year = $team['founded_year'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NBA Teams Database - Group 13</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏀</text></svg>">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <h1>🏀 NBA Teams Database</h1>
            <p class="subtitle">Group 13 - Professional Basketball Teams Management System</p>
            <p class="subtitle">Explore all <?php echo $total_teams; ?> NBA teams with comprehensive information and search functionality</p>
        </header>

        <!-- Search Section -->
        <div class="search-section">
            <form method="GET" action="">
                <div class="search-container">
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Search teams by name, city, arena, coach, or description..." 
                           value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="search-btn">🔍 Search</button>
                </div>
                
                <div class="filter-container">
                    <label for="conference">Conference:</label>
                    <select name="conference" class="filter-select" id="conference" onchange="this.form.submit()">
                        <option value="">All Conferences</option>
                        <?php while ($conf = $conferences->fetch()): ?>
                            <option value="<?php echo $conf['conference']; ?>" 
                                    <?php echo ($conference_filter === $conf['conference']) ? 'selected' : ''; ?>>
                                <?php echo $conf['conference']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    
                    <label for="division">Division:</label>
                    <select name="division" class="filter-select" id="division" onchange="this.form.submit()">
                        <option value="">All Divisions</option>
                        <?php 
                        $divisions = $nbaTeam->getDivisions();
                        while ($div = $divisions->fetch()): ?>
                            <option value="<?php echo $div['division']; ?>" 
                                    <?php echo ($division_filter === $div['division']) ? 'selected' : ''; ?>>
                                <?php echo $div['division']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    
                    <label for="sort">Sort By:</label>
                    <select name="sort" class="filter-select" id="sort" onchange="this.form.submit()">
                        <option value="name" <?php echo ($sort_by === 'name') ? 'selected' : ''; ?>>Team Name</option>
                        <option value="championships" <?php echo ($sort_by === 'championships') ? 'selected' : ''; ?>>Championships</option>
                    </select>
                    
                    <a href="index.php" class="admin-btn btn-primary">🔄 Reset Filters</a>
                </div>
            </form>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section">
            <h2>📊 League Statistics</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_teams; ?></div>
                    <div class="stat-label">Total Teams</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_championships; ?></div>
                    <div class="stat-label">Total Championships</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $eastern_teams; ?></div>
                    <div class="stat-label">Eastern Conference</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $western_teams; ?></div>
                    <div class="stat-label">Western Conference</div>
                </div>
            </div>
        </div>

        <!-- Admin Panel -->
        <div class="admin-panel">
            <h3>🛠️ Admin Panel</h3>
            <a href="admin/manage_teams.php" class="admin-btn btn-warning">⚙️ Manage Teams</a>
        </div>

        <!-- Results Section -->
        <?php if (!empty($search_query)): ?>
            <div class="search-results">
                <h2>🔍 Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
                <p><?php echo count($teams); ?> team(s) found</p>
            </div>
        <?php elseif (!empty($conference_filter)): ?>
            <div class="search-results">
                <h2>🏆 <?php echo $conference_filter; ?> Conference Teams</h2>
                <p><?php echo count($teams); ?> team(s) found</p>
            </div>
        <?php elseif (!empty($division_filter)): ?>
            <div class="search-results">
                <h2>🏅 <?php echo $division_filter; ?> Division Teams</h2>
                <p><?php echo count($teams); ?> team(s) found</p>
            </div>
        <?php endif; ?>

        <!-- Teams Grid -->
        <?php if (!empty($teams)): ?>
            <div class="teams-grid">
                <?php foreach ($teams as $team): ?>
                    <div class="team-card">
                        <div class="team-header">
                            <div class="team-logo">
                                <img src="<?php echo htmlspecialchars($team['logo_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($team['team_name']); ?> Logo"
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'.9em\' font-size=\'90\'>🏀</text></svg>'">
                            </div>
                            <div class="team-name"><?php echo htmlspecialchars($team['team_name']); ?></div>
                            <div class="team-location"><?php echo htmlspecialchars($team['city']); ?></div>
                        </div>
                        
                        <div class="team-details">
                            <div class="detail-row">
                                <span class="detail-label">Conference:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['conference']); ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Division:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['division']); ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Founded:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['founded_year']); ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Arena:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['arena']); ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Head Coach:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['head_coach']); ?></span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Championships:</span>
                                <span class="detail-value">
                                    <?php if ($team['championships'] > 0): ?>
                                        <span class="championships-badge">🏆 <?php echo $team['championships']; ?></span>
                                    <?php else: ?>
                                        <span class="detail-value">0</span>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Team Colors:</span>
                                <span class="detail-value"><?php echo htmlspecialchars($team['team_colors']); ?></span>
                            </div>
                            
                            <?php if (!empty($team['description'])): ?>
                                <div class="team-description">
                                    <strong>About the Team:</strong><br>
                                    <?php echo htmlspecialchars($team['description']); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div style="margin-top: 1rem; text-align: center;">
                                <a href="team_details.php?id=<?php echo $team['id']; ?>" class="admin-btn btn-primary">👁️ View Details</a>
                                <a href="admin/edit_team.php?id=<?php echo $team['id']; ?>" class="admin-btn btn-warning">✏️ Edit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h2>🔍 No Teams Found</h2>
                <p>No teams match your search criteria. Try adjusting your search terms or filters.</p>
                <a href="index.php" class="admin-btn btn-primary">🔄 View All Teams</a>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Add some interactive features
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation when forms are submitted
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = form.querySelector('.search-btn');
                    if (button) {
                        button.innerHTML = '🔄 Searching...';
                        button.disabled = true;
                    }
                });
            });

            // Add hover effects to team cards
            const teamCards = document.querySelectorAll('.team-card');
            teamCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add search suggestions (simple implementation)
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // You can add auto-complete functionality here
                    console.log('Search term:', this.value);
                });
            }
        });
    </script>
</body>
</html> 