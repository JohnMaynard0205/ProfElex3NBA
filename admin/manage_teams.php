<?php
// NBA Teams Database - Manage Teams Admin Panel
// Group 13 - NBA Teams

require_once '../config/database.php';
require_once '../classes/NBATeam.php';

$nbaTeam = new NBATeam($db);
$message = '';
$error = '';

// Handle delete operation
if (isset($_GET['delete'])) {
    $nbaTeam->id = $_GET['delete'];
    if ($nbaTeam->delete()) {
        $message = "Team successfully deleted!";
    } else {
        $error = "Unable to delete team. Please try again.";
    }
}

// Get all teams
$result = $nbaTeam->getAllTeams();
$teams = [];
while ($row = $result->fetch()) {
    $teams[] = $row;
}

$total_teams = count($teams);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teams - NBA Teams Database</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .data-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        
        .data-table tr:hover {
            background: rgba(102, 126, 234, 0.1);
        }
        
        .team-logo-small {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            object-fit: contain;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }
        
        .btn-small {
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-small:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .championships-count {
            background: linear-gradient(135deg, #f39c12 0%, #e74c3c 100%);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .search-bar {
            margin-bottom: 1rem;
        }
        
        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 20px;
            font-size: 16px;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-box h3 {
            font-size: 2rem;
            margin: 0;
        }
        
        .stat-box p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }
        
        @media (max-width: 768px) {
            .table-container {
                padding: 1rem;
            }
            
            .data-table {
                font-size: 14px;
            }
            
            .data-table th,
            .data-table td {
                padding: 8px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>⚙️ Manage NBA Teams</h1>
            <p class="subtitle">Group 13 - NBA Teams Database Administration</p>
            <p class="subtitle">Manage all <?php echo $total_teams; ?> NBA teams in the database</p>
        </header>

        <!-- Quick Stats -->
        <div class="stats-summary">
            <div class="stat-box">
                <h3><?php echo $total_teams; ?></h3>
                <p>Total Teams</p>
            </div>
            <div class="stat-box">
                <h3><?php echo count(array_filter($teams, function($team) { return $team['conference'] === 'Eastern'; })); ?></h3>
                <p>Eastern Conference</p>
            </div>
            <div class="stat-box">
                <h3><?php echo count(array_filter($teams, function($team) { return $team['conference'] === 'Western'; })); ?></h3>
                <p>Western Conference</p>
            </div>
            <div class="stat-box">
                <h3><?php echo array_sum(array_column($teams, 'championships')); ?></h3>
                <p>Total Championships</p>
            </div>
        </div>

        <div class="table-container">
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    ✅ <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error">
                    ❌ <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
                <h2>📋 Teams Management</h2>
            </div>

            <div class="search-bar">
                <input type="text" id="teamSearch" placeholder="🔍 Search teams by name, city, arena, or coach..." 
                       onkeyup="searchTeams()">
            </div>

            <table class="data-table" id="teamsTable">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Team</th>
                        <th>City</th>
                        <th>Conference</th>
                        <th>Division</th>
                        <th>Founded</th>
                        <th>Arena</th>
                        <th>Coach</th>
                        <th>Championships</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($teams as $team): ?>
                        <tr>
                            <td>
                                <img src="<?php echo htmlspecialchars($team['logo_url']); ?>" 
                                     alt="<?php echo htmlspecialchars($team['team_name']); ?>" 
                                     class="team-logo-small"
                                     onerror="this.src='data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 100 100\'><text y=\'.9em\' font-size=\'90\'>🏀</text></svg>'">
                            </td>
                            <td><strong><?php echo htmlspecialchars($team['team_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($team['city']); ?></td>
                            <td><?php echo htmlspecialchars($team['conference']); ?></td>
                            <td><?php echo htmlspecialchars($team['division']); ?></td>
                            <td><?php echo htmlspecialchars($team['founded_year']); ?></td>
                            <td><?php echo htmlspecialchars($team['arena']); ?></td>
                            <td><?php echo htmlspecialchars($team['head_coach']); ?></td>
                            <td>
                                <?php if ($team['championships'] > 0): ?>
                                    <span class="championships-count">🏆 <?php echo $team['championships']; ?></span>
                                <?php else: ?>
                                    <span style="color: #7f8c8d;">0</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="../team_details.php?id=<?php echo $team['id']; ?>" 
                                       class="btn-small btn-primary">👁️ View</a>
                                    <a href="edit_team.php?id=<?php echo $team['id']; ?>" 
                                       class="btn-small btn-warning">✏️ Edit</a>
                                    <a href="?delete=<?php echo $team['id']; ?>" 
                                       class="btn-small btn-danger"
                                       onclick="return confirm('Are you sure you want to delete the <?php echo htmlspecialchars($team['team_name']); ?>? This action cannot be undone.')">🗑️ Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="margin-top: 2rem; text-align: center;">
                <a href="../index.php" class="admin-btn btn-primary">🏠 Back to Home</a>
                <a href="add_team.php" class="admin-btn btn-success">➕ Add New Team</a>
                <a href="import_export.php" class="admin-btn btn-primary">📊 Import/Export</a>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        function searchTeams() {
            const input = document.getElementById('teamSearch');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('teamsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;

                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? '' : 'none';
            }
        }

        // Add hover effects and animations
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.data-table tbody tr');
            
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02)';
                    this.style.transition = 'all 0.3s ease';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Confirm delete actions
            const deleteButtons = document.querySelectorAll('.btn-danger');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Are you sure you want to delete this team? This action cannot be undone.')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html> 