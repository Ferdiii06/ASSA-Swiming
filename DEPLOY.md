# 🚀 Deploy ke VPS dengan Docker (MUDAH!)

## Prasyarat
- VPS minimal: 2GB RAM, 1 CPU core
- OS: Ubuntu 20.04+ atau Debian 11+
- Akses SSH root/sudo

---

## 📦 Setup Otomatis (3 Langkah)

### 1. Install Docker & Docker Compose di VPS
```bash
# Script install otomatis
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh
apt install docker-compose-plugin -y
```

### 2. Upload Project ke VPS
```bash
# Dari komputer Windows (Command Prompt/PowerShell):
cd C:\Workspace\Kerja\ASSA-Swiming
scp -r * root@YOUR_VPS_IP:/root/assa-swiming
```

Atau via FTP/FileZilla upload semua file ke folder VPS.

### 3. Deploy! (Jalankan di VPS)
```bash
cd /root/assa-swiming
docker-compose up -d
```

**DONE!** Aplikasi langsung jalan di: `http://YOUR_VPS_IP`

---

## 🔧 Konfigurasi Database

Database MySQL sudah otomatis setup dengan kredensial:
- **Host**: `db` (dalam network) atau `localhost` dari luar
- **Port**: `3306`
- **Database**: `swiming_schedule`
- **User**: `swiming_user`
- **Password**: `swiming_password`

Edit `.env` di VPS jika perlu:
```bash
docker-compose exec app php artisan env
docker-compose restart app
```

Untuk migrasi database:
```bash
docker-compose exec app php artisan migrate --force
```

---

## ⚡ Commands Penting

| Command | Fungsi |
|---------|--------|
| `docker-compose ps` | Cek status container |
| `docker-compose logs -f` | Lihat log aplikasi |
| `docker-compose down` | Stop semua container |
| `docker-compose up -d` | Start aplikasi |
| `docker-compose restart app` | Restart aplikasi |
| `docker system prune` | Bersihkan unused images |

---

## 🔒 Upgrade Keamanan (Recommended)

### Ganti Password Default
Edit `docker-compose.yml`, bagian `mysql`:
```yaml
environment:
  MYSQL_ROOT_PASSWORD: <password_baru_anda>
  MYSQL_PASSWORD: <password_user_baru>
```
Lalu: `docker-compose up -d`

### Setup SSL (HTTPS)
```bash
# Install Certbot
apt install certbot python3-certbot-nginx

# Generate certificate (jika pakai domain)
certbot --nginx -d yourdomain.com
```

---

## 💡 Troubleshooting

**Error: "Permission denied" saat run Docker**
```bash
sudo usermod -aG docker $USER
newgrp docker
```

**Error: Port already in use**
```bash
# Hapus container yang conflict
docker-compose down
# Atau ganti port di docker-compose.yml (contoh: "8080:80")
```

**Reset Total**
```bash
docker-compose down -v
rm -rf swiming_schedule
docker-compose up -d
```

---

## 🌐 Akses Aplikasi

Setelah deploy selesai, buka browser:
- **URL**: `http://<IP_VPS_ANDA>`
- Contoh: `http://192.168.1.100`

Jika perlu access dari luar network VPS, pastikan port 80 & 3306 dibuka di firewall VPS provider.

---

**Deployment Selesai! 🎉**
