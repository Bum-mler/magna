document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = '/naturstein/lexikon/mlstonelexicon/api/calculate-chash';
    const debugMode = true; // Debugging aktivieren/deaktivieren
    const debug = (msg, data) => {
        if (debugMode) console.log(`[DEBUG] ${msg}`, data);
    };

    debug('DOMContentLoaded event fired');

    const colorButtons = document.querySelectorAll('.filter-button');
    const originSelect = document.getElementById('searchOrigin');
    const resetFilterButton = document.getElementById('resetFilterButton');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Farbfilter-Buttons
    if (colorButtons) {
        colorButtons.forEach(button => {
            button.addEventListener('click', () => {
                const color = button.getAttribute('data-color');
                if (color) performAjaxSearch({ searchColor: color });
            });
        });
    }

    // Abbauort-Dropdown
    if (originSelect) {
        originSelect.addEventListener('change', () => {
            const origin = originSelect.value || '';
            performAjaxSearch({ searchOrigin: origin });
        });
    }

    // Filter zurücksetzen
    if (resetFilterButton) {
        resetFilterButton.addEventListener('click', (event) => {
            event.preventDefault();
            const resetUrl = resetFilterButton.getAttribute('href');
            debug('Reset URL', resetUrl);
            if (loadingSpinner) loadingSpinner.style.display = 'block';
            window.location.href = resetUrl;
        });
    }

    // AJAX-Suche
    async function performAjaxSearch(params = {}) {
        const url = new URL(window.location.href);
        const searchParams = new URLSearchParams(url.search);

        Object.keys(params).forEach(key => {
            if (params[key] === '') {
                searchParams.delete(`tx_mlstonelexicon_lexicon[${key}]`);
            } else {
                searchParams.set(`tx_mlstonelexicon_lexicon[${key}]`, params[key]);
            }
        });

        debug('Params before sending', Object.fromEntries(searchParams));

        try {
            const cHash = await calculateCHash(Object.fromEntries(searchParams));
            if (!cHash) throw new Error('Invalid cHash');
            searchParams.set('cHash', cHash);
        } catch (error) {
            console.error('cHash calculation error:', error.message);
            return;
        }

        const requestUrl = `${url.pathname}?${searchParams.toString()}`;
        debug('Generated Request URL', requestUrl);

        if (loadingSpinner) loadingSpinner.style.display = 'block';

        try {
            const response = await fetch(requestUrl, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.text();
            updateStoneList(data);
        } catch (error) {
            console.error('AJAX Request Error:', error.message);
        } finally {
            if (loadingSpinner) loadingSpinner.style.display = 'none';
        }
    }

    // Aktualisiere die Steinauswahl
    function updateStoneList(html) {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newStoneContainer = doc.querySelector('.card-menu');
        const stoneContainer = document.querySelector('.card-menu');

        if (newStoneContainer && stoneContainer) {
            stoneContainer.innerHTML = newStoneContainer.innerHTML;
        } else {
            console.error('Failed to update stone list: Container not found.');
        }
    }

    // Berechnung des cHash
    async function calculateCHash(params) {
        try {
            const response = await fetch(`${apiUrl}?parameters=${encodeURIComponent(JSON.stringify(params))}`, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            return data.cHash;
        } catch (error) {
            console.error('cHash calculation error:', error.message);
            return null;
        }
    }
});
