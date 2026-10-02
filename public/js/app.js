// ===== BowlMate - JS umum =====
document.addEventListener('DOMContentLoaded', () => {
  // 1. Konfirmasi sebelum submit form yang punya data-confirm (hapus data, dll)
  document.querySelectorAll('form[data-confirm]').forEach(form => {
    form.addEventListener('submit', e => {
      if (!confirm(form.dataset.confirm)) e.preventDefault();
    });
  });

  // 2. Tombol tambah/kurang jumlah: <div class="qty" data-qty> ... <button data-step="-1"> ... <input>
  document.querySelectorAll('[data-qty]').forEach(box => {
    const input = box.querySelector('input');
    const min = parseInt(input.min || '1', 10);
    const max = parseInt(input.max || '99', 10);
    box.querySelectorAll('[data-step]').forEach(btn => {
      btn.addEventListener('click', () => {
        const next = Math.min(max, Math.max(min, (parseInt(input.value, 10) || min) + parseInt(btn.dataset.step, 10)));
        if (next === parseInt(input.value, 10)) return;
        input.value = next;
        // Di halaman keranjang, form langsung dikirim supaya jumlah tersimpan
        if (box.dataset.autosubmit !== undefined) box.closest('form').submit();
      });
    });
  });

  // 3. Pencarian menu: kirim otomatis setelah berhenti mengetik 600 ms
  const search = document.querySelector('[data-autosearch]');
  if (search) {
    let t;
    search.addEventListener('input', () => {
      clearTimeout(t);
      t = setTimeout(() => search.form.submit(), 600);
    });
  }

  // 4. Hint metode pembayaran di halaman checkout
  document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('[data-pay-hint]').forEach(h => {
        h.classList.toggle('d-none', h.dataset.payHint !== radio.value);
      });
    });
  });
});
