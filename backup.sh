#!/bin/bash

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR=~/repos/rejecthandler/backups

echo "Backing up DEV database..."
docker exec rejecthandler_db_dev pg_dump \
    -U chirper_user \
    -d rejecthandler_db_dev \
    > $BACKUP_DIR/dev/backup_dev_$DATE.sql
echo "DEV backup saved: backup_dev_$DATE.sql"

echo "Backing up PROD database..."
docker exec rejecthandler_db_prod pg_dump \
    -U rejecthandler_user \
    -d rejecthandler_db_prod \
    > $BACKUP_DIR/prod/backup_prod_$DATE.sql
echo "PROD backup saved: backup_prod_$DATE.sql"

# Hapus backup lebih dari 7 hari
find $BACKUP_DIR/dev -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR/prod -name "*.sql" -mtime +7 -delete
echo "Old backups cleaned up."

echo "Done!"
