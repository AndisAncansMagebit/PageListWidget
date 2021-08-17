<?php

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Api;

use Magebit\Faq\Api\Data\QuestionInterface;
use Magento\Framework\Api\SearchCriteria;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Interface QuestionRepositoryInterface
 * @api
 * @since 0.0.1
 */
interface QuestionRepositoryInterface
{
    /**
     * @param QuestionInterface $faq
     * @return QuestionInterface
     * @throws CouldNotSaveException
     * @throws AlreadyExistsException
     * @since 0.0.1
     */
    public function save(QuestionInterface $faq);

    /**
     * @return QuestionInterface
     * @throws NoSuchEntityException
     * @since 0.0.1
     */
    public function getList(SearchCriteria $searchCriteria);

    /**
     * @param int $id
     * @return QuestionInterface
     * @throws NoSuchEntityException
     * @since 0.0.1
     */
    public function getById($id);

    /**
     * @param QuestionInterface $faq
     * @return bool
     * @throws CouldNotDeleteException
     * @since 0.0.1
     */
    public function delete(QuestionInterface $faq);

    /**
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     * @since 0.0.1
     */
    public function deleteById($id);

}