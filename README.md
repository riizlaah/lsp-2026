# LSP 2026
Proyek LSP 2026, sebuah web untuk profil sekolah.

## Features
- [x] Login admin
- [ ] CRUD galeri
- [ ] CRUD pengumuman
- [ ] CRUD artikel/berita
- [x] CRUD prestasi


## Entities

- User(id, username, password, email, phoneNumber, role)
- Galery(id, name, description)
- GaleryItem(id, galeryId, shortDescription, imagePath, isMain)
- Announcement(id, userId, title, imagePath, content, createdAt, updatedAt)
- AnnouncementAttachment(id, announcementId, name, type, url)
- Article(id, userId, title, imagePath, content, createdAt, updatedAt)
- Achievement(id, userId, title, rank, imagePath, content, createdAt, updatedAt)
