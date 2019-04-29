<?php

declare(strict_types=1);

namespace BehatContexts\contexts;

use Exception;
use Throwable;

trait Spinner
{
    /**
     * {@inheritdoc}
     */
    public function waitFor(callable $lambda, int $timeout = 120)
    {
        $lastException = new Exception(
    'Timeout expired before a single try could be attempted. Is your timeout too short?'
        );

        $start = time();
        while (time() - $start < $timeout)
        {
            try {
                return $lambda();
            } catch (Throwable $e) {
                $lastException = $e;
            }

            sleep(1);
        }

        throw $lastException;
    }

    /**
     * {@inheritdoc}
     */
    public function assertForTimeout(callable $lambda, int $timeout = 30)
    {
        $start = time();
        while (time() - $start < $timeout) {
            $lambda();

            sleep(1);
        }
    }
}
