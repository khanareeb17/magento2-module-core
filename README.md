# AkStackPro Core for Magento 2

Base foundation module for all **Ak Stack Pro** Magento 2 extensions. Similar to Mageplaza Core or Amasty Base, this module provides the shared admin structure — menu, configuration tab, ACL resources, and helper constants — so every AkStackPro extension integrates consistently into your Magento admin panel.

> **This module must be installed first** before any other AkStackPro extension.

---

## Purpose

AkStackPro Core does not provide business functionality on its own. It establishes the platform layer that child modules build upon:

| Responsibility | Description |
|----------------|-------------|
| **Admin menu** | Creates the top-level **Ak Stack Pro** sidebar menu |
| **Configuration tab** | Registers the **Ak Stack Pro** tab under Stores → Configuration |
| **ACL framework** | Parent permissions for menu and config access |
| **General section** | Core version and documentation info in admin |
| **Developer constants** | Shared IDs for tab, menu, and ACL used by child modules |

Child modules (Import Inventory, Sport South, etc.) extend this structure by adding their own menu headings, configuration sections, and ACL resources — without duplicating the base tab or root menu.

---

## Features

- **Unified admin menu** — single **Ak Stack Pro** entry in the Magento admin sidebar
- **Unified config tab** — all AkStackPro settings grouped under one configuration tab
- **Hierarchical menu support** — child modules can add grouped headings (e.g. *Sports South Integration*) with navigation items underneath
- **ACL parent resources** — role-based access control for all AkStackPro extensions
- **Helper constants** — `AkStackPro\Core\Helper\Data` provides shared IDs for extension developers
- **Zero business logic** — lightweight base with no frontend impact

---

## Requirements

| Requirement | Version |
|-------------|---------|
| Magento | 2.4.x (Open Source / Adobe Commerce) |
| PHP | 8.1, 8.2, or 8.3 |

### Dependencies

This module only requires standard Magento components:

- `magento/module-backend`
- `magento/module-config`

No other AkStackPro modules are required to install Core.

---

## Installation

### Option A — Composer (recommended)

```bash
composer require akstackpro/module-core
```

Then enable and upgrade:

```bash
php bin/magento module:enable AkStackPro_Core
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

### Option B — Manual installation

1. Place the module in your Magento codebase:

   ```
   app/code/AkStackPro/Core/
   ```

2. Enable and upgrade:

   ```bash
   php bin/magento module:enable AkStackPro_Core
   php bin/magento setup:upgrade
   php bin/magento cache:flush
   ```

---

## Configuration

Navigate to:

**Admin → Ak Stack Pro → Configuration**

Or:

**Stores → Configuration → Ak Stack Pro → General**

| Field | Description |
|-------|-------------|
| **Core Module Version** | Currently installed version of AkStackPro Core |
| **Documentation** | Quick reference for configuring child extensions |

---

## Admin structure

After installing Core and child extensions, the admin menu looks like this:

```
Ak Stack Pro
├── Configuration              ← Core (General settings)
├── Sports South Integration   ← Sport South module (heading)
│   └── Settings
└── Compass Integration        ← Import Inventory module (heading)
    └── Settings
```

All configuration sections appear under:

**Stores → Configuration → Ak Stack Pro**

---

## Available AkStackPro extensions

Install Core first, then add the extensions you need:

| Extension | Composer Package | Repository |
|-----------|------------------|------------|
| **Import Inventory** | `akstackpro/module-import-inventory` | [github.com/khanareeb17/magento2-module-import-inventory](https://github.com/khanareeb17/magento2-module-import-inventory) |
| **Sport South** | `akstackpro/module-sport-south` | [github.com/khanareeb17/magento2-module-sport-south](https://github.com/khanareeb17/magento2-module-sport-south) |

**Recommended install order:**

```bash
composer require akstackpro/module-core
composer require akstackpro/module-import-inventory
composer require akstackpro/module-sport-south   # optional
```

---

## For extension developers

If you are building a new AkStackPro module, use Core as your base dependency.

### 1. Declare dependency

**`etc/module.xml`**
```xml
<sequence>
    <module name="AkStackPro_Core"/>
</sequence>
```

**`composer.json`**
```json
"require": {
    "akstackpro/module-core": "^1.0"
}
```

### 2. Add a configuration section

**`etc/adminhtml/system.xml`** — do **not** redefine the tab; only add your section:

```xml
<section id="your_section" sortOrder="40">
    <label>Your Extension</label>
    <tab>akstackpro</tab>
    <resource>AkStackPro_YourModule::config</resource>
    <!-- groups and fields -->
</section>
```

### 3. Add admin menu (heading + navigation)

**`etc/adminhtml/menu.xml`**
```xml
<!-- Module heading -->
<add id="AkStackPro_YourModule::menu"
     title="Your Extension"
     parent="AkStackPro_Core::menu"
     resource="AkStackPro_YourModule::menu"
     sortOrder="40"/>

<!-- Navigation item -->
<add id="AkStackPro_YourModule::configuration"
     title="Settings"
     parent="AkStackPro_YourModule::menu"
     action="adminhtml/system_config/edit/section/your_section"
     resource="AkStackPro_YourModule::config"
     sortOrder="10"/>
```

### 4. Register ACL resources

**`etc/acl.xml`** — use the full nesting path:

```xml
<resource id="Magento_Backend::admin">
    <resource id="AkStackPro_Core::menu">
        <resource id="AkStackPro_YourModule::menu" title="Your Extension" translate="title" sortOrder="40"/>
    </resource>
    <resource id="Magento_Backend::stores">
        <resource id="Magento_Backend::stores_settings">
            <resource id="Magento_Config::config">
                <resource id="AkStackPro_Core::config">
                    <resource id="AkStackPro_YourModule::config" title="Your Extension" translate="title" sortOrder="40"/>
                </resource>
            </resource>
        </resource>
    </resource>
</resource>
```

### 5. Use helper constants

```php
use AkStackPro\Core\Helper\Data;

Data::CONFIG_TAB_ID;      // 'akstackpro'
Data::MENU_ID;            // 'AkStackPro_Core::menu'
Data::ACL_CONFIG;         // 'AkStackPro_Core::config'
Data::menuGroupId('AkStackPro_YourModule'); // 'AkStackPro_YourModule::menu'
```

---

## Permissions

Assign AkStackPro permissions under:

**System → Permissions → User Roles → Role Resources**

| Resource | Controls access to |
|----------|-------------------|
| **Ak Stack Pro** | Admin sidebar menu |
| **Ak Stack Pro Configuration** | Stores → Configuration tab |
| Child module resources | Individual extension menus and settings |

---

## Uninstallation

> Only uninstall Core if **all** AkStackPro child extensions have been removed first.

```bash
php bin/magento module:disable AkStackPro_Core
php bin/magento setup:upgrade
php bin/magento cache:flush
```

To remove via Composer:

```bash
composer remove akstackpro/module-core
```

---

## Support

- **Website:** [https://akstackpro.com](https://akstackpro.com)
- **Issues:** Open a GitHub issue in this repository

---

## License

Proprietary — Copyright © 2026 [AkStackPro](https://akstackpro.com). All rights reserved.
