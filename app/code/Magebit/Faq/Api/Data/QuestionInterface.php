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
    public function getId(): int;

    /**
     * @param string $question
     * @return $this
     * @since 100.1.0
     */
    public function setQuestion(string $question): QuestionInterface;

    /**
     * Returns Question field
     *
     * @return string
     * @since 0.0.1
     */
    public function getQuestion(): string;

    /**
     * @param string $answer
     * @return $this
     * @since 100.1.0
     */
    public function setAnswer(string $answer): QuestionInterface;

    /**
     * Returns Answer field
     *
     * @return string
     * @since 0.0.1
     */
    public function getAnswer(): string;

    /**
     * @param int $status
     * @return $this
     * @since 100.1.0
     */
    public function setStatus(int $status): QuestionInterface;

    /**
     * Returns Status field
     *
     * @return int
     * @since 0.0.1
     */
    public function getStatus(): int;

    /**
     * @param int $position
     * @return $this
     * @since 100.1.0
     */
    public function setPosition(int $position): QuestionInterface;

    /**
     * Returns Position field
     *
     * @return int
     * @since 0.0.1
     */
    public function getPosition(): int;

    /**
     * Returns Updated At field
     *
     * @return DateTime
     * @since 0.0.1
     */
    public function getUpdatedAt(): DateTime;
}
