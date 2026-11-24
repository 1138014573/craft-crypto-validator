<?php
namespace allswap\cryptovalidator\twigextensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
use allswap\cryptovalidator\validators\CryptoAddressValidator;

/**
 * Twig filters and functions for Craft CMS templates
 */
class CryptoTwigExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('isCryptoAddress', [$this, 'isCryptoAddressFilter']),
            new TwigFilter('truncateCryptoAddress', [$this, 'truncateCryptoAddressFilter']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('validateCryptoAddress', [$this, 'validateAddressFunction']),
        ];
    }

    public function isCryptoAddressFilter(string $address, string $chain = 'any'): bool
    {
        $validator = new CryptoAddressValidator(['chain' => $chain]);
        return $validator->validate($address);
    }

    public function validateAddressFunction(string $address, string $chain = 'any'): bool
    {
        return $this->isCryptoAddressFilter($address, $chain);
    }

    public function truncateCryptoAddressFilter(string $address, int $start = 6, int $end = 4): string
    {
        $len = strlen($address);
        if ($len <= ($start + $end)) {
            return $address;
        }
        return substr($address, 0, $start) . '...' . substr($address, -$end);
    }
}
