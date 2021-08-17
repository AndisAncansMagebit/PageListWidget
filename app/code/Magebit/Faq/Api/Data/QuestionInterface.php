<?php

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;
use Magento\Framework\Stdlib\DateTime;

/**
 * @api
 * @since 0.0.1
 */
interface QuestionInterface extends CustomAttributesDataInterface
{
    /**
     * Constants defined for keys of data array
     */
    const ID = 'id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    /**
     * Returns Id field
     *
     * @return int
     * @since 0.0.1
     */
    public function getId();

    /**
     * @param string $question
     * @return $this
     * @since 100.1.0
     */
    public function setQuestion($question);

    /**
     * Returns Question field
     *
     * @return string
     * @since 0.0.1
     */
    public function getQuestion();

    /**
     * @param string $answer
     * @return $this
     * @since 100.1.0
     */
    public function setAnswer($answer);

    /**
     * Returns Answer field
     *
     * @return string
     * @since 0.0.1
     */
    public function getAnswer();

    /**
     * @param int $status
     * @return $this
     * @since 100.1.0
     */
    public function setStatus($status);

    /**
     * Returns Status field
     *
     * @return int
     * @since 0.0.1
     */
    public function getStatus();

    /**
     * @param int $position
     * @return $this
     * @since 100.1.0
     */
    public function setPosition($position);

    /**
     * Returns Position field
     *
     * @return int
     * @since 0.0.1
     */
    public function getPosition();

    /**
     * Returns Updated At field
     *
     * @return DateTime
     * @since 0.0.1
     */
    public function getUpdatedAt();
}