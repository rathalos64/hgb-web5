#!/usr/bin/bash

# clear mount point for database
sudo rm -rf db/mnt
mkdir db/mnt

# clear network
docker-compose down --rmi local -v --remove-orphans

# ready, set, go
docker-compose up -d --build