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

use Magebit\Faq\Model\QuestionRepository;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepository $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepository $questionRepository
    ) {
        $this->questionRepository = $questionRepository;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->questionRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(__('You deleted the question.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
