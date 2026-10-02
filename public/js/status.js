(() => {
    if (!window.BowlMateOrderId) return;
    const statusText = document.getElementById('status-text');
    const poll = () => {
        fetch(`/pesanan/${window.BowlMateOrderId}/status`, {headers: {'Accept': 'application/json'}})
            .then((res) => res.ok ? res.json() : null)
            .then((data) => {
                if (!data) return;
                if (statusText && data.status) statusText.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
            })
            .catch(() => {});
    };
    poll();
    setInterval(poll, 5000);
})();
