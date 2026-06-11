# Web Template Studio

Laravel app độc lập cho nền tảng dịch vụ web, code, app, SEO và hỗ trợ kỹ thuật. Website ưu tiên funnel tư vấn/báo giá cho cá nhân, shop nhỏ, sinh viên, khách cần sửa website và doanh nghiệp nhỏ; template và demo project được dùng như trust asset để khách xem trước năng lực triển khai.

## Stack

- Laravel 13
- PHP 8.4 local, tương thích PHP 8.5 khi runtime nâng cấp
- SQLite local mặc định, có thể đổi sang MySQL/PostgreSQL qua `.env`
- Blade + TailwindCSS + Vite
- Auth/admin tối giản bằng `users.is_admin`

## Setup Local

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
npm install
npm run build
php artisan serve --host=127.0.0.1 --port=8010
```

Admin seed mặc định:

- Email: `admin@example.com`
- Password: `password`

## Public Routes

- `GET /`
- `GET /services`
- `GET /portfolio`
- `GET /portfolio/{slug}`
- `GET /templates`
- `GET /templates/{slug}`
- `GET /blog`
- `GET /blog/{slug}`
- `GET /sitemap.xml`
- `GET /robots.txt`

## Service Positioning

- Dịch vụ cốt lõi:
  - SEO website
  - fix và chỉnh sửa giao diện website
  - tạo website và landing page
  - hỗ trợ đồ án sinh viên
  - nhận làm task lập trình nhỏ
- Module `templates` và `demo projects` hiện được giữ lại để hỗ trợ conversion:
  - cho khách xem demo/mẫu trước
  - chứng minh năng lực thực thi
  - giúp khách đánh giá mức độ phù hợp trước khi gửi yêu cầu
- Chuỗi service-platform cốt lõi đã bao gồm service catalog, portfolio/case study, feedback, admin lead workflow, blog pillars, technical SEO và mobile conversion polish.
- Chuỗi landing-page/UI agency-grade cũng đã hoàn tất: hero 2 cột kiểu agency, problem-solution storytelling, service/portfolio showcase, feedback carousel, tech marquee, visual system mới, rotating media và conversion polish.
- Quick-contact layer hiện dùng floating icons cố định góc phải dưới cho Zalo/Facebook/Email; footer cũng đã được tăng nhấn mạnh để giữ contact/CTA rõ ở cuối trang.
Form public:

- `POST /orders`
- `POST /quote-requests`
- `POST /graduation-project-requests`
- `POST /contact-messages`

Admin:

- `GET /admin`
- `GET|POST /admin/marketplace/services`
- `PATCH /admin/marketplace/services/{service}`
- `GET|POST /admin/marketplace/templates`
- `GET /admin/marketplace/orders`
- `PATCH /admin/marketplace/orders/{order}`
- `GET /admin/marketplace/quotes`
- `PATCH /admin/marketplace/quotes/{quote}`
- `GET /admin/marketplace/graduation-requests`
- `PATCH /admin/marketplace/graduation-requests/{request}`
- `GET /admin/marketplace/customers`
- `PATCH /admin/marketplace/customers/{customer}`
- `GET /admin/marketplace/contacts`
- `PATCH /admin/marketplace/contacts/{message}`
- `GET|POST /admin/marketplace/blog-posts`
- `GET|POST /admin/marketplace/demo-projects`
- `GET|POST /admin/marketplace/testimonials`

## Environment

```env
APP_NAME="Web Template Studio"
DB_CONNECTION=sqlite
DB_DATABASE=database/seo_web.sqlite
CONTACT_ZALO_URL=https://zalo.me/0000000000
CONTACT_FACEBOOK_URL=https://facebook.com
CONTACT_EMAIL=hello@example.com
MAIL_MAILER=log
```

## Validation

```bash
composer dump-autoload --ignore-platform-req=php
php artisan migrate --force
php artisan test
npm run build
vendor/bin/pint
```
