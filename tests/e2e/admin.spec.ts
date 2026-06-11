/**
 * Admin E2E tests: onboarding notice, plugin list links and guide page.
 *
 * Requires the local Docker test environment (see tests/README.md).
 * tests/setup-test-pages.sh re-arms the activation notice option, so the
 * notice tests are deterministic when the setup script ran beforehand.
 */
import { test, expect, type Page } from '@playwright/test';

const ADMIN_USER = process.env.WP_ADMIN_USER || 'admin';
const ADMIN_PASS = process.env.WP_ADMIN_PASS || 'admin123';

async function login( page: Page ) {
	await page.goto( '/wp-login.php' );
	await page.fill( '#user_login', ADMIN_USER );
	await page.fill( '#user_pass', ADMIN_PASS );
	await page.click( '#wp-submit' );
	await page.waitForURL( /wp-admin/ );
}

test.describe( 'Plugins screen', () => {
	test( 'shows the How to use, Documentation and Support links', async ( { page } ) => {
		await login( page );
		await page.goto( '/wp-admin/plugins.php' );
		const row = page.locator( 'tr[data-slug="wind-speed-converter"]' );
		await expect( row.getByRole( 'link', { name: 'How to use' } ) ).toBeVisible();
		await expect( row.getByRole( 'link', { name: 'Documentation' } ) ).toBeVisible();
		await expect( row.getByRole( 'link', { name: 'Support' } ) ).toBeVisible();
	} );
} );

// Note: must run before the guide page test, because visiting the guide
// permanently dismisses the notice.
test.describe( 'Activation notice', () => {
	test( 'links to the guide and disappears after visiting it', async ( { page } ) => {
		await login( page );
		await page.goto( '/wp-admin/index.php' );

		const notice = page.getByText( 'Windspeed Converter is ready.' );
		if ( ! ( await notice.isVisible() ) ) {
			// Notice already dismissed; re-arm it via tests/setup-test-pages.sh.
			test.skip( true, 'Activation notice not armed - run tests/setup-test-pages.sh first.' );
		}

		await page.getByRole( 'link', { name: 'Open the guide' } ).click();
		await page.waitForURL( /page=wsconv-guide/ );

		// Visiting the guide dismisses the notice permanently.
		await page.goto( '/wp-admin/index.php' );
		await expect( page.getByText( 'Windspeed Converter is ready.' ) ).toHaveCount( 0 );
	} );
} );

test.describe( 'Guide page', () => {
	test( 'is reachable under Tools and documents all options', async ( { page } ) => {
		await login( page );
		await page.goto( '/wp-admin/tools.php?page=wsconv-guide' );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toContainText( 'How to use' );
		// Shortcode examples for every field attribute plus the backlink.
		await expect( page.getByText( '[windspeed_converter]', { exact: true } ) ).toBeVisible();
		for ( const attribute of [ 'kmh', 'mph', 'beaufort', 'ms', 'knots', 'link' ] ) {
			await expect( page.getByText( `[windspeed_converter ${ attribute }="false"]` ) ).toBeVisible();
		}
	} );
} );
