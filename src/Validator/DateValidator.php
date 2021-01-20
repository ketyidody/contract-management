<?php

namespace App\Validator;

use App\Entity\Contract;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @Annotation
 */
class DateValidator
{
    const MESSAGE_OCCUPIED = 'The date {{ date }} has already been taken';

    const MESSAGE_INVALID_RANGE = 'The end date must be bigger than the start date';

    const MESSAGE_PAST_DATE = 'You must pick a date in the future';

    public static function validate($object, ExecutionContextInterface $context, $payload)
    {
        if (!$object instanceof Contract) {
            throw new UnexpectedTypeException($object, Contract::class);
        }

        // End date is sooned than start date
        if ($object->getEndDate() < $object->getStartDate()) {
            $context->buildViolation(self::MESSAGE_INVALID_RANGE)
                ->addViolation()
            ;

            return;
        }

//        // Start date or/and end date is in the past
//        $now = (new \DateTime())->modify('today midnight');
//        if ($object->getStartDate() < $now) {
//            $context->buildViolation(self::MESSAGE_PAST_DATE)
//                ->addViolation()
//            ;
//
//            return;
//        }

        $requestedDateRange = new DateRange($object->getStartDate(), $object->getEndDate());

        $existingContracts = $object->getRentalObject()->getContracts();

        // Check if date is occupied
        /** @var Contract $existingContract */
        foreach ($existingContracts as $existingContract) {
            if ($existingContract === $object) {
                continue;
            }

            if (self::isDatesOverlap(new DateRange($existingContract->getStartDate(), $existingContract->getEndDate()), $requestedDateRange)) {
                $context->buildViolation(SELF::MESSAGE_OCCUPIED)
                    ->setParameter('{{ date }}', $requestedDateRange->getFrom()->format('Y-m-d') . ' - ' . $requestedDateRange->getTo()->format('Y-m-d'))
                    ->addViolation()
                ;
            }
        }
    }

    protected static function isDatesOverlap(DateRange $occupiedDateRange, DateRange $requestedDateRange)
    {
        dump($occupiedDateRange, $requestedDateRange);
        if ($occupiedDateRange->getFrom() > $requestedDateRange->getTo()) {
            return false;
        }

        if ($occupiedDateRange->getTo() < $requestedDateRange->getFrom()) {
            return false;
        }

        return true;
    }
}