# 🏀 NBA Teams Database Web Application

**Group 13 - NBA Teams Database**

A comprehensive web application for managing and exploring NBA team information with advanced search functionality, built with PHP and MySQL.

## 🌟 Features

### Core Functionality
- **Complete NBA Teams Database**: All 30 NBA teams with comprehensive information
- **Advanced Search**: Search by team name, city, arena, coach, or description
- **Smart Filtering**: Filter by conference, division, or championship count
- **Responsive Design**: Modern, mobile-friendly interface
- **Image Integration**: Team logos integrated as requested

### Database Features
- **30+ Team Records**: Complete dataset with all current NBA teams
- **Rich Data**: Team details including arena, coach, championships, founding year
- **Search Optimization**: Indexed database for fast search performance
- **Data Integrity**: Proper validation and sanitization

### User Interface
- **Modern Design**: Glass-morphism design with smooth animations
- **Interactive Elements**: Hover effects and smooth transitions
- **Search Functionality**: Real-time search with multiple filters
- **Statistics Dashboard**: League-wide statistics and insights
- **Admin Panel**: CRUD operations for team management

## 🚀 Quick Start

### Prerequisites
- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Browser**: Modern web browser (Chrome, Firefox, Safari, Edge)

### Installation Steps

1. **Clone/Download the Project**
   ```bash
   # If using Git
   git clone <repository-url>
   
   # Or download and extract the ZIP file
   ```

2. **Set Up Database**
   - Create a MySQL database named `nba_teams_db`
   - Import the database schema:
   ```sql
   mysql -u root -p nba_teams_db < database_setup.sql
   ```

3. **Configure Database Connection**
   - Edit `config/database.php`
   - Update database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'nba_teams_db');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   ```

4. **Deploy to Web Server**
   - Copy all files to your web server's document root
   - Ensure proper permissions for file access

5. **Access the Application**
   - Open your web browser
   - Navigate to `http://localhost/prof_elec3/` (or your configured URL)

## 📁 Project Structure

```
prof_elec3/
├── index.php                 # Main application page
├── team_details.php          # Detailed team information
├── database_setup.sql        # Database schema and sample data
├── README.md                 # This file
│
├── config/
│   └── database.php          # Database configuration
│
├── classes/
│   └── NBATeam.php          # Team data model and operations
│
├── admin/
│   ├── add_team.php         # Add new team interface
│   ├── manage_teams.php     # Team management dashboard
│   └── edit_team.php        # Edit team interface (to be created)
│
└── assets/
    └── css/
        └── style.css        # Modern CSS styling
```

## 🎯 Key Features Explained

### 1. **Database Design**
- **Teams Table**: Comprehensive team information with proper indexing
- **Image Storage**: Logo URLs stored as requested
- **Search Optimization**: Full-text search capabilities
- **Data Validation**: Proper constraints and data types

### 2. **Search Functionality**
- **Multi-field Search**: Search across team name, city, arena, coach, description
- **Conference Filter**: Filter by Eastern/Western conference
- **Division Filter**: Filter by specific divisions
- **Championship Sort**: Sort by championship count
- **Real-time Results**: Instant search results with AJAX

### 3. **Modern Interface**
- **Glass-morphism Design**: Modern UI with backdrop filters
- **Responsive Layout**: Works on all devices
- **Interactive Elements**: Hover effects and animations
- **Accessibility**: Semantic HTML and proper contrast

### 4. **Admin Features**
- **CRUD Operations**: Create, Read, Update, Delete teams
- **Form Validation**: Client and server-side validation
- **Bulk Operations**: Manage multiple teams efficiently
- **Data Export**: Export team data (planned feature)

## 🔍 Using the Search Feature

### Basic Search
1. Enter search terms in the main search box
2. Search works across: team names, cities, arenas, coaches, descriptions
3. Results update automatically

### Advanced Filtering
- **Conference Filter**: Select Eastern or Western conference
- **Division Filter**: Choose specific divisions (Atlantic, Central, etc.)
- **Sort Options**: Sort by team name or championship count
- **Reset Filters**: Clear all filters to view all teams

