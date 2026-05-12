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

/** *****************************************************************************
 * Fonction javascript pour gérer l'inscription et les champs tel que le numéro SIRET
 *******************************************************************************/
add_action('wp_footer', function() { ?>
<script>
    // On se met en écoute sur le DOM
    document.addEventListener('DOMContentLoaded', function() {

        // On récupère la div qui encercle le label et l'input
        const champsEntreprise = [
            document.getElementById('n_siret_field'),
            document.getElementById('your_company_field')
        ];

        // on recupère l'input directement ici
        const inputsEntreprise = [
            document.getElementById('n_siret'),
            document.getElementById('your_company')
        ];

        // Ici on sécurise le numéro siret et on le formate pour le rendre visible
        const siret = document.getElementById('n_siret');
        if (siret) {
            siret.addEventListener('input', function() {

                // Garde uniquement les chiffres, max 14
                // \D c'est un regex qui selectionne tout ce qui n'est pas du chiffre
                // /g l'applique sur tout l'input
                // on lui dit de remplacer par '' donc une chaine vide, donc ça supprime immédiatement les lettres.
                let chiffres = this.value.replace(/\D/g, '').slice(0, 14);
                
                // Formate en XXX XXX XXX XXXXX
                // Pareil, on joue avec des regex. / / sers a indiquer a JS que c'est des regex. les () serviront a définir les emplacements $1 $2 ...etc
                // \d récupère les chiffres et {3} est son nombre de chiffre max. Il place tout ça dans $1 puis place tout ce qui viendra après lui sur $2
                // Jusqu'au moment ou il rentrera dans le second replace, une fois que l'on insère de plus en plus de chiffre.
                // On chaine les replace jusqu'à avoir le format désiré : XXX XXX XXX XXXXX.
                let formate = chiffres
                    .replace(/(\d{3})(\d)/, '$1 $2')
                    .replace(/(\d{3}) (\d{3})(\d)/, '$1 $2 $3')
                    .replace(/(\d{3}) (\d{3}) (\d{3})(\d)/, '$1 $2 $3 $4');
                
                // On formate notre valeur en temps réel! this correspond a l'élément qui a déclenché notre "event"
                // dans ce cas : n_siret. l'event se déclenche à chaque input (donc dès qu'on tape un chiffre).
                this.value = formate;
            });
        }

        // On cache les champs si l'utilisateur a mis sa radio sur "Particulier" et on retire l'attribut required pour éviter les soucis
        function cacherChamps() {
            champsEntreprise.forEach(champ => { if(champ) champ.style.opacity = '0.4'; });
            inputsEntreprise.forEach(input => {
                if(input) {
                    input.setAttribute('disabled', 'disabled');
                    input.removeAttribute('required'); 
                }
            });

            // Supprime l'étoile afin de la masquer lorsque le champ est caché.
            document.querySelectorAll('#your_company_field label .required, #n_siret_field label .required')
            .forEach(abbr => abbr.remove());
        }

        // A l'inverse, on affiche le champ si l'utilisateur a mis sa radio sur "Entreprise" et on lui demande de remplir des champs requis supplémentaire.
        function afficherChamps() {
            champsEntreprise.forEach(champ => { if(champ) champ.style.opacity = '1'; });
            inputsEntreprise.forEach(input => { 
                if(input) {
                    input.removeAttribute('disabled', 'disabled');
                    input.setAttribute('required', 'required');
                } 
            });

            // Ajoute l'étoile pour prévenir que le champ est requis à l'utilisateur
            document.querySelectorAll('#your_company_field label, #n_siret_field label')
            .forEach(label => {
                if (!label.querySelector('.required')) {
                    label.insertAdjacentHTML('beforeend', ' <abbr class="required" title="required">*</abbr>');
                }
            });
        }

        //Appel initial = permet d'avoir les champs caché au chargement de la page pour ne pas perturber l'utilisateur.
        cacherChamps();

        // S'occupe d'afficher ou de cacher les champs en fonction du résultat de la radio
        document.querySelectorAll('[name="company_radiocheck"]').forEach(radio => {
            radio.addEventListener('change', function() {
                this.value === 'Entreprise' ? afficherChamps() : cacherChamps();
            });
        });
    });
</script>
<?php }); 

add_filter('excerpt_length', function($length) {
    return 20; // nombre de mots affiché dans les paragraphe de "résumé" d'article (excerpt)
});

add_filter('wp_nav_menu_objects', function($items, $args) {
    foreach ($items as $key => $item) {
        // Cache "Mon Profil" si non connecté
        if (in_array('menu-mon-profil', $item->classes) && !is_user_logged_in()) {
            unset($items[$key]);
        }
        // Cache "Se connecter" et "S'inscrire" si connecté
        if (in_array('menu-se-connecter', $item->classes) && is_user_logged_in()) {
            unset($items[$key]);
        }
        if (in_array('menu-sinscrire', $item->classes) && is_user_logged_in()) {
            unset($items[$key]);
        }
    }
    return $items;
}, 10, 2);