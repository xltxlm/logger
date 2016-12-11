cd %~dp0
docker-compose  up -d --remove-orphans
docker exec   docker_php_1 ls -al /opt/
docker exec -it  docker_php_1 bash -c "cd /logger/  && /logger/vendor/bin/phpunit"