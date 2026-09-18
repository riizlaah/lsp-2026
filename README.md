# LSP 2026
Proyek LSP 2026, sebuah web untuk profil sekolah.

## Features
- [x] Login admin
- [ ] UD galeri
- [ ] CRUD pengumuman
- [x] CRUD artikel/berita
- [x] CRUD prestasi


## Entities

- User(id, username, password, email, phoneNumber, role)
- GalleryItem(id, refTable, refId, shortDescription, mediaPath, isCover)
- Announcement(id, userId, title, imagePath, content, createdAt, updatedAt)
- AnnouncementAttachment(id, announcementId, name, type, url)
- Article(id, userId, title, imagePath, content, createdAt, updatedAt)
- Achievement(id, userId, title, rank, imagePath, content, createdAt, updatedAt)
