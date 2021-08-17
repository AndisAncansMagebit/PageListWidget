<?php declare(strict_types=1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Model;

use Magebit\Faq\Api\QuestionManagementInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class QuestionManagement implements QuestionManagementInterface
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param $id
     * @return Question
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function enableQuestion($id): Question
    {
        $question = $this->questionRepository->getById($id);

        if ($question->getId() && $question->getStatus() == Question::STATUS_DISABLED) {
            $question->setStatus(Question::STATUS_ENABLED);
            $this->questionRepository->save($question);
        }
        return $question;
    }

    /**
     * @param $id
     * @return Question
     * @throws AlreadyExistsException
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function disableQuestion($id): Question
    {
        $question = $this->questionRepository->getById($id);

        if ($question->getId() && $question->getStatus() == Question::STATUS_ENABLED) {
            $question->setStatus(Question::STATUS_DISABLED);
            $this->questionRepository->save($question);
        }
        return $question;
    }
}
