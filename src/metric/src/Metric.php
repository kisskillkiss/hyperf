<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Metric;

use Hyperf\Metric\Contract\MetricFactoryInterface;

/**
 * A Facade-like, syntax sugar class to create one-off metrics
 * Beta Feature. API may change.
 */
class Metric
{
    public static function count(string $name, ?int $delta = 1, ?array $labels = [])
    {
        make(MetricFactoryInterface::class)
            ->makeCounter($name, array_keys($labels))
            ->with(...array_values($labels))
            ->add($delta);
    }

    public static function gauge(string $name, float $delta, ?array $labels = [])
    {
        make(MetricFactoryInterface::class)
            ->makeGauge($name, array_keys($labels))
            ->with(...array_values($labels))
            ->set($delta);
    }

    public static function histogram(string $name, float $delta, ?array $labels = [])
    {
        make(MetricFactoryInterface::class)
            ->makeHistogram($name, array_keys($labels))
            ->with(...array_values($labels))
            ->put($delta);
    }

    public static function time(string $name, callable $func, ?array $args = [], ?array $labels = [])
    {
        $timer = new Timer($name, $labels);
        return $func(...$args);
    }
}
