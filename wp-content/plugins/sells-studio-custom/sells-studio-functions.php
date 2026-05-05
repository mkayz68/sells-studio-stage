<?php
/**
 * Plugin Name: Sells Studio Custom
 * Description: Fonctions custom pour Sells Studio
 */

/**
 * Rajouts manuel des icones de fontawesome
 * et d'une feuille de style personnalisé.
 * elle stylise le formulaire de contact qui a été réalisé avec le plugin "Contact Form 7"
 * Si on veut en changer le style, c'est dans ce CSS qu'il faut passer.
 */
function sells_studio_styles() {
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
    );
    wp_enqueue_style(
        'sells-studio-style',
        plugin_dir_url(__FILE__) . 'sells-studio.css'
    );
}
add_action('wp_enqueue_scripts', 'sells_studio_styles');

/**
 * Fonctionnalité pour afficher google map
 * Comme ça ne voulais pas fonctionner en local avec oxygen pour une raison inconnue, j'ai rajouté ça dans le plugin.
 * Seul les shortcode marchait.
 * De préférence si on peux juste mettre l'iframe de google maps, cette fonction sera désuette et à supprimer :)
 */
function sells_studio_google_maps() {
    return '<iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2665.434190204152!2d7.322678877622673!3d48.08256337123751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4791642962ad41bf%3A0xa7300ad7487cb3d5!2s64%20Rue%20Robert%20Schuman%2C%2068000%20Colmar!5e0!3m2!1sfr!2sfr!4v1777301230242!5m2!1sfr!2sfr"
                width="550" height="540" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>';
}
add_shortcode('google_maps', 'sells_studio_google_maps');



/** *****************************************************************************
 * @author Burdloff Kévin
 * Renvoie le nombre de projet effectué
 * compte le nombre d'article en base de donnée ayant la catégorie projet
 * puis les additionne
 * @return integer le nombre de client
 *******************************************************************************/
add_shortcode('nombre_projets', function() {
    $projectCount = count(get_posts([
        'category_name' => 'projet',
        'numberposts'   => -1
    ]));
    return $projectCount . "+";
});

/** *****************************************************************************
 * Renvoie le nombre de client satisfait.
 * vérifie la base de donnée si un projet a été réalisé pour un client
 * ET si le client est un nouveau client afin d'avoir un calcul juste.
 * 
 * On passe par les champs du plugin ACF(Advanced Custom Field) qui apparaissent une fois avoir coché la catégorie "projet" lorsque l'on publie un article.
 * @return integer le nombre de client
 *******************************************************************************/
add_shortcode('nombre_clients', function() {
    $posts = get_posts([
        'category_name' => 'projet',
        'numberposts'   => -1
    ]);
    
    $clientCount = 0;
    foreach($posts as $post) {
        if ((get_field('client', $post->ID) == 'oui') && (get_field('first_time', $post->ID) == 'oui')) {
            $clientCount++;
        }
    }
    return $clientCount . "+";
});

/** *****************************************************************************
 * Renvoie le nombre d'année d'experience
 * Compare l'année courante avec l'année de création de la société la plus ancienne
 * Soustrait afin de ne laisser que le nombre d'année de différence.
 * $diff est une fonction native de PHP qui permet d'effectuer cette opération!
 * @return integer le nombre d'année de différence
 *******************************************************************************/
add_shortcode('annees_experience', function() {
    $creation = new DateTime('2014-03-23');
    $now = new DateTime();
    $diff = $now->diff($creation);
    return $diff->y;
});

/** *****************************************************************************
 * Permet de renvoyer l'année courante
 * Sers à changer automatiquement la date dans du copyright dans le footer.
 * @return integer l'année
 *******************************************************************************/
add_shortcode('annee_courante', function() {
    return date('Y');
});