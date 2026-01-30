<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div x-data="{ activeTab: 'excel' }" class="semesta-ai-container p-6 bg-white rounded-xl border border-gray-200 max-w-4xl mx-auto my-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 tracking-tight">Template Konten & Kalender</h2>

    <div class="flex mb-6 border-b border-gray-200">
        <button class="py-2.5 px-5 font-medium text-sm transition-colors relative" :class="activeTab === 'excel' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" @click="activeTab = 'excel'">Excel / Google Sheet</button>
        <button class="py-2.5 px-5 font-medium text-sm transition-colors relative" :class="activeTab === 'guide' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" @click="activeTab = 'guide'">Panduan Cara Pakai</button>
    </div>

    <div x-show="activeTab === 'excel'" class="space-y-6">
        <!-- Template Item 1 -->
        <div class="border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6 hover:bg-gray-50 transition-colors">
            <div class="w-full md:w-1/3 bg-green-50 h-32 flex flex-col items-center justify-center rounded-lg border border-green-100 text-green-700">
                <svg class="w-10 h-10 mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-semibold text-sm">Preview Sheet</span>
            </div>
            <div class="w-full md:w-2/3">
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Kalender Konten Bulanan</h3>
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">Template lengkap untuk merencanakan konten Instagram & TikTok selama satu bulan. Termasuk kolom ide, caption, status, dan tanggal posting.</p>
                <a href="#" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download Excel Template
                </a>
            </div>
        </div>

        <!-- Template Item 2 -->
        <div class="border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6 hover:bg-gray-50 transition-colors">
            <div class="w-full md:w-1/3 bg-blue-50 h-32 flex flex-col items-center justify-center rounded-lg border border-blue-100 text-blue-700">
                <svg class="w-10 h-10 mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="font-semibold text-sm">Preview Sheet</span>
            </div>
            <div class="w-full md:w-2/3">
                <h3 class="font-semibold text-lg text-gray-900 mb-2">Script Video Pendek (Reels/TikTok)</h3>
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">Template struktur script mulai dari Hook, Body, hingga Call to Action. Membantu membuat video yang lebih terstruktur.</p>
                <a href="#" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Download Google Sheet
                </a>
            </div>
        </div>
    </div>

    <div x-show="activeTab === 'guide'" class="prose prose-sm max-w-none text-gray-600">
        <h3 class="text-gray-900 font-semibold text-lg">Cara Menggunakan Template</h3>
        <ol class="list-decimal pl-5 space-y-2 mt-4">
            <li>Download file template yang diinginkan pada tab "Excel / Google Sheet".</li>
            <li>Buka file menggunakan Microsoft Excel atau Google Sheets.</li>
            <li>Isi kolom tanggal sesuai bulan berjalan.</li>
            <li>Tulis ide konten di kolom "Ide Utama".</li>
            <li>Gunakan fitur <a href="#" class="text-blue-600 hover:underline">Caption Generator</a> di plugin ini untuk mengisi kolom Caption dengan cepat.</li>
        </ol>
    </div>
</div>