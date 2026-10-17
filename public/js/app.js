// Fabara Académie — petits comportements, sans dépendance externe.
document.addEventListener('submit', (e) => {
  const msg = e.target.dataset.confirm;
  if (msg && !window.confirm(msg)) e.preventDefault();
});
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('[data-copy]');
  if (!btn) return;
  const el = document.getElementById(btn.dataset.copy);
  try { await navigator.clipboard.writeText(el.value || el.textContent); btn.textContent = 'Copié ✓'; }
  catch { el.select && el.select(); }
});
