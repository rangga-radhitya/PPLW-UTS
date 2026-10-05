{{-- Toast + modal konfirmasi global (dipakai semua layout). Dikendalikan oleh public/js/app.js --}}
<div id="toasts" class="toast-stack" aria-live="polite" aria-atomic="true"></div>

<div class="modal fade" id="bmConfirm" tabindex="-1" aria-labelledby="bmConfirmTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bm-modal">
      <div class="bm-modal__icon" id="bmConfirmIcon"><i class="bi bi-question-lg"></i></div>
      <h2 class="bm-modal__title" id="bmConfirmTitle">Konfirmasi</h2>
      <p class="bm-modal__text" id="bmConfirmText"></p>
      <div class="bm-modal__actions">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="bmConfirmOk">Ya, lanjutkan</button>
      </div>
    </div>
  </div>
</div>
