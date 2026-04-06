<?php
include_once(__DIR__ . '/../../config/valida_sessao.php');

$pageTitle = 'Início';
$pageSlug = 'dashboard';
include __DIR__ . '/../Includes/app_layout_start.php';
?>
<section class="page-view">
    <div class="page-heading">
        <div>
            <h1 class="page-title">Minha geladeira</h1>
            <p class="page-subtitle">Resumo rápido do seu MyKeeper.</p>
        </div>
        <a href="/mykeeper-lucas_vianna/src/Views/produto.php?sheet=new" class="button button-primary">Adicionar produto</a>
    </div>

    <div class="summary-grid">
        <a href="/mykeeper-lucas_vianna/src/Views/produto.php" class="summary-card">
            <span class="icon-badge is-primary" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M8 3h8a2 2 0 0 1 2 2v16H6V5a2 2 0 0 1 2-2z"></path>
                    <path d="M10 8h4"></path>
                    <path d="M10 12h4"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value">01</p>
                <p class="summary-label">Produtos</p>
            </div>
        </a>

        <a href="/mykeeper-lucas_vianna/src/Views/categoria.php" class="summary-card">
            <span class="icon-badge is-warning" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 7h7"></path>
                    <path d="M4 12h16"></path>
                    <path d="M4 17h10"></path>
                    <circle cx="18" cy="7" r="2"></circle>
                    <circle cx="16" cy="17" r="2"></circle>
                </svg>
            </span>
            <div>
                <p class="summary-value">02</p>
                <p class="summary-label">Categorias</p>
            </div>
        </a>

        <a href="/mykeeper-lucas_vianna/src/Views/ticket_usuario.php" class="summary-card">
            <span class="icon-badge is-danger" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 7.5A2.5 2.5 0 0 1 7.5 5h9A2.5 2.5 0 0 1 19 7.5v5A2.5 2.5 0 0 1 16.5 15H9l-4 4v-4.5A2.5 2.5 0 0 1 2.5 12V7.5A2.5 2.5 0 0 1 5 5z"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value">03</p>
                <p class="summary-label">Tickets</p>
            </div>
        </a>

        <a href="/mykeeper-lucas_vianna/src/Views/perfil_usuario.php" class="summary-card">
            <span class="icon-badge is-primary" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="3"></circle>
                    <path d="M5 20a7 7 0 0 1 14 0"></path>
                </svg>
            </span>
            <div>
                <p class="summary-value">04</p>
                <p class="summary-label">Perfil</p>
            </div>
        </a>
    </div>

    <section class="surface-card">
        <div class="surface-header">
            <div>
                <h2 class="surface-title">Acesso rápido</h2>
                <p class="surface-subtitle">Entre direto no que você mais usa.</p>
            </div>
        </div>
        <div class="surface-content">
            <div class="quick-links-grid">
                <a href="/mykeeper-lucas_vianna/src/Views/produto.php?sheet=new" class="quick-link-card is-primary">
                    <div class="quick-link-top">
                        <div>
                            <p class="quick-link-kicker">Cadastro</p>
                            <h3 class="quick-link-title">Novo produto</h3>
                        </div>
                        <span class="quick-link-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m13 5 7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="quick-link-copy">Adicione um item e organize sua geladeira sem sair do painel.</p>
                </a>

                <a href="/mykeeper-lucas_vianna/src/Views/categoria.php?sheet=new" class="quick-link-card is-warning">
                    <div class="quick-link-top">
                        <div>
                            <p class="quick-link-kicker">Organização</p>
                            <h3 class="quick-link-title">Nova categoria</h3>
                        </div>
                        <span class="quick-link-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m13 5 7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="quick-link-copy">Crie categorias para separar melhor alimentos, bebidas e outros itens.</p>
                </a>

                <a href="/mykeeper-lucas_vianna/src/Views/ticket_usuario.php?sheet=new" class="quick-link-card is-danger">
                    <div class="quick-link-top">
                        <div>
                            <p class="quick-link-kicker">Suporte</p>
                            <h3 class="quick-link-title">Novo ticket</h3>
                        </div>
                        <span class="quick-link-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m13 5 7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="quick-link-copy">Abra um chamado rápido quando precisar de ajuda com o sistema.</p>
                </a>

                <a href="/mykeeper-lucas_vianna/src/Views/perfil_usuario.php" class="quick-link-card">
                    <div class="quick-link-top">
                        <div>
                            <p class="quick-link-kicker">Conta</p>
                            <h3 class="quick-link-title">Meu perfil</h3>
                        </div>
                        <span class="quick-link-arrow" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="m13 5 7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="quick-link-copy">Confira seus dados e ajuste as informações da sua conta quando quiser.</p>
                </a>
            </div>
        </div>
    </section>
</section>
<script src="/mykeeper-lucas_vianna/public/js/home.js"></script>
<?php include __DIR__ . '/../Includes/app_layout_end.php'; ?>
