<?php declare(strict_types = 1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magebit\Faq\Api\QuestionRepositoryInterface;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var QuestionFactory
     */
    private $questionFactory;

    /**
     * @var ResourceModel\Question
     */
    private $questionResource;

    /**
     * @var CollectionFactory
     */
    private $questionCollectionFactory;

    /**
     * @var QuestionSearchResultsFactory
     */
    private $questionSearchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    /**
     * @param QuestionFactory $questionFactory
     * @param ResourceModel\Question $questionResource
     * @param CollectionFactory $questionCollectionFactory
     * @param QuestionSearchResultsFactory $questionSearchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param HydratorInterface $hydrator
     */
    public function __construct(
        QuestionFactory $questionFactory,
        ResourceModel\Question $questionResource,
        CollectionFactory $questionCollectionFactory,
        QuestionSearchResultsFactory $questionSearchResultsFactory,
        CollectionProcessorInterface $collectionProcessor,
        HydratorInterface $hydrator
    ) {
        $this->questionFactory = $questionFactory;
        $this->questionResource = $questionResource;
        $this->questionCollectionFactory = $questionCollectionFactory;
        $this->questionSearchResultsFactory = $questionSearchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     * @throws NoSuchEntityException
     */
    public function save(QuestionInterface $faq): QuestionInterface
    {
        if ($faq->getId() && $faq instanceof QuestionInterface && !$faq->getOrigData()) {
            $faq = $this->hydrator->hydrate($this->getById($faq->getId()), $this->hydrator->extract($faq));
        }

        try {
            $this->questionResource->save($faq);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $faq;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteria $searchCriteria)
    {
        $collection = $this->questionCollectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        $searchResults = $this->questionSearchResultsFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }

    /**
     * @param int $id
     * @return Question
     * @throws NoSuchEntityException
     */
    public function getById($id): Question
    {
        $question = $this->questionFactory->create();
        $this->questionResource->load($question, $id);
        if (!$question->getId()) {
            throw new NoSuchEntityException(__('Unable to find Question with ID "%1"', $id));
        }
        return $question;
    }

    /**
     * @inheritDoc
     */
    public function delete(QuestionInterface $faq): bool
    {
        try {
            $this->questionResource->delete($faq);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the entry: %1', $exception->getMessage()));
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($id)
    {
        $question = $this->questionFactory->create();
        $this->questionResource->load($question, $id);
        try {
            $this->questionResource->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__('Could not delete the entry: %1', $exception->getMessage()));
        }

    }
}
