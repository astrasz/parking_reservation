#!/usr/bin/env bash
sleep 10;
php bin/console messenger:consume async --limit=10 --time-limit=3600 --memory-limit=128M -vv>&1;