### Search Examples
- `"Lakers"` - Find Lakers team
- `"Los Angeles"` - Find all LA teams
- `"Madison Square Garden"` - Find teams by arena
- `"Steve Kerr"` - Find teams by coach
- `"championship"` - Find teams with championship history

## 🛠️ Technical Implementation

### Backend (PHP)
- **Object-Oriented Design**: Clean, maintainable code structure
- **PDO Database Layer**: Secure database operations with prepared statements
- **Input Validation**: Comprehensive data sanitization
- **Error Handling**: Proper error management and user feedback

### Frontend (HTML/CSS/JavaScript)
- **Semantic HTML**: Proper document structure
- **Modern CSS**: Flexbox/Grid layouts with custom properties
- **Progressive Enhancement**: Works without JavaScript
- **Performance Optimized**: Efficient loading and rendering

### Database (MySQL)
- **Normalized Structure**: Proper database design
- **Indexed Fields**: Optimized for search performance
- **Data Integrity**: Proper constraints and validation
- **Sample Data**: 30 complete NBA team records

## 📊 Database Schema

### NBA Teams Table
```sql
CREATE TABLE nba_teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    conference VARCHAR(20) NOT NULL,
    division VARCHAR(20) NOT NULL,
    founded_year INT NOT NULL,
    arena VARCHAR(100) NOT NULL,
    head_coach VARCHAR(100) NOT NULL,
    championships INT DEFAULT 0,
    logo_url VARCHAR(255),           -- Images as requested
    team_colors VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🎨 Design Features

### Visual Elements
- **Color Scheme**: Professional blue/purple gradient theme
- **Typography**: Modern, readable font stack
- **Spacing**: Consistent rhythm and white space
- **Icons**: Emoji icons for better user experience

### Interactive Elements
- **Hover Effects**: Smooth transitions on cards and buttons
- **Loading States**: User feedback during operations
- **Form Validation**: Real-time validation with visual feedback
- **Responsive Behavior**: Adapts to different screen sizes

## 🔧 Customization

### Adding New Teams
1. Navigate to Admin Panel
2. Click "Add New Team"
3. Fill in all required fields
4. Add team logo URL for image integration
5. Save the team

### Modifying Styles
- Edit `assets/css/style.css` for design changes
- CSS variables available for quick theme customization
- Responsive breakpoints defined for different devices

### Database Modifications
- Modify `classes/NBATeam.php` for new fields
- Update database schema as needed
- Maintain proper indexing for search performance

## 🚀 Future Enhancements

### Planned Features
- **Player Management**: Add player information to teams
- **Statistics Integration**: Real-time NBA statistics
- **Advanced Analytics**: Team performance metrics
- **User Accounts**: Personal team favorites and notes
- **Data Export**: CSV/PDF export functionality

### Technical Improvements
- **API Integration**: Live NBA data feeds
- **Caching**: Performance optimization
- **Search Improvements**: Auto-complete and suggestions
- **Mobile App**: React Native mobile application

## 🐛 Troubleshooting

### Common Issues

1. **Database Connection Error**
   - Check database credentials in `config/database.php`
   - Ensure MySQL server is running
   - Verify database exists and is accessible

2. **Search Not Working**
   - Check database indexes are created
   - Verify PHP PDO extension is enabled
   - Check for JavaScript errors in browser console

3. **Images Not Loading**
   - Verify image URLs are accessible
   - Check for proper fallback image handling
   - Ensure CDN or image hosting is available

4. **Styling Issues**
   - Check CSS file path is correct
   - Verify browser supports modern CSS features
   - Clear browser cache

## 📝 License

This project is created for educational purposes as part of Group 13's database assignment.

## 👥 Contributors

**Group 13 - NBA Teams Database Project**
- Professional basketball team database implementation
- Modern web application with PHP and MySQL
- Comprehensive search functionality as requested

## 📞 Support

For issues or questions about this NBA Teams Database application:
1. Check the troubleshooting section above
2. Review the code documentation
3. Verify database setup and configuration
4. Check web server error logs

---

**🏀 NBA Teams Database - Group 13**  
*A comprehensive web application for exploring professional basketball teams with advanced search capabilities and modern design.* 