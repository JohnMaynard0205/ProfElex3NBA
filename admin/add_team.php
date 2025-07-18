<?php
// NBA Teams Database - Add Team Admin Panel
// Group 13 - NBA Teams

require_once '../config/database.php';
require_once '../classes/NBATeam.php';

$nbaTeam = new NBATeam($db);
$message = '';
$error = '';

if ($_POST) {
    // Set team properties
    $nbaTeam->team_name = $_POST['team_name'];
    $nbaTeam->city = $_POST['city'];
    $nbaTeam->conference = $_POST['conference'];
    $nbaTeam->division = $_POST['division'];
    $nbaTeam->founded_year = $_POST['founded_year'];
    $nbaTeam->arena = $_POST['arena'];
    $nbaTeam->head_coach = $_POST['head_coach'];
    $nbaTeam->championships = $_POST['championships'];
    $nbaTeam->logo_url = $_POST['logo_url'];
    $nbaTeam->team_colors = $_POST['team_colors'];
    $nbaTeam->description = $_POST['description'];
    
    // Create team
    if ($nbaTeam->create()) {
        $message = "Team successfully created!";
    } else {
        $error = "Unable to create team. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Team - NBA Teams Database</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-control[readonly] {
            background-color: #f8f9fa;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
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
        
        .form-row {
            display: flex;
            gap: 1rem;
        }
        
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>➕ Add New NBA Team</h1>
            <p class="subtitle">Group 13 - NBA Teams Database Administration</p>
        </header>

        <div class="form-container">
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

            <form method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="team_name">Team Name *</label>
                        <input type="text" id="team_name" name="team_name" class="form-control" 
                               placeholder="e.g., Lakers" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City *</label>
                        <input type="text" id="city" name="city" class="form-control" 
                               placeholder="e.g., Los Angeles" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="conference">Conference *</label>
                        <select id="conference" name="conference" class="form-control" required>
                            <option value="">Select Conference</option>
                            <option value="Eastern">Eastern</option>
                            <option value="Western">Western</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="division">Division *</label>
                        <select id="division" name="division" class="form-control" required>
                            <option value="">Select Division</option>
                            <option value="Atlantic">Atlantic</option>
                            <option value="Central">Central</option>
                            <option value="Southeast">Southeast</option>
                            <option value="Northwest">Northwest</option>
                            <option value="Pacific">Pacific</option>
                            <option value="Southwest">Southwest</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="founded_year">Founded Year *</label>
                        <input type="number" id="founded_year" name="founded_year" class="form-control" 
                               placeholder="e.g., 1947" min="1946" max="2024" required>
                    </div>
                    <div class="form-group">
                        <label for="championships">Championships</label>
                        <input type="number" id="championships" name="championships" class="form-control" 
                               placeholder="e.g., 17" min="0" max="20" value="0">
                    </div>
                </div>

                <div class="form-group">
                    <label for="arena">Arena *</label>
                    <input type="text" id="arena" name="arena" class="form-control" 
                           placeholder="e.g., Crypto.com Arena" required>
                </div>

                <div class="form-group">
                    <label for="head_coach">Head Coach *</label>
                    <input type="text" id="head_coach" name="head_coach" class="form-control" 
                           placeholder="e.g., Darvin Ham" required>
                </div>

                <div class="form-group">
                    <label for="logo_url">Logo URL</label>
                    <input type="url" id="logo_url" name="logo_url" class="form-control" 
                           placeholder="https://example.com/logo.png">
                </div>

                <div class="form-group">
                    <label for="team_colors">Team Colors</label>
                    <input type="text" id="team_colors" name="team_colors" class="form-control" 
                           placeholder="e.g., Purple, Gold">
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" 
                              placeholder="Brief description of the team's history, notable players, achievements, etc."></textarea>
                </div>

                <button type="submit" class="btn-submit">➕ Create Team</button>
            </form>

            <div style="margin-top: 2rem; text-align: center;">
                <a href="../index.php" class="admin-btn btn-primary">🏠 Back to Home</a>
                <a href="manage_teams.php" class="admin-btn btn-warning">⚙️ Manage Teams</a>
            </div>
        </div>
    </div>

    <script>
        // Form validation and user experience improvements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            // Add real-time validation
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });
            
            // Form submission handler
            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fix the errors before submitting.');
                }
            });
            
            function validateField(field) {
                const value = field.value.trim();
                const isRequired = field.hasAttribute('required');
                
                // Remove existing error styling
                field.classList.remove('error');
                
                // Check if required field is empty
                if (isRequired && !value) {
                    field.classList.add('error');
                    field.style.borderColor = '#e74c3c';
                    return false;
                }
                
                // Validate specific fields
                if (field.name === 'founded_year' && value) {
                    const year = parseInt(value);
                    if (year < 1946 || year > 2024) {
                        field.classList.add('error');
                        field.style.borderColor = '#e74c3c';
                        return false;
                    }
                }
                
                if (field.name === 'logo_url' && value) {
                    const urlPattern = /^https?:\/\/.+/;
                    if (!urlPattern.test(value)) {
                        field.classList.add('error');
                        field.style.borderColor = '#e74c3c';
                        return false;
                    }
                }
                
                // Field is valid
                field.style.borderColor = '#2ecc71';
                return true;
            }
        });
    </script>
</body>
</html> 