<?php

declare(strict_types=1);

namespace App\Reservation\Infrastructure\Validator;

use DateTime;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReservationPeriodValidator
{
    public static function validateStart(mixed $value, ExecutionContextInterface $context): void
    {

        /**
         * @var App\Reservation\Application\DTO\ReservePlaceDTO $reserveDTO
         */
        $reserveDTO  = $context->getObject();

        $startTimestamp = $value ? $value->getTimestamp() : null;
        $endTimestamp = $reserveDTO->getEnd() ? $reserveDTO->getEnd()->getTimestamp() : null;
        $nowTimestamp = (new DateTime())->getTimestamp();

        $error = match (true) {
            !$startTimestamp => "Start cannot be blank.",
            $startTimestamp <= $nowTimestamp => "Start Date cannot be from past.",
            $startTimestamp >= $endTimestamp => "Start Date cannot be later then End Date.",
            $startTimestamp > $nowTimestamp && $startTimestamp < $endTimestamp => false
        };

        if ($error) {
            $context->buildViolation($error)
                ->atPath('start')
                ->addViolation();
        }
    }
    public static function validateEnd(mixed $value, ExecutionContextInterface $context, mixed $payload): void
    {
        $endTimestamp = $value ? $value->getTimestamp() : null;
        $nowTimestamp = (new DateTime())->getTimestamp();

        $error = match (true) {
            !$endTimestamp => "End cannot be blank.",
            $endTimestamp <= $nowTimestamp => "End Date cannot be from past.",
            $endTimestamp > $nowTimestamp => false
        };

        if ($error) {
            $context->buildViolation($error)
                ->atPath('end')
                ->addViolation();
        }
    }
}
