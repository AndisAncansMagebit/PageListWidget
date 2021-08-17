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

use Magebit\Faq\Model\Question;

interface QuestionManagementInterface
{

    /**
     * @param $id
     * @return Question
     */
    public function enableQuestion($id): Question;

    /**
     * @param $id
     * @return Question
     */
    public function disableQuestion($id): Question;

}
