#!/bin/sh

echo "Running fpp-smartthings PreStart Script"

sudo chmod 755 /home/fpp/media/plugins/fpp-smartthings/commands/on.sh
sudo chmod 755 /home/fpp/media/plugins/fpp-smartthings/commands/off.sh
sudo chmod 755 /home/fpp/media/plugins/fpp-smartthings/commands/toggle.sh
sudo chmod 755 /home/fpp/media/plugins/fpp-smartthings/commands/routine.sh
