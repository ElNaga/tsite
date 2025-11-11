# Stop local MySQL93 service before starting Docker
Write-Host "Stopping MySQL93 service..." -ForegroundColor Yellow
Stop-Service -Name MySQL93 -ErrorAction SilentlyContinue

# Start Docker containers
Write-Host "Starting Docker containers..." -ForegroundColor Green
docker-compose up -d

Write-Host "Docker containers started!" -ForegroundColor Green
Write-Host "To stop: docker-compose down" -ForegroundColor Cyan


