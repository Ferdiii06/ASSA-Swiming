#!/bin/bash

# ==========================================
# One-Click Deploy Script untuk Laravel + Docker
# Author: Qoder
# Target: Ubuntu/Debian VPS
# ==========================================

set -e

echo "🚀 Starting One-Click Deployment..."
echo ""

# Warna output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

log_info() { echo -e "${GREEN}[INFO]${NC} $1"; }
log_warn() { echo -e "${YELLOW}[WARN]${NC} $1"; }
log_error() { echo -e "${RED}[ERROR]${NC} $1"; }

# Cek apakah root
if [ "$EUID" -ne 0 ]; then 
    log_error "Script harus dijalankan sebagai root (sudo)"
    exit 1
fi

# Cek OS
if [[ -f /etc/debian_version ]]; then
    OS="debian"
elif [[ -f /etc/ubuntu-release ]]; then
    OS="ubuntu"
else
    log_error "OS tidak didukung. Gunakan Ubuntu atau Debian."
    exit 1
fi

# Update packages
log_info "Updating system packages..."
apt update && apt upgrade -y

# Install dependencies
log_info "Installing Docker & Docker Compose..."
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh --mirror Aliyun
apt install docker-compose-plugin -y

# Setup firewall
log_info "Configuring UFW firewall..."
ufw allow ssh
ufw allow 'Nginx HTTP'
ufw --force enable

log_info "======================================"
log_info "Setup Selesai! Sekarang jalankan:"
log_info ""
log_info "  cd /root/assa-swiming"
log_info "  docker-compose up -d"
log_info ""
log_info "Lalu buka browser: http://YOUR_VPS_IP"
log_info "======================================"

exit 0
