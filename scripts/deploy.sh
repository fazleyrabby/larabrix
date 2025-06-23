#!/bin/bash
cd /var/www/larabrix  # or wherever your repo is deployed on EC2

# Stop and remove containers/services (if running)
docker-compose down || true

# Build images (especially app, with build args)
docker-compose build

# Start containers in detached mode
docker-compose up -d
