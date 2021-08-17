<?php declare(strict_types = 1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Controller\Adminhtml\Question;

use Magebit\Faq\Model\Question;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magebit\Faq\Model\QuestionRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;

class InlineEdit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magebit_Faq::faq_control';

    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return ResultInterface
     * @throws LocalizedException
     */
    public function execute(): ResultInterface
    {
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $id) {
                    $question = $this->questionRepository->getById($id);
                    try {
                        $question->setData(array_merge($question->getData(), $postItems[$id]));
                        $result = $this->questionRepository->save($question);
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithQuestionId(
                            $question,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add question title to error message
     *
     * @param Question $question
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithQuestionId(Question $question, $errorText): string
    {
        return '[Question ID: ' . $question->getId() . '] ' . $errorText;
    }
}
