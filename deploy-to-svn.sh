#!/bin/bash
# Deploy script for syncing GitHub repo to WordPress.org SVN
#
# Usage: ./deploy-to-svn.sh [version]
# Example: ./deploy-to-svn.sh 1.3.0
#
# Prerequisites:
# - SVN must be installed (brew install svn)
# - You need WordPress.org SVN credentials

set -e

# Configuration
PLUGIN_SLUG="wind-speed-converter"
SVN_URL="https://plugins.svn.wordpress.org/${PLUGIN_SLUG}"
SVN_DIR="/tmp/${PLUGIN_SLUG}-svn"
GITHUB_DIR="$(cd "$(dirname "$0")" && pwd)"

# Version from argument or plugin header
if [ -n "$1" ]; then
    VERSION="$1"
else
    VERSION=$(grep "Version:" "${GITHUB_DIR}/windspeed-converter.php" | head -1 | sed 's/.*Version:[[:space:]]*//' | tr -d '[:space:]')
fi

echo "=== Deploying ${PLUGIN_SLUG} v${VERSION} to WordPress.org SVN ==="

# Checkout SVN if not already done
if [ ! -d "${SVN_DIR}" ]; then
    echo ">> Checking out SVN repository..."
    svn checkout "${SVN_URL}" "${SVN_DIR}" --non-interactive
else
    echo ">> Updating existing SVN checkout..."
    svn update "${SVN_DIR}" --non-interactive
fi

# Files to deploy (exclude dev/GitHub-only files)
echo ">> Syncing files to trunk..."
# Build exclude list from .distignore
EXCLUDE_ARGS=""
if [ -f "${GITHUB_DIR}/.distignore" ]; then
    while IFS= read -r line; do
        # Skip empty lines and comments
        [ -z "$line" ] && continue
        [[ "$line" =~ ^# ]] && continue
        EXCLUDE_ARGS="${EXCLUDE_ARGS} --exclude=${line}"
    done < "${GITHUB_DIR}/.distignore"
fi

eval rsync -av --delete ${EXCLUDE_ARGS} "${GITHUB_DIR}/" "${SVN_DIR}/trunk/"

# Check for changes
cd "${SVN_DIR}"

# Add new files
svn status trunk/ | grep '^?' | awk '{print $2}' | xargs -I {} svn add {} 2>/dev/null || true

# Remove deleted files
svn status trunk/ | grep '^!' | awk '{print $2}' | xargs -I {} svn rm {} 2>/dev/null || true

echo ""
echo ">> SVN status:"
svn status

echo ""
echo ">> Ready to commit. Please review the changes above."
echo ""
echo "To commit trunk:"
echo "  cd ${SVN_DIR}"
echo "  svn commit -m 'Update to version ${VERSION}'"
echo ""
echo "To create the tag:"
echo "  svn copy trunk/ tags/${VERSION}/"
echo "  svn commit -m 'Tag version ${VERSION}'"
echo ""
echo "Or commit everything at once:"
echo "  svn copy trunk/ tags/${VERSION}/"
echo "  svn commit -m 'Release version ${VERSION} - WordPress.org review fixes'"
