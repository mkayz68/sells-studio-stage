<?php
/**
 * Plugin Name: Sells Studio Custom
 * Description: Fonctions custom pour Sells Studio
 */

function sells_studio_google_maps() {
    return '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2665.434190204152!2d7.322678877622673!3d48.08256337123751!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4791642962ad41bf%3A0xa7300ad7487cb3d5!2s64%20Rue%20Robert%20Schuman%2C%2068000%20Colmar!5e0!3m2!1sfr!2sfr!4v1777301230242!5m2!1sfr!2sfr" width="550" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
}
add_shortcode('google_maps', 'sells_studio_google_maps');