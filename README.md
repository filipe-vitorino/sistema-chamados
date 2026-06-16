# SISTEMA DE CONTROLE DE CHAMADOS INTERNOS

Sistema web para gerenciamento de chamados internos desenvolvido como desafio técnico para a Codificar Sistemas Tecnológicos.

---

# ÍNDICE

- Sobre o projeto
- Stack tecnológica e decisões arquiteturais
- Funcionalidades implementadas
- Requisitos
- Instalação e execução
- Executando os testes
- Estrutura do projeto
- Trade-offs e decisões de projeto

---

# SOBRE O PROJETO

Uma empresa precisava substituir cadernos e mensagens avulsas por um sistema centralizado onde funcionários pudessem abrir chamados (suporte técnico, pedidos de equipamentos etc.) e a equipe de suporte pudesse acompanhar, distribuir e resolver essas demandas de forma organizada.

---

# STACK TECNOLÓGICA E DECISÕES ARQUITETURAIS

| Camada         | Tecnologia                       | Justificativa                                                                                                                                                                                                                                                                                                                                                                                            |
| -------------- | -------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Backend        | Laravel 11 (PHP 8.2 ou superior) | Framework robusto com convenções sólidas, ORM expressivo (Eloquent) e ecossistema maduro. Reduz drasticamente o atrito de desenvolvimento em times pequenos.                                                                                                                                                                                                                                             |
| Frontend       | Blade + Bootstrap 5              | O Blade elimina o atrito entre o backend e o frontend, cortando a complexidade de gerenciar estados duplicados ou builds pesados de SPAs. O Bootstrap 5 foi escolhido estrategicamente por fornecer componentes estruturais e visuais prontos para uso (como modais, menus responsivos, botões e formulários estruturados), garantindo agilidade no desenvolvimento de um dashboard limpo e corporativo. |
| Banco de Dados | SQLite                           | Configuração zero de servidores para homologação local. Perfeito para o escopo do desafio; a migração para MySQL ou PostgreSQL exige apenas a alteração de variáveis simples no arquivo de ambiente (`.env`).                                                                                                                                                                                            |
| Assets         | Vite                             | Bundler padrão do ecossistema moderno do Laravel, oferecendo compilação rápida e hot-reload em tempo de desenvolvimento.                                                                                                                                                                                                                                                                                 |
| Testes         | PHPUnit 11                       | Totalmente integrado ao framework Laravel, permitindo a execução de testes automatizados unitários e de integração utilizando uma base de dados SQLite isolada em memória (`:memory:`).                                                                                                                                                                                                                  |

## Por que Blade e Bootstrap em vez de SPAs ou Tailwind?

O escopo do projeto ressalta que a produtividade e o foco em fundamentos importam muito mais do que a adição de recursos secundários pesados. Para uma aplicação baseada em operações CRUD como esta, a combinação de Blade com Bootstrap entrega uma interface altamente profissional, ágil e responsiva sem o overhead técnico e o tempo gasto configurando folhas de estilo utilitárias do zero ou mantendo uma API REST separada para alimentar um frontend em Vue/React.

## Aplicação de DRY, SOLID e Componentização

### 1. Princípio DRY (Don't Repeat Yourself)

Evitamos a repetição desnecessária de código tanto na camada visual quanto na lógica.

No frontend, aplicamos a Herança de Templates através do arquivo base:

```text
layouts/app.blade.php
```

No backend, regras complexas como a de identificar o técnico ideal foram encapsuladas estritamente no método:

```php
Responsavel::obterMenosOcupado()
```

sendo reutilizadas onde necessário.

### 2. Princípios SOLID (Responsabilidade Única)

Estruturamos o código utilizando o padrão MVC de forma rígida.

Mantivemos controladores limpos e enxutos (_Thin Controllers_), delegando validações formais de requisições HTTP às rotas adequadas e deixando que os Models cuidem ativamente das regras de negócio e filtros dinâmicos de dados (_Fat Models_).

## Definição de "chamado em aberto"

Para fins da distribuição inteligente e do bloqueio preventivo de desativação de técnicos, consideramos demandas ativas aquelas que possuem o status definido como:

- `aberto`
- `em_andamento`

Chamados classificados como `resolvido` entram no fluxo de concluídos e deixam de somar pontos na carga de trabalho.

---

# FUNCIONALIDADES IMPLEMENTADAS

- Cadastro completo de chamados contendo título, descrição, prioridade (baixa, média, alta), status e técnico responsável.
- Distribuição automática inteligente que identifica em tempo real qual profissional ativo possui o menor volume de demandas pendentes na fila.
- Edição de chamados com atualização instantânea de status e reatribuição de responsáveis.
- Histórico de alterações estruturado que registra de forma automatizada no banco de dados todas as movimentações de status e troca de responsáveis.
- Listagem geral enriquecida com filtros simultâneos combinando status, níveis de prioridade e técnicos.
- Gestão de responsáveis contendo listagem de profissionais, inserção automática e sistema de ativação/desativação (Toggle).
- Proteção de desativação que impede a inativação de um técnico de suporte que possua chamados ativos em sua fila.
- Rastreamento completo de chamados anteriores que mapeia o histórico de movimentações e exibe, no perfil do técnico, todos os chamados em que ele trabalhou no passado.

