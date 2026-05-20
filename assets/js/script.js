document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.querySelector('.menu-btn');
    const nav = document.querySelector('.nav');
    if (menuBtn && nav) menuBtn.addEventListener('click', () => nav.classList.toggle('open'));

    const reveals = document.querySelectorAll('.reveal');
    const reveal = () => reveals.forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 80) el.classList.add('active');
    });
    window.addEventListener('scroll', reveal);
    reveal();

    document.querySelectorAll('input[name="payment"]').forEach(radio => {
        radio.addEventListener('change', () => {
            document.querySelectorAll('[data-payment-box]').forEach(box => box.classList.add('hidden'));
            const target = document.querySelector(`[data-payment-box="${radio.value}"]`);
            if (target) target.classList.remove('hidden');
        });
    });

    // Barra de pesquisa estilo Google com sugestões automáticas.
    document.querySelectorAll('[data-suggest="true"]').forEach(input => {
        const box = document.querySelector(`[data-suggestions-for="${input.id}"]`);
        if (!box) return;
        let controller;
        input.addEventListener('input', async () => {
            const value = input.value.trim();
            box.innerHTML = '';
            box.style.display = 'none';
            if (value.length < 1) return;
            if (controller) controller.abort();
            controller = new AbortController();
            try {
                const response = await fetch(`sugestoes.php?q=${encodeURIComponent(value)}`, { signal: controller.signal });
                const suggestions = await response.json();
                if (!suggestions.length) return;
                suggestions.forEach(text => {
                    const item = document.createElement('div');
                    item.className = 'suggestion-item';
                    item.textContent = text;
                    item.addEventListener('click', () => {
                        input.value = text;
                        box.style.display = 'none';
                        input.closest('form')?.submit();
                    });
                    box.appendChild(item);
                });
                box.style.display = 'block';
            } catch (err) {}
        });
        document.addEventListener('click', e => {
            if (!box.contains(e.target) && e.target !== input) box.style.display = 'none';
        });
    });
});
