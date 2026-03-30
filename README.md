<<<<<<< HEAD
# mykeeper
MyKeeper is a food management app for everyday users, created as an university project for the Experiência Criativa course.
=======
# MyKeeper Frontend Handoff

Documentacao tecnica e operacional do frontend atual do projeto `mykeeper-main`.

Este arquivo foi pensado como handoff para outra pessoa conseguir:

- entender rapidamente a arquitetura do frontend
- localizar os arquivos certos para cada tipo de mudanca
- saber o que ja esta persistido no backend e o que ainda vive no navegador
- validar o sistema antes de subir alteracoes
- planejar a evolucao tecnica do projeto

## Resumo executivo

O projeto continua sendo um sistema em:

- PHP puro
- HTML dentro de arquivos PHP
- CSS proprio
- JavaScript vanilla

O frontend foi reorganizado para reproduzir a interface do projeto de referencia aberto no VS Code, mantendo os controllers PHP atuais como base do CRUD de produtos.

Hoje a aplicacao tem:

- layout compartilhado com sidebar desktop, header mobile e bottom navigation
- dashboard com cards-resumo e lista de itens a vencer
- inventario com busca, filtros e cards de produto
- sheet lateral para adicionar e editar produto
- pagina de produtos a vencer
- pagina de lista de compras
- pagina de historico
- tema claro/escuro salvo no navegador

## Estado atual

### O que ja esta pronto

- interface principal adaptada para o visual do projeto de referencia
- navegacao responsiva
- estrutura visual reutilizavel com includes
- integracao com CRUD real de produtos
- camada de UX para compras, historico e vencimento

### O que ainda e hibrido

Parte importante da experiencia ainda depende de `localStorage`, porque o backend atual nao persiste todos os dados que a UI precisa.

Hoje ficam no navegador:

- tema
- validade do produto
- quantidade do produto
- lista de compras
- historico

### Risco tecnico principal

O maior risco atual e consistencia de dados entre backend e frontend:

- o banco continua sendo a fonte real do CRUD de produtos
- a camada visual rica depende parcialmente de storage local

Se o navegador mudar, o cache for limpo, ou o usuario acessar em outro dispositivo, parte dos dados de UX nao acompanha.

## Estrutura de arquivos

### Layout compartilhado

- [src/Includes/header.php](c:/xampp/htdocs/mykeeper-main/src/Includes/header.php)
  Abre o HTML, injeta CSS, define `data-page`, renderiza header mobile e toolbar desktop.

- [src/Includes/sidebar.php](c:/xampp/htdocs/mykeeper-main/src/Includes/sidebar.php)
  Sidebar principal desktop com links e icones.

- [src/Includes/footer.php](c:/xampp/htdocs/mykeeper-main/src/Includes/footer.php)
  Fecha a pagina, renderiza bottom nav mobile, dialogo global, area de toast e carrega os JS principais.

### Partials de UI

- [src/Includes/product_sheet.php](c:/xampp/htdocs/mykeeper-main/src/Includes/product_sheet.php)
  Sheet lateral para adicionar ou editar produto.

- [src/Includes/shopping_sheet.php](c:/xampp/htdocs/mykeeper-main/src/Includes/shopping_sheet.php)
  Sheet lateral para adicionar item manualmente na lista de compras.

### Views

- [src/Views/home.php](c:/xampp/htdocs/mykeeper-main/src/Views/home.php)
  Dashboard.

- [src/Views/produto.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto.php)
  Inventario.

- [src/Views/produto_novo.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto_novo.php)
  Formulario standalone de criacao.

- [src/Views/produto_alterar.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto_alterar.php)
  Formulario standalone de edicao.

- [src/Views/avencer.php](c:/xampp/htdocs/mykeeper-main/src/Views/avencer.php)
  Lista de produtos proximos do vencimento.

- [src/Views/compras.php](c:/xampp/htdocs/mykeeper-main/src/Views/compras.php)
  Lista de compras.

- [src/Views/historico.php](c:/xampp/htdocs/mykeeper-main/src/Views/historico.php)
  Historico de itens finalizados.

### CSS

