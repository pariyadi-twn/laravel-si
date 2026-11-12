#!/usr/bin/env bash
set -euo pipefail
# [P01-P12] Periksa sintaks seluruh file PHP. Ini BUKAN pengganti php artisan test.
cd "$(dirname "$0")/.."
find app bootstrap config database routes tests -type f -name '*.php' -print0 | while IFS= read -r -d '' f; do
  php -l "$f" >/dev/null || exit 1
  echo "OK: $f"
done
