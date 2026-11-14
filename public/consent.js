/*
 * Cookie consent: banner, settings, loading and unblocking of services.
 *
 * - Nothing that needs consent runs before an explicit choice.
 * - The choice is kept in localStorage ("ncc-consent") with the version of the
 *   services; a new version asks again.
 * - window.cookieConsent (set up by the head script) offers allows(category),
 *   allowsService(key, category), open(), the list categories (what the banner
 *   asks for) and fires "cookie-consent:change".
 * - Blocked scripts (type="text/plain" data-ncc-category), stylesheets
 *   (rel="ncc-stylesheet") and embedded content (.ncc-embed) are switched on
 *   once allowed; withdrawing consent deletes the cookies of the category and
 *   reloads the page.
 * - The button to reopen ([data-ncc-reopen]) is shown once the visitor has
 *   chosen. It takes part in the buttons at the edge of the screen of NEO
 *   Basic (data-neo-dock): sharing a corner with buttons of other extensions,
 *   it becomes an entry of a settings menu or is stacked with them
 *   (bundles/neobasic/dock.js); this script needs nothing of it.
 */
(function () {
  'use strict';

  var KEY = 'ncc-consent';
  var api = window.cookieConsent = window.cookieConsent || {};
  var cfgEl = document.getElementById('ncc-config');
  var root = document.querySelector('[data-ncc]');

  if (!cfgEl || !root) return;

  var cfg;
  try { cfg = JSON.parse(cfgEl.textContent); } catch (e) { return; }

  var panel = root.querySelector('[data-ncc-panel]');
  var reopenBtn = document.querySelector('[data-ncc-reopen]');
  var CATS = (cfg.cats || []).slice();
  var state = api.state && api.state.v === cfg.v ? api.state : null;
  var loaded = {};
  var lastFocus = null;

  function uuid() {
    if (window.crypto && crypto.randomUUID) return crypto.randomUUID();
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
      var r = Math.random() * 16 | 0;
      return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
  }

  function allows(cat) { return cat === 'necessary' || !!(state && state.cats && state.cats[cat]); }
  function allowsService(key, cat) { return allows(cat) || !!(state && state.svc && state.svc[key]); }

  api.allows = allows;
  api.allowsService = allowsService;
  api.categories = CATS.slice();

  // ---- Running services ---------------------------------------------------

  /** Inserts HTML into the head; scripts are re-created so that they run, in order. */
  function insertHtml(html) {
    var tpl = document.createElement('template');
    tpl.innerHTML = html;
    var nodes = [].slice.call(tpl.content.childNodes);
    var chain = Promise.resolve();

    nodes.forEach(function (node) {
      chain = chain.then(function () {
        if (node.nodeName !== 'SCRIPT') {
          document.head.appendChild(node);
          return null;
        }
        return runScript(node, document.head);
      });
    });
  }

  /** A script element that runs: same attributes and code, without the blocking type. */
  function runScript(old, parent, before) {
    return new Promise(function (resolve) {
      var s = document.createElement('script');
      [].slice.call(old.attributes).forEach(function (a) {
        if (a.name === 'type' || a.name.indexOf('data-ncc-') === 0) return;
        s.setAttribute(a.name, a.value);
      });
      if (old.getAttribute('data-ncc-type') === 'module') s.type = 'module';
      if (s.src) {
        if (!old.hasAttribute('async')) s.async = false;
        s.onload = s.onerror = function () { resolve(); };
      } else {
        s.text = old.text || old.textContent || '';
      }
      if (before) before.parentNode.replaceChild(s, before); else parent.appendChild(s);
      if (!s.src) resolve();
    });
  }

  function syncConsentMode() {
    if (!cfg.consentMode || typeof window.gtag !== 'function') return;
    var g = function (cat) { return allows(cat) ? 'granted' : 'denied'; };
    window.gtag('consent', 'update', {
      ad_storage: g('marketing'),
      ad_user_data: g('marketing'),
      ad_personalization: g('marketing'),
      analytics_storage: g('statistics'),
      functionality_storage: g('functional'),
      personalization_storage: g('functional')
    });
    window.gtag('set', 'ads_data_redaction', !allows('marketing'));
  }

  function showEmbed(box) {
    var tpl = box.querySelector('template');
    if (!tpl) return;
    var frag = tpl.content.cloneNode(true);
    box.replaceWith(frag);
  }

  /** Switches on everything the current choice allows. */
  function apply(scope) {
    scope = scope || document;
    syncConsentMode();

    (cfg.loaders || []).forEach(function (l) {
      if (!loaded[l.key + l.cat] && allowsService(l.key, l.cat)) {
        loaded[l.key + l.cat] = true;
        insertHtml(l.html);
      }
    });

    var chain = Promise.resolve();
    [].slice.call(scope.querySelectorAll('script[type="text/plain"][data-ncc-category]')).forEach(function (el) {
      if (!allowsService(el.getAttribute('data-ncc-service'), el.getAttribute('data-ncc-category'))) return;
      el.removeAttribute('data-ncc-category');
      chain = chain.then(function () { return runScript(el, el.parentNode, el); });
    });

    [].slice.call(scope.querySelectorAll('link[rel="ncc-stylesheet"][data-ncc-href]')).forEach(function (el) {
      if (!allowsService(el.getAttribute('data-ncc-service'), el.getAttribute('data-ncc-category'))) return;
      el.setAttribute('href', el.getAttribute('data-ncc-href'));
      el.setAttribute('rel', 'stylesheet');
      el.removeAttribute('data-ncc-href');
    });

    [].slice.call(scope.querySelectorAll('[data-ncc-embed]')).forEach(function (box) {
      if (allowsService(box.getAttribute('data-ncc-service'), box.getAttribute('data-ncc-category'))) showEmbed(box);
    });

    [].slice.call(document.querySelectorAll('[data-ncc-id]')).forEach(function (el) { el.textContent = state ? state.id : ''; });
    [].slice.call(document.querySelectorAll('[data-ncc-id-row]')).forEach(function (el) { el.hidden = !state; });
  }

  // ---- Withdrawal ---------------------------------------------------------

  function dropCookie(name) {
    var host = location.hostname;
    var parts = host.split('.');
    var domains = [''];
    for (var i = 0; i < parts.length - 1; i++) {
      var d = parts.slice(i).join('.');
      domains.push(d, '.' + d);
    }
    domains.forEach(function (domain) {
      document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/' + (domain ? '; domain=' + domain : '');
    });
  }

  // Keys of the browser storage (local and session) a service listed as well.
  function storageKeys(store) {
    var keys = [];
    try {
      for (var i = 0; i < store.length; i++) keys.push(store.key(i));
    } catch (e) { /* storage blocked */ }
    return keys;
  }

  function dropCookies(cats) {
    var names = document.cookie.split(';').map(function (c) { return c.split('=')[0].trim(); }).filter(Boolean);
    var stores = [];
    try { stores = [window.localStorage, window.sessionStorage]; } catch (e) { /* storage blocked */ }
    cats.forEach(function (cat) {
      (cfg.cookies && cfg.cookies[cat] || []).forEach(function (pattern) {
        var re = new RegExp('^' + pattern.replace(/[.+?^${}()|[\]\\]/g, '\\$&').replace(/\*/g, '.*') + '$');
        names.forEach(function (n) { if (re.test(n)) dropCookie(n); });
        stores.forEach(function (store) {
          storageKeys(store).forEach(function (k) {
            if (k.indexOf('ncc-') !== 0 && re.test(k)) {
              try { store.removeItem(k); } catch (e) { /* storage blocked */ }
            }
          });
        });
      });
    });
  }

  // ---- Choice -------------------------------------------------------------

  function log(action) {
    if (!cfg.log || !state) return;
    try {
      fetch(cfg.log, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        keepalive: true,
        body: JSON.stringify({
          id: state.id,
          v: state.v,
          root: cfg.root,
          action: action,
          cats: CATS.filter(function (c) { return state.cats[c]; }),
          svc: Object.keys(state.svc || {}).filter(function (k) { return state.svc[k]; })
        })
      }).catch(function () {});
    } catch (e) {}
  }

  function save(cats, svc, action) {
    var before = state;
    state = { v: cfg.v, id: before && before.id ? before.id : uuid(), ts: Date.now(), cats: cats, svc: svc || (before && before.svc) || {} };
    api.state = state;
    try { localStorage.setItem(KEY, JSON.stringify(state)); } catch (e) {}

    var revoked = before ? CATS.filter(function (c) { return before.cats && before.cats[c] && !cats[c]; }) : [];

    log(action);
    try { window.dispatchEvent(new CustomEvent('cookie-consent:change', { detail: { cats: cats, svc: state.svc, action: action } })); } catch (e) {}

    if (revoked.length) {
      dropCookies(revoked);
      location.reload();
      return;
    }

    apply();
  }

  function all(value) {
    var cats = {};
    CATS.forEach(function (c) { cats[c] = value; });
    return cats;
  }

  // ---- Button to reopen ------------------------------------------------------

  // Shown while the banner is closed, once the visitor has chosen.
  function syncReopen() {
    if (!reopenBtn) return;
    reopenBtn.hidden = !root.hidden || !state;
  }

  // ---- Banner -------------------------------------------------------------

  function view(name) {
    [].slice.call(root.querySelectorAll('[data-ncc-view]')).forEach(function (el) {
      el.hidden = el.getAttribute('data-ncc-view') !== name;
    });
    root.setAttribute('data-ncc-current', name);
    if (name === 'settings') syncSwitches();
  }

  function syncSwitches() {
    [].slice.call(root.querySelectorAll('[data-ncc-cat]')).forEach(function (sw) {
      var cat = sw.getAttribute('data-ncc-cat');
      sw.setAttribute('aria-checked', String(cat === 'necessary' || allows(cat)));
    });
  }

  function readSwitches() {
    var cats = {};
    CATS.forEach(function (c) {
      var sw = root.querySelector('[data-ncc-cat="' + c + '"]');
      cats[c] = !!sw && sw.getAttribute('aria-checked') === 'true';
    });
    return cats;
  }

  // With a dimmed background the banner is modal: the rest of the page is
  // inert until the visitor chooses, and Tab stays inside the banner.
  var inerted = [];

  function setModal(on) {
    if (!cfg.modal) return;
    if (on) {
      [].slice.call(document.body.children).forEach(function (el) {
        if (el !== root && !el.contains(root) && el.nodeName !== 'SCRIPT' && !el.inert) {
          el.inert = true;
          inerted.push(el);
        }
      });
      document.documentElement.classList.add('ncc-modal-open');
    } else {
      inerted.forEach(function (el) { el.inert = false; });
      inerted = [];
      document.documentElement.classList.remove('ncc-modal-open');
    }
  }

  function show(settings, byUser) {
    if (byUser) lastFocus = document.activeElement;
    view(settings ? 'settings' : 'banner');
    root.hidden = false;
    setModal(true);
    syncReopen();
    requestAnimationFrame(function () {
      root.classList.add('is-open');
      // Keyboard users reach the choice at once instead of after the whole page.
      panel.focus({ preventScroll: true });
    });
  }

  function hide() {
    root.classList.remove('is-open');
    root.hidden = true;
    setModal(false);
    syncReopen();
    // The dock of NEO Basic shows its settings button again at once (it may
    // hold the focus to return to), not only after this script has finished.
    if (window.NeoDock && typeof window.NeoDock.refresh === 'function') window.NeoDock.refresh();
    if (lastFocus && document.contains(lastFocus) && lastFocus !== reopenBtn) {
      try { lastFocus.focus({ preventScroll: true }); } catch (e) {}
    } else if (reopenBtn && !reopenBtn.hidden) {
      reopenBtn.focus({ preventScroll: true });
    }
    lastFocus = null;
  }

  api.open = function () { show(true, true); };
  api.get = function () { return state; };

  root.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-ncc-action], [data-ncc-cat]');
    if (!btn) return;

    if (btn.hasAttribute('data-ncc-cat')) {
      if (!btn.disabled) btn.setAttribute('aria-checked', String(btn.getAttribute('aria-checked') !== 'true'));
      return;
    }

    switch (btn.getAttribute('data-ncc-action')) {
      case 'accept': save(all(true), null, 'accept'); hide(); break;
      case 'necessary': save(all(false), {}, 'necessary'); hide(); break;
      case 'save': save(readSwitches(), null, 'save'); hide(); break;
      case 'settings': view('settings'); panel.focus({ preventScroll: true }); break;
      case 'back': view('banner'); panel.focus({ preventScroll: true }); break;
    }
  });

  root.addEventListener('keydown', function (e) {
    if (e.key === 'Tab' && cfg.modal) {
      var items = [].slice.call(panel.querySelectorAll('button, a[href], summary, [tabindex]:not([tabindex="-1"])')).filter(function (el) {
        return !el.disabled && el.offsetParent !== null;
      });
      if (!items.length) return;
      var first = items[0];
      var last = items[items.length - 1];
      if (e.shiftKey && (document.activeElement === first || document.activeElement === panel)) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
      return;
    }
    if (e.key === 'Escape') {
      if (root.getAttribute('data-ncc-current') === 'settings' && !state) {
        view('banner');
        panel.focus({ preventScroll: true });
      } else if (state) {
        hide();
      }
    }
  });

  // A link with role="button" (insert tag {{cookie_consent::settings}}) also opens with the space bar, like a
  // button; without this the page would scroll instead.
  document.addEventListener('keydown', function (e) {
    if (e.key !== ' ' && e.key !== 'Spacebar') return;
    var opener = e.target.closest && e.target.closest('[data-ncc-open]');
    if (!opener || opener.tagName === 'BUTTON' || opener.getAttribute('role') !== 'button') return;
    e.preventDefault();
    api.open();
  });

  // Links and buttons anywhere on the page open the settings.
  document.addEventListener('click', function (e) {
    var opener = e.target.closest('[data-ncc-open]');
    if (opener) {
      e.preventDefault();
      api.open();
      return;
    }

    var load = e.target.closest('[data-ncc-embed-load], [data-ncc-embed-always]');
    if (!load) return;
    var box = load.closest('[data-ncc-embed]');
    if (!box) return;

    if (load.hasAttribute('data-ncc-embed-always')) {
      var svc = {};
      var key = box.getAttribute('data-ncc-service');
      if (state && state.svc) Object.keys(state.svc).forEach(function (k) { svc[k] = state.svc[k]; });
      svc[key] = true;
      save(state ? state.cats : all(false), svc, 'embed');
      if (!root.hidden) hide();
    } else {
      showEmbed(box);
    }
  });

  // Content added later (e.g. a video behind a preview image) is handled the same way.
  if ('MutationObserver' in window) {
    new MutationObserver(function (records) {
      records.forEach(function (r) {
        [].slice.call(r.addedNodes).forEach(function (n) {
          if (n.nodeType === 1 && (n.matches('[data-ncc-embed], script[data-ncc-category], link[data-ncc-href]') || n.querySelector('[data-ncc-embed], script[data-ncc-category], link[data-ncc-href]'))) {
            apply(n.parentNode || document);
          }
        });
      });
    }).observe(document.documentElement, { childList: true, subtree: true });
  }

  // ---- Start --------------------------------------------------------------

  syncReopen();

  apply();

  (api._q || []).forEach(function (cmd) { if (cmd === 'open') api.open(); });
  api._q = [];

  if (state || !CATS.length) {
    syncReopen();
    return;
  }

  if (cfg.show === 'scroll') {
    var shown = false;
    var reveal = function () {
      if (shown) return;
      shown = true;
      window.removeEventListener('scroll', onScroll);
      window.removeEventListener('wheel', onScroll);
      window.removeEventListener('touchmove', onScroll);
      window.removeEventListener('mousemove', onMouse);
      document.removeEventListener('keydown', onKey, true);
      document.removeEventListener('pointerdown', onPointer, true);
      show(false, false);
    };
    // First interaction: scrolling, a click or tap anywhere, a real mouse
    // movement (a few pixels, not a twitch while loading) or the Tab key. The
    // visitor first sees the page itself; nothing that needs consent runs before.
    var onScroll = function () { if ((window.scrollY || window.pageYOffset || 0) > 24) reveal(); };
    var onKey = function (e) { if (e.key === 'Tab') reveal(); };
    var onPointer = function () { reveal(); };
    var mx = null, my = null;
    var onMouse = function (e) {
      if (mx === null) { mx = e.clientX; my = e.clientY; return; }
      if (Math.abs(e.clientX - mx) + Math.abs(e.clientY - my) > 12) reveal();
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('wheel', onScroll, { passive: true });
    window.addEventListener('touchmove', onScroll, { passive: true });
    window.addEventListener('mousemove', onMouse, { passive: true });
    document.addEventListener('keydown', onKey, true);
    document.addEventListener('pointerdown', onPointer, true);
    // A page reloaded further down shows the banner at once.
    onScroll();
  } else {
    show(false, false);
  }
})();
