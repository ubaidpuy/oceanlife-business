const debounceDelay = 400;
const minimumQueryLength = 3;

const resultLink = (hit, kind, baseUrl) => {
    const link = document.createElement('a');
    link.href = `${baseUrl}/${encodeURIComponent(hit.slug)}`;
    link.setAttribute('role', 'option');
    link.className = 'flex items-center gap-3 rounded-xl px-3 py-2 transition hover:bg-ocean-primary/10 dark:hover:bg-gray-700';

    const image = document.createElement('img');
    image.src = hit.image || '/favicon.ico';
    image.alt = '';
    image.className = 'h-11 w-11 shrink-0 rounded-lg object-cover bg-gray-100';
    image.addEventListener('error', () => { image.src = '/favicon.ico'; }, { once: true });

    const content = document.createElement('div');
    content.className = 'min-w-0';

    const name = document.createElement('p');
    name.className = 'truncate text-sm font-semibold text-gray-900 dark:text-white';
    name.textContent = hit.name || '';
    content.append(name);

    if (kind === 'product') {
        const detail = document.createElement('p');
        detail.className = 'truncate text-xs text-gray-500 dark:text-gray-400';
        const price = hit.discount_price ?? hit.price;
        detail.textContent = [hit.category_name, price != null ? `PKR ${Number(price).toLocaleString()}` : null]
            .filter(Boolean)
            .join(' · ');
        content.append(detail);
    }

    link.append(image, content);
    return link;
};

const addSection = (container, title, hits, kind, baseUrl) => {
    if (!hits.length) return;

    const section = document.createElement('section');
    const heading = document.createElement('p');
    heading.className = 'px-3 pb-1 pt-2 text-xs font-bold uppercase tracking-wider text-ocean-primary';
    heading.textContent = title;
    section.append(heading, ...hits.map((hit) => resultLink(hit, kind, baseUrl)));
    container.append(section);
};

document.querySelectorAll('[data-unified-search]').forEach((form) => {
    const input = form.querySelector('input[type="search"]');
    const results = form.querySelector('[data-search-results]');
    let timeoutId;
    let controller;

    // Keep the panel outside the blurred/sticky header so mobile browsers use
    // the real viewport as its positioning context.
    document.body.append(results);

    const positionResults = () => {
        const inputRect = input.getBoundingClientRect();
        const gutter = 16;
        const isDesktop = window.matchMedia('(min-width: 1024px)').matches;
        const width = isDesktop
            ? Math.min(384, window.innerWidth - (gutter * 2))
            : Math.min(576, window.innerWidth - (gutter * 2));
        const left = isDesktop
            ? Math.max(gutter, Math.min(inputRect.right - width, window.innerWidth - width - gutter))
            : Math.max(gutter, (window.innerWidth - width) / 2);

        results.style.width = `${width}px`;
        results.style.left = `${left}px`;
        results.style.top = `${inputRect.bottom + 8}px`;
    };

    const close = () => {
        results.classList.add('hidden');
        input.setAttribute('aria-expanded', 'false');
    };

    const open = () => {
        positionResults();
        results.classList.remove('hidden');
        input.setAttribute('aria-expanded', 'true');
    };

    input.addEventListener('input', () => {
        clearTimeout(timeoutId);
        controller?.abort();

        const query = input.value.trim();
        if (query.length < minimumQueryLength) {
            results.replaceChildren();
            close();
            return;
        }

        timeoutId = setTimeout(async () => {
            controller = new AbortController();
            results.innerHTML = '<p class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Searching…</p>';
            open();

            try {
                const url = new URL(form.dataset.searchUrl, window.location.origin);
                url.searchParams.set('q', query);
                url.searchParams.set('per_page', '8');

                const response = await fetch(url, {
                    headers: { Accept: 'application/json' },
                    signal: controller.signal,
                });
                if (!response.ok) throw new Error('Search request failed');

                const data = await response.json();
                results.replaceChildren();
                addSection(results, 'Categories', data.categories || [], 'category', form.dataset.categoriesUrl);
                addSection(results, 'Products', data.products || [], 'product', form.dataset.productsUrl);

                if (!results.childElementCount) {
                    results.innerHTML = '<p class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No matching categories or products.</p>';
                }
            } catch (error) {
                if (error.name === 'AbortError') return;
                results.innerHTML = '<p class="px-3 py-4 text-center text-sm text-red-600">Search is temporarily unavailable.</p>';
            }
        }, debounceDelay);
    });

    input.addEventListener('focus', () => {
        if (results.childElementCount && input.value.trim().length >= minimumQueryLength) open();
    });

    form.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });

    document.addEventListener('click', (event) => {
        if (!form.contains(event.target) && !results.contains(event.target)) close();
    });

    window.addEventListener('resize', () => {
        if (!results.classList.contains('hidden')) positionResults();
    });

    window.addEventListener('scroll', close, { passive: true });
});
