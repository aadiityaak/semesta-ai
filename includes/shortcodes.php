<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Caption Generator Shortcode
function semesta_ai_caption_shortcode() {
    ob_start();
    ?>
    <div x-data="captionGenerator()" class="semesta-ai-container p-6 bg-white rounded-lg shadow-md max-w-2xl mx-auto my-8 border border-gray-200">
        <!-- Banner -->
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6" role="alert">
            <p class="font-bold">Info</p>
            <p>Free Beta sampai Lebaran! 🌙</p>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Caption Generator UMKM</h2>

        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                <input type="text" x-model="form.product" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Sambal Cumi Judes">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Usaha</label>
                    <input type="text" x-model="form.business_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Kuliner">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Target Market</label>
                    <input type="text" x-model="form.target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Mahasiswa, Ibu Rumah Tangga">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Platform</label>
                    <select x-model="form.platform" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Instagram">Instagram</option>
                        <option value="TikTok">TikTok</option>
                        <option value="Facebook">Facebook</option>
                        <option value="WhatsApp">WhatsApp</option>
                        <option value="Twitter">Twitter/X</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tone</label>
                    <select x-model="form.tone" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Casual & Fun">Casual & Fun</option>
                        <option value="Professional">Professional</option>
                        <option value="Persuasive (Hard Sell)">Persuasive (Hard Sell)</option>
                        <option value="Storytelling">Storytelling</option>
                        <option value="Educational">Educational</option>
                    </select>
                </div>
            </div>

            <button @click="generateCaption" :disabled="loading" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full transition duration-300 flex justify-center items-center">
                <span x-show="loading" class="mr-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span x-text="loading ? 'Sedang Membuat...' : 'Generate Caption'"></span>
            </button>

            <!-- Result Area -->
            <div x-show="result" class="mt-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Hasil Caption:</label>
                <textarea x-model="result" rows="8" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline bg-gray-50" readonly></textarea>
                
                <div class="flex space-x-2 mt-2">
                    <button @click="copyToClipboard" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded flex-1">
                        <span x-text="copied ? 'Tersalin!' : 'Copy Caption'"></span>
                    </button>
                    <button @click="generateCaption" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex-1">
                        Generate Ulang
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'semesta_caption', 'semesta_ai_caption_shortcode' );

// 2. HPP Calculator Shortcode
function semesta_ai_hpp_shortcode() {
    ob_start();
    ?>
    <div x-data="hppCalculator()" id="hpp-calculator-card" class="semesta-ai-container p-6 bg-white rounded-lg shadow-md max-w-2xl mx-auto my-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Kalkulator HPP UMKM</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Modal Bahan (Rp)</label>
                <input type="number" x-model.number="form.material" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Biaya Produksi (Rp)</label>
                <input type="number" x-model.number="form.production" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Biaya Kemasan (Rp)</label>
                <input type="number" x-model.number="form.packaging" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Biaya Operasional (Rp)</label>
                <input type="number" x-model.number="form.operational" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Target Profit (%)</label>
                <input type="number" x-model.number="form.profit_percent" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: 30">
            </div>
        </div>

        <div class="bg-gray-100 p-4 rounded-lg mb-6">
            <h3 class="font-bold text-lg mb-2">Hasil Perhitungan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm text-gray-500">HPP / Unit</p>
                    <p class="text-xl font-bold text-blue-600" x-text="formatRupiah(calculateHPP())"></p>
                </div>
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm text-gray-500">Harga Jual</p>
                    <p class="text-xl font-bold text-green-600" x-text="formatRupiah(calculatePrice())"></p>
                </div>
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm text-gray-500">Margin (Rp)</p>
                    <p class="text-xl font-bold text-purple-600" x-text="formatRupiah(calculateMargin())"></p>
                </div>
            </div>
        </div>

        <div class="flex space-x-2">
            <button @click="exportToPDF" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex-1">
                Export PDF
            </button>
            <button @click="exportToPNG" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded flex-1">
                Export PNG
            </button>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'semesta_hpp', 'semesta_ai_hpp_shortcode' );

// 3. Template Konten Shortcode
function semesta_ai_template_shortcode() {
    ob_start();
    ?>
    <div x-data="{ activeTab: 'excel' }" class="semesta-ai-container p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto my-8 border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Template Konten & Kalender</h2>
        
        <div class="flex mb-4 border-b">
            <button class="py-2 px-4 font-semibold" :class="activeTab === 'excel' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'" @click="activeTab = 'excel'">Excel / Google Sheet</button>
            <button class="py-2 px-4 font-semibold" :class="activeTab === 'guide' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'" @click="activeTab = 'guide'">Panduan Cara Pakai</button>
        </div>

        <div x-show="activeTab === 'excel'" class="space-y-6">
            <!-- Template Item 1 -->
            <div class="border rounded-lg p-4 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-4">
                <div class="w-full md:w-1/3 bg-green-100 h-32 flex items-center justify-center rounded text-green-700 font-bold">
                    Preview Sheet
                </div>
                <div class="w-full md:w-2/3">
                    <h3 class="font-bold text-lg">Kalender Konten Bulanan</h3>
                    <p class="text-gray-600 mb-4">Template lengkap untuk merencanakan konten Instagram & TikTok selama satu bulan. Termasuk kolom ide, caption, status, dan tanggal posting.</p>
                    <a href="#" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Download Excel Template
                    </a>
                </div>
            </div>
            
            <!-- Template Item 2 -->
            <div class="border rounded-lg p-4 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-4">
                <div class="w-full md:w-1/3 bg-blue-100 h-32 flex items-center justify-center rounded text-blue-700 font-bold">
                    Preview Sheet
                </div>
                <div class="w-full md:w-2/3">
                    <h3 class="font-bold text-lg">Script Video Pendek (Reels/TikTok)</h3>
                    <p class="text-gray-600 mb-4">Template struktur script mulai dari Hook, Body, hingga Call to Action. Membantu membuat video yang lebih terstruktur.</p>
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Download Google Sheet
                    </a>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'guide'" class="prose max-w-none">
            <h3>Cara Menggunakan Template</h3>
            <ol>
                <li>Download file template yang diinginkan.</li>
                <li>Buka menggunakan Microsoft Excel atau Google Sheets.</li>
                <li>Isi kolom tanggal sesuai bulan berjalan.</li>
                <li>Tulis ide konten di kolom "Ide Utama".</li>
                <li>Gunakan fitur "Caption Generator" di plugin ini untuk mengisi kolom Caption.</li>
            </ol>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'semesta_template', 'semesta_ai_template_shortcode' );
