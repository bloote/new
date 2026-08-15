#!/usr/bin/env bash
#
# Package the theme for installation.
#
#   ./tools/build.sh   →  dist/northline-<version>.zip
#
set -euo pipefail

root="$( cd "$( dirname "${BASH_SOURCE[0]}" )/.." && pwd )"
version="$( sed -n 's/^Version: *//p' "$root/northline/style.css" | head -1 )"
out="$root/dist/northline-${version}.zip"

command -v zip >/dev/null || { echo "zip is not installed." >&2; exit 1; }

echo "Linting…"
find "$root/northline" -name '*.php' -print0 | xargs -0 -n1 php -l >/dev/null

mkdir -p "$root/dist"
rm -f "$out"

cd "$root"
zip -rq "$out" northline \
	-x 'northline/.*' \
	-x '*/.DS_Store' \
	-x '*/node_modules/*'

echo "Built $out ($( du -h "$out" | cut -f1 ))"
