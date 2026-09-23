# Dijital Mezuniyet Yıllığı (WAMP / XAMPP)

## Kurulum (3 adım)
1) Proje klasörünü web root'a kopyala:
- WAMP: C:\wamp64\www\dijital-mezuniyet-yilligi
- XAMPP: C:\xampp\htdocs\dijital-mezuniyet-yilligi

2) Veritabanı:
- phpMyAdmin -> Import -> database.sql dosyasını içe aktar.
- DB adı: yearbook_db

3) Aç:
http://localhost/dijital-mezuniyet-yilligi/frontend/

## Notlar
- Token ile giriş kalıcıdır. Çıkış yapmadıkça tekrar giriş istemez.
- uploads/ klasörüne fotoğraflar kaydedilir.

## Admin Panel

Admin paneli proje içinde ayrı bir sayfa olarak eklendi:

- `frontend/admin.html`
- Varsayılan admin e-posta: `admin@mera.com`
- İlk kurulum varsayılan şifre: `Admin123!@#`

Giriş yaptıktan sonra **Şifre Ayarı** bölümünden admin şifresi değiştirilebilir. Admin şifre yenileme periyodu 1, 3 veya 6 ay olarak seçilebilir. Süre dolduğunda panel uyarı gösterir ve yeni şifre belirlenmesini ister.

> Güvenlik notu: İlk girişten sonra varsayılan admin şifresini mutlaka değiştirin.

## Bu teslimde yapılan düzeltmeler
- Kullanıcı değişince arayüz oturumu temizlenir; dedikodu filtresi, arama kutuları, seçili ekran ve yerel oyun rekorları kullanıcıya özel hale getirildi.
- Admin ban/mute işlemleri için `is_banned` ve `mute_until` alanları otomatik oluşturulur; banlanan kullanıcının tokenları silinir ve tekrar giriş yapması engellenir.
- Admin paneline **İçerik Takibi** bölümü eklendi: dedikodular, Eski Toprak mesajları ve anketler görüntülenebilir.
- MEra Blast tahtası 7x7, M2 Blocks tahtası 5x5 yapıldı; M2 sayı üretimi oyun ilerledikçe daha büyük değerlere çıkar.
- Avatar/civciv bakım ihtiyaçları hızlandırıldı; açlık, uyku ve tuvalet bildirimleri daha sık ve net gelir.
