# Todo List & Excel Report Backend API 

Backend RESTful API berbasis **Laravel** untuk manajemen daftar tugas (*Todo List*) yang dilengkapi dengan validasi input, filter data dinamis, dan fitur export laporan ke format Microsoft Excel (`.xlsx`).

---

## Tech Stack
* **Framework:** Laravel (PHP)
* **Database:** SQLite
* **Excel Generator:** `rap2hpoutre/fast-excel`
* **API Testing:** Postman (`Todo_API_HMTI.json`)

---

## Cara Menjalankan Project di Local

1. **Clone repository ini:**
   ```bash
   git clone [https://github.com/IgnasiusDhimas/Talenavi-IgnasiusDhimasPanjiUtomo-BackEnd.git](https://github.com/IgnasiusDhimas/Talenavi-IgnasiusDhimasPanjiUtomo-BackEnd.git)
   cd Talenavi-IgnasiusDhimasPanjiUtomo-BackEnd
   ```

2. **Install dependency Composer:**
   ```bash
   composer install
   ```

3. **Salin file konfigurasi `.env` dan generate application key:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Buat file database SQLite (jika belum ada) dan jalankan migrasi beserta Seeder data dummy:**
   ```bash
   touch database/database.sqlite
   php artisan migrate:fresh --seed
   ```

5. **Jalankan server lokal Laravel:**
   ```bash
   php artisan serve
   ```
   Server akan berjalan di `http://127.0.0.1:8000`.

---

## Dokumentasi Endpoint API

### 1. Create Todo List
Menambahkan data todo baru ke dalam database.
* **Endpoint:** `POST /api/todos`
* **Headers:**
  * `Accept: application/json`
  * `Content-Type: application/json`
* **Request Body (JSON):**
  ```json
  {
    "title": "Persiapan Konsumsi & Banner LDKM HMTI",
    "assignee": "Dhimas",
    "due_date": "2026-12-28",
    "time_tracked": 2,
    "priority": "medium"
  }
  ```
* **Aturan Validasi:**
  * `title`: Wajib diisi (*string*).
  * `assignee`: Opsional (*string*).
  * `due_date`: Wajib diisi (*date*), tidak boleh tanggal di masa lalu (`after_or_equal:today`).
  * `time_tracked`: Opsional (*numeric*, minimal `0`, default `0`).
  * `status`: Opsional (`pending`, `open`, `in_progress`, `completed`, default `pending`).
  * `priority`: Wajib diisi (`low`, `medium`, `high`).

---

### 2. Get Todo List & Generate Excel Report
Mengunduh laporan daftar todo dalam format Excel (`.xlsx`) lengkap dengan baris *summary* (`Total Todos` & `Total Time`) di bagian bawah.
* **Endpoint:** `GET /api/todos/report`
* **Query Parameters (Opsional / Dapat Dikombinasikan):**

| Parameter | Format / Contoh | Keterangan |
| :--- | :--- | :--- |
| `title` | `HMTI` | Pencarian sebagian kata (*partial match*) |
| `assignee` | `Dhimas,Toto` | Filter beberapa nama dipisahkan koma |
| `start` & `end` | `start=2026-12-01&end=2026-12-20` | Filter rentang tanggal `due_date` |
| `min` & `max` | `min=2&max=4` | Filter rentang nilai `time_tracked` |
| `status` | `pending,in_progress` | Filter beberapa status dipisahkan koma |
| `priority` | `medium,high` | Filter beberapa prioritas dipisahkan koma |

---

## Pengujian Menggunakan Postman
1. Buka aplikasi **Postman**.
2. Klik **Import** dan pilih file **`Todo_API_HMTI.json`** yang tersedia di root directory project ini.
3. Jalankan request `POST` untuk menambah data atau gunakan request `GET` (`Send and Download`) untuk mengunduh laporan Excel.
