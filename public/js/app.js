// ===== BowlMate - interaksi UI =====
// Semua handler memakai event delegation supaya tetap jalan setelah bagian halaman diganti (live swap).
(() => {
  const $ = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const sleep = ms => new Promise(r => setTimeout(r, ms));
  const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Toast ---------- */
  window.bmToast = (msg, type = 'success') => {
    const stack = $('#toasts');
    if (!stack || !msg) return;
    const el = document.createElement('div');
    el.className = 'bm-toast bm-toast--' + type;
    el.innerHTML = '<i class="bi ' + (type === 'error' ? 'bi-exclamation-circle-fill' : 'bi-check-circle-fill') + '"></i><span></span>';
    el.lastChild.textContent = msg;
    stack.appendChild(el);
    requestAnimationFrame(() => el.classList.add('show'));
    setTimeout(() => { el.classList.remove('show'); setTimeout(() => el.remove(), 300); }, 2600);
  };

  /* ---------- State loading pada tombol ---------- */
  function setLoading(btn, on) {
    if (!btn || !btn.classList) return;
    btn.classList.toggle('is-loading', on);
    if (on) { btn.dataset.wasDisabled = btn.disabled ? '1' : ''; setTimeout(() => { if (btn.classList.contains('is-loading')) btn.disabled = true; }, 0); }
    else { btn.disabled = btn.dataset.wasDisabled === '1'; }
  }
  window.addEventListener('pageshow', () => $$('.is-loading').forEach(b => setLoading(b, false)));

  /* ---------- Modal konfirmasi (menggantikan confirm() bawaan browser) ---------- */
  const modalEl = $('#bmConfirm');
  const modal = modalEl && window.bootstrap ? bootstrap.Modal.getOrCreateInstance(modalEl) : null;
  let pendingForm = null;
  function openConfirm(form) {
    if (!modal) { if (confirm(form.dataset.confirm)) { form.dataset.confirmed = '1'; form.requestSubmit(); } return; }
    pendingForm = form;
    const danger = form.hasAttribute('data-confirm-danger');
    $('#bmConfirmTitle').textContent = form.dataset.confirmTitle || 'Konfirmasi';
    $('#bmConfirmText').textContent = form.dataset.confirm;
    const ok = $('#bmConfirmOk');
    ok.textContent = form.dataset.confirmOk || 'Ya, lanjutkan';
    ok.className = 'btn ' + (danger ? 'btn-danger' : 'btn-primary');
    modalEl.classList.toggle('bm-modal--danger', danger);
    $('#bmConfirmIcon').innerHTML = '<i class="bi ' + (danger ? 'bi-trash3' : 'bi-question-lg') + '"></i>';
    modal.show();
  }
  $('#bmConfirmOk')?.addEventListener('click', () => {
    if (!pendingForm) return;
    const f = pendingForm; pendingForm = null;
    modal.hide();
    f.dataset.confirmed = '1';
    f.requestSubmit();
  });

  /* ---------- Live swap: ganti bagian halaman tanpa reload ---------- */
  const parse = html => new DOMParser().parseFromString(html, 'text/html');
  async function liveFetch(url, opts = {}) {
    const res = await fetch(url, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }, ...opts });
    return { res, doc: parse(await res.text()) };
  }
  function swapSlots(doc) {
    const seen = {};
    $$('[data-live-slot]').forEach(old => {
      const name = old.dataset.liveSlot;
      const i = seen[name] = (seen[name] ?? -1) + 1;
      const fresh = doc.querySelectorAll('[data-live-slot="' + name + '"]')[i];
      if (!fresh || old.innerHTML.trim() === fresh.innerHTML.trim()) return;
      const wasEmpty = old.innerHTML.trim() === '';
      old.innerHTML = fresh.innerHTML;
      if (wasEmpty && !reduceMotion) old.firstElementChild?.classList.add('anim-in');
      if (old.hasAttribute('data-live-bump')) { old.classList.remove('bump'); void old.offsetWidth; old.classList.add('bump'); }
      if (old.hasAttribute('data-live-tick')) { old.classList.remove('tick'); void old.offsetWidth; old.classList.add('tick'); }
    });
  }
  async function liveNavigate(url, push = true) {
    $$('[data-live-slot="menu-list"]').forEach(s => s.classList.add('is-busy'));
    try {
      const { doc } = await liveFetch(url);
      swapSlots(doc);
      if (doc.title) document.title = doc.title;
      if (push) history.pushState({ live: 1 }, '', url);
    } catch { location.href = url; }
    $$('.is-busy').forEach(s => s.classList.remove('is-busy'));
  }
  window.addEventListener('popstate', () => { if (document.querySelector('[data-live-slot="menu-list"]')) liveNavigate(location.href, false); });

  document.addEventListener('click', e => {
    const a = e.target.closest('a[data-live-link]');
    if (a && !e.metaKey && !e.ctrlKey) { e.preventDefault(); liveNavigate(a.href); }
  });

  /* ---------- Submit form: konfirmasi, live update, state loading ---------- */
  document.addEventListener('submit', async e => {
    const form = e.target.closest('form');
    if (!form || e.defaultPrevented) return;

    if (form.dataset.confirm && form.dataset.confirmed !== '1') { e.preventDefault(); openConfirm(form); return; }
    delete form.dataset.confirmed;

    if (form.hasAttribute('data-live-form')) {            // filter/pencarian (GET) tanpa reload
      e.preventDefault();
      const url = form.action + '?' + new URLSearchParams(new FormData(form)).toString();
      liveNavigate(url);
      return;
    }

    if (form.hasAttribute('data-live')) {                  // aksi keranjang tanpa reload
      e.preventDefault();
      const btn = e.submitter || form.querySelector('button:not([type=button])');
      const row = form.dataset.liveRemove ? form.closest(form.dataset.liveRemove) : null;
      setLoading(btn, true);
      if (row && !reduceMotion) { row.classList.add('is-removing'); await sleep(240); }
      let result;
      try {
        result = await liveFetch(form.action, { method: 'POST', body: new FormData(form) });
      } catch { row?.classList.remove('is-removing'); setLoading(btn, false); bmToast('Koneksi bermasalah. Coba lagi.', 'error'); return; }
      const { res, doc } = result;
      if (new URL(res.url).pathname !== location.pathname) { location.href = res.url; return; }   // diarahkan ke halaman lain: ikuti
      if (!res.ok) { row?.classList.remove('is-removing'); setLoading(btn, false); bmToast('Aksi gagal. Coba lagi.', 'error'); return; }
      swapSlots(doc);
      const err = doc.querySelector('.alert-danger');
      if (err) bmToast(err.textContent.trim().split('\n')[0], 'error');
      else bmToast(form.dataset.liveToast || 'Berhasil');
      setLoading(btn, false);
      return;
    }

    setLoading(e.submitter || form.querySelector('button:not([type=button])'), true);   // submit biasa
  });

  /* ---------- Stepper jumlah ---------- */
  document.addEventListener('click', e => {
    const b = e.target.closest('[data-qty] [data-step]');
    if (!b) return;
    const box = b.closest('[data-qty]');
    const input = $('input', box);
    const min = parseInt(input.min || '1', 10), max = parseInt(input.max || '99', 10);
    const cur = parseInt(input.value, 10) || min;
    const next = Math.min(max, Math.max(min, cur + parseInt(b.dataset.step, 10)));
    if (next === cur) return;
    input.value = next;
    input.dispatchEvent(new Event('change', { bubbles: true }));
    if (box.hasAttribute('data-autosubmit')) {
      clearTimeout(box._t);
      box._t = setTimeout(() => box.closest('form').requestSubmit(), 280);
    }
  });

  /* ---------- Total harga di detail menu ---------- */
  document.addEventListener('change', e => {
    const form = e.target.closest('form[data-price]');
    if (!form || e.target.name !== 'quantity') return;
    const total = $('[data-total]', form);
    if (!total) return;
    const val = (parseInt(form.dataset.price, 10) || 0) * (parseInt(e.target.value, 10) || 1);
    total.textContent = 'Rp' + val.toLocaleString('id-ID');
    total.classList.remove('tick'); void total.offsetWidth; total.classList.add('tick');
  });

  /* ---------- Pencarian menu (debounce) ---------- */
  document.addEventListener('input', e => {
    if (!e.target.matches('[data-autosearch]')) return;
    clearTimeout(e.target._t);
    e.target._t = setTimeout(() => e.target.form.requestSubmit(), 450);
  });

  /* ---------- Pilihan cara bayar ---------- */
  document.addEventListener('change', e => {
    if (e.target.name !== 'payment_method') return;
    $$('[data-pay-hint]').forEach(h => h.classList.toggle('d-none', h.dataset.payHint !== e.target.value));
    $$('[data-pay-label]').forEach(l => { l.textContent = e.target.dataset.label || e.target.value; });
  });

  /* ---------- Tampilkan/sembunyikan kata sandi ---------- */
  document.addEventListener('click', e => {
    const t = e.target.closest('[data-toggle-password]');
    if (!t) return;
    const input = t.parentElement.querySelector('input');
    const show = input.type === 'password';
    input.type = show ? 'text' : 'password';
    t.innerHTML = '<i class="bi ' + (show ? 'bi-eye-slash' : 'bi-eye') + '"></i>';
  });

  /* ---------- Salin teks (nominal pembayaran) ---------- */
  document.addEventListener('click', async e => {
    const b = e.target.closest('[data-copy]');
    if (!b) return;
    try { await navigator.clipboard.writeText(b.dataset.copy); bmToast('Nominal disalin'); }
    catch { bmToast('Tidak bisa menyalin otomatis', 'error'); }
  });

  /* ---------- Filter chip riwayat & tab pesanan staff (tanpa reload) ---------- */
  function applyFilter(group, value) {
    $$('[data-filter-item]', group.closest('[data-filter-scope]') || document).forEach(it => {
      const vals = (it.dataset.filterItem || '').split(',');
      it.classList.toggle('d-none', !(value === 'all' || vals.includes(value)));
    });
  }
  document.addEventListener('click', e => {
    const chip = e.target.closest('[data-filter]');
    if (!chip) return;
    const group = chip.closest('[data-filter-group]');
    $$('[data-filter]', group).forEach(c => c.classList.toggle('active', c === chip));
    window.bmFilterValue = chip.dataset.filter;
    applyFilter(group, chip.dataset.filter);
  });
  window.bmReapplyFilter = () => {
    const group = $('[data-filter-group]');
    if (!group || !window.bmFilterValue) return;
    $$('[data-filter]', group).forEach(c => c.classList.toggle('active', c.dataset.filter === window.bmFilterValue));
    applyFilter(group, window.bmFilterValue);
  };

  /* ---------- Pratinjau foto profil (maks 2 MB) ---------- */
  document.addEventListener('change', e => {
    if (!e.target.matches('[data-avatar-input]')) return;
    const box = $('[data-avatar-preview]'); const file = e.target.files[0];
    if (!box || !file) return;
    if (file.size > 2 * 1024 * 1024) { bmToast('Ukuran foto maksimal 2 MB.', 'error'); e.target.value = ''; return; }
    const size = box.dataset.size || 88;
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file); img.alt = 'Pratinjau foto'; img.className = 'avatar';
    img.style.cssText = 'width:' + size + 'px;height:' + size + 'px';
    box.replaceChildren(img);
  });

  /* ---------- Jam WIB di topbar staff ---------- */
  const clock = $('#wib-clock');
  if (clock) {
    const fmt = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jakarta', weekday: 'long', day: 'numeric', month: 'short', hour: '2-digit', minute: '2-digit', hour12: false });
    const tick = () => { clock.textContent = fmt.format(new Date()).replace(/\./g, ':') + ' WIB'; };
    tick(); setInterval(tick, 30000);
  }

  /* ---------- Alert flash: hilang otomatis ---------- */
  $$('.alert-success.alert-dismissible').forEach(a => setTimeout(() => { if (window.bootstrap) bootstrap.Alert.getOrCreateInstance(a).close(); }, 4500));

  /* ---------- Efek kilau saat tombol utama ditekan ---------- */
  document.addEventListener('pointerdown', e => {
    const b = e.target.closest('.btn-primary, .btn-add, .cart-bar__go');
    if (!b || reduceMotion) return;
    const r = b.getBoundingClientRect();
    const dot = document.createElement('span');
    dot.className = 'ripple';
    dot.style.left = (e.clientX - r.left) + 'px'; dot.style.top = (e.clientY - r.top) + 'px';
    b.appendChild(dot);
    setTimeout(() => dot.remove(), 600);
  });
})();
