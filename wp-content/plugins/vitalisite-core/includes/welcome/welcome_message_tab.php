<?php

function display_welcome_message() {
    echo '<h1>Bienvenue !</h1>';
    echo '<p>Merci d’avoir choisi notre thème. Nous allons vous guider dans la configuration de votre thème.</p>';
    echo '<ul>';
    echo '<li>Étape 1 : Activez votre licence</li>';
    echo '<li>Étape 2 : Activez les extensions requises</li>';
    echo '<li>Étape 3 : Commencez la personnalisation</li>';
    echo '</ul>';
    echo '<a class="next-step" href="?page=theme-activation&tab=activation">Étape suivante</a>';
}