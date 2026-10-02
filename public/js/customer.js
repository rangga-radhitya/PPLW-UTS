document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-auto-submit]').forEach((el) => {
        el.addEventListener('change', () => el.form?.submit());
    });

    document.querySelectorAll('.quantity-control').forEach((control) => {
        const input = control.querySelector('input[type="number"]');
        control.querySelector('[data-minus]')?.addEventListener('click', () => {
            if (input) input.value = Math.max(1, parseInt(input.value || '1', 10) - 1);
        });
        control.querySelector('[data-plus]')?.addEventListener('click', () => {
            if (input) input.value = parseInt(input.value || '1', 10) + 1;
        });
    });
});
