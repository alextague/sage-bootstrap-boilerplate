#!/bin/bash

set -e

# Validate required env vars
if [ -z "$WPE_ENV" ]; then
    echo "Error: WPE_ENV is not set"
    exit 1
fi

if [ -z "$THEME_SLUG" ]; then
    echo "Error: THEME_SLUG is not set"
    exit 1
fi

# WPEngine SSH convention: all values derive from WPE_ENV
SSH_HOST="${WPE_ENV}.ssh.wpengine.net"
SSH_USER="${WPE_ENV}"
SITE_PATH="sites/${WPE_ENV}"

# Setup SSH key
mkdir -p ~/.ssh
echo "$WPE_SSHG_KEY_PRIVATE" > ~/.ssh/id_rsa
chmod 600 ~/.ssh/id_rsa

# Add WPEngine host to known_hosts
ssh-keyscan -t rsa "$SSH_HOST" >> ~/.ssh/known_hosts 2>/dev/null || true

# Activate theme and clear caches
echo "Activating theme and clearing caches on ${WPE_ENV}..."
ssh -o StrictHostKeyChecking=no "${SSH_USER}@${SSH_HOST}" <<EOF
cd $SITE_PATH

current_theme=\$(wp option get stylesheet)
if [ "\$current_theme" != "$THEME_SLUG" ]; then
    echo "Activating the theme..."
    wp option update template "$THEME_SLUG"
    wp option update stylesheet "$THEME_SLUG"
else
    echo "Theme is already active."
fi

wp eval 'wpecommon::purge_varnish_cache();'
wp acorn optimize:clear
wp acorn view:cache
EOF

echo "${WPE_ENV} deployment complete!"
