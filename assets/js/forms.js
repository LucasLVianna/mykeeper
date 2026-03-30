(function () {
    const state = {
        products: [],
        filter: 'all',
        search: '',
        confirmAction: null,
    };

    function toast(message, type) {
        if (window.MyKeeperUI) {
            window.MyKeeperUI.showToast(message, type);
        }
    }

    function dialogRefs() {
        return {
            root: document.getElementById('confirmDialog'),
            title: document.getElementById('confirmDialogTitle'),
            description: document.getElementById('confirmDialogDescription'),
            action: document.getElementById('confirmDialogAction'),
        };
    }

    function openDialog(options) {
        const refs = dialogRefs();
        if (!refs.root) {
            return;
        }

        refs.title.textContent = options.title;
        refs.description.textContent = options.description;
        refs.action.textContent = options.actionText || 'Confirmar';
        refs.action.className = 'button ' + (options.actionClass || 'button-primary');
        refs.root.hidden = false;
        state.confirmAction = options.onConfirm;
    }

    function closeDialog() {
        const refs = dialogRefs();
        if (!refs.root) {
            return;
        }

        refs.root.hidden = true;
        state.confirmAction = null;
    }

    function initDialog() {
        const refs = dialogRefs();
        if (!refs.root || !refs.action) {
            return;
        }

        refs.root.addEventListener('click', (event) => {
            const target = event.target;
            if (target instanceof HTMLElement && target.dataset.closeDialog === 'true') {
                closeDialog();
            }
        });

        refs.action.addEventListener('click', async () => {
            if (typeof state.confirmAction === 'function') {
                await state.confirmAction();
            }
            closeDialog();
        });
    }

    function sheetRefs() {
        return {
            root: document.getElementById('productSheet'),
            form: document.getElementById('productSheetForm'),
            title: document.getElementById('productSheetTitle'),
            description: document.getElementById('productSheetDescription'),
            submit: document.getElementById('productSheetSubmit'),
            id: document.getElementById('sheet_product_id'),
            nome: document.getElementById('sheet_nome_produto'),
            validade: document.getElementById('sheet_data_validade_produto'),
            quantidade: document.getElementById('sheet_quantidade_produto'),
            categoria: document.getElementById('sheet_categoria_produto'),
            unidade: document.getElementById('sheet_und_medida_produto'),
        };
    }

    function openSheet(mode, product) {
        const refs = sheetRefs();
        if (!refs.root || !refs.form) {
            return;
        }

        refs.form.dataset.mode = mode;
        refs.id.value = product ? product.id : '';
        refs.nome.value = product ? product.nome_produto : '';
        refs.validade.value = product ? product.expirationDate : '';
        refs.quantidade.value = product ? String(product.quantity) : '1';
        refs.categoria.value = product ? product.categoryKey : 'outros';
        refs.unidade.value = product ? product.und_medida_produto : '';
        refs.title.textContent = product ? 'Editar Produto' : 'Adicionar Produto';
        refs.description.textContent = product ? 'Altere as informacoes do produto.' : 'Preencha os dados do novo produto.';
        refs.submit.textContent = product ? 'Salvar Alteracoes' : 'Adicionar Produto';
        refs.root.hidden = false;
    }

    function closeSheet() {
        const refs = sheetRefs();
        if (!refs.root || !refs.form) {
            return;
        }

        refs.root.hidden = true;
        refs.form.reset();
        refs.quantidade.value = '1';
        refs.categoria.value = 'outros';
    }

    function payloadFromForm(form) {
        return {
            id: form.querySelector('[name="id"]') ? form.querySelector('[name="id"]').value : '',
            nome_produto: form.querySelector('[name="nome_produto"]').value.trim(),
            expirationDate: form.querySelector('[name="data_validade_produto"]').value,
            quantity: Number(form.querySelector('[name="quantidade_produto"]').value || 1),
            categoryKey: form.querySelector('[name="categoria_produto"]').value || 'outros',
            und_medida_produto: form.querySelector('[name="und_medida_produto"]').value.trim(),
        };
    }

    function validateProduct(payload) {
        if (!payload.nome_produto) {
            toast('Informe o nome do produto.', 'error');
            return false;
        }

        if (!payload.expirationDate) {
            toast('Informe a data de vencimento.', 'error');
            return false;
        }

        if (payload.quantity < 1) {
            toast('Quantidade invalida.', 'error');
            return false;
        }

        if (!payload.und_medida_produto) {
            toast('Informe a unidade de medida.', 'error');
            return false;
        }

        return true;
    }

    async function submitPayload(payload, mode) {
        if (!validateProduct(payload)) {
            return false;
        }

        if (mode === 'edit' && payload.id) {
            const result = await window.MyKeeperApp.updateProduct(payload.id, payload);
            if (result.status !== 'ok' && result.mensagem !== 'Nenhuma alteracao realizada') {
                toast(result.mensagem || 'Falha ao atualizar produto.', 'error');
                return false;
            }

            window.MyKeeperApp.setProductMeta(payload.id, {
                expirationDate: payload.expirationDate,
                quantity: payload.quantity,
                categoryKey: payload.categoryKey,
            });
            toast('Produto atualizado com sucesso!', 'success');
            return true;
        }

        const result = await window.MyKeeperApp.createProduct(payload);
        if (result.status !== 'ok') {
            toast(result.mensagem || 'Falha ao adicionar produto.', 'error');
            return false;
        }

        if (result.data && result.data.id) {
            window.MyKeeperApp.setProductMeta(String(result.data.id), {
                expirationDate: payload.expirationDate,
                quantity: payload.quantity,
                categoryKey: payload.categoryKey,
            });
        }
        toast('Produto adicionado com sucesso!', 'success');
        return true;
    }

    async function loadProducts() {
        state.products = await window.MyKeeperApp.fetchProducts();
        return state.products;
    }

    function renderInventory() {
        const container = document.getElementById('inventoryGrid');
        if (!container) {
            return;
        }

        const all = state.products;
        const expiringCount = all.filter((item) => item.status === 'expiring').length;
        const expiredCount = all.filter((item) => item.status === 'expired').length;

        const allCount = document.getElementById('filterAllCount');
        const expiringCountElement = document.getElementById('filterExpiringCount');
        const expiredCountElement = document.getElementById('filterExpiredCount');
        if (allCount) allCount.textContent = String(all.length);
        if (expiringCountElement) expiringCountElement.textContent = String(expiringCount);
        if (expiredCountElement) expiredCountElement.textContent = String(expiredCount);

        const filtered = all
            .filter((item) => {
                if (state.filter === 'expiring') {
                    return item.status === 'expiring';
                }

                if (state.filter === 'expired') {
                    return item.status === 'expired';
                }

                return true;
            })
            .filter((item) => {
                if (!state.search) {
                    return true;
                }

                const query = state.search.toLowerCase();
                return item.nome_produto.toLowerCase().includes(query) || item.categoria_produto.toLowerCase().includes(query);
            })
            .sort((a, b) => window.MyKeeperApp.differenceInDays(a.expirationDate) - window.MyKeeperApp.differenceInDays(b.expirationDate));

        if (!filtered.length) {
            container.innerHTML = '' +
                '<section class="surface-card empty-state">' +
                    '<div class="empty-state-icon" aria-hidden="true">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' +
                            '<path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>' +
                            '<path d="M10 8h4"></path>' +
                            '<path d="M10 12h4"></path>' +
                        '</svg>' +
                    '</div>' +
                    '<p class="empty-title">Nenhum produto encontrado</p>' +
                    '<p class="empty-copy">' + (state.search ? 'Tente alterar sua busca.' : 'Adicione produtos para comecar.') + '</p>' +
                '</section>';
            return;
        }

        container.innerHTML = filtered.map((item) => {
            const expiration = window.MyKeeperApp.buildExpirationMarkup(item.expirationDate);
            return '' +
                '<article class="surface-card inventory-card is-' + item.status + '">' +
                    '<div class="inventory-topline">' +
                        '<div class="inventory-main">' +
                            '<p class="inventory-title">' + window.MyKeeperApp.escapeHtml(item.nome_produto) + '</p>' +
                            '<span class="inventory-meta">' + window.MyKeeperApp.escapeHtml(item.categoria_produto) + '</span>' +
                        '</div>' +
                        window.MyKeeperApp.buildStatusBadge(item.status) +
                    '</div>' +
                    '<div class="' + expiration.className + '">' +
                        '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + expiration.icon + '</svg>' +
                        '<span>' + window.MyKeeperApp.escapeHtml(expiration.text) + '</span>' +
                        (expiration.date ? '<span class="mini-copy">' + window.MyKeeperApp.escapeHtml(expiration.date) + '</span>' : '') +
                    '</div>' +
                    '<div class="inventory-detail">Qtd: ' + window.MyKeeperApp.escapeHtml(String(item.quantity)) + ' | Unidade: ' + window.MyKeeperApp.escapeHtml(item.und_medida_produto) + '</div>' +
                    '<div class="inventory-footer">' +
                        '<div class="inventory-action-group">' +
                            '<button class="button button-ghost" type="button" data-action="edit" data-id="' + window.MyKeeperApp.escapeHtml(item.id) + '">Editar</button>' +
                            '<button class="button button-ghost button-success" type="button" data-action="finish" data-id="' + window.MyKeeperApp.escapeHtml(item.id) + '">Acabou</button>' +
                            '<button class="button button-ghost button-danger" type="button" data-action="delete" data-id="' + window.MyKeeperApp.escapeHtml(item.id) + '">Excluir</button>' +
                        '</div>' +
                    '</div>' +
                '</article>';
        }).join('');
    }

    async function refreshDashboard() {
        if (document.body.dataset.page !== 'dashboard') {
            return;
        }

        const products = await window.MyKeeperApp.fetchProducts();
        window.MyKeeperApp.renderDashboard(products);
    }

    async function finishProduct(product) {
        const result = await window.MyKeeperApp.deleteProduct(product.id);
        if (result.status !== 'ok') {
            toast(result.mensagem || 'Falha ao mover item.', 'error');
            return;
        }

        window.MyKeeperApp.removeProductMeta(product.id);
        window.MyKeeperApp.addItemToShopping(product);
        window.MyKeeperApp.addItemToHistory(product);
        toast(product.nome_produto + ' movido para a lista de compras!', 'success');
        state.products = state.products.filter((item) => item.id !== product.id);
        renderInventory();
        await refreshDashboard();
    }

    async function deleteProduct(product) {
        const result = await window.MyKeeperApp.deleteProduct(product.id);
        if (result.status !== 'ok') {
            toast(result.mensagem || 'Falha ao excluir produto.', 'error');
            return;
        }

        window.MyKeeperApp.removeProductMeta(product.id);
        toast('Produto excluido com sucesso!', 'success');
        state.products = state.products.filter((item) => item.id !== product.id);
        renderInventory();
        await refreshDashboard();
    }

    function initInventoryPage() {
        const container = document.getElementById('inventoryGrid');
        if (!container) {
            return;
        }

        loadProducts().then(renderInventory);

        const searchInput = document.getElementById('inventorySearch');
        if (searchInput) {
            searchInput.addEventListener('input', (event) => {
                state.search = event.target.value.trim();
                renderInventory();
            });
        }

        document.querySelectorAll('[data-filter]').forEach((button) => {
            button.addEventListener('click', () => {
                state.filter = button.dataset.filter || 'all';
                document.querySelectorAll('[data-filter]').forEach((chip) => chip.classList.remove('is-active'));
                button.classList.add('is-active');
                renderInventory();
            });
        });

        container.addEventListener('click', (event) => {
            const button = event.target.closest('[data-action]');
            if (!button) {
                return;
            }

            const product = state.products.find((item) => item.id === button.dataset.id);
            if (!product) {
                return;
            }

            if (button.dataset.action === 'edit') {
                openSheet('edit', product);
            }

            if (button.dataset.action === 'finish') {
                openDialog({
                    title: 'Mover para compras',
                    description: 'Deseja mover "' + product.nome_produto + '" para a lista de compras?',
                    actionText: 'Mover',
                    actionClass: 'button-primary',
                    onConfirm: function () {
                        return finishProduct(product);
                    },
                });
            }

            if (button.dataset.action === 'delete') {
                openDialog({
                    title: 'Excluir produto',
                    description: 'Tem certeza que deseja excluir "' + product.nome_produto + '"? Esta acao nao pode ser desfeita.',
                    actionText: 'Excluir',
                    actionClass: 'button-primary',
                    onConfirm: function () {
                        return deleteProduct(product);
                    },
                });
            }
        });
    }

    function initProductSheet() {
        const refs = sheetRefs();
        if (!refs.root || !refs.form) {
            return;
        }

        document.querySelectorAll('[data-open-product-sheet]').forEach((button) => {
            button.addEventListener('click', () => openSheet('add'));
        });

        refs.root.addEventListener('click', (event) => {
            const target = event.target;
            if (target instanceof HTMLElement && target.dataset.closeSheet === 'true') {
                closeSheet();
            }
        });

        refs.form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const payload = payloadFromForm(refs.form);
            const success = await submitPayload(payload, refs.form.dataset.mode || 'add');
            if (!success) {
                return;
            }

            closeSheet();
            if (document.body.dataset.page === 'inventory') {
                await loadProducts();
                renderInventory();
            } else {
                await refreshDashboard();
            }
        });
    }

    function setStandaloneCategory(select, value) {
        if (!select) {
            return;
        }

        select.value = value || 'outros';
    }

    async function initStandaloneForm() {
        const form = document.getElementById('standaloneProductForm');
        if (!form) {
            return;
        }

        const mode = form.dataset.mode || 'add';
        if (mode === 'edit') {
            const params = new URLSearchParams(window.location.search);
            const id = params.get('id');
            if (id) {
                const products = await window.MyKeeperApp.fetchProducts();
                const product = products.find((item) => item.id === id);
                if (product) {
                    form.querySelector('#id').value = product.id;
                    form.querySelector('#nome_produto').value = product.nome_produto;
                    form.querySelector('#data_validade_produto').value = product.expirationDate;
                    form.querySelector('#quantidade_produto').value = String(product.quantity);
                    setStandaloneCategory(form.querySelector('#categoria_produto'), product.categoryKey);
                    form.querySelector('#und_medida_produto').value = product.und_medida_produto;
                }
            }
        }

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const payload = payloadFromForm(form);
            const success = await submitPayload(payload, mode);
            if (success) {
                window.location.href = '/mykeeper-main/src/Views/produto.php';
            }
        });
    }

    function shoppingRefs() {
        return {
            root: document.getElementById('shoppingSheet'),
            form: document.getElementById('shoppingSheetForm'),
            nome: document.getElementById('shopping_nome_item'),
            quantidade: document.getElementById('shopping_quantidade_item'),
            categoria: document.getElementById('shopping_categoria_item'),
        };
    }

    function openShoppingSheet() {
        const refs = shoppingRefs();
        if (refs.root) {
            refs.root.hidden = false;
        }
    }

    function closeShoppingSheet() {
        const refs = shoppingRefs();
        if (!refs.root || !refs.form) {
            return;
        }

        refs.root.hidden = true;
        refs.form.reset();
        refs.quantidade.value = '1';
        refs.categoria.value = 'outros';
    }

    function initShoppingPage() {
        const list = document.getElementById('shoppingList');
        if (!list) {
            return;
        }

        const openButton = document.getElementById('openShoppingForm');
        if (openButton) {
            openButton.addEventListener('click', openShoppingSheet);
        }

        const refs = shoppingRefs();
        if (refs.root && refs.form) {
            refs.root.addEventListener('click', (event) => {
                const target = event.target;
                if (target instanceof HTMLElement && target.dataset.closeShoppingSheet === 'true') {
                    closeShoppingSheet();
                }
            });

            refs.form.addEventListener('submit', (event) => {
                event.preventDefault();
                const name = refs.nome.value.trim();
                const quantity = Number(refs.quantidade.value || 1);
                const categoryKey = refs.categoria.value || 'outros';

                if (!name) {
                    toast('Informe o nome do item.', 'error');
                    return;
                }

                if (quantity < 1) {
                    toast('Quantidade invalida.', 'error');
                    return;
                }

                const items = window.MyKeeperApp.getShoppingItems();
                items.unshift({
                    id: 'shopping-' + Date.now(),
                    name: name,
                    quantity: quantity,
                    categoryKey: categoryKey,
                    categoryLabel: window.MyKeeperApp.formatCategoryLabel(categoryKey),
                    unit: 'Unidade',
                    addedAt: new Date().toISOString(),
                });
                window.MyKeeperApp.saveShoppingItems(items);
                closeShoppingSheet();
                window.MyKeeperApp.renderShopping();
                toast('Item adicionado a lista de compras!', 'success');
            });
        }

        list.addEventListener('click', async (event) => {
            const button = event.target.closest('[data-shopping-action]');
            if (!button) {
                return;
            }

            const items = window.MyKeeperApp.getShoppingItems();
            const item = items.find((entry) => entry.id === button.dataset.id);
            if (!item) {
                return;
            }

            if (button.dataset.shoppingAction === 'bought') {
                const nextItems = items.filter((entry) => entry.id !== item.id);
                window.MyKeeperApp.saveShoppingItems(nextItems);
                window.MyKeeperApp.renderShopping();
                toast(item.name + ' marcado como comprado!', 'success');
            }

            if (button.dataset.shoppingAction === 'remove') {
                openDialog({
                    title: 'Remover item',
                    description: 'Tem certeza que deseja remover "' + item.name + '" da lista de compras?',
                    actionText: 'Remover',
                    actionClass: 'button-primary',
                    onConfirm: async function () {
                        const nextItems = window.MyKeeperApp.getShoppingItems().filter((entry) => entry.id !== item.id);
                        window.MyKeeperApp.saveShoppingItems(nextItems);
                        window.MyKeeperApp.renderShopping();
                        toast('Item removido da lista!', 'success');
                    },
                });
            }

            if (button.dataset.shoppingAction === 'restore') {
                const result = await window.MyKeeperApp.restoreShoppingItem(item);
                if (result.status !== 'ok') {
                    toast(result.mensagem || 'Falha ao restaurar item.', 'error');
                    return;
                }

                const nextItems = window.MyKeeperApp.getShoppingItems().filter((entry) => entry.id !== item.id);
                window.MyKeeperApp.saveShoppingItems(nextItems);
                window.MyKeeperApp.renderShopping();
                toast(item.name + ' restaurado para o inventario!', 'success');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initDialog();
        initProductSheet();
        initStandaloneForm();
        initInventoryPage();
        initShoppingPage();
    });
})();