- [assets/css/style.css](c:/xampp/htdocs/mykeeper-main/assets/css/style.css)
  Tokens visuais, cores, tema, layout base, sidebar, header, buttons, sheets, dialogs e toasts.

- [assets/css/components.css](c:/xampp/htdocs/mykeeper-main/assets/css/components.css)
  Cards, filtros, listas, inventario, badges, expiracao, empty states e detalhes de componentes.

- [assets/css/responsive.css](c:/xampp/htdocs/mykeeper-main/assets/css/responsive.css)
  Regras responsivas do layout e dos componentes.

### JavaScript

- [assets/js/ui.js](c:/xampp/htdocs/mykeeper-main/assets/js/ui.js)
  Tema claro/escuro, abertura da sidebar mobile, highlight da navegacao e toasts globais.

- [assets/js/app.js](c:/xampp/htdocs/mykeeper-main/assets/js/app.js)
  Camada central de dados e renderizacao compartilhada. Busca produtos no backend, monta metadados faltantes, renderiza dashboard, vencimentos, compras e historico.

- [assets/js/forms.js](c:/xampp/htdocs/mykeeper-main/assets/js/forms.js)
  Controla formularios, sheets, filtros do inventario, dialogos e acoes das paginas.

### Backend usado pelo frontend

- [src/Controllers/produto_get.php](c:/xampp/htdocs/mykeeper-main/src/Controllers/produto_get.php)
  Retorna produtos em JSON.

- [src/Controllers/produto_novo_back.php](c:/xampp/htdocs/mykeeper-main/src/Controllers/produto_novo_back.php)
  Cria produto e devolve `insert_id` em `data.id`.

- [src/Controllers/produto_alterar_back.php](c:/xampp/htdocs/mykeeper-main/src/Controllers/produto_alterar_back.php)
  Atualiza produto.

- [src/Controllers/produto_excluir.php](c:/xampp/htdocs/mykeeper-main/src/Controllers/produto_excluir.php)
  Exclui produto.

## Onboarding

Secao para quem acabou de assumir o frontend.

### 1. O que voce precisa ter

- PHP local funcional
- MySQL/MariaDB configurado
- ambiente tipo XAMPP ou equivalente
- navegador moderno
- acesso ao projeto atual e, idealmente, ao projeto de referencia

### 2. Ordem recomendada de leitura

1. [README.md](c:/xampp/htdocs/mykeeper-main/README.md)
2. [src/Includes/header.php](c:/xampp/htdocs/mykeeper-main/src/Includes/header.php)
3. [src/Includes/footer.php](c:/xampp/htdocs/mykeeper-main/src/Includes/footer.php)
4. [assets/js/app.js](c:/xampp/htdocs/mykeeper-main/assets/js/app.js)
5. [assets/js/forms.js](c:/xampp/htdocs/mykeeper-main/assets/js/forms.js)
6. [src/Views/produto.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto.php)
7. [src/Controllers/produto_get.php](c:/xampp/htdocs/mykeeper-main/src/Controllers/produto_get.php)

### 3. Mapa mental rapido

- `Includes` = shell da interface
- `Views` = telas
- `assets/css` = identidade visual
- `assets/js/ui.js` = UX global
- `assets/js/app.js` = dados e renderizacao compartilhada
- `assets/js/forms.js` = formularios e interacoes
- `Controllers` = endpoints reais

### 4. Checklist de entrada no projeto

Na primeira hora, confirme:

1. dashboard abre
2. inventario lista produtos
3. tema alterna
4. menu mobile funciona
5. adicionar produto funciona
6. editar produto funciona
7. excluir produto funciona

### 5. Regras de manutencao

- preserve os includes compartilhados antes de duplicar HTML
- nao troque IDs e hooks do JS sem revisar todas as chamadas
- nao renomeie parametros do CRUD sem revisar controllers e formulios
- ao mexer em UX, revise impacto em `localStorage`
- ao mexer no visual, tente manter tokens e classes centrais

## Como o frontend funciona

## 1. Boot da pagina

Cada view define:

- `$pageTitle`
- `$pageSlug`

O `header.php` usa essas variaveis para:

- montar o `<title>`
- preencher `data-page` no `<body>`
- permitir que o JS saiba qual tela esta ativa

Exemplo:

