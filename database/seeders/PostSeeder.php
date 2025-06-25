<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'yamansharmarakta@gmail.com')->first();
        
        if (!$admin) {
            return;
        }
        
        $posts = [
            [
                'title' => 'A Week in Kyoto: Ancient Temples and Modern Delights',
                'excerpt' => 'My journey through Kyoto was a perfect blend of traditional and contemporary Japan.',
                'content' => '<p>My journey through Kyoto was a perfect blend of traditional and contemporary Japan. From the serene bamboo groves of Arashiyama to the vibrant street food scene in Nishiki Market, every moment was filled with discovery.</p>
                <p>The highlight of my trip was undoubtedly the early morning visit to Fushimi Inari Shrine. Arriving at 6 AM meant I could experience the magical tunnel of torii gates in near solitude, with the morning light filtering through the vermilion structures.</p>
                <p>Kinkaku-ji (the Golden Pavilion) lived up to its reputation, its gold leaf exterior shimmering against the backdrop of a perfectly manicured garden. However, I found equal beauty in the less-visited Daitoku-ji temple complex, where the zen gardens invited quiet contemplation.</p>
                <p>For those planning a visit, I recommend staying in the Gion district to experience the heart of traditional Kyoto. And don\'t miss the opportunity to participate in a tea ceremony - I joined one at Camellia Tea Ceremony, where the host patiently explained each step of this ancient ritual.</p>',
                'featured_image' => 'posts/kyoto.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Exploring the Hidden Beaches of Bali',
                'excerpt' => 'Beyond the tourist hotspots, Bali hides some of the most pristine beaches I\'ve ever seen.',
                'content' => '<p>Beyond the tourist hotspots, Bali hides some of the most pristine beaches I\'ve ever seen. While Kuta and Seminyak draw the crowds, I spent my time seeking out the lesser-known coastal gems of this Indonesian paradise.</p>
                <p>Green Bowl Beach, tucked away at the bottom of a steep staircase on the Bukit Peninsula, was my first discovery. The emerald-hued water and white sand were complemented by the absence of vendors and crowds. The cave at one end of the beach provided welcome shade during the midday heat.</p>
                <p>Bingin Beach offered a different experience altogether. This surfer\'s haven features dramatic limestone cliffs and a maze of rustic accommodations built into the hillside. Watching the sunset from one of the cliff-top warungs, with a cold Bintang in hand, was a daily ritual I quickly adopted.</p>
                <p>For those willing to venture even further off the beaten path, Nyang Nyang Beach rewards the adventurous. The 20-minute hike through fields and down a makeshift path deters most tourists, resulting in an almost private beach experience. I spent an entire day here without seeing more than a dozen other people.</p>',
                'featured_image' => 'posts/bali.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'The Northern Lights: Chasing Aurora in Iceland',
                'excerpt' => 'My three-night adventure hunting for the elusive Northern Lights in the Icelandic wilderness.',
                'content' => '<p>My three-night adventure hunting for the elusive Northern Lights in the Icelandic wilderness was both challenging and rewarding. After two nights of cloudy skies and disappointment, nature finally rewarded our persistence.</p>
                <p>We had set up camp near Kirkjufell mountain, away from any light pollution. Our guide, Thor, had been monitoring the aurora forecast meticulously and assured us that our final night presented the best conditions. As temperatures dropped to -10°C, we huddled around a small fire, occasionally glancing upward with waning hope.</p>
                <p>Then, shortly after midnight, it happened. A faint green glow appeared on the horizon, gradually intensifying and expanding across the sky. Within minutes, we were witnessing ribbons of green and purple dancing overhead, reflecting in the still waters of the nearby lake. The mountain\'s distinctive shape created a perfect foreground for this celestial display.</p>
                <p>For photographers hoping to capture the aurora, I recommend a camera capable of manual settings, a sturdy tripod, and most importantly, patience. Set your ISO between 800-3200, aperture as wide as possible (f/2.8 or wider), and experiment with exposure times between 5-20 seconds.</p>',
                'featured_image' => 'posts/iceland.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Street Food Tour of Bangkok: A Culinary Adventure',
                'excerpt' => 'Navigating the bustling streets of Bangkok through its incredible food scene.',
                'content' => '<p>Navigating the bustling streets of Bangkok through its incredible food scene was the highlight of my Thailand trip. Instead of following a structured itinerary, I let my taste buds guide me through the city\'s vibrant neighborhoods.</p>
                <p>My journey began in Chinatown (Yaowarat), where the narrow alleyways come alive after sunset. Here, I sampled succulent grilled satay skewers, followed by a bowl of kuay teow rua (boat noodles) so rich and complex that I immediately ordered a second serving. The night concluded with freshly made khanom buang – delicate crispy pancakes filled with meringue and shredded coconut.</p>
                <p>The following day, I explored the Bang Rak district, known to locals as the "Village of Love" but perhaps better described as the "Village of Food." Under the guidance of a local food enthusiast I met through a cooking class, I discovered jay fai-inspired crab omelets, fragrant massaman curry, and mango sticky rice that redefined my understanding of this classic dessert.</p>
                <p>For travelers concerned about street food safety, I followed three simple rules: eat where locals eat, ensure food is freshly cooked in front of you, and carry hand sanitizer. Following these guidelines, I enjoyed dozens of street food meals without any issues.</p>',
                'featured_image' => 'posts/bangkok.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(21),
            ],
            [
                'title' => 'Trekking the Inca Trail: Lessons from the Path to Machu Picchu',
                'excerpt' => 'Four days of challenging hiking through the Andes taught me as much about myself as about the ancient Inca civilization.',
                'content' => '<p>Four days of challenging hiking through the Andes taught me as much about myself as about the ancient Inca civilization. The classic Inca Trail to Machu Picchu is not just a physical journey but a profound cultural and personal experience.</p>
                <p>Day one started deceptively easy, with a gentle walk alongside the Urubamba River. By afternoon, the trail steepened, offering our first test of endurance. Our guide, Carlos, a descendant of the Quechua people, shared stories of his ancestors as we caught our breath at various viewpoints.</p>
                <p>The second day presented the greatest challenge – Dead Woman\'s Pass. Standing at 4,215 meters (13,828 feet), this highest point of the trek pushed me to my limits. The thin mountain air made each step laborious, but the panoramic views of snow-capped peaks provided ample reward for our efforts.</p>
                <p>Days three and four revealed increasingly impressive Inca ruins, each site more elaborate than the last, building anticipation for our final destination. Intipata\'s agricultural terraces, Wiñay Wayna\'s cascading architecture, and finally, the Sun Gate (Inti Punku), offering that first magical glimpse of Machu Picchu in the distance.</p>',
                'featured_image' => 'posts/machu-picchu.jpg',
                'status' => 'published',
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Upcoming Travel Trends for 2024',
                'excerpt' => 'Predictions for how travel will evolve in the coming year based on emerging patterns.',
                'content' => '<p>As we look ahead to 2024, several emerging travel trends are reshaping how we explore the world. Based on industry reports and my observations as a frequent traveler, here are the developments I believe will define travel in the coming year.</p>
                <p>Regenerative tourism is moving beyond sustainability to become the new gold standard. Rather than simply minimizing environmental impact, travelers are increasingly seeking experiences that actively improve the destinations they visit. This includes participating in reforestation projects, marine conservation efforts, or community development initiatives.</p>
                <p>Technology continues to transform the travel experience, with AI-powered personalization leading the way. From smart hotel rooms that adjust to your preferences to hyper-customized itineraries created by algorithms that learn your travel style, technology is creating more tailored experiences than ever before.</p>
                <p>The concept of "workations" is evolving into more structured "talent mobility" programs, as companies formalize policies for employees to work from different locations. This is driving growth in mid-term accommodation options (2-4 weeks) and co-working spaces in traditionally leisure-focused destinations.</p>',
                'featured_image' => 'posts/trends.jpg',
                'status' => 'draft',
                'published_at' => null,
            ],
        ];
        
        foreach ($posts as $postData) {
            $slug = Str::slug($postData['title']);
            $uniqueSlug = $slug;
            $counter = 1;
            
            // Ensure slug is unique
            while (Post::where('slug', $uniqueSlug)->exists()) {
                $uniqueSlug = $slug . '-' . $counter++;
            }
            
            Post::create([
                'user_id' => $admin->id,
                'title' => $postData['title'],
                'slug' => $uniqueSlug,
                'excerpt' => $postData['excerpt'],
                'content' => $postData['content'],
                'featured_image' => $postData['featured_image'],
                'status' => $postData['status'],
                'published_at' => $postData['published_at'],
            ]);
        }
    }
}