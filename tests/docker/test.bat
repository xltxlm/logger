cd %~dp0
docker build -t phplog ./php/
docker-compose  up -d
docker exec -it  docker_php_1 bash -c "cd /logger/  && /logger/vendor/bin/phpunit"
docker-compose  down