<?php declare(strict_types = 1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Block;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Model\Question;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magebit\Faq\Model\QuestionRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

class QuestionList extends Template
{
    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->questionRepository = $questionRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context);
    }

    /**
     * @return array
     * @throws NoSuchEntityException
     */
    public function prepareQuestions(): array
    {
        $sortOrder = $this->sortOrderBuilder->setField(QuestionInterface::POSITION)
            ->setAscendingDirection()->create();
        $searchCriteria = $this->searchCriteriaBuilder->addFilter(QuestionInterface::STATUS,
            Question::STATUS_ENABLED)->setSortOrders([$sortOrder])->create();
        $questions = $this->questionRepository->getList($searchCriteria);
        $faqs = [];

        foreach ($questions->getItems() as $question) {
            $faqs[] = array(
                'question' => $question->getQuestion(),
                'answer' => $question->getAnswer()
            );
        }

        return $faqs;
    }
}
