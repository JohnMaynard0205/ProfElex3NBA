# Azure Deployment Guide - NBA Teams Database

This guide will walk you through deploying your PHP NBA Teams Database application to Microsoft Azure.

## Prerequisites

- Microsoft Azure account (free tier available at [azure.com](https://azure.microsoft.com))
- Azure CLI installed ([Download here](https://docs.microsoft.com/en-us/cli/azure/install-azure-cli))
- Git repository (GitHub recommended)

## Option 1: Quick Deployment with Azure App Service (Recommended)

### Step 1: Create Azure Database for MySQL

1. **Login to Azure Portal**
   - Go to [portal.azure.com](https://portal.azure.com)
   - Sign in with your Azure account

2. **Create MySQL Database**
   ```bash
   # Using Azure CLI (alternative to portal)
   az mysql flexible-server create \
     --name nba-teams-mysql-server \
     --resource-group nba-teams-rg \
     --location "East US" \
     --admin-user nbateamsadmin \
     --admin-password "YourStrongPassword123!" \
     --version 8.0 \
     --sku-name Standard_B1ms \
     --storage-size 20 \
     --public-access 0.0.0.0
   ```

   **Or via Azure Portal:**
   - Search "Azure Database for MySQL"
   - Click "Create" → "Flexible server"
   - Choose resource group or create new: `nba-teams-rg`
   - Server name: `nba-teams-mysql-server`
   - Region: Choose closest to you
   - MySQL version: 8.0
   - Compute + storage: Basic tier (B1ms) for development
   - Admin username: `nbateamsadmin`
   - Password: Create strong password
   - Networking: Allow public access from Azure services

3. **Configure Firewall**
   - In MySQL server → Networking
   - Add rule: "Allow Azure Services" (0.0.0.0 - 0.0.0.0)
   - Add your IP address for management access

4. **Create Database**
   ```bash
   # Connect and create database
   mysql -h nba-teams-mysql-server.mysql.database.azure.com -u nbateamsadmin -p
   CREATE DATABASE nba_teams_db;
   ```
   
   **Or use Azure Cloud Shell:**
   - Open Cloud Shell in Azure Portal
   - Run the database_setup.sql script

### Step 2: Create Azure App Service

1. **Create App Service Plan**
   ```bash
   az appservice plan create \
     --name nba-teams-plan \
     --resource-group nba-teams-rg \
     --sku F1 \
     --is-linux
   ```

2. **Create Web App**
   ```bash
   az webapp create \
     --resource-group nba-teams-rg \
     --plan nba-teams-plan \
     --name nba-teams-app-[unique-suffix] \
     --runtime "PHP|8.2"
   ```

   **Or via Azure Portal:**
   - Search "App Services"
   - Click "Create" → "Web App"
   - Resource group: `nba-teams-rg`
   - Name: `nba-teams-app-[unique-suffix]`
   - Runtime stack: PHP 8.2
   - Operating System: Linux
   - Region: Same as MySQL
   - Pricing plan: Free F1 (for testing)

### Step 3: Configure Application Settings

1. **Add Database Environment Variables**
   
   Go to App Service → Configuration → Application settings, add:

   | Name | Value |
   |------|-------|
   | `DB_HOST` | `nba-teams-mysql-server.mysql.database.azure.com` |
   | `DB_NAME` | `nba_teams_db` |
   | `DB_USER` | `nbateamsadmin@nba-teams-mysql-server` |
   | `DB_PASSWORD` | `YourStrongPassword123!` |
   | `ENVIRONMENT` | `production` |

   **Using Azure CLI:**
   ```bash
   az webapp config appsettings set \
     --resource-group nba-teams-rg \
     --name nba-teams-app-[unique-suffix] \
     --settings \
       DB_HOST="nba-teams-mysql-server.mysql.database.azure.com" \
       DB_NAME="nba_teams_db" \
       DB_USER="nbateamsadmin@nba-teams-mysql-server" \
       DB_PASSWORD="YourStrongPassword123!" \
       ENVIRONMENT="production"
   ```

### Step 4: Deploy Your Application

#### Option A: Deploy from GitHub (Recommended)

1. **Push your code to GitHub** (if not already done)

2. **Set up Continuous Deployment**
   - In App Service → Deployment Center
   - Source: GitHub
   - Authorize Azure to access your GitHub
   - Select organization, repository, and branch
   - Save configuration

#### Option B: Deploy via Git (Local)

1. **Configure local Git deployment**
   ```bash
   az webapp deployment source config-local-git \
     --name nba-teams-app-[unique-suffix] \
     --resource-group nba-teams-rg
   ```

2. **Get deployment credentials**
   ```bash
   az webapp deployment list-publishing-credentials \
     --name nba-teams-app-[unique-suffix] \
     --resource-group nba-teams-rg
   ```

3. **Deploy your code**
   ```bash
   git remote add azure <git-clone-url-from-step-1>
   git push azure main
   ```

#### Option C: Deploy via ZIP

1. **Create ZIP file** (exclude .git, node_modules, etc.)
   ```bash
   zip -r nba-teams-app.zip . -x ".git/*" "*.md" "azure-app-settings.json"
   ```

2. **Deploy ZIP**
   ```bash
   az webapp deployment source config-zip \
     --resource-group nba-teams-rg \
     --name nba-teams-app-[unique-suffix] \
     --src nba-teams-app.zip
   ```

### Step 5: Import Database Data

1. **Connect to your MySQL database**
   - Use Azure Cloud Shell or local MySQL client
   - Run your `database_setup.sql` file

2. **Using MySQL Workbench or phpMyAdmin:**
   - Connect to: `nba-teams-mysql-server.mysql.database.azure.com`
   - Import the SQL file with team data

## Option 2: Container Deployment with Docker

### Step 1: Build and Push Docker Image

1. **Build Docker image locally**
   ```bash
   docker build -t nba-teams-app .
   ```

2. **Create Azure Container Registry**
   ```bash
   az acr create \
     --resource-group nba-teams-rg \
     --name nbateamsacr \
     --sku Basic \
     --admin-enabled true
   ```

3. **Push to Azure Container Registry**
   ```bash
   az acr login --name nbateamsacr
   docker tag nba-teams-app nbateamsacr.azurecr.io/nba-teams-app:latest
   docker push nbateamsacr.azurecr.io/nba-teams-app:latest
   ```

### Step 2: Create Container Instance

```bash
az container create \
  --resource-group nba-teams-rg \
  --name nba-teams-container \
  --image nbateamsacr.azurecr.io/nba-teams-app:latest \
  --registry-login-server nbateamsacr.azurecr.io \
  --registry-username nbateamsacr \
  --registry-password <acr-password> \
  --dns-name-label nba-teams-app \
  --ports 80 \
  --environment-variables \
    DB_HOST=nba-teams-mysql-server.mysql.database.azure.com \
    DB_NAME=nba_teams_db \
    DB_USER=nbateamsadmin@nba-teams-mysql-server \
    DB_PASSWORD=YourStrongPassword123! \
    ENVIRONMENT=production
```

## Post-Deployment Configuration

### 1. SSL/HTTPS Setup
- In App Service → TLS/SSL settings
- Enable "HTTPS Only"
- Azure provides free SSL certificates

### 2. Custom Domain (Optional)
- In App Service → Custom domains
- Add your domain and verify ownership
- Update DNS records

### 3. Monitoring and Logs
- Enable Application Insights for monitoring
- Check logs in App Service → Log stream

## Testing Your Deployment

1. **Visit your application URL:**
   - `https://nba-teams-app-[unique-suffix].azurewebsites.net`

2. **Test database connection:**
   - Verify teams are loading
   - Test search functionality
   - Check admin panel access

3. **Monitor logs:**
   ```bash
   az webapp log tail \
     --resource-group nba-teams-rg \
     --name nba-teams-app-[unique-suffix]
   ```

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Verify firewall rules allow Azure services
   - Check connection strings in app settings
   - Ensure MySQL server is running

2. **PHP Errors**
   - Check logs in App Service → Log stream
   - Verify PHP extensions are installed
   - Check file permissions

3. **Static Files Not Loading**
   - Verify web.config is deployed
   - Check Azure App Service supports your file types

### Useful Commands

```bash
# Restart web app
az webapp restart --resource-group nba-teams-rg --name nba-teams-app-[unique-suffix]

# View logs
az webapp log download --resource-group nba-teams-rg --name nba-teams-app-[unique-suffix]

# Check app settings
az webapp config appsettings list --resource-group nba-teams-rg --name nba-teams-app-[unique-suffix]
```

## Cost Optimization

### Free Tier Limitations
- F1 App Service Plan: 1GB storage, 165 MB/day bandwidth
- B1ms MySQL: Basic tier for development only

### Production Recommendations
- Upgrade to Standard App Service Plan for custom domains/SSL
- Use General Purpose MySQL tier for better performance
- Consider Azure CDN for static assets

## Security Best Practices

1. **Environment Variables**
   - Never commit passwords to Git
   - Use Azure Key Vault for sensitive data

2. **Database Security**
   - Restrict firewall rules to specific IPs
   - Use strong passwords
   - Regular backups

3. **Application Security**
   - Enable HTTPS only
   - Regular updates of PHP/dependencies
   - Monitor for vulnerabilities

## Next Steps

- Set up automated backups
- Configure monitoring alerts
- Implement CI/CD pipeline
- Scale based on traffic patterns

## Support Resources

- [Azure Documentation](https://docs.microsoft.com/azure/)
- [Azure Support](https://azure.microsoft.com/support/)
- [PHP on Azure Guide](https://docs.microsoft.com/azure/app-service/quickstart-php)

---

**Note:** Replace all placeholder values (server names, passwords, etc.) with your actual values when following this guide. 