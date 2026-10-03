<?php
header("Content-Type: application/xml; charset=utf-8");

// 1. आपकी ब्लॉगर साइट का लिंक
$bloggerUrl = "https://hd4upr.blogspot.com"; 
// 2. यहाँ अपना असली TMDB API Key पेस्ट करें
$tmdbApiKey = "5478181d128d405468f1d7a676908f08"; 

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://sitemaps.org" xmlns:video="http://google.com">';

// होमपेज का लिंक
echo "<url>\n";
echo "  <loc>" . $bloggerUrl . "/</loc>\n";
echo "  <changefreq>daily</changefreq>\n";
echo "  <priority>1.0</priority>\n";
echo "</url>\n";

// TMDB API से ट्रेंडिंग मूवीज के लिंक्स निकालना
for ($page = 1; $page <= 2; $page++) {
    $apiUrl = "https://themoviedb.org" . $tmdbApiKey . "&page=" . $page;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response) {
        $data = json_decode($response, true);
        if (isset($data['results']) && is_array($data['results'])) {
            foreach ($data['results'] as $movie) {
                $movieId = $movie['id'];
                // आपकी साइट का मूवी यूआरएल ढांचा
                $movieUrl = $bloggerUrl . "/?id=" . $movieId; 
                
                echo "<url>\n";
                echo "  <loc>" . htmlspecialchars($movieUrl) . "</loc>\n";
                echo "  <changefreq>weekly</changefreq>\n";
                echo "  <priority>0.8</priority>\n";
                echo "</url>\n";
            }
        }
    }
}

echo '</urlset>';
?>
