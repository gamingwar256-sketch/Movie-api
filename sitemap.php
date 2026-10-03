<?php
header("Content-Type: application/xml; charset=utf-8");

// TMDB API Key (wahi jo aapki main file me hai)
define('TMDB_API_KEY', '5478181d128d405468f1d7a676908f08');
define('TMDB_BASE_URL', 'https://api.themoviedb.org/3');

$baseUrl = "https://hd4upr.blogspot.com";

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Homepage link
echo "  <url>\n";
echo "    <loc>" . $baseUrl . "</loc>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

// TMDB se popular movies fetch karne ka function
function fetchPopularMovies($page = 1) {
    $url = TMDB_BASE_URL . "/movie/popular?api_key=" . TMDB_API_KEY . "&page=" . $page;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $res = curl_exec($ch);
    curl_close($ch);
    
    return $res ? json_decode($res, true) : null;
}

// Hum yahan pehle 2 pages (lagbhag 40 movies) fetch kar rahe hain sitemap ke liye
for ($p = 1; $p <= 2; $p++) {
    $data = fetchPopularMovies($p);
    
    if (isset($data['results'])) {
        foreach ($data['results'] as $movie) {
            $movieId = $movie['id'];
            // Yeh aapke movie ka link banayega (jise aap apne Blogger theme me set kar sakte hain)
            $movieUrl = $baseUrl . "/p/movie.html?id=" . $movieId;
            
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($movieUrl) . "</loc>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }
    }
}

echo '</urlset>';
?>
