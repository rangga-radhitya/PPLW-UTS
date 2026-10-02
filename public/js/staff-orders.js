// ===== Polling daftar pesanan (staff) =====
// Mengambil ulang halaman daftar pesanan tiap 5 detik lalu mengganti isi #orders-live.
// Cara ini tidak bergantung pada bentuk JSON dari /staff/pesanan/data, jadi aman
// walaupun format JSON dari Back End berubah.
(function () {
  const box = document.getElementById('orders-live');
  if (!box) return;
  const url = box.dataset.url || window.location.href;

  setInterval(() => {
    // Jangan menimpa tampilan kalau staff sedang menekan tombol / form aktif
    if (box.contains(document.activeElement) && document.activeElement.tagName !== 'BODY') return;

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
      .then(res => res.ok ? res.text() : Promise.reject(res.status))
      .then(html => {
        const doc = new DOMParser().parseFromString(html, 'text/html');
        const fresh = doc.getElementById('orders-live');
        if (fresh) box.innerHTML = fresh.innerHTML;
      })
      .catch(() => {});
  }, 5000);
})();
