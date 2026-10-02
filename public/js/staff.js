function confirmDelete(label = 'data ini') {
    return window.confirm(`Yakin ingin menghapus ${label}?`);
}

(() => {
    const url = window.staffOrderPollingUrl;
    if (!url) return;
    const refresh = () => {
        fetch(url, {headers: {'Accept': 'application/json'}})
            .then((res) => res.ok ? res.json() : null)
            .then((data) => {
                const count = Array.isArray(data) ? data.length : (Array.isArray(data?.orders) ? data.orders.length : null);
                if (count !== null) document.title = `Pesanan (${count}) - BowlMate Staff`;
            })
            .catch(() => {});
    };
    refresh();
    setInterval(refresh, 5000);
})();
