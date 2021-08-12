<?php
/**
 * Magebit/learning
 *
 * @category        Magebit
 * @package         Magebit/learning
 * @author          Andis Ancans <info@magebit.com>
 * @copyright       Copyright (c) 2021 Magebit, Ltd.
 * @license         http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::THEME, 'frontend/Magebit/learning', __DIR__);
