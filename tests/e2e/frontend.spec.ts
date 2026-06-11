/**
 * Frontend E2E tests for the Windspeed Converter plugin.
 *
 * Requires the local Docker test environment (see tests/README.md)
 * with the seeded test pages created by tests/setup-test-pages.sh.
 */
import { test, expect, type Page } from '@playwright/test';

const FIELDS = [ 'kmh', 'mph', 'beaufort', 'ms', 'knots' ] as const;

async function typeInto( page: Page, field: string, value: string ) {
	// The conversion script listens on "keyup", so the value must be
	// typed key by key instead of being set programmatically.
	await page.locator( `input[name="${ field }"]` ).first().pressSequentially( value );
}

test.describe( 'Shortcode page (all fields)', () => {
	test( 'shows all five fields and the backlink', async ( { page } ) => {
		await page.goto( '/converter/' );
		for ( const field of FIELDS ) {
			await expect( page.locator( `input[name="${ field }"]` ) ).toBeVisible();
		}
		await expect( page.locator( '#link a' ) ).toHaveText( 'by Ostheimer.at' );
	} );

	test( 'converts 100 km/h into all other units', async ( { page } ) => {
		await page.goto( '/converter/' );
		await typeInto( page, 'kmh', '100' );
		await expect( page.locator( 'input[name="mph"]' ) ).toHaveValue( '62.14' );
		await expect( page.locator( 'input[name="ms"]' ) ).toHaveValue( '27.78' );
		await expect( page.locator( 'input[name="knots"]' ) ).toHaveValue( '54.00' );
		await expect( page.locator( 'input[name="beaufort"]' ) ).toHaveValue( '10' );
	} );

	test( 'converts 10 m/s into all other units', async ( { page } ) => {
		await page.goto( '/converter/' );
		await typeInto( page, 'ms', '10' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toHaveValue( '36.00' );
		await expect( page.locator( 'input[name="mph"]' ) ).toHaveValue( '22.37' );
		await expect( page.locator( 'input[name="knots"]' ) ).toHaveValue( '19.44' );
		await expect( page.locator( 'input[name="beaufort"]' ) ).toHaveValue( '5' );
	} );

	test( 'shows Beaufort ranges for a Beaufort input', async ( { page } ) => {
		await page.goto( '/converter/' );
		await typeInto( page, 'beaufort', '5' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toHaveValue( '29 - 38' );
		await expect( page.locator( 'input[name="mph"]' ) ).toHaveValue( '19 - 24' );
		await expect( page.locator( 'input[name="ms"]' ) ).toHaveValue( '8.0 - 10.7' );
		await expect( page.locator( 'input[name="knots"]' ) ).toHaveValue( '16 - 21' );
	} );

	test( 'rejects a Beaufort value above 12', async ( { page } ) => {
		await page.goto( '/converter/' );
		await typeInto( page, 'beaufort', '13' );
		await expect( page.locator( '.message' ) ).toContainText( 'Number between 1 and 12' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toHaveValue( '-' );
	} );

	test( 'asks for a dot as decimal separator', async ( { page } ) => {
		await page.goto( '/converter/' );
		await typeInto( page, 'kmh', '10,5' );
		await expect( page.locator( '.message' ) ).toContainText( 'Use . (dot) as comma.' );
	} );
} );

test.describe( 'Shortcode attributes', () => {
	test( 'link="false" hides the backlink', async ( { page } ) => {
		await page.goto( '/nolink/' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toBeVisible();
		await expect( page.locator( '#link' ) ).toHaveCount( 0 );
	} );

	test( 'beaufort="false" ms="false" hides those fields', async ( { page } ) => {
		await page.goto( '/partial/' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toBeVisible();
		await expect( page.locator( 'input[name="mph"]' ) ).toBeVisible();
		await expect( page.locator( 'input[name="knots"]' ) ).toBeVisible();
		await expect( page.locator( 'input[name="beaufort"]' ) ).toHaveCount( 0 );
		await expect( page.locator( 'input[name="ms"]' ) ).toHaveCount( 0 );
	} );

	test( 'two shortcodes on one page render two converters', async ( { page } ) => {
		await page.goto( '/double/' );
		await expect( page.locator( '.wind_converter' ) ).toHaveCount( 2 );
	} );
} );

test.describe( 'Gutenberg block', () => {
	test( 'renders the converter with disabled fields', async ( { page } ) => {
		await page.goto( '/block-test/' );
		await expect( page.locator( 'input[name="kmh"]' ) ).toBeVisible();
		await expect( page.locator( 'input[name="mph"]' ) ).toBeVisible();
		await expect( page.locator( 'input[name="beaufort"]' ) ).toHaveCount( 0 );
		await expect( page.locator( '#link' ) ).toHaveCount( 0 );
	} );

	test( 'block output is interactive (conversion works)', async ( { page } ) => {
		await page.goto( '/block-test/' );
		await typeInto( page, 'kmh', '100' );
		await expect( page.locator( 'input[name="mph"]' ) ).toHaveValue( '62.14' );
	} );
} );
