// ===== Polling status pesanan (customer) =====
// Dipakai di customer/status.blade.php. Meminta GET /pesanan/{id}/status tiap 5 detik.
// Respons JSON yang diharapkan: { "status": "processing", "payment_status": "pending" }
(function () {
  const box = document.getElementById('order-tracker');
  if (!box) return;

  const STEPS = ['pending', 'confirmed', 'processing', 'ready', 'done'];
  const LABEL = {
    pending: 'Menunggu konfirmasi', confirmed: 'Dikonfirmasi', processing: 'Sedang dibuat',
    ready: 'Siap diantar', done: 'Selesai',
  };
  const PAY_LABEL = { pending: 'Belum dibayar', paid: 'Lunas' };
  const url = box.dataset.url;
  let timer;

  function render(status, payStatus) {
    const idx = STEPS.indexOf(status);
    if (idx < 0) return;

    const text = document.getElementById('status-text');
    if (text) text.textContent = LABEL[status];

    const badge = document.getElementById('status-badge');
    if (badge) {
      badge.textContent = LABEL[status];
      badge.className = 'bm-badge bm-status-' + status;
    }

    box.querySelectorAll('li[data-step]').forEach((li, i) => {
      li.classList.toggle('is-done', i < idx || status === 'done');
      li.classList.toggle('is-current', i === idx && status !== 'done');
    });

    const pay = document.getElementById('payment-badge');
    if (pay && payStatus) {
      pay.textContent = PAY_LABEL[payStatus] || payStatus;
      pay.className = 'bm-badge bm-pay-' + payStatus;
    }

    if (status === 'done') clearInterval(timer);
  }

  function poll() {
    fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
      .then(res => res.ok ? res.json() : Promise.reject(res.status))
      .then(data => render(data.status, data.payment_status))
      .catch(() => { /* koneksi putus sebentar: coba lagi di putaran berikutnya */ });
  }

  render(box.dataset.status, null);
  timer = setInterval(poll, 5000);
})();