```php
<?php
$pageTitle = 'Inventario';
$pageSlug = 'inventory';
include __DIR__ . '/../Includes/header.php';
?>
```

O `footer.php` injeta ao final:

- `ui.js`
- `app.js`
- `forms.js`

## 2. Estado compartilhado

O frontend nao usa framework. O estado fica distribuido em:

- DOM
- resposta dos controllers PHP
- `localStorage`

### Chaves de `localStorage`

- `mykeeper-theme`
  Tema `light` ou `dark`

- `mykeeper-product-meta`
  Metadados visuais dos produtos:
  - `expirationDate`
  - `quantity`
  - `categoryKey`

- `mykeeper-shopping-list`
  Lista de compras

- `mykeeper-history-list`
  Historico de itens finalizados

## 3. O que vem do banco e o que nao vem

Hoje o backend persiste principalmente:

- `id`
- `nome_produto`
- `categoria_produto`
- `und_medida_produto`

Mas a UI precisa tambem de:

- data de vencimento
- quantidade
- status
- compras
- historico

Como esses campos nao estao todos no schema atual, o frontend complementa os dados no navegador.

### Implicacao pratica

- o CRUD principal continua vindo do banco
- a UX avancada ainda e parcialmente local
- limpar o navegador pode apagar parte do estado visual

## 4. API global do frontend

O arquivo [assets/js/app.js](c:/xampp/htdocs/mykeeper-main/assets/js/app.js) expoe `window.MyKeeperApp`.

Funcoes principais:

- `fetchProducts()`
- `renderDashboard(products)`
- `renderExpiring(products)`
- `renderShopping()`
- `renderHistory()`
- `createProduct(payload)`
- `updateProduct(id, payload)`
- `deleteProduct(id)`
- `restoreShoppingItem(item)`
- `setProductMeta(id, meta)`
- `removeProductMeta(id)`

O arquivo [assets/js/ui.js](c:/xampp/htdocs/mykeeper-main/assets/js/ui.js) expoe `window.MyKeeperUI.showToast()`.

## Fluxo por pagina

## Dashboard

Arquivo:

- [src/Views/home.php](c:/xampp/htdocs/mykeeper-main/src/Views/home.php)

Fluxo:

1. `app.js` detecta `data-page="dashboard"`.
2. Busca produtos em `produto_get.php`.
3. Calcula cards de resumo.
4. Monta a lista "Proximos a vencer".

## Inventario

Arquivo:

- [src/Views/produto.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto.php)

Fluxo:

1. `forms.js` carrega todos os produtos com `fetchProducts()`.
2. Salva no `state.products`.
3. `renderInventory()` desenha os cards.
4. Busca e filtros alteram apenas o estado local.
5. Acoes disponiveis:
   - `Editar`
   - `Acabou`
   - `Excluir`

## Formulario lateral de produto

Arquivo:

- [src/Includes/product_sheet.php](c:/xampp/htdocs/mykeeper-main/src/Includes/product_sheet.php)

Controlado por:

- [assets/js/forms.js](c:/xampp/htdocs/mykeeper-main/assets/js/forms.js)

Fluxo:

1. Abre em modo `add` ou `edit`.
2. Valida campos.
3. Envia para o controller PHP correto.
4. Atualiza `mykeeper-product-meta`.

## Formularios standalone

Arquivos:

- [src/Views/produto_novo.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto_novo.php)
- [src/Views/produto_alterar.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto_alterar.php)

Usam a mesma logica principal do `forms.js`.

## Produtos a vencer

Arquivo:

- [src/Views/avencer.php](c:/xampp/htdocs/mykeeper-main/src/Views/avencer.php)

Fluxo:

1. Busca produtos.
2. Filtra `status === "expiring"`.
3. Ordena por data.
4. Destaca urgencia quando faltam ate 2 dias.

## Lista de compras

Arquivo:

- [src/Views/compras.php](c:/xampp/htdocs/mykeeper-main/src/Views/compras.php)

Fluxo:

1. Le `mykeeper-shopping-list`.
2. Abre `shoppingSheet` para insercao manual.
3. Permite:
   - marcar como comprado
   - restaurar para inventario
   - remover

### Observacao importante

