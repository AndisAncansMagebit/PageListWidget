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

use Exception;
use Magebit\Faq\Model\Question;
use Magebit\Faq\Model\QuestionManagement;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\Faq\Model\ResourceModel\Question\CollectionFactory;

/**
 * Class MassEnable
 */
class MassEnable extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Magebit_Faq::faq_control';

    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var QuestionManagement
     */
    private $questionManagement;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QuestionManagement $questionManagement
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QuestionManagement $questionManagement
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->questionManagement = $questionManagement;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return Redirect
     * @throws LocalizedException|Exception
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $question) {
            if ($question->getStatus() == Question::STATUS_DISABLED) {
                $question->setStatus(Question::STATUS_ENABLED)->save();
            }
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been enabled.', $collectionSize));

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
