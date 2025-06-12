docker compose -f 'docker-compose.yml' up -d --build
docker compose -f 'docker-compose.yml' down

sudo kill -9 $(lsof -t -i :9003)