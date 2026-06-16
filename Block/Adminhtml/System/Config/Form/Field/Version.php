<?php declare(strict_types=1);
/**
 * @author    AkStackPro
 * @copyright Copyright (c) 2026 AkStackPro (http://akstackpro.com/)
 * @package   AkStackPro_Core
 */
namespace AkStackPro\Core\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

class Version extends Field
{
    /**
     * @inheritdoc
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return '<strong>1.0.0</strong>';
    }
}
