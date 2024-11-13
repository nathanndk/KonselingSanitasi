<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HouseParameter;
use App\Models\User;

class HouseParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user with ID 1 exists, otherwise use the first user available
        $userId = User::find(1) ? 1 : User::first()->id;

        $parameters = [
            // parameter_category_id null, house_condition_id 1
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'TANGGAL KUNJUNGAN', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'NIK', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'NAMA PENGHUNI RUMAH', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'No HP', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'Diagnosis Penyakit dalam 1 Bulan Terakhir', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'NAMA KEPALA KELUARGA (KK)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'KELURAHAN', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'RT', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'RW', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'AIR MINUM', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'AIR BERSIH', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'PENDIDIKAN TERAKHIR KK', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'PEKERJAAN KK', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'JUMLAH JIWA DLM KK', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'STATUS KEPEMILIKAN RUMAH', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 1, 'name' => 'LUAS RUMAH (m2)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 1, house_condition_id 2
            ['parameter_category_id' => 1, 'house_condition_id' => 2, 'name' => 'Tidak berada di lokasi rawan longsor', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 1, 'house_condition_id' => 2, 'name' => 'Tidak berada di lokasi bekas tempat pembuangan sampah akhir', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 1, 'house_condition_id' => 2, 'name' => 'Lokasi tidak berada pada jalur tegangan tinggi', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 2, house_condition_id 2
            ['parameter_category_id' => 2, 'house_condition_id' => 2, 'name' => 'Bangunan kuat, tidak bocor, dan tidak menjadi tempat perindukan tikus', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 2, 'house_condition_id' => 2, 'name' => 'Memiliki drainase atap yang memadai untuk limpasan air hujan', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 3, house_condition_id 2
            ['parameter_category_id' => 3, 'house_condition_id' => 2, 'name' => 'Bangunan kuat dan aman', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 3, 'house_condition_id' => 2, 'name' => 'Mudah dibersihkan dan tidak menyerap debu', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 3, 'house_condition_id' => 2, 'name' => 'Permukaan rata dan mempunyai ketinggian yang memungkinkan adanya pertukaran udara yang cukup.', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 3, 'house_condition_id' => 2, 'name' => 'Kondisi dalam keadaan bersih.', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 4, house_condition_id 2
            ['parameter_category_id' => 4, 'house_condition_id' => 2, 'name' => 'Dinding bangunan kuat dan kedap air', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 4, 'house_condition_id' => 2, 'name' => 'Permukaan rata, halus, tidak licin, dan tidak retak', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 4, 'house_condition_id' => 2, 'name' => 'Permukaan tidak menyerap debu dan mudah dibersihkan', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 4, 'house_condition_id' => 2, 'name' => 'Warna yang terang dan cerah', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 4, 'house_condition_id' => 2, 'name' => 'Dinding dalam keadaan bersih', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 5, house_condition_id 2
            ['parameter_category_id' => 5, 'house_condition_id' => 2, 'name' => 'Kondisi dalam keadaan bersih', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 5, 'house_condition_id' => 2, 'name' => 'Pencahayaan yang diperlukan sesuai aktivitas dalam kamar (>60 LUX)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 5, 'house_condition_id' => 2, 'name' => 'Luas ruang tidur minimum 9 m2', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 5, 'house_condition_id' => 2, 'name' => 'Tinggi langit-langit minimum 2,4 m2', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 6, house_condition_id 2
            ['parameter_category_id' => 6, 'house_condition_id' => 2, 'name' => 'Tidak terdapat bahan yang mengandung bahan beracun, bahan mudah meledak, dan bahan lain yang berbahaya', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 6, 'house_condition_id' => 2, 'name' => 'Bangunan kuat, aman, mudah dibersihkan, dan mudah pemeliharaannya', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 7, house_condition_id 2
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Lantai bangunan kedap air', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Permukaan rata, halus, tidak licin, dan tidak retak', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Lantai tidak menyerap debu dan mudah dibersihkan', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Lantai yang kontak dengan air dan memiliki kemiringan cukup landai untuk memudahkan pembersihan dan tidak terjadi genangan air', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Lantai rumah dalam keadaan bersih', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 7, 'house_condition_id' => 2, 'name' => 'Warna lantai harus berwarna terang', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 8, house_condition_id 2
            ['parameter_category_id' => 8, 'house_condition_id' => 2, 'name' => 'Ada ventilasi rumah', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 8, 'house_condition_id' => 2, 'name' => 'Luas ventilasi permanen > 10% luas lantai', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

            // parameter_category_id 9, house_condition_id 2
            ['parameter_category_id' => 9, 'house_condition_id' => 2, 'name' => 'Ada pencahayaan rumah', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => 9, 'house_condition_id' => 2, 'name' => 'Terang, tidak silau sehingga dapat untuk baca dengan normal', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 10, house_condition_id 3
              ['parameter_category_id' => 10, 'house_condition_id' => 3, 'name' => 'Menggunakan sumber Air Minum yang layak', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 10, 'house_condition_id' => 3, 'name' => 'Lokasi sumber Air Minum berada di dalam sarana bangunan/on premises', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 10, 'house_condition_id' => 3, 'name' => 'Tidak mengalami kesulitan pasokan air selama 24 jam', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 10, 'house_condition_id' => 3, 'name' => 'Kualitas air memenuhi SBMKL dan Persyaratan Kesehatan air sesuai ketentuan yang berlaku.', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 11, house_condition_id 3
              ['parameter_category_id' => 11, 'house_condition_id' => 3, 'name' => 'Buang Air Besar di Jamban', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 11, 'house_condition_id' => 3, 'name' => 'Jamban milik sendiri', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 11, 'house_condition_id' => 3, 'name' => 'Kloset Leher Angsa', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 11, 'house_condition_id' => 3, 'name' => 'Tangki septik disedot setidaknya sekali dalam 3-5 tahun terakhir, atau disalurkan ke Sistem Pengolahan Air Limbah Domestik Terpusat (SPAL-DT)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 12, house_condition_id 3
              ['parameter_category_id' => 12, 'house_condition_id' => 3, 'name' => 'Memiliki sarana CTPS dengan air mengalir dilengkapi dengan sabun', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 12, 'house_condition_id' => 3, 'name' => 'Lokasi sarana CTPS mudah dijangkau pada saat Waktu-waktu kritis CTPS', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 13, house_condition_id 3
              ['parameter_category_id' => 13, 'house_condition_id' => 3, 'name' => 'Tersedia tempat sampah di ruangan, kuat dan mudah dibersihkan', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 13, 'house_condition_id' => 3, 'name' => 'Ada perlakuan yang aman (tidak dibakar, tidak dibuang ke sungai/kebun/ saluran drainase/ tempat terbuka)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 13, 'house_condition_id' => 3, 'name' => 'Tersedia tempat pembuangan sampah sementara', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 13, 'house_condition_id' => 3, 'name' => 'Telah melakukan pemilahan sampah', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 14, house_condition_id 3
              ['parameter_category_id' => 14, 'house_condition_id' => 3, 'name' => 'Tidak terlihat genangan air di sekitar rumah karena limbah cair domestik', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 14, 'house_condition_id' => 3, 'name' => 'Terhubung dengan sumur resapan dan atau sistem pengolahan limbah (IPAL Komunal/ sewerage system)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
              ['parameter_category_id' => 14, 'house_condition_id' => 3, 'name' => 'Tersedia tempat pengelolaan limbah cair dengan kondisi tertutup', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              // parameter_category_id 15, house_condition_id 3
              ['parameter_category_id' => 15, 'house_condition_id' => 3, 'name' => 'Bila memiliki kandang ternak, kandang terpisah dengan rumah tinggal', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

              ['parameter_category_id' => null, 'house_condition_id' => 4, 'name' => 'Jendela kamar tidur selalu dibuka setiap hari', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 4, 'name' => 'Jendela kamar keluarga selalu dibuka setiap hari', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 4, 'name' => 'Ventilasi rumah selalu dibuka setiap hari', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 4, 'name' => 'Melakukan Cuci Tangan Pakai Sabun (CTPS)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
            ['parameter_category_id' => null, 'house_condition_id' => 4, 'name' => 'Melakukan Pemberantasan Sarang Nyamuk (PSN) seminggu sekali', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

                        // parameter_category_id 16, house_condition_id 5
                        ['parameter_category_id' => 16, 'house_condition_id' => 5, 'name' => 'Kebisingan (<85 dBA)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 16, 'house_condition_id' => 5, 'name' => 'Kelembaban (40-60%RH)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 16, 'house_condition_id' => 5, 'name' => 'Pencahayaan (>60 LUX)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 16, 'house_condition_id' => 5, 'name' => 'Laju ventilasi udara (0,15-0,25 m/s)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 16, 'house_condition_id' => 5, 'name' => 'Suhu ruang (18 - 30°C)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],

                        // parameter_category_id 17, house_condition_id 5
                        ['parameter_category_id' => 17, 'house_condition_id' => 5, 'name' => 'pH (6,5-8,5)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 17, 'house_condition_id' => 5, 'name' => 'Suhu (Suhu udara ± 3°C)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
                        ['parameter_category_id' => 17, 'house_condition_id' => 5, 'name' => 'TDS (<300 mg/l)', 'value' => null, 'created_by' => $userId, 'updated_by' => $userId],
        ];

        foreach ($parameters as $parameter) {
            HouseParameter::create($parameter);
        }
    }
}
