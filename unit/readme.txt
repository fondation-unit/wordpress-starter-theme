=== IUT en ligne ===
Contributors: UNIT
Requires PHP: 8+
Requires: Understrap Theme [https://github.com/fondation-unit/understrap.git](https://github.com/fondation-unit/understrap.git)

== Description ==

Le site est une déclinaison du thème de L'Université Numérique adapté pour les besoins de l'IUT en Ligne.
!! C'est le thème enfant du thème understrap disponible ici : [https://github.com/fondation-unit/understrap.git](https://github.com/fondation-unit/understrap.git) !! Il faut le prendre ici car nous avons optimisé le code pour l'accessibilité des menus notamment.

== Installation ==

Une fois le thème installé dans le dossier wp-content/themes, il faut installer les dépendances via composer et via npm.
 - composer install
Les css sont gérés via scss :
 - npm run watch pour générer les css et js lors du développement
 - npm run build pour générer une seule fois les css et js

== Personnalisation ==

Dans la personnalisation du thème, dans la partie "Réglages de la mise en page", il faut bien choisir
 - Version de Bootstrap : Bootstrap 5 (même si on le force via le functions.php ligne 75)
 - Largeur du contenu : "Conteneur en pleine largeur"
 - Type de navigation responsive : "Hors champ"

== Modification ==

Les fichiers à modifier sont dans le dossier wp-content/themes/iutenligne/src
 - le dossier sass contient les fichiers css. Seul le dossier theme est à modifier. Le fichier theme/_child_theme_variables.scss permet de gérer les couleurs générales du site.
 - pour les javascript, le fichier à modifier est src/js/custom-javascript.js

Les différents fichiers scss spécifiques au thème sont ensuite appelés dans le fichier src/sass/theme/child_theme.scss

Aucun code ne doit être ajouté dans le fichier functions.php. Il faut passer par le fichier inc/templates-functions.php qui renferme toutes les modifications apportées au thème personnalisé.

== Explications ==

- Les zones de widgets du footer sont générées dans le fichier inc/templates-functions.php ligne 144
- L'optimisation des images se fait via un script javascript Lozad que l'on ajoute automatiquement aux images via un code dans inc/templates-functions.php ligne 91
- Le contenu du header se trouve dans le fichier global-templates/navbar-offcanvas-bootstrap5.php. Si on veut travailler avec le menu responsive dans la page, ce sera le fichier navbar-collapse-bootstrap5.php
- La page d'actualités doit avoir pour modèle le template "Page Actualités" pour utiliser ce qui est dans le fichier template-actualites.php