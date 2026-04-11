(function () {
    const STORAGE_KEY = 'mykeeper:pending-notification';
    const DEFAULT_DURATION = 4200;
    let container = null;

    function ensureContainer() {
        if (container && document.body.contains(container)) {
            return container;
        }

        container = document.createElement('div');
        container.className = 'app-toast-container';
        document.body.appendChild(container);
        return container;
    }

    function escapeHtml(value) {
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function normalizeNotification(rawMessage) {
        const message = String(rawMessage || '').trim();
        const lower = message.toLowerCase();

        let type = 'info';
        let title = 'Aviso';
        let text = message;

        if (/^sucesso!?/i.test(message)) {
            type = 'success';
            title = 'Sucesso';
            text = message.replace(/^sucesso!?\s*:?-?\s*/i, '') || 'Operacao concluida com sucesso.';
        } else if (/^erro!?|^erro:|^erro\s/i.test(message) || lower.includes('nao foi possivel') || lower.includes('não foi possível')) {
            type = 'error';
            title = 'Erro';
            text = message.replace(/^erro!?\s*:?-?\s*/i, '') || 'Ocorreu um erro na operacao.';
        } else if (lower.startsWith('por favor') || lower.startsWith('digite') || lower.startsWith('preencha') || lower.includes('selecione')) {
            type = 'warning';
            title = 'Atencao';
            text = message;
        }

        return {
            id: `toast-${Date.now()}-${Math.random().toString(16).slice(2)}`,
            type,
            title,
            text,
            duration: type === 'error' ? 5200 : DEFAULT_DURATION,
            createdAt: Date.now(),
        };
    }

    function iconForType(type) {
        if (type === 'success') return '✓';
        if (type === 'error') return '!';
        if (type === 'warning') return '•';
        return 'i';
    }

    function removeToast(toast) {
        if (!toast || toast.classList.contains('is-leaving')) {
            return;
        }

        toast.classList.add('is-leaving');
        window.setTimeout(() => toast.remove(), 280);
    }

    function renderToast(notification) {
        ensureContainer();

        const toast = document.createElement('div');
        toast.className = `app-toast app-toast--${notification.type}`;
        toast.innerHTML = `
            <div class="app-toast__header">
                <div class="app-toast__title-wrap">
                    <span class="app-toast__icon">${iconForType(notification.type)}</span>
                    <span class="app-toast__title">${escapeHtml(notification.title)}</span>
                </div>
                <button type="button" class="app-toast__close" aria-label="Fechar notificacao">&times;</button>
            </div>
            <div class="app-toast__message">${escapeHtml(notification.text)}</div>
            <div class="app-toast__progress"></div>
        `;

        const progress = toast.querySelector('.app-toast__progress');
        progress.style.animationDuration = `${notification.duration}ms`;

        toast.querySelector('.app-toast__close').addEventListener('click', () => removeToast(toast));

        ensureContainer().appendChild(toast);
        window.setTimeout(() => removeToast(toast), notification.duration);
    }

    function rememberNotification(notification) {
        sessionStorage.setItem(STORAGE_KEY, JSON.stringify(notification));

        window.setTimeout(() => {
            const stored = sessionStorage.getItem(STORAGE_KEY);
            if (!stored) {
                return;
            }

            try {
                const parsed = JSON.parse(stored);
                if (parsed.id === notification.id) {
                    sessionStorage.removeItem(STORAGE_KEY);
                }
            } catch (error) {
                sessionStorage.removeItem(STORAGE_KEY);
            }
        }, 700);
    }

    function showPendingNotification() {
        const stored = sessionStorage.getItem(STORAGE_KEY);
        if (!stored) {
            return;
        }

        sessionStorage.removeItem(STORAGE_KEY);

        try {
            const notification = JSON.parse(stored);
            if (!notification || Date.now() - notification.createdAt > 10000) {
                return;
            }

            renderToast(notification);
        } catch (error) {
            sessionStorage.removeItem(STORAGE_KEY);
        }
    }

    function showNotification(message, options) {
        const notification = {
            ...normalizeNotification(message),
            ...(options || {}),
            createdAt: Date.now(),
        };

        renderToast(notification);
        rememberNotification(notification);
        return notification;
    }

    function appConfirm(message, options) {
        const settings = {
            title: 'Confirmar acao',
            confirmText: 'Confirmar',
            cancelText: 'Cancelar',
            ...options,
        };

        return new Promise((resolve) => {
            const overlay = document.createElement('div');
            overlay.className = 'app-confirm-overlay';
            overlay.innerHTML = `
                <div class="app-confirm-dialog" role="dialog" aria-modal="true" aria-label="${escapeHtml(settings.title)}">
                    <div class="app-confirm-title">${escapeHtml(settings.title)}</div>
                    <div class="app-confirm-message">${escapeHtml(message)}</div>
                    <div class="app-confirm-actions">
                        <button type="button" class="app-confirm-button app-confirm-button--cancel">${escapeHtml(settings.cancelText)}</button>
                        <button type="button" class="app-confirm-button app-confirm-button--confirm">${escapeHtml(settings.confirmText)}</button>
                    </div>
                </div>
            `;

            const finish = (result) => {
                overlay.remove();
                resolve(result);
            };

            overlay.addEventListener('click', (event) => {
                if (event.target === overlay) {
                    finish(false);
                }
            });

            overlay.querySelector('.app-confirm-button--cancel').addEventListener('click', () => finish(false));
            overlay.querySelector('.app-confirm-button--confirm').addEventListener('click', () => finish(true));

            document.body.appendChild(overlay);
        });
    }

    window.appNotify = showNotification;
    window.appConfirm = appConfirm;
    window.alert = function (message) {
        showNotification(message);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', showPendingNotification, { once: true });
    } else {
        showPendingNotification();
    }
})();