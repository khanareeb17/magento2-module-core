<?php declare(strict_types=1);
/**
 * @author    AkStackPro
 * @copyright Copyright (c) 2026 AkStackPro (http://akstackpro.com/)
 * @package   AkStackPro_Core
 */
namespace AkStackPro\Core\Block\Adminhtml\System\Config\Form\Field;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;
use Magento\Store\Model\ScopeInterface;

class WebsitePortal extends Field
{
    private const XML_PATH_WEBSITE_URL = 'akstackpro/portal/website_url';
    private const XML_PATH_IFRAME_TIMEOUT = 'akstackpro/portal/iframe_timeout';

    /**
     * @var string
     */
    protected $_template = 'AkStackPro_Core::system/config/website_portal.phtml';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data, $secureRenderer);
    }

    /**
     * @inheritdoc
     */
    public function render(AbstractElement $element)
    {
        $this->setElement($element);

        return '<tr class="akstackpro-portal-row"><td colspan="4" class="value akstackpro-portal-cell">'
            . $this->toHtml()
            . '</td></tr>';
    }

    public function getWebsiteUrl(): string
    {
        return (string) $this->scopeConfig->getValue(
            self::XML_PATH_WEBSITE_URL,
            ScopeInterface::SCOPE_STORE
        ) ?: 'https://akstackpro.com/';
    }

    public function getIframeTimeoutMs(): int
    {
        $seconds = (int) $this->scopeConfig->getValue(
            self::XML_PATH_IFRAME_TIMEOUT,
            ScopeInterface::SCOPE_STORE
        );

        return ($seconds > 0 ? $seconds : 12) * 1000;
    }
}
