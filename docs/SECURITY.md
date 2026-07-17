# 🔐 Guia de Segurança - AGROPAY Gateway Mozambique

## Princípios de Segurança

1. **Defense in Depth** - Múltiplas camadas de proteção
2. **Least Privilege** - Acesso mínimo necessário
3. **Secure by Default** - Configurações seguras por padrão
4. **Zero Trust** - Validação de todas requisições
5. **Encryption Everywhere** - Dados criptografados em trânsito e repouso

## Autenticação

### JWT (JSON Web Tokens)

```php
// Geração
$token = JWT::encode([
    'user_id' => $user->id,
    'email' => $user->email,
    'exp' => now()->addHours(24)->timestamp
], config('jwt.secret'), 'HS256');
```

### 2FA (Autenticação em Dois Fatores)

```php
// Habilitar 2FA
Auth::user()->enableTwoFactor();

// Validar código
Auth::user()->validateTwoFactorCode($code);
```

## Criptografia

### AES-256-CBC

```php
// Criptografar
$encrypted = Crypt::encryptString($data);

// Descriptografar
$decrypted = Crypt::decryptString($encrypted);
```

## Rate Limiting

```php
// Middleware
Route::middleware('throttle:60,1')->group(function () {
    Route::post('/payments', [PaymentController::class, 'store']);
});
```

## Headers de Segurança

```nginx
# HTTPS
add_header Strict-Transport-Security "max-age=31536000" always;

# X-Frame-Options
add_header X-Frame-Options "DENY" always;

# X-Content-Type-Options
add_header X-Content-Type-Options "nosniff" always;
```

## Boas Práticas

✅ Validar TUDO na entrada
✅ Escapar TUDO na saída
✅ Usar prepared statements
✅ Implementar rate limiting
✅ Logar eventos sensíveis
✅ Monitorar atividades suspeitas
✅ Fazer backup regularmente
