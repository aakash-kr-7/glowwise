#!/usr/bin/env bash
set -euo pipefail
# Containers never need the VM identity; only the root host cost timer does.
iptables -C DOCKER-USER -d 169.254.169.254/32 -j REJECT 2>/dev/null || \
  iptables -I DOCKER-USER 1 -d 169.254.169.254/32 -j REJECT
