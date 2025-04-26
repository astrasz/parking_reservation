#!/usr/bin/env bash
sleep 10;
php bin/console messenger:consume async --memory-limit=128M -vv>&1;