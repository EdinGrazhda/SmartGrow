# SmartGrow - Digital Farming Management System

![SmartGrow Logo](img/logo1.png)

## Overview

SmartGrow is a comprehensive digital platform designed to revolutionize farming practices through technology, data-driven insights, and smart agricultural management. The system helps farmers optimize their operations, make informed planting decisions based on weather data, and improve overall farm productivity using modern tech solutions.

## Features

### For Farmers

- **Farm Management**: Add, view, update, and delete farm records
- **Weather-Based Planting Advisor**:
  - 40-day weather forecasts for any location
  - AI-powered planting recommendations based on plant categories
  - Intelligent analysis of optimal planting conditions
- **Plant Disease Detection**: AI-powered plant disease diagnosis tool
- **Dashboard**: Insights and analytics about farm performance

### For Administrators

- **User Management**: Control user accounts and permissions
- **Category Management**: Add, update, and delete plant categories
- **System Settings**: Configure application settings

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5, jQuery
- **Backend**: PHP
- **Database**: MySQL
- **APIs Integration**:
  - OpenWeatherMap API (Weather forecasting)
  - OpenAI API (AI-powered recommendations)
  - EmailJS (Contact form submissions)
- **Libraries**:
  - AOS (Animations On Scroll)
  - Font Awesome (Icons)
  - EmailJS (Email services)

## Installation & Setup

### Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP/WAMP/MAMP or any PHP server environment
- Web browser with JavaScript enabled

### Installation Steps

1. **Clone Repository**

   ```
   git clone [repository-url]
   ```

2. **Database Configuration**

   - Create a MySQL database named `smartgrow`
   - Import the database structure from the SQL file (if available)
   - Configure database connection in `database.php`:
     ```php
     $hostName = "localhost";
     $dbUser = "root";
     $dbPassword = "";
     $dbName = "smartgrow";
     ```

3. **API Keys Configuration**

   - OpenWeatherMap API key (configured in `farmers/weatherforcast.php`)
   - OpenAI API key (configured in `farmers/weatherforcast.php` and `analyze.php`)
   - EmailJS configuration (service ID, template ID, public key - configured in `index.php`)

4. **Start Server**
   - Place the project folder in the `htdocs` directory of your XAMPP installation
   - Start XAMPP (Apache and MySQL)
   - Access the application at `http://localhost/SmartGrow/`

## File Structure

- `index.php` - Main landing page
- `login.php` - User authentication
- `register.php` - New user registration
- `/admin` - Administrator portal
- `/farmers` - Farmer-specific features
  - `weatherforcast.php` - Weather-based planting advisor
  - `farms.php` - Farm management
  - `analyze.php` - Plant disease detection
- `/api` - API handlers
- `/img` - Images and logos
- `/includes` - Common PHP functions and configurations

## User Roles

1. **Administrator**

   - Manage user accounts
   - Configure plant categories
   - System settings

2. **Farmer**
   - Manage farm records
   - Access weather forecasting and planting advice
   - Use plant disease detection tools

## API Integrations

### OpenWeatherMap

Used for retrieving accurate weather forecasts for the planting advisor feature.

### OpenAI

Powers the intelligent planting recommendations and plant disease diagnosis tools.

### EmailJS

Handles contact form submissions directly from the browser to your email inbox.

## Contact Form

The contact form on the landing page uses EmailJS to submit messages directly to the administrator's email address without server-side processing. Configured with:

- Service ID: `service_ivxylli`
- Template ID: `template_x6i4pku`
- Public Key: `GIMPfkH3Ozq1MzLcJ`

## Maintenance

- Regularly update API keys and credentials
- Back up the MySQL database periodically
- Monitor error logs for any issues

## Future Enhancements

- Mobile app integration
- IoT device connectivity for real-time farm monitoring
- Advanced crop yield predictions
- Extended weather forecasting capabilities
- Enhanced plant disease detection with treatment recommendations

## Credits

- Weather data provided by OpenWeatherMap
- AI-powered analysis by OpenAI
- Email services by EmailJS
- Icons by Font Awesome
- Frontend framework by Bootstrap

## License

[Include license information here]

---

© 2025 SmartGrow. All Rights Reserved.
