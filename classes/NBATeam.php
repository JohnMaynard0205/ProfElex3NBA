<?php
class NBATeam {
    private $conn;
    private $table_name = "nba_teams";
    
    public $id;
    public $team_name;
    public $city;
    public $conference;
    public $division;
    public $founded_year;
    public $arena;
    public $head_coach;
    public $championships;
    public $logo_url;
    public $team_colors;
    public $description;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // Get all teams
    public function getAllTeams() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY team_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Get team by ID
    public function getTeamById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt;
    }
    
    // Search teams
    public function searchTeams($search_term) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE team_name LIKE ? 
                  OR city LIKE ? 
                  OR conference LIKE ? 
                  OR division LIKE ? 
                  OR arena LIKE ? 
                  OR head_coach LIKE ? 
                  OR description LIKE ?
                  ORDER BY team_name ASC";
        
        $search_term = "%{$search_term}%";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $search_term);
        $stmt->bindParam(2, $search_term);
        $stmt->bindParam(3, $search_term);
        $stmt->bindParam(4, $search_term);
        $stmt->bindParam(5, $search_term);
        $stmt->bindParam(6, $search_term);
        $stmt->bindParam(7, $search_term);
        
        $stmt->execute();
        return $stmt;
    }
    
    // Filter teams by conference
    public function getTeamsByConference($conference) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE conference = ? ORDER BY team_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $conference);
        $stmt->execute();
        return $stmt;
    }
    
    // Filter teams by division
    public function getTeamsByDivision($division) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE division = ? ORDER BY team_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $division);
        $stmt->execute();
        return $stmt;
    }
    
    // Get teams with most championships
    public function getTeamsByChampionships() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY championships DESC, team_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Create new team
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (team_name, city, conference, division, founded_year, arena, head_coach, championships, logo_url, team_colors, description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->team_name = htmlspecialchars(strip_tags($this->team_name));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->conference = htmlspecialchars(strip_tags($this->conference));
        $this->division = htmlspecialchars(strip_tags($this->division));
        $this->founded_year = htmlspecialchars(strip_tags($this->founded_year));
        $this->arena = htmlspecialchars(strip_tags($this->arena));
        $this->head_coach = htmlspecialchars(strip_tags($this->head_coach));
        $this->championships = htmlspecialchars(strip_tags($this->championships));
        $this->logo_url = htmlspecialchars(strip_tags($this->logo_url));
        $this->team_colors = htmlspecialchars(strip_tags($this->team_colors));
        $this->description = htmlspecialchars(strip_tags($this->description));
        
        // Bind parameters
        $stmt->bindParam(1, $this->team_name);
        $stmt->bindParam(2, $this->city);
        $stmt->bindParam(3, $this->conference);
        $stmt->bindParam(4, $this->division);
        $stmt->bindParam(5, $this->founded_year);
        $stmt->bindParam(6, $this->arena);
        $stmt->bindParam(7, $this->head_coach);
        $stmt->bindParam(8, $this->championships);
        $stmt->bindParam(9, $this->logo_url);
        $stmt->bindParam(10, $this->team_colors);
        $stmt->bindParam(11, $this->description);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Update team
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET team_name = ?, city = ?, conference = ?, division = ?, founded_year = ?, 
                      arena = ?, head_coach = ?, championships = ?, logo_url = ?, team_colors = ?, description = ?
                  WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitize input
        $this->team_name = htmlspecialchars(strip_tags($this->team_name));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->conference = htmlspecialchars(strip_tags($this->conference));
        $this->division = htmlspecialchars(strip_tags($this->division));
        $this->founded_year = htmlspecialchars(strip_tags($this->founded_year));
        $this->arena = htmlspecialchars(strip_tags($this->arena));
        $this->head_coach = htmlspecialchars(strip_tags($this->head_coach));
        $this->championships = htmlspecialchars(strip_tags($this->championships));
        $this->logo_url = htmlspecialchars(strip_tags($this->logo_url));
        $this->team_colors = htmlspecialchars(strip_tags($this->team_colors));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        // Bind parameters
        $stmt->bindParam(1, $this->team_name);
        $stmt->bindParam(2, $this->city);
        $stmt->bindParam(3, $this->conference);
        $stmt->bindParam(4, $this->division);
        $stmt->bindParam(5, $this->founded_year);
        $stmt->bindParam(6, $this->arena);
        $stmt->bindParam(7, $this->head_coach);
        $stmt->bindParam(8, $this->championships);
        $stmt->bindParam(9, $this->logo_url);
        $stmt->bindParam(10, $this->team_colors);
        $stmt->bindParam(11, $this->description);
        $stmt->bindParam(12, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Delete team
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    // Get team count
    public function getTeamCount() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    // Get distinct conferences
    public function getConferences() {
        $query = "SELECT DISTINCT conference FROM " . $this->table_name . " ORDER BY conference";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    // Get distinct divisions
    public function getDivisions() {
        $query = "SELECT DISTINCT division FROM " . $this->table_name . " ORDER BY division";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?> 