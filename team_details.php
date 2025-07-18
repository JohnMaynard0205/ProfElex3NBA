<?php
// NBA Teams Database - Team Details Page
// Group 13 - NBA Teams

require_once 'config/database.php';
require_once 'classes/NBATeam.php';

$nbaTeam = new NBATeam($db);

// Get team ID from URL parameter
$team_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($team_id <= 0) {
    header('Location: index.php');
    exit;
}

// Get team details
$result = $nbaTeam->getTeamById($team_id);
$team = $result->fetch();

if (!$team) {
    header('Location: index.php?error=team_not_found');
    exit;
}

// Get related teams (same conference)
$related_result = $nbaTeam->getTeamsByConference($team['conference']);
$related_teams = [];
while ($row = $related_result->fetch()) {
    if ($row['id'] != $team_id) {
        $related_teams[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($team['team_name']); ?> - NBA Teams Database</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .team-profile {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .team-profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        
        .team-logo-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            padding: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }
        
        .team-logo-large img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .team-info {
            flex: 1;
            min-width: 300px;
        }
        
        .team-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        
        .team-subtitle {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 1rem;
        }
        
        .team-badges {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }
        
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
        }
        
        .badge-conference {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .badge-division {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        }
        
        .badge-championships {
            background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
        }
        
        .team-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .detail-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }
        
        .detail-section h3 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #495057;
        }
        
        .detail-value {
            color: #6c757d;
            text-align: right;
        }
        
        .team-description-full {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        .related-teams {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .related-teams-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .related-team-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        
        .related-team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .related-team-logo {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 auto 0.5rem;
            background: white;
            padding: 5px;
        }
        
        .related-team-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .breadcrumb {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .breadcrumb a {
            color: #667eea;
            text-decoration: none;
            margin-right: 0.5rem;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .team-profile-header {
                flex-direction: column;
                text-align: center;
            }
            
            .team-title {
                font-size: 2rem;
            }
            
            .team-details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb">
            <a href="index.php">🏠 Home</a> / 
            <a href="index.php?conference=<?php echo urlencode($team['conference']); ?>">
                <?php echo htmlspecialchars($team['conference']); ?> Conference
            </a> / 
            <strong><?php echo htmlspecialchars($team['team_name']); ?></strong>
        </div>

        <!-- Team Profile -->
        <div class="team-profile">
            <div class="team-profile-header">
                <div class="team-logo-large">
                    <img src="<?php echo htmlspecialchars($team['logo_url']); ?>" 
                         alt="<?php echo htmlspecialchars($team['team_name']); ?> Logo"
                         onerror="this.src='data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'.9em\' font-size=\'90\'>🏀</text></svg>'">
                </div>
                <div class="team-info">
                    <h1 class="team-title"><?php echo htmlspecialchars($team['team_name']); ?></h1>
                    <p class="team-subtitle"><?php echo htmlspecialchars($team['city']); ?> • Founded <?php echo htmlspecialchars($team['founded_year']); ?></p>
                    
                    <div class="team-badges">
                        <span class="badge badge-conference">
                            <?php echo htmlspecialchars($team['conference']); ?> Conference
                        </span>
                        <span class="badge badge-division">
                            <?php echo htmlspecialchars($team['division']); ?> Division
                        </span>
                        <?php if ($team['championships'] > 0): ?>
                            <span class="badge badge-championships">
                                🏆 <?php echo $team['championships']; ?> Championship<?php echo $team['championships'] > 1 ? 's' : ''; ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="team-details-grid">
                <div class="detail-section">
                    <h3>🏟️ Team Information</h3>
                    <div class="detail-item">
                        <span class="detail-label">Home Arena:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($team['arena']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Head Coach:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($team['head_coach']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Team Colors:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($team['team_colors']); ?></span>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>📊 Team Statistics</h3>
                    <div class="detail-item">
                        <span class="detail-label">Founded Year:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($team['founded_year']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Championships:</span>
                        <span class="detail-value">
                            <?php if ($team['championships'] > 0): ?>
                                <span class="championships-badge">🏆 <?php echo $team['championships']; ?></span>
                            <?php else: ?>
                                0
                            <?php endif; ?>
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Years in League:</span>
                        <span class="detail-value"><?php echo date('Y') - $team['founded_year']; ?> years</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Description -->
        <?php if (!empty($team['description'])): ?>
            <div class="team-description-full">
                <h2>📖 About the <?php echo htmlspecialchars($team['team_name']); ?></h2>
                <p><?php echo htmlspecialchars($team['description']); ?></p>
            </div>
        <?php endif; ?>

        <!-- Related Teams -->
        <?php if (!empty($related_teams)): ?>
            <div class="related-teams">
                <h2>🏀 Other <?php echo htmlspecialchars($team['conference']); ?> Conference Teams</h2>
                <div class="related-teams-grid">
                    <?php foreach (array_slice($related_teams, 0, 8) as $related_team): ?>
                        <a href="team_details.php?id=<?php echo $related_team['id']; ?>" class="related-team-card">
                            <div class="related-team-logo">
                                <img src="<?php echo htmlspecialchars($related_team['logo_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($related_team['team_name']); ?> Logo"
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'.9em\' font-size=\'90\'>🏀</text></svg>'">
                            </div>
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">
                                <?php echo htmlspecialchars($related_team['team_name']); ?>
                            </div>
                            <div style="font-size: 0.9rem; color: #7f8c8d;">
                                <?php echo htmlspecialchars($related_team['city']); ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div style="text-align: center; margin-top: 2rem;">
            <a href="index.php" class="admin-btn btn-primary">🏠 Back to Home</a>
            <a href="index.php?conference=<?php echo urlencode($team['conference']); ?>" class="admin-btn btn-primary">
                📊 View <?php echo htmlspecialchars($team['conference']); ?> Teams
            </a>
            <a href="admin/edit_team.php?id=<?php echo $team['id']; ?>" class="admin-btn btn-warning">✏️ Edit Team</a>
        </div>
    </div>

    <script>
        // Add animation effects
        document.addEventListener('DOMContentLoaded', function() {
            // Animate team profile on load
            const teamProfile = document.querySelector('.team-profile');
            teamProfile.style.opacity = '0';
            teamProfile.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                teamProfile.style.transition = 'all 0.6s ease';
                teamProfile.style.opacity = '1';
                teamProfile.style.transform = 'translateY(0)';
            }, 100);

            // Animate related teams
            const relatedCards = document.querySelectorAll('.related-team-card');
            relatedCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 200 + (index * 100));
            });

            // Add hover effects to badges
            const badges = document.querySelectorAll('.badge');
            badges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.2s ease';
                });
                
                badge.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html> 