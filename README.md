# Laravel 9 API

Base API with versioning. Filter data based on query string:

  HTTP usage:
  ```
  GET: /api/v1/customers?postalCode[gt]=30000&type[eq]=I&includeInvoices=true
  POST: /api/v1/customers
  ```

## Quickstart
1. Clone repository
2. Fill .env values
3. Run migrations `php artisan migrate:fresh --seed`
4. When making request set `Content-Type` & `Accept` to `application/json`