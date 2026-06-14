<?php
// 1. CNN Türk Canlı Yayın sayfasını tarayıcı gibi taklit ederek çağırıyoruz
$url = "https://www.cnnturk.com/canli-yayin";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
curl_setopt($ch, CURLOPT_REFERER, 'https://www.google.com/');
$html = curl_exec($ch);
curl_close($ch);

// 2. Sayfa kaynağındaki gizli .m3u8 ve arkasındaki dinamik token kısmını yakalıyoruz
// CNN Türk medyadcn altyapısını kullanır, regex ile bu adresi süzüyoruz
if (preg_match('/"(https:\/\/[^"]+medyacdn\.com\/[^"]+cnnturk\/[^"]+\.m3u8[^"]*)"/', $html, $matches)) {
    $stream_url = $matches[1];
    
    // 3. IPTV oynatıcını (VLC, Smarters vb.) doğrudan bu taze linke yönlendiriyoruz
    header("Location: " . $stream_url);
    exit;
} else {
    // Eğer bir hata olur da kod siteden linki sökemezse, genel yedek linke yönlendirir
    header("Location: https://tv-cnnturk.medyacdn.com/cnnturk/live.m3u8");
    exit;
}
?>