<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\CoreBundle\OrderProcessing;

use PHPSpec2\ObjectBehavior;
use Sylius\Bundle\CoreBundle\Entity\Order;

/**
 * Taxation processor spec.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class TaxationProcessor extends ObjectBehavior
{
    /**
     * @param Sylius\Bundle\ResourceBundle\Model\RepositoryInterface         $adjustmentRepository
     * @param Sylius\Bundle\TaxationBundle\Calculator\CalculatorInterface    $calculator
     * @param Sylius\Bundle\TaxationBundle\Resolver\TaxRateResolverInterface $taxRateResolver
     * @param Sylius\Bundle\AddressingBundle\Matcher\ZoneMatcherInterface    $zoneMatcher
     * @param Sylius\Bundle\SettingsBundle\Model\Settings                    $taxationSettings
     */
    function let($adjustmentRepository, $calculator, $taxRateResolver, $zoneMatcher, $taxationSettings)
    {
        $this->beConstructedWith($adjustmentRepository, $calculator, $taxRateResolver, $zoneMatcher, $taxationSettings);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Sylius\Bundle\CoreBundle\OrderProcessing\TaxationProcessor');
    }

    function it_implements_Sylius_taxation_processor_interface()
    {
        $this->shouldImplement('Sylius\Bundle\CoreBundle\OrderProcessing\TaxationProcessorInterface');
    }

    /**
     * @param Sylius\Bundle\CoreBundle\Model\OrderInterface $order
     */
    function it_doesnt_apply_any_taxes_if_order_has_no_items($order)
    {
        $order->getItems()->willReturn(array());
        $order->addAdjustment(ANY_ARGUMENT)->shouldNotBeCalled();

        $this->applyTaxes($order);
    }
}
