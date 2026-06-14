const express = require('express');
const axios = require('axios');
const app = express();
const PORT = process.env.PORT || 3000;

app.get('/', async (req, res) => {
    try {
        // 1. CNN Türk Canlı Yayın sayfasını çekiyoruz
        const response = await axios.get('https://www.cnnturk.com/canli-yayin', {
            headers: {
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Referer': 'https://www.google.com/'
            }
        });

        const html = response.data;
        
        // 2. Regex ile m3u8 linkini ve tokenı ayıklıyoruz
        const regex = /"(https:\/\/[^"]+medyacdn\.com\/[^"]+cnnturk\/[^"]+\.m3u8[^"]*)"/;
        const match = html.match(regex);

        if (match && match[1]) {
            // 3. IPTV oynatıcıyı güncel linke yönlendir
            return res.redirect(match[1]);
        } else {
            // Bulamazsa genel yedek linke yönlendir
            return res.redirect('https://tv-cnnturk.medyacdn.com/cnnturk/live.m3u8');
        }
    } catch (error) {
        // Hata durumunda yedek link
        return res.redirect('https://tv-cnnturk.medyacdn.com/cnnturk/live.m3u8');
    }
});

app.listen(PORT, () => {
    console.log(`Sunucu ${PORT} portunda çalışıyor.`);
});
