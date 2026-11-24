<?php
namespace allswap\cryptovalidator\validators;

use yii\validators\Validator;
use Craft;

/**
 * Validates multi-chain cryptocurrency wallet addresses.
 * Supported chains: BTC (Legacy, SegWit, Taproot), ETH/EVM/BSC, SOL, TON, TRON.
 */
class CryptoAddressValidator extends Validator
{
    /**
     * @var string Target blockchain network ('btc', 'eth', 'evm', 'bsc', 'sol', 'ton', 'tron', 'any')
     */
    public string $chain = 'any';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Craft::t('crypto-address-validator', 'The address "{value}" is not a valid {chain} cryptocurrency address.');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function validateValue($value): ?array
    {
        if (!is_string($value) || trim($value) === '') {
            return [$this->message, ['value' => (string)$value, 'chain' => strtoupper($this->chain)]];
        }

        $address = trim($value);
        $valid = false;
        $chain = strtolower($this->chain);

        switch ($chain) {
            case 'btc':
            case 'bitcoin':
                $valid = self::isBitcoinAddress($address);
                break;

            case 'eth':
            case 'ethereum':
            case 'evm':
            case 'bsc':
            case 'polygon':
            case 'arbitrum':
            case 'base':
                $valid = self::isEvmAddress($address);
                break;

            case 'sol':
            case 'solana':
                $valid = self::isSolanaAddress($address);
                break;

            case 'ton':
                $valid = self::isTonAddress($address);
                break;

            case 'trx':
            case 'tron':
                $valid = self::isTronAddress($address);
                break;

            case 'any':
            default:
                $valid = self::isBitcoinAddress($address)
                    || self::isEvmAddress($address)
                    || self::isSolanaAddress($address)
                    || self::isTonAddress($address)
                    || self::isTronAddress($address);
                break;
        }

        if (!$valid) {
            return [$this->message, ['value' => $address, 'chain' => strtoupper($chain)]];
        }

        return null;
    }

    /**
     * Validate EVM address (Ethereum, BSC, Polygon, Arbitrum, Base, Optimism)
     */
    public static function isEvmAddress(string $address): bool
    {
        return (bool)preg_match('/^0x[a-fA-F0-9]{40}$/', $address);
    }

    /**
     * Validate Bitcoin address (P2PKH 1..., P2SH 3..., Bech32 SegWit bc1q..., Taproot bc1p...)
     */
    public static function isBitcoinAddress(string $address): bool
    {
        // Bech32 / Bech32m (bc1...)
        if (preg_match('/^bc1[a-z0-9]{39,59}$/i', $address)) {
            return true;
        }
        // Base58 Legacy / P2SH (1... or 3...)
        if (preg_match('/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/', $address)) {
            return true;
        }
        return false;
    }

    /**
     * Validate Solana address (Base58, 32 to 44 characters)
     */
    public static function isSolanaAddress(string $address): bool
    {
        return (bool)preg_match('/^[1-9A-HJ-NP-Za-km-z]{32,44}$/', $address);
    }

    /**
     * Validate TRON address (starts with T, Base58 34 characters)
     */
    public static function isTronAddress(string $address): bool
    {
        return (bool)preg_match('/^T[a-km-zA-HJ-NP-Z1-9]{33}$/', $address);
    }

    /**
     * Validate TON address (user-friendly bounceable/non-bounceable EQ/UQ base64, 48 chars)
     */
    public static function isTonAddress(string $address): bool
    {
        // Standard base64url or base64 user-friendly address (EQ... or UQ...)
        if (preg_match('/^[EU]Q[a-zA-Z0-9_\-]{46}$/', $address)) {
            return true;
        }
        // Raw format 0:hash or -1:hash
        if (preg_match('/^-?[0-9]:[a-fA-F0-9]{64}$/', $address)) {
            return true;
        }
        return false;
    }
}