Ao restaurar:

- o produto volta ao banco via `produto_novo_back.php`
- a validade padrao aplicada no frontend e `hoje + 7 dias`
- a quantidade restaurada fica em `mykeeper-product-meta`

## Historico

Arquivo:

- [src/Views/historico.php](c:/xampp/htdocs/mykeeper-main/src/Views/historico.php)

Fluxo:

1. Le `mykeeper-history-list`.
2. Renderiza nome, categoria, quantidade anterior e data.

## Tema claro/escuro

Arquivo:

- [assets/js/ui.js](c:/xampp/htdocs/mykeeper-main/assets/js/ui.js)

Fluxo:

1. Le `mykeeper-theme`.
2. Usa `prefers-color-scheme` se necessario.
3. Aplica ou remove `theme-dark`.
4. Alterna os icones.

## Navegacao

A navegacao tem tres camadas:

- sidebar desktop
- header mobile com menu
- bottom nav mobile

O destaque da pagina atual e controlado por `data-page` + `data-nav`.

Arquivos principais:

- [src/Includes/sidebar.php](c:/xampp/htdocs/mykeeper-main/src/Includes/sidebar.php)
- [src/Includes/footer.php](c:/xampp/htdocs/mykeeper-main/src/Includes/footer.php)
- [assets/js/ui.js](c:/xampp/htdocs/mykeeper-main/assets/js/ui.js)

## Dialogos e feedback visual

### Dialogo global de confirmacao

Fica em:

- [src/Includes/footer.php](c:/xampp/htdocs/mykeeper-main/src/Includes/footer.php)

Usado por:

- exclusao de produto
- mover para compras
- remover item da lista de compras

### Toasts

Tambem ficam centralizados no `footer.php`, com disparo por:

- `window.MyKeeperUI.showToast()`

## Checklist de deploy

### Pre-deploy

- validar sintaxe dos arquivos PHP alterados
- validar sintaxe dos JS principais
- confirmar que a tabela `produto` existe
- confirmar que o caminho base `/mykeeper-main/` esta correto
- confirmar que os controllers respondem em JSON
- confirmar suporte a `localStorage` no navegador alvo

### Validacao funcional minima

- abrir [home.php](c:/xampp/htdocs/mykeeper-main/src/Views/home.php)
- abrir [produto.php](c:/xampp/htdocs/mykeeper-main/src/Views/produto.php)
- testar adicionar produto
- testar editar produto
- testar excluir produto
- testar marcar produto como acabado
- testar adicionar item manualmente em compras
- testar restaurar item de compras
- testar historico
- testar tema claro/escuro
- testar desktop e mobile

### Validacao visual minima

- sidebar alinhada
- header mobile alinhado
- bottom nav visivel no mobile
- sheet lateral abrindo corretamente
- dialogo centralizado
- cards com espacamento correto
- filtros com estado ativo
- toasts aparecendo no topo

### Validacao de consistencia

- produto criado aparece no inventario
- produto editado atualiza corretamente
- exclusao remove card e metadado local
- mover para compras remove do inventario e adiciona em compras/historico
- restaurar de compras cria produto novamente

### Pos-deploy

- testar em aba anonima
- testar com base vazia
- testar com base populada
- revisar logs PHP se houver comportamento inesperado

## Checklist de troubleshooting

Se algo quebrar, siga esta ordem:

1. verificar console do navegador
2. verificar resposta JSON dos controllers
3. verificar `data-page` da view
4. verificar IDs usados no HTML e no JS
5. verificar `localStorage`
6. verificar se o caminho `/mykeeper-main/` mudou

## Regras de manutencao

- nao duplique layout entre views
- prefira partials em `src/Includes` para estruturas recorrentes
- mudanca estrutural: comece por `style.css`
- mudanca visual de componente: use `components.css`
- mudanca de breakpoint: use `responsive.css`
- mudanca de UX global: use `ui.js`
- mudanca de dados/renderizacao: use `app.js`
- mudanca de formularios/filtros: use `forms.js`

## Se precisar persistir tudo de forma real

Quando o backend passar a armazenar:

- validade
- quantidade
- status
- compras
- historico

o ideal e:

