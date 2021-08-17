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
use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Stdlib\DateTime;
use Magento\Tests\NamingConvention\true\string;

class Question extends AbstractModel implements IdentityInterface, QuestionInterface
{
    /**
     * Cache tag
     */
    const CACHE_TAG = 'magebit_faq_questions';

    /**
     * @inheirtDoc
     */
    protected $_cacheTag = 'magebit_faq_questions';

    /**
     * @inheirtDoc
     */
    protected $_eventPrefix = 'magebit_faq_questions';

    /**
     * Constants for Question status
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param AbstractResource|null $resource
     * @param AbstractDb|null $resourceCollection
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel\Question::class);
    }

    /**
     * @inheritDoc
     */
    public function getIdentities(): array
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return parent::getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setQuestion(string $question): Question
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
    public function setAnswer(string $answer): Question
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * @inheritDoc
     */
    public function getAnswer(): string
    {
        return $this->getData(self::ANSWER);
    }

    /**
     * @inheritDoc
     */
    public function setStatus(int $status): Question
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): int
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritDoc
     */
    public function setPosition(int $position): Question
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): int
    {
        return $this->getData(self::POSITION);
    }

    /**
     * @inheritDoc
     */
    public function getUpdatedAt(): DateTime
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
