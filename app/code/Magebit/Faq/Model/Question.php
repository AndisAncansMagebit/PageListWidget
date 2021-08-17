<?php

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
use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Stdlib\DateTime;

class Question extends AbstractModel implements IdentityInterface, QuestionInterface
{

    const CACHE_TAG = 'magebit_faq_questions';

    protected $_cacheTag = 'magebit_faq_questions';

    protected $_eventPrefix = 'magebit_faq_questions';

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $registry,
        AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    public function _construct()
    {
        $this->_init(ResourceModel\Question::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getId()
    {
        return parent::getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setQuestion($question)
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * @inheritDoc
     */
    public function getQuestion()
    {
        return $this->getData(self::QUESTION);
    }

    /**
     * @inheritDoc
     */
    public function setAnswer($answer)
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * @inheritDoc
     */
    public function getAnswer()
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * @inheritDoc
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * @inheritDoc
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @inheritDoc
     */
    public function getCustomAttribute($attributeCode)
    {
        return $this->getData($attributeCode);
    }

    /**
     * @inheritDoc
     */
    public function setCustomAttribute($attributeCode, $attributeValue)
    {
        return $this->setData($attributeCode, $attributeValue);
    }

    /**
     * @inheritDoc
     */
    public function getCustomAttributes()
    {
        return $this->getData();
    }

    /**
     * @inheritDoc
     */
    public function setCustomAttributes(array $attributes)
    {
        return $this->setData($attributes);
    }
}