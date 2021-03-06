<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusMolliePlugin\Repository;

use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderPaymentStates;

final class OrderRepository extends BaseOrderRepository implements OrderRepositoryInterface
{
    public function findAbandonedByDateTime(\DateTime $dateTime): array
    {
        return $this->createQueryBuilder('o')
            ->where('o.paymentState = :paymentState')
            ->andWhere('o.state = :state')
            ->andWhere('o.createdAt <= :createdAt')
            ->andWhere('o.abandonedEmail = :abandonedEmail')
            ->setParameter('state', OrderInterface::STATE_NEW)
            ->setParameter('paymentState', OrderPaymentStates::STATE_AWAITING_PAYMENT)
            ->setParameter('createdAt', $dateTime)
            ->setParameter('abandonedEmail', false)
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
            ;
    }
}
