# cPanel Reseller to DirectAdmin Migrator

This DirectAdmin plugin, developed by Onur TAŞCI, helps you migrate reseller-level cPanel accounts to DirectAdmin seamlessly. With this tool, you can easily transfer reseller accounts from cPanel to DirectAdmin, simplifying the migration process.

## Features

- Migrate cPanel reseller accounts to DirectAdmin.
- Automatic account creation and data transfer.
- Simple installation and user-friendly operation.

## Installation

To install the plugin, follow these steps:

1. Connect to your server via SSH.

2. Run the following commands to download and install the plugin:

    ```bash
    wget -qO- https://github.com/OnurTasci/cpanelResellerToDirectadmin/archive/refs/heads/main.zip | bsdtar -xvf- -C /usr/local/directadmin/plugins/ --strip-components=1 -s'/^cpanelResellerToDirectadmin-main/cpanelMigrator/'
    cd /usr/local/directadmin/plugins/cpanelMigrator/scripts
    chmod +x install.sh
    ./install.sh -f
    ```

## Usage

After installation, you can activate the plugin from the DirectAdmin panel and start migrating cPanel reseller accounts to DirectAdmin.

1. Log in to your **DirectAdmin** panel.
2. Navigate to the **Plugins** section and find the "cPanel Reseller to DirectAdmin Migrator" plugin.
3. Activate the plugin and begin migrating your cPanel users.

## Author

Developed by **Onur TAŞCI**  
Website: [onurtasci.com](https://onurtasci.com)

## License

This project is licensed under the **Onur TAŞCI License**. All rights to the code are reserved by the author.
