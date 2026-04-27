# BlueERP V3

## URLs & Ports

| Service | URL | Port |
|---------|-----|------|
| Application | http://localhost:8900 | 8900 |
| PhpMyAdmin | http://localhost:8920 | 8920 |

## Database Credentials

| Setting | Value |
|---------|-------|
| Host | db |
| Port | 3306 |
| Database | blueerp_v3 |
| Username | root |
| Password | plzletme!n123 |

### Application User
- Username: appuser
- Password: apppassword

## Docker Commands

```bash
# Start all services
docker compose up -d

# Stop all services
docker compose down

# View running containers
docker ps

# View logs
docker compose logs -f
```

## PhpMyAdmin Login

When logging into PhpMyAdmin:
- Server: db
- Username: root
- Password: plzletme!n123