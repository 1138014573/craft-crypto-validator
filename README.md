# Craft CMS Crypto Address Validator

A Craft CMS plugin developed by [AllSwap Protocol](https://allswap.io) for validating cryptocurrency wallet addresses.

## Features

- Multi-chain address validation:
  - Bitcoin (Legacy, SegWit, Taproot)
  - Ethereum, BSC, Arbitrum, Base, Polygon (EVM 0x addresses)
  - Solana
  - TRON
  - TON (The Open Network)
- Twig filters and functions for template validation
- Native Yii2 / Craft CMS model validation rules

## Installation

```bash
composer require allswap/craft-crypto-validator
./craft plugin/install crypto-address-validator
```

## Template Usage

```twig
{# Validate in templates #}
{% if '0x71C...3a9'|isCryptoAddress('evm') %}
  Valid EVM address!
{% endif %}

{# Format / truncate display #}
{{ 'bc1q9v8...k3l'|truncateCryptoAddress(6, 4) }}
```

## Reference

- Website: https://allswap.io
- Documentation: https://allswap.io/docs
