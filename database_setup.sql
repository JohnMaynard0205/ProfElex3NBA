-- NBA Teams Database Setup
-- Group 13 - NBA Teams Database

-- Create the database
CREATE DATABASE IF NOT EXISTS nba_teams_db;
USE nba_teams_db;

-- Create the NBA teams table
CREATE TABLE IF NOT EXISTS nba_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    conference VARCHAR(20) NOT NULL,
    division VARCHAR(20) NOT NULL,
    founded_year INT NOT NULL,
    arena VARCHAR(100) NOT NULL,
    head_coach VARCHAR(100) NOT NULL,
    championships INT DEFAULT 0,
    logo_url VARCHAR(255),
    team_colors VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert 30 NBA teams with comprehensive data and working logo URLs
INSERT INTO nba_teams (team_name, city, conference, division, founded_year, arena, head_coach, championships, logo_url, team_colors, description) VALUES
('Lakers', 'Los Angeles', 'Western', 'Pacific', 1947, 'Crypto.com Arena', 'Darvin Ham', 17, 'https://logoeps.com/wp-content/uploads/2013/03/los-angeles-lakers-vector-logo.png', 'Purple, Gold', 'One of the most successful franchises in NBA history with legendary players like Magic Johnson, Kareem Abdul-Jabbar, Kobe Bryant, and LeBron James.'),
('Celtics', 'Boston', 'Eastern', 'Atlantic', 1946, 'TD Garden', 'Joe Mazzulla', 17, 'https://logoeps.com/wp-content/uploads/2013/03/boston-celtics-vector-logo.png', 'Green, White', 'Historic franchise with the most championships tied with Lakers, known for their Big Three era and legendary players like Bill Russell and Larry Bird.'),
('Warriors', 'Golden State', 'Western', 'Pacific', 1946, 'Chase Center', 'Steve Kerr', 7, 'https://logoeps.com/wp-content/uploads/2013/03/golden-state-warriors-vector-logo.png', 'Blue, Yellow', 'Recent dynasty with Stephen Curry, Klay Thompson, and Draymond Green, revolutionizing basketball with their three-point shooting.'),
('Heat', 'Miami', 'Eastern', 'Southeast', 1988, 'FTX Arena', 'Erik Spoelstra', 3, 'https://logoeps.com/wp-content/uploads/2013/03/miami-heat-vector-logo.png', 'Red, Black, White', 'Known for their championship runs with LeBron James, Dwyane Wade, and Chris Bosh, and their strong organizational culture.'),
('Nets', 'Brooklyn', 'Eastern', 'Atlantic', 1967, 'Barclays Center', 'Jacque Vaughn', 0, 'https://logoeps.com/wp-content/uploads/2013/03/brooklyn-nets-vector-logo.png', 'Black, White', 'Relocated from New Jersey, known for their star-studded roster attempts and modern approach to basketball.'),
('Knicks', 'New York', 'Eastern', 'Atlantic', 1946, 'Madison Square Garden', 'Tom Thibodeau', 2, 'https://logoeps.com/wp-content/uploads/2013/03/new-york-knicks-vector-logo.png', 'Blue, Orange', 'Historic franchise playing in the most famous arena, known for their passionate fanbase and legendary players like Walt Frazier and Patrick Ewing.'),
('76ers', 'Philadelphia', 'Eastern', 'Atlantic', 1949, 'Wells Fargo Center', 'Nick Nurse', 3, 'https://logoeps.com/wp-content/uploads/2013/03/philadelphia-76ers-vector-logo.png', 'Blue, Red, White', 'Team with rich history including legends like Julius Erving, Allen Iverson, and current stars Joel Embiid and Tyrese Maxey.'),
('Raptors', 'Toronto', 'Eastern', 'Atlantic', 1995, 'Scotiabank Arena', 'Darko Rajaković', 1, 'https://logoeps.com/wp-content/uploads/2013/03/toronto-raptors-vector-logo.png', 'Red, Black, Silver', 'Canada\'s only NBA team, won their first championship in 2019 with Kawhi Leonard leading the way.'),
('Bulls', 'Chicago', 'Eastern', 'Central', 1966, 'United Center', 'Billy Donovan', 6, 'https://logoeps.com/wp-content/uploads/2013/03/chicago-bulls-vector-logo.png', 'Red, Black, White', 'Legendary franchise of the 1990s with Michael Jordan, Scottie Pippen, and Phil Jackson winning six championships.'),
('Cavaliers', 'Cleveland', 'Eastern', 'Central', 1970, 'Rocket Mortgage FieldHouse', 'J.B. Bickerstaff', 1, 'https://logoeps.com/wp-content/uploads/2013/03/cleveland-cavaliers-vector-logo.png', 'Wine, Gold, Navy', 'Brought Cleveland its first major sports championship in 52 years when LeBron James led them to victory in 2016.'),
('Pistons', 'Detroit', 'Eastern', 'Central', 1941, 'Little Caesars Arena', 'Monty Williams', 3, 'https://logoeps.com/wp-content/uploads/2013/03/detroit-pistons-vector-logo.png', 'Red, White, Blue', 'Known for their "Bad Boys" era in the late 1980s and early 1990s with Isiah Thomas and Dennis Rodman.'),
('Pacers', 'Indiana', 'Eastern', 'Central', 1967, 'Gainbridge Fieldhouse', 'Rick Carlisle', 0, 'https://logoeps.com/wp-content/uploads/2013/03/indiana-pacers-vector-logo.png', 'Navy, Gold, White', 'Strong franchise with a history of competitive teams, known for their battles with the Bulls and Lakers.'),
('Bucks', 'Milwaukee', 'Eastern', 'Central', 1968, 'Fiserv Forum', 'Adrian Griffin', 2, 'https://logoeps.com/wp-content/uploads/2013/03/milwaukee-bucks-vector-logo.png', 'Green, Cream, Blue', 'Recent champions in 2021 led by Giannis Antetokounmpo, also won in 1971 with Kareem Abdul-Jabbar.'),
('Hawks', 'Atlanta', 'Eastern', 'Southeast', 1946, 'State Farm Arena', 'Quin Snyder', 1, 'https://logoeps.com/wp-content/uploads/2013/03/atlanta-hawks-vector-logo.png', 'Red, Black, White', 'Historic franchise with exciting young talent led by Trae Young and a strong organizational foundation.'),
('Hornets', 'Charlotte', 'Eastern', 'Southeast', 1988, 'Spectrum Center', 'Steve Clifford', 0, 'https://logoeps.com/wp-content/uploads/2013/03/charlotte-hornets-vector-logo.png', 'Teal, Purple, White', 'Expansion team owned by Michael Jordan, known for their unique color scheme and passionate fanbase.'),
('Magic', 'Orlando', 'Eastern', 'Southeast', 1989, 'Amway Center', 'Jamahl Mosley', 0, 'https://logoeps.com/wp-content/uploads/2013/03/orlando-magic-vector-logo.png', 'Blue, Black, Silver', 'Young franchise with a history of star centers like Shaquille O\'Neal and Dwight Howard.'),
('Wizards', 'Washington', 'Eastern', 'Southeast', 1961, 'Capital One Arena', 'Wes Unseld Jr.', 1, 'https://logoeps.com/wp-content/uploads/2013/03/washington-wizards-vector-logo.png', 'Navy, Red, White', 'Franchise with a rich history, won their championship in 1978 as the Washington Bullets.'),
('Nuggets', 'Denver', 'Western', 'Northwest', 1967, 'Ball Arena', 'Michael Malone', 1, 'https://logoeps.com/wp-content/uploads/2013/03/denver-nuggets-vector-logo.png', 'Navy, Gold, Red', 'Recent champions in 2023 led by Nikola Jokić, known for their high-altitude home court advantage.'),
('Timberwolves', 'Minnesota', 'Western', 'Northwest', 1989, 'Target Center', 'Chris Finch', 0, 'https://logoeps.com/wp-content/uploads/2013/03/minnesota-timberwolves-vector-logo.png', 'Blue, Green, Silver', 'Young franchise with exciting talent led by Anthony Edwards and Karl-Anthony Towns.'),
('Thunder', 'Oklahoma City', 'Western', 'Northwest', 1967, 'Paycom Center', 'Mark Daigneault', 1, 'https://logoeps.com/wp-content/uploads/2013/03/oklahoma-city-thunder-vector-logo.png', 'Blue, Orange, Navy', 'Relocated from Seattle, known for developing young talent and strong organizational culture.'),
('Blazers', 'Portland', 'Western', 'Northwest', 1970, 'Moda Center', 'Chauncey Billups', 1, 'https://logoeps.com/wp-content/uploads/2013/03/portland-trail-blazers-vector-logo.png', 'Red, Black, White', 'Passionate fanbase and rich history, won championship in 1977 with Bill Walton.'),
('Jazz', 'Utah', 'Western', 'Northwest', 1974, 'Delta Center', 'Will Hardy', 0, 'https://logoeps.com/wp-content/uploads/2013/03/utah-jazz-vector-logo.png', 'Navy, Yellow, Green', 'Known for their legendary duo of John Stockton and Karl Malone in the 1990s.'),
('Mavericks', 'Dallas', 'Western', 'Southwest', 1980, 'American Airlines Center', 'Jason Kidd', 1, 'https://logoeps.com/wp-content/uploads/2013/03/dallas-mavericks-vector-logo.png', 'Blue, Silver, Navy', 'Won championship in 2011 with Dirk Nowitzki and currently led by Luka Dončić.'),
('Rockets', 'Houston', 'Western', 'Southwest', 1967, 'Toyota Center', 'Ime Udoka', 2, 'https://logoeps.com/wp-content/uploads/2013/03/houston-rockets-vector-logo.png', 'Red, Black, White', 'Won back-to-back championships in 1994 and 1995 with Hakeem Olajuwon.'),
('Grizzlies', 'Memphis', 'Western', 'Southwest', 1995, 'FedExForum', 'Taylor Jenkins', 0, 'https://logoeps.com/wp-content/uploads/2013/03/memphis-grizzlies-vector-logo.png', 'Navy, Blue, Gold', 'Young and exciting team known for their "Grit and Grind" mentality and passionate fanbase.'),
('Pelicans', 'New Orleans', 'Western', 'Southwest', 1988, 'Smoothie King Center', 'Willie Green', 0, 'https://logoeps.com/wp-content/uploads/2013/03/new-orleans-pelicans-vector-logo.png', 'Navy, Gold, Red', 'Franchise with rising star Zion Williamson and a unique cultural identity in New Orleans.'),
('Spurs', 'San Antonio', 'Western', 'Southwest', 1967, 'Frost Bank Center', 'Gregg Popovich', 5, 'https://logoeps.com/wp-content/uploads/2013/03/san-antonio-spurs-vector-logo.png', 'Black, Silver, White', 'Model franchise with five championships and legendary coach Gregg Popovich.'),
('Kings', 'Sacramento', 'Western', 'Pacific', 1945, 'Golden 1 Center', 'Mike Brown', 1, 'https://logoeps.com/wp-content/uploads/2013/03/sacramento-kings-vector-logo.png', 'Purple, Black, Silver', 'Historic franchise with passionate fanbase, won championship in 1951 as Rochester Royals.'),
('Clippers', 'Los Angeles', 'Western', 'Pacific', 1970, 'Crypto.com Arena', 'Tyronn Lue', 0, 'https://logoeps.com/wp-content/uploads/2013/03/los-angeles-clippers-vector-logo.png', 'Red, Blue, White', 'Share arena with Lakers, known for their "Lob City" era and current championship aspirations.'),
('Suns', 'Phoenix', 'Western', 'Pacific', 1968, 'Footprint Center', 'Frank Vogel', 0, 'https://logoeps.com/wp-content/uploads/2013/03/phoenix-suns-vector-logo.png', 'Orange, Purple, Black', 'Fast-paced, entertaining team with a history of great point guards and recent Finals appearance.');

-- Create index for better search performance
CREATE INDEX idx_team_name ON nba_teams(team_name);
CREATE INDEX idx_city ON nba_teams(city);
CREATE INDEX idx_conference ON nba_teams(conference);
CREATE INDEX idx_division ON nba_teams(division);

-- Create a view for search functionality
CREATE VIEW team_search AS
SELECT 
    id,
    team_name,
    city,
    conference,
    division,
    founded_year,
    arena,
    head_coach,
    championships,
    logo_url,
    team_colors,
    description,
    CONCAT(team_name, ' ', city, ' ', conference, ' ', division, ' ', arena, ' ', head_coach) AS search_text
FROM nba_teams;