---

# REQUISITOS

- PHP >= 8.2
- Composer
- Node.js >= 18
- NPM

O sistema utiliza a tecnologia SQLite, dispensando qualquer instalação ou configuração manual de servidores de banco de dados externos.

---

# INSTALAÇÃO E EXECUÇÃO

Siga as etapas abaixo para configurar o ecossistema localmente.

## 1. Clone o repositório do projeto

```bash
git clone https://github.com/filipe-vitorino/sistema-chamados.git

cd sistema-chamados
```

## 2. Instale as dependências de backend e frontend

```bash
composer install

npm install
```

## 3. Configure o arquivo de ambiente

```bash
cp .env.example .env

php artisan key:generate
```

**Nota:** Certifique-se de que o arquivo `.env` gerado esteja com a variável `DB_CONNECTION=sqlite`.

## 4. Execute as migrações e popule o banco de dados

```bash
php artisan migrate:fresh --seed
```

O Seeder integrado cria automaticamente os técnicos exigidos pela especificação e uma massa de chamados fictícios distribuídos.

## 5. Compile os recursos visuais

```bash
npm run build
```

## 6. Inicie o servidor embutido do Laravel

```bash
php artisan serve
```

Abra o navegador e acesse:

```text
http://localhost:8000
```

---

# EXECUTANDO OS TESTES

Para rodar toda a suíte automatizada de verificação de comportamento:

```bash
php artisan test
```

A arquitetura de testes utiliza um banco de dados SQLite simulado estritamente em memória (`:memory:`), garantindo execuções rápidas e prevenindo alterações indesejadas na base principal.

## Ajustes Técnicos de Infraestrutura de Testes

O projeto adota o PHPUnit 11 (padrão nativo do Laravel 11).

Implementamos correções de infraestrutura nos testes para garantir compatibilidade com o Windows:

1. Ativação de Attribute Casting (`protected $casts`) no Model `Responsavel` para converter os retornos numéricos do SQLite em booleanos nativos.
2. Substituição de geradores de texto físicos (`realText`) no `ChamadoFactory` por métodos em memória RAM (`text`), eliminando falhas de Segmentation Fault.

## Cobertura da Suite de Testes Automatizados

### Testes Unitários (`tests/Unit/`)

#### ResponsavelTest.php

Valida:

- O comportamento lógico da regra de negócio que encontra o técnico menos ocupado (`obterMenosOcupado`)
- O mecanismo de resgate de projetos passados (`chamadosAnteriores`)
- Ignorar responsáveis inativos e chamados resolvidos
- Relacionamentos

#### ChamadoTest.php

Valida:

- A integridade da estrutura do chamado
- Relacionamento com responsável
- Relacionamento com histórico

### Testes de Integração (`tests/Feature/`)

#### ChamadoControllerTest.php

Valida:

- Carregamento da tela de listagem
- Validação obrigatória de campos
- Criação de chamados
- Geração automática de histórico
- Atualização de status
- Auditoria de alterações

#### ResponsavelControllerTest.php

Valida:

- Exibição da lista de responsáveis
- Carregamento da fila individual
- Funcionamento do filtro de projetos anteriores
- Bloqueio de desativação para responsáveis com pendências
- Desativação permitida para responsáveis sem chamados atribuídos

---

# ESTRUTURA DO PROJETO

```text
app/
├── Http/Controllers/
│   ├── ChamadoController.php
│   └── ResponsavelController.php
├── Models/
│   ├── Chamado.php
│   ├── Responsavel.php
│   └── HistoricoChamado.php

database/
├── migrations/
├── factories/
└── seeders/

resources/views/
├── layouts/app.blade.php
├── chamados/
└── responsaveis/

routes/
└── web.php

tests/
├── Unit/
└── Feature/
```

---

# TRADE-OFFS E DECISÕES DE PROJETO

## Autenticação não implementada

O escopo inicial foca na resolução do problema de distribuição e rastreabilidade interna de tarefas.

Em um ambiente real de produção, o incremento imediato seria a integração com ferramentas como o Laravel Breeze.

## Nome de responsável automatizado no cadastro rápido

O documento exigia a flexibilidade de selecionar técnicos e gerenciar seu estado, sem obrigatoriedade de formulários completos.

Para otimizar a fluidez, a criação gera nomes utilizando fakers em memória.

## Uso do SQLite

Escolhido para tornar a avaliação do código imediata e livre de fricções com ferramentas extras de infraestrutura (como Docker ou servidores locais de banco), mantendo os arquivos portáteis.

## Sem paginação na listagem

Dado o escopo de um desafio focado em monitoramento ágil de equipes enxutas, a exibição de painéis filtráveis atendeu as regras propostas sem a complexidade extra de sistemas de paginação.
