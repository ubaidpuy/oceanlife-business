/*
Add these meta tags to your Blade layout head:
<meta name="algolia-app-id" content="{{ config('services.algolia.app_id') }}">
<meta name="algolia-search-key" content="{{ config('services.algolia.search_key') }}">
*/

const appId = document.querySelector('meta[name="algolia-app-id"]')?.content;
const searchKey = document.querySelector('meta[name="algolia-search-key"]')?.content;
const input = document.querySelector('#search-input');
const results = document.querySelector('#search-results');
const placeholderImage = '/images/placeholder.png';

if (window.algoliasearch && appId && searchKey && input && results) {
    const client = window.algoliasearch(appId, searchKey);
    const productIndex = client.initIndex('products');
    let timeoutId;

    input.addEventListener('input', () => {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(async () => {
            const query = input.value.trim();

            if (! query) {
                results.innerHTML = '';
                return;
            }

            const response = await productIndex.search(query);

            results.innerHTML = response.hits.map((hit) => `
                <article class="search-result">
                    <img src="${hit.image || placeholderImage}" alt="${hit.name || 'Product image'}">
                    <div>
                        <h3>${hit.name || ''}</h3>
                        <p>${hit.price ? `$${Number(hit.price).toFixed(2)}` : ''}</p>
                    </div>
                </article>
            `).join('');
        }, 300);
    });
}
