#!/usr/bin/env bash
#
# ExpressLogist — скрипт обновления сайта на сервере (Nginx + PHP-FPM).
# Тянет последние изменения из main и восстанавливает корректные права для www-data.
#
# Использование (на сервере, из-под root):
#   cd /var/www/expresslogists.com && ./deploy.sh
#
# При первом запуске сделать исполняемым:
#   chmod +x deploy.sh

set -euo pipefail

# Корень проекта = папка, где лежит этот скрипт
PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
WEB_USER="www-data"
BRANCH="main"

echo "==> Проект: ${PROJECT_DIR}"
cd "${PROJECT_DIR}"

# 1. Забираем изменения из репозитория
echo "==> git fetch + reset на origin/${BRANCH}"
git fetch origin "${BRANCH}"
git reset --hard "origin/${BRANCH}"

# 2. Восстанавливаем владельца и права (файлы после git принадлежат root)
echo "==> Восстанавливаю владельца ${WEB_USER} и права доступа"
chown -R "${WEB_USER}:${WEB_USER}" "${PROJECT_DIR}"
find "${PROJECT_DIR}" -type d -exec chmod 755 {} \;
find "${PROJECT_DIR}" -type f -exec chmod 644 {} \;

# 3. Папка logs/ должна быть доступна на запись (форма заявок)
if [ -d "${PROJECT_DIR}/logs" ]; then
  chmod 775 "${PROJECT_DIR}/logs"
  echo "==> logs/ доступна на запись"
fi

# 4. Скрипт снова исполняемый (после reset права слетают)
chmod +x "${PROJECT_DIR}/deploy.sh"

echo "==> Готово. Текущий коммит:"
git --no-pager log -1 --oneline
