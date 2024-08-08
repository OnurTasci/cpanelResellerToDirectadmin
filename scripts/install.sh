#!/bin/sh
PLUGINPATH=/usr/local/directadmin/plugins/cpanelMigrator

for dir in hooks images includes admin; do {
    chmod -R 755 ${PLUGINPATH}/${dir}
}
done;

chmod -R 700 ${PLUGINPATH}/scripts

touch ${PLUGINPATH}/.env
chmod -R 766 ${PLUGINPATH}/.env

chown -R diradmin:diradmin ${PLUGINPATH}

echo 'Plugin is now installed!';
exit 0;
