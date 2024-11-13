<?php
// URL del feed RSS
$feedUrl = 'https://www.rollingstone.com/music/music-news/feed/'; 

// Función para cargar y mostrar el feed
function fetchRssFeed($url) {
    // Cargar el feed
    $xml = @simplexml_load_file($url);
    
    // Verificar si hay errores al cargar el feed
    if ($xml === false) {
        echo "Error al cargar el feed.";
        return;
    }
    
    // Mostrar los elementos del feed
    foreach ($xml->channel->item as $item) {
        echo '<h2>' . htmlspecialchars($item->title) . '</h2>';
        echo '<p>' . htmlspecialchars($item->description) . '</p>';
        echo '<a href="' . htmlspecialchars($item->link) . '">Leer más</a><br><br>';
    }
}

// Llamar a la función con la URL del feed
fetchRssFeed($feedUrl);
?>