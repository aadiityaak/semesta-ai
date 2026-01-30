<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
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
