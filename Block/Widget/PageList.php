<?php
/**
 * Magebit_PageListWidget
 *
 * @category	Magebit
 * @package		Magebit_PageListWidget
 * @author		Andis Ancans <info@magebit.com>
 * @copyright   Copyright (c) 2021 Magebit, Ltd.
 * @license		http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\ResourceModel\Page;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;


class PageList extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = 'page-list.phtml';

    /**
     * @var Page
     */
    protected $resourcePage;

    /**
     * @var PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param Page $resourcePage
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Page $resourcePage,
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Template\Context $context,
        array $data = []
    ) {
        $this->resourcePage = $resourcePage;
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * @return array|null
     * @throws LocalizedException
     */
    public function getPageUrls(): ?array
    {
        $page_scope = $this->getData('page_scope');
        if ($page_scope == 1) {
            $pages = [];
            foreach ($this->pageRepository->getList($this->getSearchCriteria())->getItems() as $page) {
                $pages[] = [
                    'title' => $page->getTitle(),
                    'url' => $this->getUrl($page->getIdentifier())
                ];
            }
            return $pages;
        } else {
            if ($page_scope == 0) {
                $sites = $this->getData('pages');
                $keys = explode(",", $sites);
                $pages = [];

                foreach ($keys as $key) {
                    $pages[] = array(
                        'title' => $this->resourcePage->getCmsPageTitleByIdentifier($key),
                        'url' => $this->getUrl($key)
                    );
                }

                return $pages;
            }
        }
        return null;
    }

    /**
     * @return SearchCriteria
     */
    protected function getSearchCriteria(): SearchCriteria
    {
        return $this->searchCriteriaBuilder->addFilter('is_active', '1')->create();
    }
}
