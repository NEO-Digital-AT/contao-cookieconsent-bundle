// Screenshots of the documentation (docs/<lang>/bilder/*.png) in a test installation, marked with the
// NEO annotation layer. See README.md in this folder.
//
//   node capture.cjs <en|de>
//
// Environment: NCC_BASE (default http://127.0.0.1:8000), NCC_ADMIN_USER / NCC_ADMIN_PASSWORD,
// NCC_MYSQL (default "mysql contao"), NCC_ANNOTATE (path to annotate.js of the plugin neo-doku).
const { chromium } = require('playwright');
const { execSync } = require('child_process');
const path = require('path');

const lang = process.argv[2] || 'en';
const env = (name, fallback) => process.env[name] || fallback;
const base = env('NCC_BASE', 'http://127.0.0.1:8000');
const user = env('NCC_ADMIN_USER', 'admin');
const password = env('NCC_ADMIN_PASSWORD', '');
const mysql = env('NCC_MYSQL', 'mysql contao');
const out = path.resolve(__dirname, '../../docs', lang, 'bilder');
const annotate = env('NCC_ANNOTATE', path.resolve(__dirname, '../../../NEO-Claude-Plugins/plugins/neo-doku/scripts/annotate.js'));
const sql = (query) => execSync(mysql + ' -N -e "' + query.replace(/"/g, '\\"') + '"').toString().trim();

const context = (browser) => browser.newContext({
  viewport: { width: 1280, height: 800 },
  deviceScaleFactor: 2,
  reducedMotion: 'reduce',
  colorScheme: 'light',
  locale: lang === 'de' ? 'de-AT' : 'en-GB',
  timezoneId: 'Europe/Vienna',
});

// Marks: [selector, number, padding].
async function mark(page, marks) {
  await page.evaluate(() => document.fonts.ready);
  await page.addScriptTag({ path: annotate });
  await page.evaluate((list) => {
    for (const [selector, number, pad] of list) {
      if (document.querySelector(selector)) neoAnnotate.frame(selector, { number, padding: pad == null ? 6 : pad });
    }
  }, marks);
}

(async () => {
  if (!password) {
    console.error('Set NCC_ADMIN_PASSWORD.');
    process.exit(2);
  }
  // The back end and the website in the language of the images; both are restored at the end.
  const userLanguage = sql("SELECT language FROM tl_user WHERE username = '" + user + "'");
  const root = sql("SELECT id FROM tl_page WHERE type = 'root' ORDER BY sorting LIMIT 1");
  const rootLanguage = sql('SELECT language FROM tl_page WHERE id = ' + root);
  sql("UPDATE tl_user SET language = '" + lang + "' WHERE username = '" + user + "'");
  sql("UPDATE tl_page SET language = '" + lang + "' WHERE id = " + root);
  const browser = await chromium.launch();

  try {
    // 1. The first layer for a new visitor (whole window: where it appears on the page).
    const visitor = await (await context(browser)).newPage();
    await visitor.goto(base + '/', { waitUntil: 'networkidle' });
    await visitor.waitForSelector('[data-ncc]:not([hidden]) [data-ncc-view="banner"]');
    await visitor.waitForTimeout(400);
    await mark(visitor, [
      ['.ncc__text[data-ncc-view="banner"]', 1, 6],
      ['.ncc__actions[data-ncc-view="banner"]', 2, 3],
      ['.ncc__links', 3, 6],
    ]);
    await visitor.screenshot({ path: path.join(out, 'banner.png') });
    console.log(path.join(out, 'banner.png'));

    // 2. The second layer: a switch per category with its services.
    await visitor.evaluate(() => document.getElementById('neo-annotation-layer') && document.getElementById('neo-annotation-layer').remove());
    await visitor.click('.ncc__actions[data-ncc-view="banner"] [data-ncc-action="settings"]');
    await visitor.waitForSelector('.ncc__actions[data-ncc-view="settings"]:not([hidden])');
    // The services of the second category opened, as a visitor does with "Show services".
    await visitor.evaluate(() => { const d = document.querySelectorAll('.ncc__cat')[1]; if (d && d.querySelector('details')) d.querySelector('details').open = true; });
    await visitor.waitForTimeout(400);
    await mark(visitor, [
      ['.ncc__cat:nth-of-type(2) .ncc__switch', 1, 4],
      ['.ncc__cat:nth-of-type(2) .ncc__services', 2, 4],
      ['.ncc__actions[data-ncc-view="settings"]', 3, 4],
    ]);
    await visitor.screenshot({ path: path.join(out, 'settings-layer.png') });
    console.log(path.join(out, 'settings-layer.png'));
    await visitor.context().close();

    // 3. The services in the back end, with the buttons above the list.
    const page = await (await context(browser)).newPage();
    await page.goto(base + '/contao/login');
    await page.fill('input[name="username"]', user);
    await page.fill('input[name="password"]', password);
    await Promise.all([page.waitForNavigation(), page.click('button[type="submit"]')]);
    await page.goto(base + '/contao?do=neo_cookieconsent', { waitUntil: 'networkidle' });
    await page.addStyleTag({ content: '.sf-toolbar,.sf-minitoolbar{display:none!important}' });
    await mark(page, [
      ['.header_new', 1, 1],
      ['.header_settings', 2, 1],
      ['.header_texts', 3, 1],
      ['.header_findings', 4, 1],
      ['.header_log', 5, 1],
    ]);
    await page.screenshot({ path: path.join(out, 'services.png') });
    console.log(path.join(out, 'services.png'));
  } finally {
    await browser.close();
    sql("UPDATE tl_user SET language = '" + userLanguage + "' WHERE username = '" + user + "'");
    sql("UPDATE tl_page SET language = '" + rootLanguage + "' WHERE id = " + root);
  }
})();
