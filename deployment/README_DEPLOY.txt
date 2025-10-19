DEPLOYMENT INSTRUCTIONS

1. Upload all files from public_html to the hosting public_html folder.

2. Create a MySQL database and user.

3. Import dump_theaterztb.sql into that database using phpMyAdmin.

4. Copy config-template.php to config.php and fill DB credentials.

5. Test site at domain URL.

6. Delete from package: docker-compose.yml, Dockerfile, node_modules, .git

7. Zip project folder as theaterztb_deploy_YYYYMMDD.zip

8. Send the zip file and README_DEPLOY.txt to the agent.


