# Checklist Mise en Production — Vitalisite FSE

> À suivre pour chaque déploiement du thème chez un client praticien de santé.

---

## 1. Pré-déploiement (sur le poste dev)

### Fichiers & code
- [ ] Vérifier que `WP_DEBUG` est à `false` dans `wp-config.php` du site cible
- [ ] Vérifier que `VITALISITE_DEV_MODE` n'est **pas** défini (ou `false`)
- [ ] Supprimer le fichier `wp-content/debug.log` s'il existe
- [ ] Vérifier la version dans `style.css` (header `Version:`) — incrémenter si besoin
- [ ] Vérifier que `theme.json` → `$schema` pointe vers la bonne version WP cible
- [ ] S'assurer qu'aucun `console.log()` de debug ne traîne dans les fichiers JS

### Assets
- [ ] Vérifier que tous les CSS/JS sont bien enqueued dans `functions.php`
- [ ] Vérifier que Swiper.js (`assets/js/vendor/swiper.min.js`) est présent et minifié
- [ ] Vérifier que les images placeholder ne sont pas incluses (pas de données de test)

---

## 2. Installation sur le serveur

### WordPress
- [ ] WordPress ≥ 6.5 (requis pour Block Bindings, theme.json v3)
- [ ] PHP ≥ 7.4 (recommandé : 8.1+)
- [ ] Activer le thème `vitalisite-fse`
- [ ] Vérifier qu'aucun thème enfant ou plugin n'entre en conflit

### Configuration initiale
- [ ] **Vitalisite > Réglages > Cabinet** : remplir nom, téléphone, email, adresse, spécialité
- [ ] **Vitalisite > Réglages > Horaires** : configurer les horaires d'ouverture
- [ ] **Vitalisite > Réglages > Réseaux sociaux** : renseigner les liens (Google, Doctolib, etc.)
- [ ] **Vitalisite > Réglages > Fonctionnalités** : activer/désactiver bannière, sticky CTA

---

## 3. Vérification des patterns & blocs

### Patterns à tester (insérer sur une page et vérifier le rendu front)
- [ ] **Hero** (3 variations) — image, titre, boutons
- [ ] **Bento Grid** — responsive, images
- [ ] **Cards** — affichage, hover
- [ ] **Text + Image** — alignement, responsive
- [ ] **Accordion** — ouverture/fermeture, animation
- [ ] **Slider** — navigation, autoplay, responsive
- [ ] **Testimonials** — carousel Swiper, pagination, flèches
- [ ] **Doctor Presentation** — photo arrondie (respecte `--wp--custom--image-radius`), infos
- [ ] **Before/After** — slider interactif
- [ ] **Opening Hours** — données dynamiques depuis les réglages
- [ ] **Video** — lecture, responsive
- [ ] **Pricing** — bordures visibles, boutons alignés en bas, centrage si < 3 cards
- [ ] **Contact Form** — voir section 4 ci-dessous

### Templates
- [ ] **Page d'accueil** (`front-page.html`) — rendu correct
- [ ] **Page standard** (`page.html`) — contenu affiché
- [ ] **Page de liens** (`template-links.html`) — metabox visible, liens affichés, éditeur masqué

### Template Parts
- [ ] **Header** — logo, navigation, responsive, menu mobile
- [ ] **Footer** — infos cabinet dynamiques, liens sociaux, copyright

---

## 4. ✉️ Test envoi d'email (CRITIQUE)

> `wp_mail()` fonctionne nativement sur les hébergeurs classiques (OVH, o2switch, Infomaniak…).
> En local, les emails ne sont PAS envoyés sans serveur SMTP.

### Test du formulaire de contact
- [ ] Insérer le pattern "Formulaire de contact" sur une page
- [ ] Soumettre un message de test avec tous les champs remplis
- [ ] **Vérifier la réception de l'email** à l'adresse configurée dans Vitalisite > Réglages > Cabinet > Email
- [ ] Vérifier le contenu de l'email (nom, email, téléphone, sujet, message)
- [ ] Vérifier que le `Reply-To` fonctionne (répondre à l'email → doit aller vers l'expéditeur)
- [ ] Tester la validation : soumettre sans nom → erreur affichée
- [ ] Tester la validation : soumettre sans email → erreur affichée
- [ ] Tester la validation : soumettre sans message → erreur affichée
- [ ] Tester le rate limiting : soumettre 2x rapidement → message "patientez"
- [ ] Vérifier le message de succès après envoi

### Si l'email n'arrive pas
1. Vérifier l'adresse email dans Vitalisite > Réglages > Cabinet
2. Vérifier les spams / courrier indésirable
3. Installer un plugin SMTP (ex: **WP Mail SMTP**, **FluentSMTP**) et configurer avec les identifiants SMTP de l'hébergeur
4. Activer `WP_DEBUG_LOG` temporairement et vérifier `debug.log` pour le log `[Vitalisite Contact]`

---

## 5. Style Variations

- [ ] Tester au moins 2 variations de style (ex: Solaire + Clinique)
- [ ] Vérifier que les couleurs, typographies et arrondis changent correctement
- [ ] Vérifier que le formulaire de contact s'adapte au thème choisi
- [ ] Vérifier que la photo docteur respecte le `--wp--custom--image-radius` du thème

---

## 6. Responsive & Performance

### Mobile (< 768px)
- [ ] Header : menu hamburger fonctionnel
- [ ] Hero : texte lisible, image adaptée
- [ ] Formulaire de contact : champs en 1 colonne
- [ ] Pricing cards : empilées verticalement
- [ ] Footer : infos lisibles
- [ ] Sticky CTA : visible et fonctionnel

### Tablette (768px – 1024px)
- [ ] Layout intermédiaire correct
- [ ] Pas de débordement horizontal

### Performance
- [ ] Pas de CSS/JS inutile chargé (vérifier avec DevTools > Network)
- [ ] Images optimisées (WebP si possible)
- [ ] Pas d'erreurs console JS

---

## 7. SEO & Accessibilité

- [ ] Balises `<h1>` à `<h6>` dans le bon ordre (pas de saut)
- [ ] Attributs `alt` sur les images
- [ ] Labels sur tous les champs de formulaire
- [ ] `aria-live="polite"` sur les messages d'erreur du formulaire
- [ ] Contrastes de couleurs suffisants (WCAG AA)
- [ ] Navigation au clavier fonctionnelle

---

## 8. Sécurité

- [ ] `WP_DEBUG` = `false` en production
- [ ] Nonce vérifié sur le formulaire de contact
- [ ] Honeypot actif (champ caché)
- [ ] Rate limiting actif (30s entre chaque soumission)
- [ ] Toutes les entrées utilisateur sanitizées (`sanitize_text_field`, `sanitize_email`, etc.)
- [ ] Pas de clés API ou secrets exposés dans le code source

---

## 9. Sauvegarde & Rollback

- [ ] Backup complet du site avant mise à jour du thème
- [ ] Garder la version précédente du thème en archive
- [ ] Tester sur un environnement de staging si possible avant la prod

---

## Notes

- **Version actuelle du thème :** 0.1.5
- **WordPress minimum :** 6.5
- **PHP minimum :** 7.4
- **Epics restants :** Epic 7 (License System & Setup Wizard)
