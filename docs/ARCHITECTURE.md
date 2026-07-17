# 🏗️ Arquitetura - AGROPAY Gateway Mozambique

## Visão Geral

O projeto segue **Clean Architecture** com separação clara de responsabilidades:

```
Presentation Layer (Controllers, Requests, Resources)
        ↓
Application Layer (Services, DTOs, Events)
        ↓
Domain Layer (Models, Interfaces, Business Logic)
        ↓
Infrastructure Layer (Repositories, Drivers, Database)
```

## Estrutura Backend (Laravel)

### Controllers
Responsáveis por receber requisições e retornar respostas.

```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php
│   ├── RegisterController.php
│   └── LogoutController.php
├── Payment/
│   ├── PaymentController.php
│   ├── RefundController.php
│   └── WebhookController.php
├── Merchant/
│   ├── MerchantController.php
│   ├── ApiKeyController.php
│   └── DashboardController.php
└── Admin/
    ├── UserController.php
    ├── MerchantController.php
    └── ReportController.php
```

## Fluxo de Pagamento

```
1. Cliente → Merchant Site
   ↓
2. Merchant → Criar Link de Pagamento (API)
   ↓
3. Cliente → Checkout AGROPAY
   ↓
4. AGROPAY → Selecionar Gateway (M-Pesa, e-Mola, etc)
   ↓
5. Cliente → Processar Pagamento
   ↓
6. Gateway → AGROPAY (Notificação)
   ↓
7. AGROPAY → Atualizar Status
   ↓
8. AGROPAY → Webhook para Merchant
   ↓
9. Merchant → Confirmar Pedido
```

## SOLID Principles

✅ **Single Responsibility** - Cada classe tem uma responsabilidade
✅ **Open/Closed** - Aberta para extensão (novos gateways)
✅ **Liskov Substitution** - Implementações intercambiáveis
✅ **Interface Segregation** - Interfaces específicas
✅ **Dependency Inversion** - Injeção de dependências
