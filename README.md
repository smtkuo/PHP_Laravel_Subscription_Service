# Laravel Subscription Service

## Başlarken

Bu talimatlar, projeyi yerel makinenizde geliştirme ve test amaçlarıyla çalıştırmanız için bir kopyasını alıp kurmanıza yardımcı olacaktır. Daha fazla detay için lütfen ilerleyin.

### Ön Koşullar

Laravel projenizi yerel makinenizde çalıştırabilmek için aşağıdaki araçlara ihtiyacınız olacak:

```
PHP >= 8.0
Composer
Veritabanı (MySQL, PostgreSQL, SQLite, vb.)
```

### Yükleme

Aşağıdaki adımlar, yerel makinenizde nasıl çalıştırılacağını açıklar:

1. Projeyi klonlayın:

```bash
git clone https://github.com/smtkuo/PHP_Laravel_Subscription_Service.git
```

2. Bağımlılıkları yükleyin:

```bash
cd PHP_Laravel_Subscription_Service
composer install
```

3. `.env` dosyasını oluşturun ve düzenleyin:

```bash
cp .env.example .env
```

Bu dosyayı açın ve veritabanı ayarlarınızı yapın.

4. Uygulama anahtarını oluşturun:

```bash
php artisan key:generate
```

5. Veritabanını ayarlayın ve göç edin:

```bash
php artisan migrate
```

6. Sunucuyu başlatın:

```bash
php artisan serve
```

Projeyi tarayıcınızda `http://localhost:8000` adresinde görüntüleyebilirsiniz.

## Testlerin Çalıştırılması

php artisan test

# Postman Collection: 2023_07_23_121717_laravel_collection.json

This repository contains a Postman collection for the API endpoints of the project. The Postman collection file is `2023_07_23_121717_laravel_collection.json.json`.

## Collection Variables

The following variables are used in this collection:

- `base_url`: http://localhost


## Requests

The collection contains the following requests:


### api/register

- Method: POST
- URL: {{base_url}}/api/register

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `name`: `None`
- `email`: `None`
- `password`: `None`


### api/login

- Method: POST
- URL: {{base_url}}/api/login

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `email`: `None`
- `password`: `None`


### api/logout

- Method: POST
- URL: {{base_url}}/api/logout

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters


### api/user/{id}/subscription

- Method: POST
- URL: {{base_url}}/api/user/:id/subscription

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `subscription_type_id`: `None`
- `renewed_at`: `None`
- `expired_at`: `None`


### api/user/{userId}/subscription/{subscriptionId}

- Method: PUT
- URL: {{base_url}}/api/user/:userId/subscription/:subscriptionId

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `subscription_type_id`: `None`
- `renewed_at`: `None`
- `expired_at`: `None`


### api/user/{id}/subscription

- Method: DELETE
- URL: {{base_url}}/api/user/:id/subscription

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters


### api/user/{id}/transaction

- Method: POST
- URL: {{base_url}}/api/user/:id/transaction

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `subscription_id`: `None`
- `price`: `None`


### api/user/{id}

- Method: GET
- URL: {{base_url}}/api/user/:id

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters


### api/subscription-types

- Method: GET
- URL: {{base_url}}/api/subscription-types

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters


### api/subscription-types

- Method: POST
- URL: {{base_url}}/api/subscription-types

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `name`: `None`
- `price`: `None`
- `duration`: `None`
- `details`: `None`


### api/subscription-types/{subscription_type}

- Method: GET
- URL: {{base_url}}/api/subscription-types/{subscription_type}

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters


### api/subscription-types/{subscription_type}

- Method: PUT
- URL: {{base_url}}/api/subscription-types/{subscription_type}

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `name`: `None`
- `price`: `None`
- `duration`: `None`
- `details`: `None`


### api/subscription-types/{subscription_type}

- Method: PATCH
- URL: {{base_url}}/api/subscription-types/{subscription_type}

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

- `name`: `None`
- `price`: `None`
- `duration`: `None`
- `details`: `None`


### api/subscription-types/{subscription_type}

- Method: DELETE
- URL: {{base_url}}/api/subscription-types/{subscription_type}

Headers:

- `Accept`: `application/json`
- `Content-Type`: `application/json`

Body Parameters (if any):

No body parameters

## Artisan Commands

The application provides several artisan commands for managing subscriptions:

1. `php artisan subscription:create {userId} {subscriptionTypeId}`: This command creates a new subscription for a user.
2. `php artisan subscription:delete {subscriptionId}`: This command deletes a subscription.
3. `php artisan subscription:renew {subscriptionId}`: This command renews a subscription.
4. `php artisan subscription:update {subscriptionId} {renewedAt} {expiredAt} {subscriptionTypeId}`: This command updates a subscription.

Remember to replace the placeholders (`{userId}`, `{subscriptionTypeId}`, `{subscriptionId}`, `{renewedAt}`, `{expiredAt}`) with actual values when running these commands.

## Background Jobs

The application uses background jobs for tasks that can be processed in the background. One such job is the `RenewSubscriptionsJob`.

The `RenewSubscriptionsJob` is responsible for renewing subscriptions that are due for renewal. It does this by using the `SubscriptionService` to get all subscriptions due for renewal and renewing them. The renewal is done by calling the `update` method of the `SubscriptionService`, passing the `user_id`, `id` (subscription ID), current time (`Carbon::now()`), and the time one month from now (`Carbon::now()->addMonth()`) as parameters.