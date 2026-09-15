<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Novel;
use App\Models\Chapter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Account
        $admin = User::updateOrCreate(
            ['email' => 'admin@novelku.com'],
            [
                'name'     => 'Admin NovelKu',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'bio'      => 'Pengelola utama NovelKu.',
            ]
        );

        // 2. Regular User Account
        $user = User::updateOrCreate(
            ['email' => 'user@novelku.com'],
            [
                'name'     => 'Pembaca Setia',
                'password' => Hash::make('password'),
                'role'     => 'user',
                'bio'      => 'Suka membaca cerita fantasi dan misteri.',
            ]
        );

        // 3. Sample Novels
        $novelsData = [
            [
                'title'    => 'Legenda Pedang Langit',
                'genre'    => 'Fantasy',
                'status'   => 'ongoing',
                'views'    => 1240,
                'synopsis' => 'Di benua Benua Awan Timur, seorang pemuda desa bernama Lu Feng menemukan sebuah pedang misterius yang tertanam di puncak gunung salju. Tanpa disadarinya, pedang tersebut adalah ciptaan kuno dari Para Dewa Langit yang telah lama punah. Petualangan besar menembus berbagai sekte pedang dan bahaya kegelapan pun dimulai!',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'title'          => 'Pemuda Dari Desa Kabut',
                        'content'        => "Desa Kabut selalu diselimuti oleh kabut tebal setiap pagi. Lu Feng, seorang pemuda berusia 17 tahun, berjalan menyusuri jalanan berbatu sambil memikul seikat kayu bakar.\n\nHari itu seperti hari-hari biasanya, sampai suara gemuruh dahsyat terdengar dari puncak Gunung Salju Hitam. Suara itu begitu mengerikan hingga membuat burung-burung di hutan terbang berhamburan.\n\n\"Apa yang terjadi di atas sana?\" gumam Lu Feng penasaran. Tanpa ragu, ia membulatkan tekad untuk mendaki gunung yang dikenal angker tersebut.\n\nSetibanya di dekat puncak, tanah tempatnya berdiri runtuh! Lu Feng jatuh ke dalam sebuah goa bawah tanah. Di tengah goa yang remang-remang itu, memancar sinar biru keemasan. Sebuah pedang tua tertancap di atas batu kristal hitam.\n\nSaat jemari Lu Feng menyentuh gagang pedang tersebut, arus energi purba yang sangat dahsyat mengalir deras ke dalam dadanya. Takdirnya telah berubah selamanya."
                    ],
                    [
                        'chapter_number' => 2,
                        'title'          => 'Sinar Pedang Pertama',
                        'content'        => "Energi misterius dari pedang itu memasuki tubuh Lu Feng, menyatukan meridian darahnya yang dulu tersumbat. Rasa sakit bagai terbakar api membakar seluruh tubuhnya sebelum berganti menjadi kehangatan yang luar biasa.\n\nPedang tua itu perlahan terlepas dari batu kristal. Ukiran naga kuno di bilahnya menyala terang.\n\n\"Apakah ini... Senjata Pusaka Kuno?\" bisik Lu Feng terperanjat.\n\nTiba-tiba dari kegelapan goa, muncul sepasang mata merah menyala. Seekor Serigala Bayangan bertanduk satu merayap keluar, mengincar darah pemuda itu.\n\nLu Feng tidak punya waktu untuk takut. Ia mengayunkan pedang barunya secara refleks. Cahaya tebasan berwarna keemasan melintas, membelah kegelapan goa dan memotong sang monster dalam satu gerakan cepat!\n\nPedang Langit telah terbangun, dan kisah Lu Feng baru saja dimulai."
                    ]
                ]
            ],
            [
                'title'    => 'Kencan di Ujung Senja',
                'genre'    => 'Romance',
                'status'   => 'completed',
                'views'    => 850,
                'synopsis' => 'Maya dan Rehan selalu bertemu di kedai kopi tua yang sama setiap pukul 5 sore. Namun, mereka tidak pernah saling menyapa hingga suatu hari hujan deras memaksa mereka berbagi satu payung yang sama.',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'title'          => 'Kedai Kopi Pukul Lima',
                        'content'        => "Aroma biji kopi arabika yang diseduh mengisi seluruh sudut Kedai Senja. Maya duduk di sudut favoritnya dekat jendela besar, seperti yang selalu dilakukannya setiap hari Senin hingga Jumat.\n\nDi meja seberang, ada Rehan. Pemuda itu selalu memesan Americano dingin tanpa gula dan sibuk dengan laptopnya. Mereka berdua telah menjadi 'orang asing yang akrab' selama lebih dari enam bulan.\n\nHari itu, hujan turun sangat deras. Angin kencang bertiup merusak payung milik Maya saat ia mencoba melangkah keluar dari kedai. Rehan yang berada di belakangnya menahan pintu dan menyodorkan payung lipat miliknya.\n\n\"Gunakan payung ini. Kita bisa jalan bareng sampai stasiun,\" ucap Rehan dengan senyum tipis. Hati Maya mendadak berdesir cepat."
                    ]
                ]
            ],
            [
                'title'    => 'Detektif Bayangan: Jejak Yang Hilang',
                'genre'    => 'Mystery',
                'status'   => 'ongoing',
                'views'    => 2100,
                'synopsis' => 'Sebuah lukisan ternama hilang dari museum kota tanpa merusak segel pengaman sama sekali. Detektif Arya dipanggil untuk memecahkan kasus yang disebut-sebut melibatkan sihir atau ilusi sempurna.',
                'chapters' => [
                    [
                        'chapter_number' => 1,
                        'title'          => 'Malam Hilangnya Lukisan',
                        'content'        => "Sirine polisi meraung-raung melintasi jalanan kota yang basah oleh hujan malam. Gedung Museum Seni Nasional telah dikepung oleh puluhan petugas.\n\nArya melangkah masuk melewati garis polisi. Di ruang pameran utama, bingkai emas lukisan 'Matahari Merah' tampak kosong melompong. Kaca pelindung tidak retak, alarm tidak berbunyi, dan kamera pengawas hanya merekam rekaman kosong selama 3 menit.\n\n\"Tidak ada sidik jari, tidak ada jejak kaki,\" bisik Asisten Tania. \"Bagaimana mungkin seseorang mengambil lukisan berukuran 2 meter dalam waktu 3 menit tanpa memicu alarm?\"\n\nArya berlutut di depan bingkai. Ia mengambil sebaris jamur berspora biru muda yang menempel tipis di sudut bawah bingkai.\n\n\"Pencurinya tidak masuk dari pintu atau jendela... dia sudah berada di dalam ruangan ini sejak awal,\" kata Arya dengan pandangan tajam."
                    ]
                ]
            ]
        ];

        foreach ($novelsData as $data) {
            $chapters = $data['chapters'];
            unset($data['chapters']);

            $novel = Novel::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'user_id'  => $admin->id,
                    'title'    => $data['title'],
                    'synopsis' => $data['synopsis'],
                    'genre'    => $data['genre'],
                    'status'   => $data['status'],
                    'views'    => $data['views'],
                ]
            );

            foreach ($chapters as $ch) {
                Chapter::updateOrCreate(
                    [
                        'novel_id' => $novel->id,
                        'chapter_number' => $ch['chapter_number'],
                    ],
                    [
                        'title'          => $ch['title'],
                        'content'        => $ch['content'],
                        'views'          => rand(50, 300),
                    ]
                );
            }
        }
    }
}
