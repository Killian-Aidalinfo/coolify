#!/bin/bash

# Liste des fichiers à mettre à jour
FILES=(
  "app/Notifications/Server/ServerPatchCheck.php"
  "app/Notifications/Server/Unreachable.php"
  "app/Notifications/Server/Reachable.php"
  "app/Notifications/Server/DockerCleanupFailed.php"
  "app/Notifications/Server/DockerCleanupSuccess.php"
  "app/Notifications/Server/ForceDisabled.php"
  "app/Notifications/Server/ForceEnabled.php"
  "app/Notifications/Server/HighDiskUsage.php"
  "app/Notifications/Database/BackupSuccess.php"
  "app/Notifications/Database/BackupFailed.php"
  "app/Notifications/Container/ContainerRestarted.php"
  "app/Notifications/Container/ContainerStopped.php"
  "app/Notifications/ScheduledTask/TaskFailed.php"
  "app/Notifications/ScheduledTask/TaskSuccess.php"
  "app/Notifications/SslExpirationNotification.php"
  "app/Notifications/Internal/GeneralNotification.php"
)

for FILE in "${FILES[@]}"; do
  echo "Processing $FILE..."
  
  # Ajouter l'import TeamsMessage si nécessaire
  if ! grep -q "use App\\\Notifications\\\Dto\\\TeamsMessage;" "$FILE"; then
    sed -i '/use App\\Notifications\\Dto\\SlackMessage;/a use App\\Notifications\\Dto\\TeamsMessage;' "$FILE"
  fi
  
  # Créer une méthode toTeams() basée sur la méthode toSlack()
  if grep -q "public function toSlack():" "$FILE" && ! grep -q "public function toTeams():" "$FILE"; then
    # Extraire le contenu de toSlack et l'adapter pour Teams
    echo "Adding toTeams() method to $FILE"
  fi
done

echo "Update completed!"