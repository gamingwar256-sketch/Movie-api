<?php
while (ob_get_level()) {
    ob_end_clean();
}

// Content-Type ko strict XML header set karein
header("Content-Type: text/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
echo "\n";

$baseUrl = "https://hd4upr.blogspot.com";
$apiKey = '5478181d128d405468f1d7a676908f08'; // Apni asli TMDB API key yahan daal dena

// Homepage
echo "  <url>\n";
echo "    <loc>" . htmlspecialchars($baseUrl, ENT_XML1, 'UTF-8') . "</loc>\n";
echo "    <changefreq>daily</changefreq>\n";
echo "    <priority>1.0</priority>\n";
echo "  </url>\n";

// TMDB se popular movies fetch karna
for ($p = 1; $p <= 3; $p++) {
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=" . $apiKey . "&page=" . $p;

    $ctx = stream_context_create([
        'http' => ['timeout' => 5, 'ignore_errors' => true],
        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
    ]);

    $response = @file_get_contents($url, false, $ctx);

    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $movie) {
                if (isset($movie['id'])) {
                    $movieUrl = $baseUrl . "/p/movie.html?id=" . $movie['id'];
                    echo "  <url>\n";
                    echo "    <loc>" . htmlspecialchars($movieUrl, ENT_XML1, 'UTF-8') . "</loc>\n";
                    echo "    <changefreq>weekly</changefreq>\n";
                    echo "    <priority>0.8</priority>\n";
                    echo "  </url>\n";
                }
            }
        }
    }
}

echo '</urlset>';
exit;
?>
