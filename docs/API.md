# 🔌 Documentação API - AGROPAY Gateway Mozambique

## Base URL

```
Production: https://api.agropay.mz/api
Development: http://localhost:8000/api
```

## Autenticação

Todas as requisições requerem JWT Token no header:

```
Authorization: Bearer {token}
```

## Endpoints Principais

### Autenticação

#### Login
```
POST /auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password123"
}

Response 200:
{
  "success": true,
  "data": {
    "user": {...},
    "access_token": "eyJhbGc...",
    "refresh_token": "eyJhbGc...",
    "expires_in": 3600
  }
}
```

### Pagamentos

#### Criar Pagamento
```
POST /payments
Authorization: Bearer {token}
Content-Type: application/json

{
  "amount": 5000,
  "currency": "MZN",
  "method": "mpesa",
  "phone": "+258123456789",
  "reference": "ORDER-001"
}

Response 201:
{
  "success": true,
  "data": {
    "id": "pay_123456",
    "status": "pending",
    "amount": 5000,
    "checkout_url": "https://checkout.agropay.mz/pay_123456"
  }
}
```

#### Obter Status
```
GET /payments/{payment_id}
Authorization: Bearer {token}

Response 200:
{
  "success": true,
  "data": {
    "id": "pay_123456",
    "status": "completed",
    "amount": 5000
  }
}
```

## Códigos de Erro

```
200 - OK
201 - Created
400 - Bad Request
401 - Unauthorized
403 - Forbidden
404 - Not Found
422 - Unprocessable Entity
429 - Too Many Requests
500 - Internal Server Error
```
