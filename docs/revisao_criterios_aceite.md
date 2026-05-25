# Revisao dos criterios de aceite

Data: 25/05/2026
Branch: criterios-de-aceite
Ambiente: XAMPP em `http://127.0.0.1/mykeeper`

## Resultado geral

- Testes automatizados por HTTP nos controllers: 54 passaram, 0 falharam.
- Sintaxe validada em todos os controllers PHP e scripts JS.
- Microfone: validado por codigo. O teste real precisa ser manual no Chrome/Edge, em `localhost` ou HTTPS, permitindo o uso do microfone.

## Pontos retirados por pedido

- HU1/HU2: nao foi cobrada quantidade em produto cadastrado. Produto registrado fica com nome, categoria, unidade de medida e imagem.
- HU24: nao foi cobrada soma de quantidade no estoque. A conclusao de compras voltou a inserir novo item no estoque, duplicando quando ja existe.

## Correcoes feitas nesta revisao

- HU14: cadastro de suporte agora bloqueia e-mail duplicado e retorna JSON `nok`.
- HU16: edicao de suporte agora bloqueia e-mail duplicado e retorna JSON `nok`, sem erro 500.

## Cobertura revisada

| HU | Resultado | Observacao |
| --- | --- | --- |
| HU1 | Passou | Cadastro manual de produto sem quantidade no produto registrado. |
| HU2 | Passou | Listagem de produtos sem campo quantidade. |
| HU3 | Passou | Exclusao de produto sem vinculos. |
| HU4 | Passou | Edicao de produto e bloqueio de campos obrigatorios vazios. |
| HU5 | Passou | Cadastro de categoria e bloqueio de duplicidade. |
| HU6 | Passou | Cadastro de ticket e validacao de titulo/descricao. |
| HU7 | Passou | Usuario ve apenas seus tickets. |
| HU8 | Passou | Ticket aberto pode ser editado; respondido nao pode. |
| HU9 | Passou | Ticket aberto pode ser excluido; respondido nao pode. |
| HU10 | Passou | Suporte lista tickets. |
| HU11 | Passou | Suporte responde ticket; resposta vazia e bloqueada. |
| HU12 | Passou | Sem alteracao retorna mensagem de nenhuma alteracao. |
| HU13 | Passou | Senha administrativa correta/incorreta. |
| HU14 | Passou | Cadastro de suporte e bloqueio de e-mail duplicado. |
| HU15 | Passou | Listagem de suportes. |
| HU16 | Passou | Edicao de suporte e bloqueio de e-mail duplicado. |
| HU17 | Passou | Exclusao de conta de suporte diferente da logada. |
| HU18 | Passou com ressalva | Codigo protegido para navegadores sem SpeechRecognition; microfone real precisa teste manual no Chrome. |
| HU19 | Passou | Link publico de lista e erro para token invalido. |
| HU20 | Passou | Criacao de estoque e adicao de produto ao estoque. |
| HU21 | Passou | Lista arquivada nao pode ser modificada. |
| HU22 | Passou | Listagem de listas de compras. |
| HU23 | Passou | Adicao, bloqueio de duplicidade e remocao de item da lista. |
| HU24 | Passou no comportamento pedido | Conclusao da compra insere item no estoque sem somar duplicados. |
| HU25 | Passou | Receita cria com ingrediente; titulo vazio bloqueado. |
| HU26 | Passou | Receita retorna status de disponibilidade do estoque. |
| HU27 | Passou | Listagem de receitas. |
| HU28 | Passou | Link publico de receita e erro depois de remover. |
| HU29 | Passou | Receita removida com sucesso. |
| HU30 | Passou | Edicao de receita bloqueia titulo vazio. |
| HU31 | Passou | Login de suporte correto/incorreto. |
| HU32 | Passou | Criacao de lista e bloqueio de titulo vazio. |

## Comandos principais

```bash
curl -s -o /tmp/mykeeper_index.html -w '%{http_code}\n' http://127.0.0.1/mykeeper/
for f in src/Controllers/*.php; do /opt/lampp/bin/php -l "$f"; done
for f in public/js/*.js; do node --check "$f"; done
bash /tmp/mykeeper_acceptance.sh
```

Ultima bateria:

```text
SUMMARY|pass=54|fail=0|run=acc1779726775052463092
```
