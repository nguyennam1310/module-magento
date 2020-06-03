<?php


namespace Shop\CustomerChatbox\Block;

class FacebookMessenger extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Locale\ResolverInterface
     */
    protected $_localeResolver;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Locale\ResolverInterface $localeResolver
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Locale\ResolverInterface $localeResolver
    ) {
        $this->_localeResolver = $localeResolver;
        parent::__construct($context);
    }

    /**
     * Retrieve the locate
     * The results as vi_VN, en_US, etc,...
     *
     * @return string
     */
    public function getLocate()
    {
        return $this->_localeResolver->getLocale();
    }
}
