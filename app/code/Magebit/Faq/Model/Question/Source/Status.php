<?php declare(strict_types = 1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magebit\Faq\Model\Question;

class Status implements OptionSourceInterface
{
    /**
     * @var Question
     */
    protected $question;

    /**
     * Constructor
     *
     * @param Question $question
     */
    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Enabled',
                'value' => Question::STATUS_ENABLED,
            ],
            1 => [
                'label' => 'Disabled',
                'value' => Question::STATUS_DISABLED,
            ],
        ];

        return $options;
    }
}