# FreeEvents

Plataforma web para criação e participação em eventos. Usuários podem publicar eventos com data, endereço e itens, além de entrar em eventos de outros usuários, gerenciar solicitações de participação e organizar galerias de fotos.

## Funcionalidades

- **Eventos públicos e privados** — eventos privados confirmam presença automaticamente; eventos públicos exigem aprovação do organizador
- **Criação, edição e exclusão** de eventos com título, descrição, data, horário, endereço (busca por CEP) e lista de itens
- **Dashboard do usuário** — eventos criados e eventos em que participa
- **Gestão de solicitações** — aprovar, rejeitar ou aprovar todas as solicitações de participação
- **Página de informações** — lista de participantes com status de confirmação
- **Galeria de fotos** — upload de até 50 imagens por evento, exclusão individual ou total
- **Busca** de eventos por título
- **Status do evento** — Aberto, Hoje ou Fechado conforme a data
- **Link para Google Maps** com o endereço do evento
- Autenticação completa (Laravel Jetstream): registro, login, verificação de e-mail e autenticação de dois fatores

## Tecnologias

- PHP 8.1+
- Laravel 10
- Laravel Jetstream (Livewire)
- Laravel Sanctum
- MySQL
- Tailwind CSS
- Alpine.js
- Vite

## Requisitos

- PHP >= 8.1
- Composer
- Node.js e npm
- MySQL (ou banco compatível)

## Instalação

```bash
# Clonar o repositório
git clone git@github.com:renanaragao9/projetoEvento.git
cd projetoEvento

# Instalar dependências PHP
composer install

# Instalar dependências de front-end
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate
```

Configure as credenciais do banco de dados no arquivo `.env` e em seguida:

```bash
# Executar migrations
php artisan migrate

# Gerar assets de front-end
npm run build

# Iniciar o servidor
php artisan serve
```

Acesse a aplicação em `http://localhost:8000`.

## Banco de dados

### Tabelas principais

| Tabela       | Descrição                                               |
| ------------ | ------------------------------------------------------- |
| `users`      | Usuários (Jetstream, com suporte a 2FA)                 |
| `events`     | Eventos com título, descrição, endereço, data e itens   |
| `event_user` | Pivô entre usuários e eventos (confirmação de presença) |
| `galleries`  | Imagens da galeria de cada evento                       |

## Rotas principais

| Método | Rota                                      | Descrição                                   |
| ------ | ----------------------------------------- | ------------------------------------------- |
| GET    | `/`                                       | Home com lista e busca de eventos           |
| GET    | `/verEvento/{id}`                         | Página de detalhes do evento                |
| GET    | `/evento/criar`                           | Formulário de criação (autenticado)         |
| POST   | `/Criando`                                | Salvar novo evento                          |
| GET    | `/dashboard`                              | Eventos do usuário (criados e participando) |
| GET    | `/evento/editar/{id}`                     | Editar evento (somente dono)                |
| DELETE | `/evento/{id}`                            | Excluir evento                              |
| POST   | `/evento/unir/{id}`                       | Entrar no evento                            |
| DELETE | `/evento/sair/{id}`                       | Sair do evento                              |
| GET    | `/events/{id}/pending-requests`           | Solicitações pendentes (somente dono)       |
| POST   | `/events/{eventId}/approve/{userId}`      | Aprovar solicitação                         |
| POST   | `/events/{eventId}/reject/{userId}`       | Rejeitar solicitação                        |
| POST   | `/events/{eventId}/approveAllRequests`    | Aprovar todas as solicitações               |
| POST   | `/events/{event}/galleries`               | Enviar imagens para a galeria               |
| DELETE | `/gallery/images/{id}`                    | Excluir imagem da galeria                   |
| DELETE | `/gallery/event/delete-all/{eventFolder}` | Excluir toda a galeria do evento            |

## Estrutura de diretórios

```
app/
├── Http/Controllers/
│   ├── EventController.php    # CRUD de eventos, participação e solicitações
│   └── GalleryController.php  # Upload e exclusão de imagens da galeria
└── Models/
    ├── Event.php              # Evento (pertence a um usuário, muitos participantes)
    ├── Gallery.php            # Imagens da galeria
    └── User.php               # Usuário (Jetstream + relacionamentos)
resources/views/
├── events/                    # Views de eventos (create, show, edit, dashboard, etc.)
├── auth/                      # Views de autenticação (Jetstream)
└── layouts/                   # Layouts principais
```

## Testes

```bash
php artisan test
```
