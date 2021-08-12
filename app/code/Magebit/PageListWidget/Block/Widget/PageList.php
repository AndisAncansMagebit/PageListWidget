<?php declare(strict_types = 1);
/**
 * Magebit_PageListWidget
 *
 * @category        Magebit
 * @package         Magebit_PageListWidget
 * @author          Andis Ancans <info@magebit.com>
 * @copyright       Copyright (c) 2021 Magebit, Ltd.
 * @license         http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace Magebit\PageListWidget\Block\Widget;

use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class PageList extends Template implements BlockInterface
{
    public const PAGE_SCOPE = 'page_scope';
    public const SELECTED_PAGES = 'pages';
    public const SPECIFIC_PAGES = 0;
    public const ALL_PAGES = 1;

    /**
     * @var string
     */
    protected $_template = 'page-list.phtml';

    /**
     * @var PageRepositoryInterface
     */
    protected PageRepositoryInterface $pageRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var FilterGroupBuilder
     */
    protected FilterGroupBuilder $filterGroupBuilder;

    /**
     * @var FilterBuilder
     */
    protected FilterBuilder $filterBuilder;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param FilterBuilder $filterBuilder
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
        Template\Context $context,
        array $data = []
    ) {
        $this->pageRepository = $pageRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Returns array of selected/all page titles and urls
     *
     * @since 0.0.1
     *
     * @return array|null
     * @throws LocalizedException
     */
    public function getPageUrls(): ?array
    {
        $page_scope = $this->getData(self::PAGE_SCOPE);
        if ($page_scope == self::ALL_PAGES) {
            $pages = [];

            foreach ($this->pageRepository->getList($this->getIsActiveSearchCriteria())->getItems() as $page) {
                $pages[] = [
                    'title' => $page->getTitle(),
                    'url' => $this->getUrl($page->getIdentifier())
                ];
            }
            return $pages;
        } else {
            if ($page_scope == self::SPECIFIC_PAGES) {
                $sites = $this->getData(self::SELECTED_PAGES);
                $keys = explode(",", $sites);
                $pages = [];

                foreach ($this->pageRepository->getList($this->createPageSearchCriteria($keys))->getItems() as $page) {
                    $pages[] = array(
                        'title' => $page->getTitle(),
                        'url' => $this->getUrl($page->getIdentifier())
                    );
                }

                return $pages;
            }
        }
        return null;
    }

    /**
     * Build SearchCriteria
     *
     * @since 0.0.1
     *
     * @return SearchCriteria
     */
    protected function getIsActiveSearchCriteria(): SearchCriteria
    {
        return $this->searchCriteriaBuilder->addFilter('is_active', '1')->create();
    }

    /**
     * Builds SearchCriteria from page identifiers
     *
     * @since 0.0.1
     *
     * @param $pages
     *
     * @return SearchCriteria
     */
    protected function createPageSearchCriteria($pages): SearchCriteria
    {
        $filters = [];

        foreach ($pages as $page) {
            $filter = $this->filterBuilder
                ->setField("identifier")
                ->setValue($page)
                ->setConditionType("eq")
                ->create();
            $filters[] = $filter;
        }
        $filterGroup = $this->filterGroupBuilder->setFilters($filters)->create();

        return $this->searchCriteriaBuilder->setFilterGroups([$filterGroup])->create();
    }
}
