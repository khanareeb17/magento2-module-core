<?php declare(strict_types=1);
/**
 * @author    AkStackPro
 * @copyright Copyright (c) 2026 AkStackPro (http://akstackpro.com/)
 * @package   AkStackPro_Core
 */
namespace AkStackPro\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public const CONFIG_TAB_ID = 'akstackpro';
    public const CONFIG_SECTION_ID = 'akstackpro';
    public const MENU_ID = 'AkStackPro_Core::menu';
    public const ACL_CONFIG = 'AkStackPro_Core::config';
    public const ACL_MENU = 'AkStackPro_Core::menu';

    /**
     * Build a module menu group ID for adminhtml/menu.xml headings.
     */
    public static function menuGroupId(string $moduleCode): string
    {
        return $moduleCode . '::menu';
    }
}
