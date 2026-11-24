# Changelog: Crypto Address Validator

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.0.0 - 2026-11-24

### Added
- Initial release of Crypto Address Validator for Craft CMS 4 and Craft CMS 5.
- Multi-chain address validation support for:
  - Bitcoin (Legacy Base58, SegWit Bech32 `bc1q`, Taproot `bc1p`)
  - Ethereum and EVM-compatible chains (BSC, Polygon, Arbitrum, Base, Optimism)
  - Solana (Base58 address format)
  - TON (The Open Network User-Friendly bounceable/non-bounceable `EQ`/`UQ` & Raw)
  - TRON (`T` prefix Base58 format)
- Twig filter `isCryptoAddress(chain)` and `truncateCryptoAddress(start, end)`.
- Twig function `validateCryptoAddress(address, chain)`.
- Native Yii2 / Craft Form Model validation support.
