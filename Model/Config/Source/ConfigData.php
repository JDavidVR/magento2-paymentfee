<?php

/**
 * MagePrince
 * Copyright (C) 2019 Mageprince
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category MagePrince
 * @package Prince_Paymentfee
 * @copyright Copyright (c) 2018 MagePrince
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MagePrince
 */

namespace Prince\Paymentfee\Model\Config\Source;

class ConfigData
{
    /**
     * Module status config path
     */
    const MODULE_STATUS_XML_PATH = 'paymentfee/general/active';

    /**
     * Payment fee zeropayment fee config path
     */
    const PAYMENTFEE_ZEROPAYMENT_XML_PATH = 'paymentfee/general/zeropaymentfee';

    /**
     * Payment fee discriotion status config path
     */
    const PAYMENTFEE_SHOW_DESCRIPTION_XML_PATH = 'paymentfee/general/is_description';

    /**
     * Payment fee description content config path
     */
    const PAYMENTFEE_DESCRIPTION_XML_PATH = 'paymentfee/general/description';

    /**
     * Payment fee minimum order amount config path
     */
    const PAYMENTFEE_MINORDER_XML_PATH = 'paymentfee/paymentfee_settings/minorderamount';

    /**
     * Payment fee title config path
     */
    const PAYMENTFEE_TITLE_XML_PATH = 'paymentfee/general/title';

    /**
     * Payment fee pricetype config path
     */
    const PAYMENTFEE_PRICETYPE_XML_PATH = 'paymentfee/paymentfee_settings/pricetype';

    /**
     * Payment fee customer group config path
     */
    const PAYMENTFEE_CUSTOMERS_XML_PATH = 'paymentfee/paymentfee_settings/customers';

    /**
     * Payment fee amount config path
     */
    const PAYMENTFEE_AMOUNT_XML_PATH = 'paymentfee/paymentfee_settings/paymentfee';

    /**
     * Default payment fee
     */
    const PAYMENTFEE_DEFAULT_FEE_XML_PATH = 'paymentfee/paymentfee_settings/default_fee';
}
