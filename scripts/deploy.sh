#!/bin/bash
cd /var/www/larabrix

# Stop old container (optional)
docker stop larabrix || true
docker rm larabrix || true

# Build and run the container
docker build -t larabrix .

docker run -d --name larabrix \
  -p 80:80 \
  larabrix
