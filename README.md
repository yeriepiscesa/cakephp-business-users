# BusinessUsers

Plugin ini menambahkan layer business access control di atas `CakeDC/Users` untuk kebutuhan multi-tenant B2B/B2B2C di domain flight booking.

Fokus domain saat ini:

- tenant bisnis
- membership user per tenant
- group dan role per tenant
- module dan permission
- assignment role/group/module/permission ke tenant user
- audit trail perubahan model melalui `AuditStash`

Plugin ini berisi domain business access control beserta template admin bawaannya. Layout admin dan asset CSS/JS dipasok oleh plugin theme aktif (default: Uikit) lewat konfigurasi `BusinessUsers.theme`. Template dapat di-override di theme jika framework CSS berbeda.

Selain model ORM dan admin CRUD, plugin ini sekarang juga memiliki jalur clean architecture untuk endpoint bisnis non-CRUD:

- `Application/` untuk DTO dan use case
- `Domain/` untuk enum dan kontrak repository
- `Infrastructure/` untuk implementasi repository berbasis CakePHP ORM
- `Controller/Api/` untuk interface layer REST API plugin

## Daftar Isi

1. [Instalasi](#instalasi)
2. [Konfigurasi](#konfigurasi)
3. [Migration & Seed](#migration--seed)
4. [Struktur Ringkas](#struktur-ringkas)
5. [Admin CRUD](#admin-crud)
6. [REST API](#rest-api)
7. [Testing](#testing)

## Instalasi

### 1. Composer

Pastikan host application sudah memiliki `cakephp/plugin-installer`.

```bash
composer require yeriepiscesa/cakephp-business-users
```

Atau via repository GitHub:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/yeriepiscesa/cakephp-business-users"
        }
    ],
    "require": {
        "yeriepiscesa/cakephp-business-users": "dev-main"
    }
}
```

Dependency Composer plugin ini sudah mencakup: `cakedc/users`, `friendsofcake/crud`, `friendsofcake/search`, `dereuromark/cakephp-audit-stash`, `cakephp/migrations`, `halaxa/json-machine`.

Disarankan tambahan:

```bash
composer require yeriepiscesa/cakephp-uikit
```

### 2. Load plugin

#### Prinsip umum — hindari duplikasi

Beberapa plugin dependensi **tidak** perlu (dan **tidak boleh**) didaftarkan dua kali di `config/plugins.php`. BusinessUsers mem-load `CakeDC/Users` otomatis di `BusinessUsersPlugin::bootstrap()` jika plugin tersebut belum terdaftar.

| Plugin | Siapa yang load | Daftar di `config/plugins.php`? |
|---|---|---|
| `CakeDC/Users` | **BusinessUsers** (otomatis) | **Jangan** — kecuali BusinessUsers tidak dipakai |
| `Crud`, `Search`, `AuditStash`, `Migrations` | Host application | **Ya** |
| `CrudConnect` | Host application | **Ya** — admin CRUD extends base controller plugin ini |
| `Uikit` | Host application | **Ya** (disarankan) |
| `BusinessUsers` | Host application | **Ya** |

Menambahkan `'CakeDC/Users' => []` **dan** `'BusinessUsers' => []` bersamaan dapat menyebabkan plugin ter-bootstrap dua kali atau konfigurasi `Users.config` bentrok.

#### Contoh `config/plugins.php` — BusinessUsers saja

```php
return [
    'Migrations' => ['onlyCli' => true],
    'Crud' => [],
    'Search' => [],
    'AuditStash' => [],
    'CrudConnect' => [],
    'Uikit' => [],           // disarankan untuk layout admin
    'BusinessUsers' => [],
];
```

#### Contoh `config/plugins.php` — BusinessUsers + FileManager + Uikit

Gunakan konfigurasi ini bila project memakai keduanya. Perhatikan: **`CakeDC/Users` tidak ada** di daftar — BusinessUsers yang mem-load-nya.

```php
return [
    'Migrations' => ['onlyCli' => true],
    'Crud' => [],
    'Search' => [],
    'Josegonzalez/Upload' => [],
    'AuditStash' => [],
    'CrudConnect' => [],
    'Uikit' => [],
    'BusinessUsers' => [],   // mem-load CakeDC/Users otomatis
    'FileManager' => [],    // load setelah BusinessUsers
];
```

#### Urutan load

Urutan entri di array menentukan urutan bootstrap. Ikuti aturan ini:

1. `Crud`, `Search` — dasar CRUD dan filter
2. `AuditStash`, `Migrations` — audit log dan migration CLI
3. `CrudConnect` — base controller admin/API
4. `Josegonzalez/Upload` — hanya jika memakai FileManager
5. `Uikit` — theme/layout admin
6. `BusinessUsers` — identitas, RBAC, multi-tenant (mem-load `CakeDC/Users`)
7. `FileManager` — **setelah** BusinessUsers agar port `TenantUserRepositoryInterface` sudah terdaftar saat wiring DI FileManager
8. Plugin domain aplikasi (mis. `FlightBooking`, `Cms`)

#### Anti-pattern (hindari)

```php
// ❌ JANGAN — CakeDC/Users ter-load dua kali saat BusinessUsers bootstrap
'CakeDC/Users' => [],
'BusinessUsers' => [],
'FileManager' => [],
```

#### Checklist cepat saat menambah plugin lain

- Plugin consumer (mis. FileManager) cukup didaftarkan **setelah** BusinessUsers; jangan ulangi dependensi yang sudah di-load otomatis.
- Jika plugin lain README-nya menyebut `'CakeDC/Users' => []`, abaikan baris itu bila BusinessUsers sudah dipakai.
- Pastikan `CrudConnect` terdaftar sebelum BusinessUsers/FileManager jika admin CRUD memakai base controller bersama.

### 3. Prasyarat host

| Prasyarat | Keterangan |
|---|---|
| UUID di `users.id` | Wajib — relasi tenant user memakai UUID CakeDC/Users |
| `AuditStash` plugin | Wajib — semua Table BusinessUsers memakai behavior audit |
| Base `CrudController` | Wajib — admin CRUD extends `CrudConnect\Controller\CrudController` |
| Base `ApiController` | Wajib untuk REST API — plugin wrapper extends `CrudConnect\Controller\ApiController` |
| Git LFS | Wajib untuk clone/pull data geo — jalankan `git lfs install` sebelum pull |

### UsersTable (CakeDC/Users)

Plugin menyediakan `BusinessUsers\Model\Table\UsersTable` sebagai perpanjangan CakeDC Users (email-as-username). Konfigurasi CakeDC/Users ada di `plugins/BusinessUsers/config/users.php` dan dimuat otomatis via `Users.config`:

```php
'table' => 'BusinessUsers.Users',
```

Alias `Users` dan `CakeDC/Users.Users` akan resolve ke class plugin sehingga auth, tenant user, dan admin user form tetap berfungsi tanpa ubah kode lain.

Admin CRUD users (`/admin/users/*`) disediakan oleh `BusinessUsers\Controller\Admin\UsersController` yang extends CakeDC Users. Template default ada di `plugins/BusinessUsers/templates/Admin/Users/`; override theme di `plugins/<Theme>/templates/plugin/BusinessUsers/Admin/Users/` bila diperlukan.

### Konfigurasi CakeDC/Users & RBAC

| File plugin | Isi |
|---|---|
| `config/users.php` | Auth, registration, OAuth, RememberMe, dll. |
| `config/permissions.php` | Rule bypass login/register dan admin role |

Host application cukup menyimpan `config/permissions.php` tipis untuk rule khusus app (Pages, DebugKit, CMS, dll.). Keduanya di-merge via `Auth.RbacPolicy.autoload_config`.

Override opsional host:

```php
// config/bootstrap.php atau sebelum plugin load
Configure::write('Users.config', ['my_users_override']);
```

## Konfigurasi

Tambahkan ke `config/app.php` atau `config/app_local.php`:

```php
'BusinessUsers' => [
    // Nama plugin theme untuk layout admin (default: Uikit)
    'theme' => env('BUSINESS_USERS_THEME', 'Uikit'),
],
```

### Audit log UUID (host application)

Karena BusinessUsers memakai UUID untuk relasi identity, kolom `audit_logs.primary_key` di host harus kompatibel (string 36 char). Buat migration di **host app** (bukan di plugin):

```php
$this->table('audit_logs')
    ->changeColumn('primary_key', 'string', [
        'default' => null,
        'limit' => 36,
        'null' => true,
    ])
    ->update();
```

Jalankan migration host **sebelum atau sesudah** migration plugin BusinessUsers.

## Migration & Seed

### Migration plugin

```bash
bin/cake migrations migrate --plugin BusinessUsers
```

Cek status:

```bash
bin/cake migrations status --plugin BusinessUsers
```

Rollback satu step bila diperlukan:

```bash
bin/cake migrations rollback --plugin BusinessUsers
```

### Seed contoh data (opsional)

```bash
bin/cake migrations seed --plugin BusinessUsers --seed BusinessUsersTenantGroupRoleSeed
```

Seed mengisi contoh tenant, group, dan role untuk skenario provider, agent, dan end-user.

### Seed data geografis (Countries / States / Cities)

Data geo (~36MB JSON) disimpan di `config/data/countries+states+cities.json` (Git LFS). Pastikan Git LFS terpasang:

```bash
git lfs install
git lfs pull
```

Jalankan seed berurutan:

```bash
bin/cake migrations seed --plugin BusinessUsers --seed CountriesSeed
bin/cake migrations seed --plugin BusinessUsers --seed StatesSeed
bin/cake migrations seed --plugin BusinessUsers --seed CitiesSeed
```

Fallback kecil tersedia di `config/data/countries.sql` untuk referensi manual.

### Verifikasi cepat

```bash
bin/cake routes check /admin/business-users/tenants
bin/cake routes check /api/business-users/v1/roles
bin/cake routes check /api/business-users/v1/roles/enums
```

## Struktur Ringkas

```text
plugins/BusinessUsers/
|- config/
|  |- Migrations/
|  |- Seeds/
|  |- users.php
|  |- permissions.php
|  `- data/
|     |- countries+states+cities.json
|     `- countries.sql
|- src/
|  |- Application/
|  |- Domain/
|  |- Infrastructure/
|  |- Controller/Api/
|  |- Model/Entity/
|  |- Model/Table/
|  `- BusinessUsersPlugin.php
|- templates/
|  `- Admin/
|     |- Tenants/
|     |- Modules/
|     |- Permissions/
|     |- Groups/
|     |- Roles/
|     `- TenantUsers/
|- tests/
|  |- Fixture/
|  `- TestCase/Model/Table/
`- README.md
```

## Geographic Lookup Data

Plugin menyediakan model ORM untuk lookup geografis global:

- `countries` — `BusinessUsers.Countries`
- `states` — `BusinessUsers.States`
- `cities` — `BusinessUsers.Cities`

Admin CRUD untuk geo lookup tersedia di `/admin/business-users/countries`, `/admin/business-users/states`, dan `/admin/business-users/cities`. Menu **Regions** (Countries, States, Cities) hanya ditampilkan untuk superadmin (`users.role = superuser` atau `is_superuser = 1`). Consumer plugin lain (mis. FlightBooking Airports) tetap memakai lookup Cities/States/Countries tanpa akses CRUD penuh.

`CountriesTable` dan `StatesTable` memiliki finder `lookup()` untuk autocomplete (tom_select). `CitiesTable` memiliki finder `lookup()` dengan contain `States → Countries`. Plugin **tidak** bergantung ke domain host; relasi `Airports belongsTo Cities` didefinisikan di aplikasi host.

Migration geo (`CreateCountries`, `CreateStates`, `CreateCities`) ikut di `--plugin BusinessUsers`. Environment yang sudah menjalankan migration geo di app level tidak perlu re-run.

## Dependensi dan Integrasi

- Identity utama tetap dari `CakeDC/Users` melalui `users.id` bertipe UUID. Plugin ini mem-load `CakeDC/Users` otomatis — jangan daftarkan ulang di `config/plugins.php` (lihat [Load plugin](#2-load-plugin)).
- Plugin consumer seperti **FileManager** cukup didaftarkan setelah BusinessUsers; FileManager mendeteksi keberadaan BusinessUsers saat wiring DI, bukan saat bootstrap.
- Audit model memakai `AuditStash.AuditLog` pada Table classes BusinessUsers.
- Karena `BusinessUsers` memakai UUID untuk identity relation, host application perlu migration `audit_logs.primary_key` ke string UUID (lihat [Konfigurasi](#konfigurasi)).
- Endpoint REST API plugin memakai base controller bersama dari plugin `CrudConnect` (`CrudConnect\Controller\ApiController`). Plugin menyediakan wrapper `BusinessUsers\Controller\ApiController` untuk namespacing lokal.
- Form admin add/edit user di `CakeDC/Users` memakai lookup role dari enum `BusinessUsers\Domain\Enum\UserRole`, sehingga pilihan role aplikasi tersentralisasi.
- Test plugin bergantung pada bootstrap root app yang menjalankan migration `CakeDC/Users` dan `BusinessUsers` ke SQLite test database.
- Test plugin memakai fixture lokal `tests/Fixture/UsersFixture.php` karena fixture vendor `CakeDC/Users` tidak langsung dipakai oleh suite app.

## Clean Architecture Slice

Bagian ini dipakai untuk kebutuhan bisnis yang tidak cocok dimodelkan sebagai CRUD controller tipis saja.

### Application

- `DTO/RoleData` - representasi role yang bebas dari entity ORM
- `DTO/TenantData` - representasi tenant
- `DTO/GroupData` - representasi group
- `DTO/TenantMembershipData` - agregat membership user dalam satu tenant, termasuk tenant, groups, dan roles
- `UseCase/GetRoles/*` - use case untuk listing role business users
- `UseCase/GetUserBusinessProfile/*` - use case untuk mengambil profil bisnis user lintas tenant

### Domain

- `Enum/UserRole` - role level aplikasi untuk kolom `users.role`
- `Enum/BusinessRole` - role level bisnis untuk kolom `business_users_roles.code`
- `Repository/RoleRepositoryInterface` - kontrak query role
- `Repository/TenantUserRepositoryInterface` - kontrak query membership user

### Infrastructure

- `Repository/OrmRoleRepository` - implementasi `RoleRepositoryInterface` via ORM
- `Repository/OrmTenantUserRepository` - implementasi `TenantUserRepositoryInterface` via ORM

Aturan praktis:

- controller hanya memetakan HTTP ke use case
- DTO adalah boundary output/input antar layer
- repository interface tidak mengetahui CakePHP ORM
- implementasi repository adalah satu-satunya layer yang mengetahui `contain()`, entity ORM, dan mapping hasil query

## Contoh Struktur Hierarki User

Model mental yang dipakai plugin ini adalah membership per tenant, bukan user global langsung menempel ke semua object bisnis.

Urutan relasi yang paling umum adalah:

```text
Tenant
`- Group
	`- TenantUser (membership dari users.id di tenant tersebut)
		`- Roles
```

Dalam implementasi database, bentuknya kurang lebih seperti ini:

```text
users
`- business_users_tenant_users
	|- business_users_group_members -> business_users_groups
	`- business_users_tenant_user_roles -> business_users_roles
```

Artinya:

- `users` tetap menjadi identitas utama global dari `CakeDC/Users`
- `business_users_tenant_users` adalah node membership user di tenant tertentu
- `business_users_group_members` menghubungkan membership user ke satu atau lebih group dalam tenant yang sama
- `business_users_tenant_user_roles` menghubungkan membership user ke satu atau lebih role dalam tenant yang sama

Contoh konkret:

```text
Tenant: Acme Travel
`- Group: Reservation Team
	`- User: user_id=9f0b6c4e-1234-4ad3-9e1a-8c32db2d1111
		|- Tenant membership: active
		|- Roles:
		|  |- agent-staff
		|  `- approver-level-1
		`- Modules/permissions tambahan bila diperlukan
```

Jika ditulis sebagai relasi bisnis:

1. User global login sebagai identity utama dari `users.id`.
2. User tersebut menjadi member tenant melalui satu row di `business_users_tenant_users`.
3. Membership itu dapat masuk ke satu atau lebih group melalui `business_users_group_members`.
4. Membership yang sama dapat memiliki satu atau lebih role melalui `business_users_tenant_user_roles`.

Catatan penting:

- group dipakai untuk mengelompokkan membership user dalam tenant, misalnya divisi, tim reservasi, atau finance
- role dipakai untuk menyatakan privilege/hierarchy bisnis user dalam tenant
- satu user global dapat memiliki membership di beberapa tenant, dengan group dan role yang berbeda di tiap tenant
- plugin juga memiliki relasi `business_users_group_roles` untuk memasangkan role ke group, tetapi DTO `TenantMembershipData` saat ini membawa daftar role yang di-assign langsung ke user melalui `business_users_tenant_user_roles`

Contoh multi-tenant sederhana:

```text
User: 9f0b6c4e-1234-4ad3-9e1a-8c32db2d1111
|- Tenant A: Acme Travel
|  |- Group: Reservation Team
|  `- Roles: agent-staff, approver-level-1
`- Tenant B: Sky Provider Ops
	|- Group: Operations Control
	`- Roles: provider-supervisor
```

Dengan struktur ini, satu identity user yang sama dapat memiliki konteks bisnis yang berbeda tergantung tenant aktif yang sedang dipakai aplikasi.

## Enum Role dan Kompatibilitas Seed

Plugin sekarang memiliki dua jenis enum role:

### User role untuk `CakeDC/Users`

Enum `BusinessUsers\Domain\Enum\UserRole` dipakai untuk kolom `users.role` dan saat ini menyediakan:

- `user`
- `admin`
- `superuser`

Lookup ini dipakai oleh admin form add/edit user sehingga pilihan role aplikasi konsisten.

### Business role untuk `business_users_roles`

Enum `BusinessUsers\Domain\Enum\BusinessRole` diselaraskan dengan seed `config/Seeds/BusinessUsersTenantGroupRoleSeed.php`.

Nilai enum saat ini mencakup:

- provider: `provider-staff`, `provider-supervisor`, `provider-manager`, `provider-owner`
- agent: `agent-staff`, `agent-supervisor`, `agent-manager`, `agent-owner`
- end-user: `end-user`, `travel-coordinator`, `approver-level-1`, `approver-level-2`, `corporate-admin`

Karena enum disamakan dengan seed, `BusinessRole::tryFrom($role->code)` sekarang akan resolve dengan benar untuk seluruh seeded role.

## How to Add New Business Role

Jika Anda ingin menambah role bisnis baru, jangan cukup mengubah satu file saja. Role baru harus konsisten di enum, seed, data existing, dan layer authorization yang memakainya.

### Kapan perlu menambah role baru

- saat ada persona bisnis baru yang benar-benar berbeda secara otorisasi
- saat role baru membutuhkan level hierarchy yang berbeda
- saat role tersebut akan dipakai lintas tenant sejenis sebagai canonical code

Jika kebutuhan hanya label tenant-specific tanpa semantik global, evaluasi dulu apakah cukup memakai role existing + permission assignment, daripada menambah canonical role baru.

### Urutan perubahan yang disarankan

1. Tambahkan case baru di `BusinessUsers\Domain\Enum\BusinessRole`.
2. Tentukan `value`, `label()`, `level()`, dan `tenantType()` yang benar.
3. Sinkronkan seed `config/Seeds/BusinessUsersTenantGroupRoleSeed.php` bila role tersebut harus tersedia pada data contoh lokal.
4. Evaluasi apakah data existing di database perlu di-backfill atau di-migrasi.
5. Perbarui rule authorization atau use case yang membaca hierarchy/tenant type bila ada asumsi hardcoded terhadap level atau category role.
6. Verifikasi endpoint `GET /api/business-users/v1/roles/enums` dan `GET /api/business-users/v1/roles` agar role baru ikut muncul.

### Menentukan canonical code

Canonical code harus:

- stabil dalam jangka panjang
- memakai format slug lowercase dengan separator `-`
- menjelaskan domain tenantnya bila role hanya relevan untuk tenant tertentu

Contoh yang baik:

- `provider-auditor`
- `agent-ticketing-manager`
- `corporate-travel-auditor`

Contoh yang sebaiknya dihindari:

- `manager2`
- `special-role`
- `role-baru`

### Menentukan level hierarchy

Gunakan `level()` untuk menunjukkan privilege relatif dalam tenant yang sama.

- level lebih tinggi = privilege lebih tinggi
- hindari memakai level yang sama untuk dua role berbeda bila authorization nanti membedakan keduanya secara hierarkis
- jaga pola numerik tetap sederhana, misalnya kelipatan `10`

Jika role baru tidak benar-benar lebih tinggi/rendah dari role existing dan hanya berbeda fungsi, pertimbangkan untuk memodelkannya lewat permission, bukan hierarchy level baru.

### Kapan perlu migration

Tidak semua role baru membutuhkan migration.

Migration dibutuhkan jika:

- Anda mengubah struktur table
- Anda ingin melakukan data backfill permanen ke environment yang sudah berjalan
- Anda perlu rename canonical code lama ke code baru secara otomatis

Migration tidak dibutuhkan jika:

- Anda hanya menambah enum case
- Anda hanya menambah data contoh di seed untuk local/dev/test

Untuk environment yang sudah memiliki data nyata, jangan mengandalkan seed untuk memperbaiki data existing. Buat migration atau command backfill yang eksplisit.

### Checklist verifikasi setelah menambah role

- enum `BusinessRole` sudah lengkap: `value`, `label()`, `level()`, `tenantType()`
- seed sinkron bila role itu bagian dari sample data
- role baru muncul di `BusinessRole::cases()`
- `BusinessRole::tryFrom($role->code)` resolve untuk data yang relevan
- endpoint `/api/business-users/v1/roles/enums` menampilkan role baru
- endpoint `/api/business-users/v1/roles` menampilkan row database dengan code yang cocok
- jika role dipakai untuk authorization, test atau skenario manual untuk policy/hierarchy ikut diperbarui

### Command verifikasi cepat

```bash
php -l src/Domain/Enum/BusinessRole.php
bin/cake routes check /api/business-users/v1/roles/enums
bin/cake routes check /api/business-users/v1/roles
```

Jika Anda juga mengubah seed, jalankan ulang seed di environment lokal yang aman atau reset data pengujian terlebih dahulu sebelum memverifikasi hasil query.

## Model yang Tersedia

Table utama yang sudah ada:

- `business_users_tenants`
- `business_users_modules`
- `business_users_permissions`
- `business_users_tenant_users`
- `business_users_groups`
- `business_users_roles`
- `business_users_tenant_modules`
- `business_users_role_permissions`
- `business_users_tenant_user_roles`
- `business_users_group_members`
- `business_users_group_roles`
- `business_users_tenant_user_modules`
- `business_users_tenant_user_permissions`
- `countries`, `states`, `cities` (geographic lookup)

Semua table tersebut memiliki kolom audit dasar `created`, `created_by`, `modified`, `modified_by` dan sudah dipasangi behavior `Timestamp` serta `AuditStash.AuditLog`.

Table-table yang memiliki admin CRUD screen juga dipasangi `Search.Search` behavior agar kompatibel dengan `Crud.Search` listener:

- `business_users_tenants` — search: `name`, `code`
- `business_users_modules` — search: `name`, `code`
- `business_users_permissions` — search: `name`, `code`
- `business_users_groups` — search: `name`, `code`
- `business_users_roles` — search: `name`, `code`
- `business_users_tenant_users` — search: `user_id`, `status`
- `countries` — search: `iso`, `name`, `nicename`
- `states` — search: `name`, `state_code`
- `cities` — search: `name`

## Admin CRUD

Admin screen tersedia di path `/admin/business-users/*` dengan prefix `Admin`, plugin `BusinessUsers`.

Controller yang tersedia:

| URL | Controller |
|-----|-----------|
| `/admin/business-users/tenants` | `Admin/TenantsController` |
| `/admin/business-users/modules` | `Admin/ModulesController` |
| `/admin/business-users/permissions` | `Admin/PermissionsController` |
| `/admin/business-users/groups` | `Admin/GroupsController` |
| `/admin/business-users/roles` | `Admin/RolesController` |
| `/admin/business-users/tenant-users` | `Admin/TenantUsersController` |
| `/admin/business-users/countries` | `Admin/CountriesController` |
| `/admin/business-users/states` | `Admin/StatesController` |
| `/admin/business-users/cities` | `Admin/CitiesController` |
| `/admin/users/*` | `Admin/UsersController` (wraps CakeDC/Users) |

### Template

Template admin default berada di plugin BusinessUsers:

```text
plugins/BusinessUsers/templates/Admin/
├── Tenants/
├── Modules/
├── Permissions/
├── Groups/
├── Roles/
├── TenantUsers/
├── Countries/
├── States/
└── Cities/
```

Template bawaan memakai elemen UIkit (`Uikit.page_header`, `Uikit.table_controls`, dll.) karena theme default adalah Uikit. Layout admin tetap berasal dari theme aktif.

`BusinessUsers\Controller\CrudController` memanggil `$this->viewBuilder()->setTheme($theme)` berdasarkan `BusinessUsers.theme` (default: `Uikit`). CakePHP mencari template dengan urutan:

1. `plugins/<Theme>/templates/plugin/BusinessUsers/Admin/<Controller>/<action>.php` (override theme)
2. `plugins/BusinessUsers/templates/Admin/<Controller>/<action>.php` (default plugin)

Jika theme diganti dan CSS framework berbeda:

1. Set `BusinessUsers.theme` ke theme baru di `config/app.php`.
2. Buat override template di `plugins/<Theme>/templates/plugin/BusinessUsers/Admin/`.
3. Template yang tidak di-override tetap memakai default dari plugin BusinessUsers.

Menu admin didaftarkan otomatis via `AdminMenuAdapter` yang diregister di `bootstrap()` plugin.

## REST API

REST API plugin saat ini tersedia di bawah prefix `/api/business-users/v1/*`.

Endpoint yang sudah ada:

| Method | URL | Keterangan |
|-----|-----------|-----------|
| `GET` | `/api/business-users/v1/roles` | Mengambil daftar role business users dengan filter `tenant_id`, `is_active`, `page`, `limit` |
| `GET` | `/api/business-users/v1/roles/enums` | Mengambil daftar enum canonical untuk `BusinessRole` dan `UserRole` |

Implementasi JSON response memakai native CakePHP `JsonView` melalui base controller API app, bukan `json_encode()` manual, agar DebugKit tetap dapat membaca payload view variables.

## Use Case Bisnis yang Tersedia

### GetRoles

Use case ini dipakai oleh endpoint `GET /api/business-users/v1/roles`.

Input yang didukung:

- `tenantId` opsional
- `isActive` opsional
- `page`
- `limit`

Output berisi:

- daftar `RoleData`
- metadata pagination (`total`, `page`, `limit`, `pages`)

### GetUserBusinessProfile

Use case ini dipakai untuk mengambil konteks bisnis user berdasarkan `users.id`.

Kemampuan saat ini:

- mengambil seluruh membership tenant untuk satu `user_id`
- mengambil membership user untuk tenant tertentu
- membawa informasi tenant, group, dan role yang terkait dengan membership tersebut

Kasus pakai umum:

- membangun endpoint `/me/business-profile`
- menentukan tenant context setelah login
- memuat group dan role bisnis user untuk authorization layer aplikasi
- menyiapkan payload dashboard multi-tenant tanpa query terpisah dari controller

```bash
bin/cake migrations migrate --plugin BusinessUsers
```

Cek status migration plugin:

```bash
bin/cake migrations status --plugin BusinessUsers
```

Rollback satu step migration plugin bila memang diperlukan:

```bash
bin/cake migrations rollback --plugin BusinessUsers
```

Karena audit log UUID diatur pada level app, jalankan juga migration host bila environment belum sinkron (lihat [Konfigurasi](#konfigurasi)).

## Seed (detail)

Seed yang tersedia saat ini:

- `BusinessUsersTenantGroupRoleSeed`

Menjalankan seed:

```bash
bin/cake migrations seed --plugin BusinessUsers --seed BusinessUsersTenantGroupRoleSeed
```

Seed tersebut mengisi contoh struktur tenant, group, dan role untuk skenario provider, agent, dan end-user.

Setelah menjalankan seed, verifikasi endpoint:

```bash
bin/cake routes check /api/business-users/v1/roles
bin/cake routes check /api/business-users/v1/roles/enums
```

## Testing

Menjalankan seluruh test plugin BusinessUsers:

```bash
vendor/bin/phpunit --colors=always plugins/BusinessUsers/tests
```

Menjalankan hanya table tests BusinessUsers:

```bash
vendor/bin/phpunit --colors=always plugins/BusinessUsers/tests/TestCase/Model/Table
```

Menjalankan satu file test spesifik:

```bash
vendor/bin/phpunit --colors=always plugins/BusinessUsers/tests/TestCase/Model/Table/TenantsTableTest.php
```

Catatan test saat ini:

- Table test skeleton untuk 13 model sudah tersedia.
- Bootstrap test root app harus menjalankan migration `CakeDC/Users` dan `BusinessUsers` sebelum fixture dipakai.
- Sebagian besar test masih berupa `markTestIncomplete()`, jadi status hijau saat ini berarti suite bisa bootstrap dan schema/fixture sudah terbaca dengan benar.

## Command Operasional yang Sering Dipakai

Refresh schema cache sebelum debugging relasi/model:

```bash
bin/cake orm_cache clear
bin/cake cache clear_all
```

Lint cepat file plugin:

```bash
php -l src/BusinessUsersPlugin.php
php -l src/Controller/Api/V1/RolesController.php
```

## Konvensi Kerja

- Pertahankan controller tetap tipis; logic akses bisnis ada di Table/Service.
- Jangan menduplikasi identity/auth flow yang sudah dimiliki `CakeDC/Users`.
- Jika menambah auditing atau mengubah shape primary key yang direkam audit log, cek ulang kompatibilitas `AuditStash` dan migration app.
- Jika menambah fixture atau test baru, sesuaikan dengan autoload root Composer dan bootstrap test app.
- Untuk endpoint bisnis non-CRUD, pertahankan pemisahan `Controller → UseCase → RepositoryInterface → OrmRepository`.
- Jika menambah role business baru, sinkronkan sekaligus enum `BusinessRole`, seed `BusinessUsersTenantGroupRoleSeed`, dan asumsi level/hierarchy yang dipakai authorization.
- Jika menambah role level aplikasi, sinkronkan enum `UserRole`, form admin users, dan rule authorization yang membaca `users.role`.
- Template default admin CRUD harus ada di `plugins/BusinessUsers/templates/Admin/`. Override theme (jika diperlukan) di `plugins/<Theme>/templates/plugin/BusinessUsers/Admin/`.

## Referensi Terkait

- Plugin entry point: `src/BusinessUsersPlugin.php`
- Main migration: `config/Migrations/20260514090000_CreateBusinessUsersAccessTables.php`
- Seed: `config/Seeds/BusinessUsersTenantGroupRoleSeed.php`
- Package Composer: `yeriepiscesa/cakephp-business-users`
