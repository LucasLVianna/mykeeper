(function () {
    const ROOT = '/mykeeper-main';
    const PRODUCT_ENDPOINT = ROOT + '/src/Controllers/produto_get.php';
    const PRODUCT_CREATE_ENDPOINT = ROOT + '/src/Controllers/produto_novo_back.php';
    const PRODUCT_UPDATE_ENDPOINT = ROOT + '/src/Controllers/produto_alterar_back.php';
    const PRODUCT_DELETE_ENDPOINT = ROOT + '/src/Controllers/produto_excluir.php';

    const STORAGE_KEYS = {
        meta: 'mykeeper-product-meta',
        shopping: 'mykeeper-shopping-list',
        history: 'mykeeper-history-list',
    };

    const CATEGORY_LABELS = {
        laticinios: 'Laticinios',
        carnes: 'Carnes',
        frutas: 'Frutas',
        verduras: 'Verduras',
        bebidas: 'Bebidas',
        congelados: 'Congelados',
        condimentos: 'Condimentos',
        outros: 'Outros',
    };

    function safeParse(json, fallback) {
        try {
            return JSON.parse(json);
        } catch (error) {
            return fallback;
        }
    }

    function loadStorage(key, fallback) {
        return safeParse(localStorage.getItem(key), fallback);
    }

    function saveStorage(key, value) {
        localStorage.setItem(key, JSON.stringify(value));
    }

    function normalizeText(value) {
        return String(value || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim()
            .toLowerCase();
    }

    function inferCategoryKey(rawValue) {
        const normalized = normalizeText(rawValue);
        if (normalized.includes('latic')) return 'laticinios';
        if (normalized.includes('carn')) return 'carnes';
        if (normalized.includes('frut')) return 'frutas';
        if (normalized.includes('verd') || normalized.includes('leg')) return 'verduras';
        if (normalized.includes('beb')) return 'bebidas';
        if (normalized.includes('congel')) return 'congelados';
        if (normalized.includes('cond')) return 'condimentos';
        return 'outros';
    }

    function formatCategoryLabel(key, fallback) {
        return CATEGORY_LABELS[key] || fallback || CATEGORY_LABELS.outros;
    }

    function todayAtStart() {
        const today = new Date();
        return new Date(today.getFullYear(), today.getMonth(), today.getDate());
    }

    function parseDate(dateString) {
        if (!dateString) {
            return null;
        }

        const parts = String(dateString).split('-');
        if (parts.length !== 3) {
            return null;
        }

        return new Date(Number(parts[0]), Number(parts[1]) - 1, Number(parts[2]));
    }

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }

    function formatDateBr(dateString) {
        const date = parseDate(dateString);
        if (!date) {
            return '--/--/----';
        }

        return String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + date.getFullYear();
    }

    function addDays(date, amount) {
        const next = new Date(date);
        next.setDate(next.getDate() + amount);
        return next;
    }

    function differenceInDays(targetDateString) {
        const targetDate = parseDate(targetDateString);
        if (!targetDate) {
            return 999;
        }

        const diffInMs = targetDate.getTime() - todayAtStart().getTime();
        return Math.round(diffInMs / 86400000);
    }

    function calculateStatus(expirationDate, quantity) {
        if (Number(quantity) <= 0) {
            return 'finished';
        }

        const diff = differenceInDays(expirationDate);
        if (diff < 0) {
            return 'expired';
        }

        if (diff <= 7) {
            return 'expiring';
        }

        return 'normal';
    }

    function defaultMetaForItem(item, index) {
        const seed = Number(item.id || index + 1);
        const pattern = [14, 6, 2, -1, 18, 4, 9, -3];
        const today = todayAtStart();
        const expiresIn = typeof item.previsao_vencimento !== 'undefined'
            ? Number(item.previsao_vencimento)
            : pattern[index % pattern.length] + (seed % 2);

        let expirationDate = formatDate(addDays(today, expiresIn));
        if (String(item.expirado) === '1' || item.expirado === true) {
            expirationDate = formatDate(addDays(today, -2));
        }

        return {
            expirationDate: expirationDate,
            quantity: Number(item.quantidade || ((seed % 4) + 1)),
            categoryKey: inferCategoryKey(item.categoria_produto),
        };
    }

    function escapeHtml(value) {
        return String(value)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function getProductMetaMap() {
        return loadStorage(STORAGE_KEYS.meta, {});
    }

    function saveProductMetaMap(map) {
        saveStorage(STORAGE_KEYS.meta, map);
    }

    function setProductMeta(id, meta) {
        const map = getProductMetaMap();
        map[String(id)] = meta;
        saveProductMetaMap(map);
    }

    function removeProductMeta(id) {
        const map = getProductMetaMap();
        delete map[String(id)];
        saveProductMetaMap(map);
    }

    function getShoppingItems() {
        return loadStorage(STORAGE_KEYS.shopping, []);
    }

    function saveShoppingItems(items) {
        saveStorage(STORAGE_KEYS.shopping, items);
    }

    function getHistoryItems() {
        return loadStorage(STORAGE_KEYS.history, []);
    }

    function saveHistoryItems(items) {
        saveStorage(STORAGE_KEYS.history, items);
    }

    function generateId(prefix) {
        return prefix + '-' + Math.random().toString(36).slice(2, 10) + Date.now().toString(36);
    }

    async function fetchProducts() {
        const response = await fetch(PRODUCT_ENDPOINT);
        const result = await response.json();
        if (result.status !== 'ok' || !Array.isArray(result.data)) {
            return [];
        }

        const metaMap = getProductMetaMap();
        let changed = false;

        const items = result.data.map((item, index) => {
            const id = String(item.id);
            const meta = metaMap[id] || defaultMetaForItem(item, index);
            if (!metaMap[id]) {
                metaMap[id] = meta;
                changed = true;
            }

            const categoryKey = meta.categoryKey || inferCategoryKey(item.categoria_produto);
            const quantity = Number(meta.quantity || 1);
            const expirationDate = meta.expirationDate;

            return {
                id: id,
                nome_produto: item.nome_produto || '',
                categoria_produto: item.categoria_produto || formatCategoryLabel(categoryKey),
                und_medida_produto: item.und_medida_produto || 'Unidade',
                expirationDate: expirationDate,
                quantity: quantity,
                categoryKey: categoryKey,
                status: calculateStatus(expirationDate, quantity),
            };
        });

        if (changed) {
            saveProductMetaMap(metaMap);
        }

        return items;
    }

    function buildExpirationMarkup(expirationDate) {
        const diff = differenceInDays(expirationDate);
        const formatted = formatDateBr(expirationDate);

        if (diff < 0) {
            const amount = Math.abs(diff);
            return {
                className: 'expiration-chip is-danger',
                text: 'Venceu ' + amount + (amount === 1 ? ' dia atras' : ' dias atras'),
                date: '(' + formatted + ')',
                icon: '<circle cx="12" cy="12" r="8"></circle><path d="M9 9l6 6"></path><path d="M15 9l-6 6"></path>',
            };
        }

        if (diff === 0) {
            return {
                className: 'expiration-chip is-danger',
                text: 'Vence hoje!',
                date: '(' + formatted + ')',
                icon: '<path d="M12 9v4"></path><path d="M12 17h.01"></path><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>',
            };
        }

        if (diff <= 7) {
            return {
                className: 'expiration-chip is-warning',
                text: diff + (diff === 1 ? ' dia restante' : ' dias restantes'),
                date: '(' + formatted + ')',
                icon: '<circle cx="12" cy="12" r="8"></circle><path d="M12 8v4l2 2"></path>',
            };
        }

        return {
            className: 'expiration-chip is-muted',
            text: formatted,
            date: '',
            icon: '<circle cx="12" cy="12" r="8"></circle><path d="M12 8v4l2 2"></path>',
        };
    }

    function buildStatusBadge(status) {
        const labels = {
            normal: 'OK',
            expiring: 'A vencer',
            expired: 'Vencido',
            finished: 'Acabou',
        };

        return '<span class="status-badge is-' + status + '">' + labels[status] + '</span>';
    }

    function renderDashboard(products) {
        const expiring = products.filter((item) => item.status === 'expiring');
        const expired = products.filter((item) => item.status === 'expired');
        const shopping = getShoppingItems();

        const totalElement = document.getElementById('summaryTotal');
        const expiringElement = document.getElementById('summaryExpiring');
        const expiredElement = document.getElementById('summaryExpired');
        const shoppingElement = document.getElementById('summaryShopping');
        const listElement = document.getElementById('upcomingExpiringList');

        if (totalElement) totalElement.textContent = String(products.length);
        if (expiringElement) expiringElement.textContent = String(expiring.length);
        if (expiredElement) expiredElement.textContent = String(expired.length);
        if (shoppingElement) shoppingElement.textContent = String(shopping.length);

        if (!listElement) {
            return;
        }

        if (!expiring.length) {
            listElement.innerHTML = '' +
                '<div class="empty-state">' +
                    '<div class="empty-state-icon is-success" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path d="M12 8v4l2 2"></path>' +
                            '<circle cx="12" cy="12" r="8"></circle>' +
                        '</svg>' +
                    '</div>' +
                    '<p class="empty-title">Nenhum produto proximo do vencimento</p>' +
                    '<p class="empty-copy">Tudo certo por aqui.</p>' +
                '</div>';
            return;
        }

        const upcoming = expiring
            .slice()
            .sort((a, b) => parseDate(a.expirationDate) - parseDate(b.expirationDate))
            .slice(0, 5);

        listElement.innerHTML = upcoming.map((item) => {
            const expiration = buildExpirationMarkup(item.expirationDate);
            return '' +
                '<div class="list-row">' +
                    '<div class="row-main">' +
                        '<p class="row-title">' + escapeHtml(item.nome_produto) + '</p>' +
                        '<div class="' + expiration.className + '">' +
                            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + expiration.icon + '</svg>' +
                            '<span>' + escapeHtml(expiration.text) + '</span>' +
                            (expiration.date ? '<span class="mini-copy">' + escapeHtml(expiration.date) + '</span>' : '') +
                        '</div>' +
                    '</div>' +
                    '<div class="row-side">' +
                        '<span class="mini-copy">Qtd: ' + escapeHtml(String(item.quantity)) + '</span>' +
                        buildStatusBadge(item.status) +
                    '</div>' +
                '</div>';
        }).join('');
    }

    function renderExpiring(products) {
        const container = document.getElementById('expiringList');
        if (!container) {
            return;
        }

        const expiring = products
            .filter((item) => item.status === 'expiring')
            .sort((a, b) => parseDate(a.expirationDate) - parseDate(b.expirationDate));

        if (!expiring.length) {
            container.innerHTML = '' +
                '<section class="surface-card empty-state">' +
                    '<div class="empty-state-icon is-success" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                            '<circle cx="12" cy="12" r="8"></circle>' +
                            '<path d="M12 8v4l2 2"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<p class="empty-title">Nenhum produto proximo do vencimento</p>' +
                    '<p class="empty-copy">Todos os seus produtos estao com a validade em dia.</p>' +
                '</section>';
            return;
        }

        container.innerHTML = expiring.map((item) => {
            const diff = differenceInDays(item.expirationDate);
            const urgent = diff <= 2;
            const expiration = buildExpirationMarkup(item.expirationDate);
            return '' +
                '<div class="surface-card list-row">' +
                    '<div class="row-main">' +
                        '<div class="row-side">' +
                            '<p class="row-title">' + escapeHtml(item.nome_produto) + '</p>' +
                            (urgent ? '<span class="warning-badge">Urgente</span>' : '') +
                        '</div>' +
                        '<div class="' + expiration.className + '">' +
                            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + expiration.icon + '</svg>' +
                            '<span>' + escapeHtml(expiration.text) + '</span>' +
                            (expiration.date ? '<span class="mini-copy">' + escapeHtml(expiration.date) + '</span>' : '') +
                        '</div>' +
                        '<span class="row-meta">' + escapeHtml(item.categoria_produto) + '</span>' +
                    '</div>' +
                    '<div class="row-side">' +
                        buildStatusBadge(item.status) +
                        '<span class="mini-copy">Qtd: ' + escapeHtml(String(item.quantity)) + '</span>' +
                    '</div>' +
                '</div>';
        }).join('');
    }

    function renderShopping() {
        const listElement = document.getElementById('shoppingList');
        const countLabel = document.getElementById('shoppingCountLabel');
        if (!listElement) {
            return;
        }

        const items = getShoppingItems();
        if (countLabel) {
            countLabel.textContent = items.length + (items.length === 1 ? ' item na lista' : ' itens na lista');
        }

        if (!items.length) {
            listElement.innerHTML = '' +
                '<section class="surface-card empty-state">' +
                    '<div class="empty-state-icon is-primary" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path d="M6 6h15l-1.5 9H8.5L6 6z"></path>' +
                            '<path d="M6 6L4 3H2"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<p class="empty-title">Lista de compras vazia</p>' +
                    '<p class="empty-copy">Itens acabados serao adicionados aqui automaticamente.</p>' +
                '</section>';
            return;
        }

        listElement.innerHTML = items.map((item) => {
            return '' +
                '<div class="surface-card shopping-row">' +
                    '<div class="row-main">' +
                        '<p class="row-title">' + escapeHtml(item.name) + '</p>' +
                        '<div class="row-side">' +
                            '<span class="row-meta">' + escapeHtml(formatCategoryLabel(item.categoryKey, item.categoryLabel)) + '</span>' +
                            '<span class="shopping-counter">Qtd: ' + escapeHtml(String(item.quantity)) + '</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="shopping-row-actions">' +
                        '<button class="button button-ghost button-success" type="button" data-shopping-action="bought" data-id="' + escapeHtml(item.id) + '">Comprado</button>' +
                        '<button class="button button-ghost" type="button" data-shopping-action="restore" data-id="' + escapeHtml(item.id) + '">Restaurar</button>' +
                        '<button class="button button-ghost button-danger" type="button" data-shopping-action="remove" data-id="' + escapeHtml(item.id) + '">Remover</button>' +
                    '</div>' +
                '</div>';
        }).join('');
    }

    function renderHistory() {
        const listElement = document.getElementById('historyList');
        if (!listElement) {
            return;
        }

        const items = getHistoryItems();
        if (!items.length) {
            listElement.innerHTML = '' +
                '<section class="surface-card empty-state">' +
                    '<div class="empty-state-icon" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path d="M3 3v6h6"></path>' +
                            '<path d="M12 7a5 5 0 1 1-5 5"></path>' +
                            '<path d="M21 21v-6h-6"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<p class="empty-title">Nenhum historico ainda</p>' +
                    '<p class="empty-copy">Quando produtos acabarem, eles aparecerao aqui.</p>' +
                '</section>';
            return;
        }

        listElement.innerHTML = items.map((item) => {
            const finishedDate = item.finishedAt ? new Date(item.finishedAt) : new Date();
            const finishedCopy = String(finishedDate.getDate()).padStart(2, '0') + '/' + String(finishedDate.getMonth() + 1).padStart(2, '0') + '/' + finishedDate.getFullYear();
            return '' +
                '<div class="surface-card history-row">' +
                    '<div class="row-main">' +
                        '<p class="row-title">' + escapeHtml(item.name) + '</p>' +
                        '<span class="row-meta">' + escapeHtml(formatCategoryLabel(item.categoryKey, item.categoryLabel)) + '</span>' +
                    '</div>' +
                    '<div class="history-row-side">' +
                        '<span class="mini-copy">Qtd: ' + escapeHtml(String(item.previousQuantity)) + '</span>' +
                        '<span class="mini-copy">' + escapeHtml(finishedCopy) + '</span>' +
                    '</div>' +
                '</div>';
        }).join('');
    }

    async function createProduct(payload) {
        const formData = new FormData();
        formData.append('nome_produto', payload.nome_produto);
        formData.append('categoria_produto', formatCategoryLabel(payload.categoryKey));
        formData.append('und_medida_produto', payload.und_medida_produto);

        const response = await fetch(PRODUCT_CREATE_ENDPOINT, {
            method: 'POST',
            body: formData,
        });
        return response.json();
    }

    async function updateProduct(id, payload) {
        const formData = new FormData();
        formData.append('nome_produto', payload.nome_produto);
        formData.append('categoria_produto', formatCategoryLabel(payload.categoryKey));
        formData.append('und_medida_produto', payload.und_medida_produto);

        const response = await fetch(PRODUCT_UPDATE_ENDPOINT + '?id=' + encodeURIComponent(id), {
            method: 'POST',
            body: formData,
        });
        return response.json();
    }

    async function deleteProduct(id) {
        const response = await fetch(PRODUCT_DELETE_ENDPOINT + '?id=' + encodeURIComponent(id));
        return response.json();
    }

    async function restoreShoppingItem(item) {
        const result = await createProduct({
            nome_produto: item.name,
            categoryKey: item.categoryKey || 'outros',
            und_medida_produto: item.unit || 'Unidade',
        });

        if (result.status !== 'ok') {
            return result;
        }

        const newId = result.data && result.data.id ? String(result.data.id) : null;
        if (newId) {
            setProductMeta(newId, {
                expirationDate: formatDate(addDays(todayAtStart(), 7)),
                quantity: Number(item.quantity || 1),
                categoryKey: item.categoryKey || 'outros',
            });
        }

        return result;
    }

    function addItemToShopping(product) {
        const items = getShoppingItems();
        items.unshift({
            id: generateId('shopping'),
            name: product.nome_produto,
            quantity: Number(product.quantity || 1),
            categoryKey: product.categoryKey || inferCategoryKey(product.categoria_produto),
            categoryLabel: product.categoria_produto,
            unit: product.und_medida_produto,
            addedAt: new Date().toISOString(),
        });
        saveShoppingItems(items);
    }

    function addItemToHistory(product) {
        const items = getHistoryItems();
        items.unshift({
            id: generateId('history'),
            name: product.nome_produto,
            previousQuantity: Number(product.quantity || 1),
            categoryKey: product.categoryKey || inferCategoryKey(product.categoria_produto),
            categoryLabel: product.categoria_produto,
            finishedAt: new Date().toISOString(),
        });
        saveHistoryItems(items);
    }

    document.addEventListener('DOMContentLoaded', async () => {
        const page = document.body.dataset.page || '';
        if (!page || page === 'inventory-form') {
            return;
        }

        try {
            const products = await fetchProducts();

            if (page === 'dashboard') {
                renderDashboard(products);
            }

            if (page === 'expiring') {
                renderExpiring(products);
            }

            if (page === 'shopping') {
                renderShopping();
            }

            if (page === 'history') {
                renderHistory();
            }

            window.MyKeeperData = {
                products: products,
            };
        } catch (error) {
            console.error(error);
            if (window.MyKeeperUI) {
                window.MyKeeperUI.showToast('Nao foi possivel carregar os dados.', 'error');
            }
        }
    });

    window.MyKeeperApp = {
        CATEGORY_LABELS: CATEGORY_LABELS,
        fetchProducts: fetchProducts,
        renderDashboard: renderDashboard,
        renderExpiring: renderExpiring,
        renderShopping: renderShopping,
        renderHistory: renderHistory,
        buildExpirationMarkup: buildExpirationMarkup,
        buildStatusBadge: buildStatusBadge,
        escapeHtml: escapeHtml,
        formatCategoryLabel: formatCategoryLabel,
        inferCategoryKey: inferCategoryKey,
        getShoppingItems: getShoppingItems,
        saveShoppingItems: saveShoppingItems,
        getHistoryItems: getHistoryItems,
        saveHistoryItems: saveHistoryItems,
        setProductMeta: setProductMeta,
        removeProductMeta: removeProductMeta,
        createProduct: createProduct,
        updateProduct: updateProduct,
        deleteProduct: deleteProduct,
        addItemToShopping: addItemToShopping,
        addItemToHistory: addItemToHistory,
        restoreShoppingItem: restoreShoppingItem,
        differenceInDays: differenceInDays,
        formatDate: formatDate,
    };
})();