1. atualizar schema
2. atualizar controllers para devolver esses dados
3. reduzir ou remover `mykeeper-product-meta`
4. reduzir ou remover `mykeeper-shopping-list`
5. reduzir ou remover `mykeeper-history-list`

## Roadmap tecnico

### Fase 1: estabilizacao

Objetivo:

- reduzir risco de regressao
- padronizar manutencao

Entregas sugeridas:

- documentar schema atual do banco
- revisar encoding de textos
- remover scripts legados nao utilizados em `public/js`
- padronizar smoke test manual

### Fase 2: persistencia real da UX

Objetivo:

- parar de depender de `localStorage` para dados importantes

Entregas sugeridas:

- persistir validade e quantidade no banco
- modelar compras e historico no backend
- atualizar `produto_get.php`
- simplificar o uso de metadados locais em [app.js](c:/xampp/htdocs/mykeeper-main/assets/js/app.js)

### Fase 3: consolidacao do frontend

Objetivo:

- deixar a camada frontend mais previsivel

Entregas sugeridas:

- separar renderizadores por pagina
- centralizar constantes de seletores e rotas
- reduzir HTML em string quando possivel
- reaproveitar helpers visuais

### Fase 4: robustez operacional

Objetivo:

- tornar o projeto mais seguro para manutencao por equipe

Entregas sugeridas:

- ambiente de homologacao
- checklist automatizado de lint/sintaxe
- testes de interface basicos
- processo de release padronizado

### Fase 5: alinhamento total com produto

Objetivo:

- transformar a replica visual em sistema consolidado

Entregas sugeridas:

- revisar se todas as telas devem ser persistidas de forma real
- definir regra oficial para compras e historico
- remover heuristicas temporarias do frontend

## Backlog tecnico priorizado

1. persistir validade e quantidade no backend
2. persistir compras e historico no backend
3. limpar JS legado em `public/js`
4. corrigir textos com encoding inconsistente
5. modularizar `app.js` e `forms.js`
6. criar testes de regressao das principais rotas

## Decisoes tecnicas importantes

### Por que nao foi refeito em framework

Porque a prioridade foi:

- manter PHP puro
- preservar rotas e logica existentes
- adaptar o visual sem reescrever o backend

### Por que existe `localStorage`

Porque o schema atual nao guarda tudo que a interface precisa.

Foi uma decisao pragmatica para:

- manter fidelidade visual
- preservar o CRUD atual
- entregar UX rica sem exigir refatoracao completa antes

### Quando isso deve mudar

Quando o backend suportar de forma nativa:

- vencimento
- quantidade
- compras
- historico

## Handoff para o proximo dev

### O que voce pode mexer com baixo risco

- CSS de layout e componentes
- labels e textos das views
- tema, menu e modal
- renderizacao visual das listas

### O que exige mais cuidado

- nomes dos campos enviados aos controllers
- endpoints do CRUD
- fluxo de criacao e restauracao de produto
- sincronizacao entre banco e `localStorage`

### O que eu revisaria primeiro numa continuacao

- schema do banco
- controllers de produto
- estrategia real de persistencia para compras/historico
- limpeza de scripts antigos nao usados

## Plano recomendado para a proxima sprint

1. mapear schema atual do banco
2. decidir persistencia real de validade e quantidade
3. remover a dependencia dessas informacoes do `localStorage`
4. revisar visualmente todas as telas lado a lado com a referencia
5. limpar arquivos JS antigos fora do fluxo principal

## Resumo final

O frontend atual foi desenhado para ficar visualmente alinhado ao projeto de referencia, sem trocar a base PHP pura do sistema.

Em termos praticos:

- o backend atual continua sendo a fonte real do CRUD de produtos
- o frontend adiciona uma camada rica de UX e estado visual
- parte dessa camada ainda depende de `localStorage`

Se alguem novo entrar no projeto, o melhor caminho e:

1. ler este README
2. abrir [assets/js/app.js](c:/xampp/htdocs/mykeeper-main/assets/js/app.js)
3. abrir [assets/js/forms.js](c:/xampp/htdocs/mykeeper-main/assets/js/forms.js)
4. depois seguir para os includes, views e controllers
>>>>>>> local-snapshot
