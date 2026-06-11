#!/bin/bash
# Seeds the local Docker WordPress with the pages the E2E tests expect
# and re-arms the one-time activation notice.
#
# Run from the directory that contains the docker-compose.yml of the
# test environment:
#   ../tests/setup-test-pages.sh   (or with an absolute path)

set -e

wp() {
    docker compose run --rm cli wp "$@"
}

create_page_if_missing() {
    local slug="$1" title="$2" content="$3"
    if [ -z "$(wp post list --post_type=page --name="${slug}" --field=ID 2>/dev/null | tr -d '[:space:]')" ]; then
        wp post create --post_type=page --post_status=publish \
            --post_title="${title}" --post_name="${slug}" --post_content="${content}"
        echo ">> created page /${slug}/"
    else
        echo ">> page /${slug}/ already exists"
    fi
}

create_page_if_missing "converter"  "Converter"  "[windspeed_converter]"
create_page_if_missing "nolink"     "NoLink"     "[windspeed_converter link=\"false\"]"
create_page_if_missing "partial"    "Partial"    "[windspeed_converter beaufort=\"false\" ms=\"false\"]"
create_page_if_missing "double"     "Double"     "[windspeed_converter][windspeed_converter]"
create_page_if_missing "block-test" "Block Test" "<!-- wp:wind-speed-converter/converter {\"beaufort\":false,\"link\":false} /-->"

# Pretty permalinks (the tests navigate to /converter/ etc.).
wp rewrite structure '/%postname%/' --hard

# Re-arm the one-time activation notice for the admin spec.
wp option update wsconv_show_activation_notice 1

echo ">> done"
