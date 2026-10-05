// ===== Polling daftar pesanan (staff) =====
// Mengambil ulang halaman tiap 5 detik lalu mengganti isi #orders-live (tidak bergantung pada format JSON BE).
(function () {
  const box = document.getElementById('orders-live');
  if (!box) return;
  const url = box.dataset.url || window.location.href;

  setInterval(() => {
    if (document.hidden) return;
    if (box.contains(document.activeElement) && document.activeElement.tagName === 'BUTTON') return;
    if (document.querySelector('#bmConfirm.show')) return;   // jangan ganti saat modal terbuka

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
      .then(res => res.ok ? res.text() : Promise.reject(res.status))
      .then(html => {
        const fresh = new DOMParser().parseFromString(html, 'text/html').getElementById('orders-live');
        if (!fresh || fresh.innerHTML.trim() === box.innerHTML.trim()) return;
        box.innerHTML = fresh.innerHTML;
        if (window.bmReapplyFilter) window.bmReapplyFilter();
      })
      .catch(() => {});
  }, 5000);
})();
