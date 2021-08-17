<?php declare(strict_types = 1);

/**
 * Magebit_Faq
 *
 * @category     Magebit
 * @package      Magebit_Faq
 * @author       Andis Ancans
 * @copyright    Copyright (c) 2021 Magebit, Ltd.(http://www.magebit.com/)
 */

namespace Magebit\Faq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'magebit_faq_questions_collection';
    protected $_eventObject = 'questions_collection';

    /**
     * Define Resource Model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(\Magebit\Faq\Model\Question::class,
            \Magebit\Faq\Model\ResourceModel\Question::class);
    }

}
