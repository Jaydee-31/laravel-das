<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendorNames = [
            '1&1-IONOS', '3DCONNEXION', '3M', '4WORLD', 'A-DATA', 'ACER',
            'ACER-MONITOR', 'ACRONIS', 'ACTIVISION', 'ADERIAN', 'ADOBE',
            'AGFEO', 'AIRSLATE', 'AKYGA', 'ALCATEL-LUCENT', 'ALLIED-TELESIS',
            'ALSO', 'AMD', 'ANKI', 'AOC-INTERNATIONAL', 'APACER', 'APC',
            'APPLE', 'APPLICATIELINK', 'ARCSERVE', 'ART', 'ARUBA', 'ASROCK',
            'ASSMANN-ELECTRONIC', 'ASUS', 'ATEN', 'AUERSWALD', 'AUREA-SOFTWARE',
            'AV-STUMPFL', 'AVER-INDORMATION', 'AVERPOINT', 'AVM',
            'AXIS-COMMUNICATIONS', 'AZON', 'BARCO', 'BARRACUDA', 'BASF-3D',
            'BELKIN', 'BENQ', 'BINTEC-ELMEG', 'BLAUPUNKT', 'BLIZZARD-ENTERTAINMENT',
            'ZYXEL', 'ZIMBRA', 'ZOTAC'
        ];

        foreach ($vendorNames as $name) {
            Vendor::create(['name' => $name]);
        }
    }
}
