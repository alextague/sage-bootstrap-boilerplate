#!/bin/bash
#
# Runs after each deploy (.github/workflows/deploy.yml).
#
# WP Engine blocks logged-out web requests from creating .php files, and Acorn's caches (compiled
# Blade views, services.php, packages.php) are .php. So the caches must be rebuilt over SSH after
# every deploy, or visitors get WordPress's critical error page until someone logged in loads a
# page.
#
# This script never switches the active theme. Activate the theme in WP Admin → Appearance →
# Themes (or `wp theme activate <slug>`), which keeps widget assignments; a raw update of the
# template/stylesheet options does not. Switching themes on a deploy could also replace the theme
# on a live site that isn't ready for it.
#
# Acorn only boots when this theme is the active theme, so while another theme is active this
# only reports and exits. After activating the theme, rerun the workflow so the caches are built.

set -e

for var in WPE_ENV THEME_SLUG WPE_SSHG_KEY_PRIVATE; do
  if [ -z "${!var}" ]; then
    echo "Error: $var is not set"
    exit 1
  fi
done

# WP Engine SSH convention: all values derive from WPE_ENV
SSH_HOST="${WPE_ENV}.ssh.wpengine.net"
SSH_USER="${WPE_ENV}"
SITE_PATH="sites/${WPE_ENV}"

mkdir -p ~/.ssh
echo "$WPE_SSHG_KEY_PRIVATE" > ~/.ssh/id_rsa
chmod 600 ~/.ssh/id_rsa
ssh-keyscan -t rsa "$SSH_HOST" >> ~/.ssh/known_hosts 2>/dev/null || true

# No "exit" or "set -e" in the remote part: a session there that ended with "exit 0" came back
# from WP Engine's SSH gateway with status 1 and failed the deploy. The if/else returns the status
# of the cache commands, or 0 when they're skipped.
ssh -o StrictHostKeyChecking=no "${SSH_USER}@${SSH_HOST}" <<EOF
cd $SITE_PATH
current_theme=\$(wp option get stylesheet 2>/dev/null | tr -d '[:space:]')
if [ "\$current_theme" = "$THEME_SLUG" ]; then
    wp acorn optimize:clear && wp acorn view:cache && wp eval 'wpecommon::purge_varnish_cache();'
else
    echo "The active theme is \$current_theme, not $THEME_SLUG: skipping the Acorn caches."
fi
EOF

echo "${WPE_ENV} post-deploy complete."
