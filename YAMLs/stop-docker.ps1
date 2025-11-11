# Stop Docker containers
Write-Host "Stopping Docker containers..." -ForegroundColor Yellow
docker-compose down

# Start MySQL93 service back (optional - uncomment if you want local MySQL running)
# Write-Host "Starting MySQL93 service..." -ForegroundColor Green
# Start-Service -Name MySQL93 -ErrorAction SilentlyContinue

Write-Host "Docker containers stopped!" -ForegroundColor Green


