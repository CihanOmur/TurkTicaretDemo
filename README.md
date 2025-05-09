
# 📝 Fullstack Todo Uygulaması (Laravel + React)

## 📌 Proje Açıklaması
Bu proje, Laravel (back-end) kullanılarak geliştirilmiş, kategorili ve öncelikli görev yönetimi sağlayan bir **todo backend uygulamasıdır**.  
Kullanıcılar görevler oluşturabilir, güncelleyebilir, filtreleyebilir, arayabilir ve kategorilere göre gruplayabilir.  
Proje API-first mimarisi ile yazılmıştır.

---

## 🧩 Özellikler

- ✅ Görev CRUD işlemleri (create, read, update, delete)
- ✅ Durum, öncelik, tarih bazlı filtreleme
- ✅ Başlık/açıklama üzerinden arama
- ✅ Kategori CRUD ve ilişkilendirme
- ✅ İstatistik uç noktaları (durum ve öncelik bazlı görev sayısı)
- ✅ Soft delete (görev silindiğinde veritabanında tutulur)
- ✅ Validasyon & güvenlik önlemleri
- ✅ RESTful API tasarımı
- ✅ JSON API standartlarında cevaplar

---

## 🛠 Teknoloji Stack’i

### Backend
- Laravel 10
- MySQL / MariaDB
- Laravel Form Requests (validasyon)
- Eloquent ORM
- Laravel API Resources
- Laravel CORS & Middleware


## ⚙️ Kurulum Adımları

### Backend (Laravel)

```bash
git clone https://github.com/kullanici/todo-app-backend.git
cd todo-app-backend
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## ▶️ Çalıştırma Talimatları

1. Laravel API'yi çalıştır:  
   `php artisan serve`

---

## 📚 API Dokümantasyonu

Tüm uç noktalar detaylı şekilde Postman Collection’ında belgelenmiştir:

🔗 Proje > Todo API.postman_collection.json

---

## 🧪 Örnek Kullanım Senaryoları

- Kullanıcı yeni bir görev oluşturur ve “yüksek öncelikli” olarak ayarlar.
- Kullanıcı “tamamlandı” durumundaki görevleri filtreler.
- Kullanıcı “Alışveriş” kategorisine ait görevleri listeler.
- Kullanıcı arama kutusuna “rapor” yazarak ilgili görevleri bulur.
- Kullanıcı görev durumunu `PATCH /api/todos/{id}/status` ile günceller.

---

## 🎁 Bonus Özellikler

- 🟢 `GET /api/stats/todos` → Duruma göre görev sayıları
- 🟢 `GET /api/stats/priorities` → Önceliğe göre görev sayıları
- 🟢 Soft delete desteği (`deleted_at`)
- 🟢 Sayfalama, sıralama ve filtreleme kombinasyonu
