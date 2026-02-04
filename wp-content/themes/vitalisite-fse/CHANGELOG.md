# Changelog

Toutes les modifications notables de ce projet seront documentées dans ce fichier.

Le format est basé sur [Keep a Changelog](https://keepachangelog.com/fr/1.0.0/),
et ce projet adhère au [Semantic Versioning](https://semver.org/lang/fr/).

## [Non publié]

### À venir

- Patterns de contenu additionnels
- Blocs personnalisés
- Documentation utilisateur

---

## [0.1.0] - 2026-02-04

### Ajouté

- **Système multi-thèmes** avec 5 variations de style :
  - Clinique (bleu professionnel, 6px radius)
  - Mineral (gris brutalist, 0px radius)
  - Nature (vert organique, 999px pill buttons)
  - Nocturne (violet dark mode, 6px radius)
  - Solaire (terracotta chaleureux, 12px radius)
- **Palettes de couleurs** prédéfinies (5) dans `/styles/colors/`
- **Presets typographiques** (4) dans `/styles/typography/` :
  - System Modern
  - Serif Classic
  - Mono Tech
  - Mixed Contrast
- **Design system** complet dans `theme.json` :
  - 13 couleurs sémantiques
  - 4 gradients
  - 7 tailles de police fluides
  - 7 espacements avec `clamp()`
  - 4 ombres portées
- **Header minimal** inspiré du thème Ollie
- **Border-radius cohérent** entre CTAs et sections hero par thème
- Support WordPress 6.7+ avec `theme.json` v3

### Modifié

- Refonte complète de l'architecture FSE
- Migration de Elementor vers FSE natif
- Suppression des dépendances plugins

### Technique

- PHP 7.4+ requis
- WordPress 6.0+ minimum
- Testé jusqu'à WordPress 6.7

---

## Format des versions

- **MAJOR** (x.0.0) : Changements incompatibles avec versions précédentes
- **MINOR** (0.x.0) : Nouvelles fonctionnalités rétrocompatibles
- **PATCH** (0.0.x) : Corrections de bugs rétrocompatibles

---

## Liens

- [Non publié]: https://github.com/votre-repo/vitalisite-fse/compare/v0.1.0...HEAD
- [0.1.0]: https://github.com/votre-repo/vitalisite-fse/releases/tag/v0.1.0
