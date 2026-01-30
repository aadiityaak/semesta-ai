<?php
if (! defined('ABSPATH')) {
    exit;
}
?>
<div x-data="hppCalculator()" id="hpp-calculator-card" class="semesta-ai-container p-6 bg-white rounded-xl border border-gray-200 w-full mx-auto my-8 relative">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 tracking-tight">Kalkulator HPP UMKM</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Modal Bahan (Rp)</label>
            <input type="text" inputmode="numeric" :value="formatNumber(form.material)" @input="inputMoney($event, 'material')" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Biaya Produksi (Rp)</label>
            <input type="text" inputmode="numeric" :value="formatNumber(form.production)" @input="inputMoney($event, 'production')" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Biaya Kemasan (Rp)</label>
            <input type="text" inputmode="numeric" :value="formatNumber(form.packaging)" @input="inputMoney($event, 'packaging')" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Biaya Operasional (Rp)</label>
            <input type="text" inputmode="numeric" :value="formatNumber(form.operational)" @input="inputMoney($event, 'operational')" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
        </div>
        <div class="md:col-span-2">
            <label class="block text-gray-700 text-sm font-medium mb-2">Target Profit (%)</label>
            <input type="number" x-model.number="form.profit_percent" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Contoh: 30">
        </div>
    </div>

    <div class="bg-gray-50 border border-gray-200 p-6 rounded-xl mb-8">
        <h3 class="font-semibold text-lg mb-4 text-gray-900">Hasil Perhitungan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">HPP / Unit</p>
                <p class="text-xl font-bold text-blue-600" x-text="formatRupiah(calculateHPP())"></p>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Harga Jual</p>
                <p class="text-xl font-bold text-green-600" x-text="formatRupiah(calculatePrice())"></p>
            </div>
            <div class="bg-white p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Margin (Rp)</p>
                <p class="text-xl font-bold text-purple-600" x-text="formatRupiah(calculateMargin())"></p>
            </div>
        </div>
    </div>

    <div class="flex space-x-3">
        <button @click="exportToPDF" class="flex-1 bg-white border border-red-500 text-red-600 hover:bg-red-50 font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            Export PDF
        </button>
        <button @click="exportToPNG" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Export PNG
        </button>
    </div>

    <!-- Hidden Export Layout -->
    <div id="hpp-export-layout" style="position: absolute; left: -9999px; top: 0; width: 800px; padding: 40px; background-color: white;">
        <div class="text-center mb-10 border-b border-gray-100 pb-6">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Laporan HPP UMKM</h2>
            <p class="text-gray-500">Perhitungan Harga Pokok Penjualan</p>
        </div>

        <div class="grid grid-cols-2 gap-10 mb-10">
            <div class="space-y-5">
                <h3 class="font-bold text-gray-800 text-lg border-b pb-2 mb-3">Komponen Biaya</h3>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <span class="text-gray-600">Modal Bahan</span>
                    <span class="font-medium text-gray-900" x-text="formatRupiah(form.material)"></span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <span class="text-gray-600">Biaya Produksi</span>
                    <span class="font-medium text-gray-900" x-text="formatRupiah(form.production)"></span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <span class="text-gray-600">Biaya Kemasan</span>
                    <span class="font-medium text-gray-900" x-text="formatRupiah(form.packaging)"></span>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-50">
                    <span class="text-gray-600">Biaya Operasional</span>
                    <span class="font-medium text-gray-900" x-text="formatRupiah(form.operational)"></span>
                </div>
            </div>

            <div class="space-y-5">
                <h3 class="font-bold text-gray-800 text-lg border-b pb-2 mb-3">Target Profit</h3>
                <div class="flex flex-col justify-center items-center h-48 bg-blue-50 rounded-xl border border-blue-100">
                    <span class="text-5xl font-bold text-blue-600" x-text="form.profit_percent + '%'"></span>
                    <p class="text-blue-500 font-medium mt-2">Margin Keuntungan</p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-xl p-8 mb-10 border border-gray-200">
            <h3 class="font-bold text-gray-900 mb-6 text-xl text-center">Hasil Analisa Keuangan</h3>
            <div class="grid grid-cols-3 gap-6 text-center">
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm mb-2 uppercase tracking-wide">HPP / Unit</p>
                    <p class="text-2xl font-bold text-gray-800" x-text="formatRupiah(calculateHPP())"></p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm mb-2 uppercase tracking-wide">Harga Jual</p>
                    <p class="text-2xl font-bold text-green-600" x-text="formatRupiah(calculatePrice())"></p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <p class="text-gray-500 text-sm mb-2 uppercase tracking-wide">Profit / Unit</p>
                    <p class="text-2xl font-bold text-purple-600" x-text="formatRupiah(calculateMargin())"></p>
                </div>
            </div>
        </div>

        <div class="text-center pt-8 border-t border-gray-200 mt-auto">
            <p class="text-gray-400 font-medium italic">Dibuat dengan <b>Semesta AI</b> - semestaai.my.id</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('hppCalculator', () => ({
            form: {
                material: 0,
                production: 0,
                packaging: 0,
                operational: 0,
                profit_percent: 30
            },

            formatNumber(number) {
                if (number === '' || number === null) return '';
                return new Intl.NumberFormat('id-ID').format(number);
            },

            inputMoney(event, field) {
                // Hapus semua karakter selain angka
                let rawValue = event.target.value.replace(/[^0-9]/g, '');

                // Konversi ke angka
                let value = rawValue ? parseInt(rawValue, 10) : 0;

                // Update model
                this.form[field] = value;

                // Format tampilan input
                if (rawValue === '') {
                    event.target.value = '';
                } else {
                    event.target.value = this.formatNumber(value);
                }
            },

            calculateHPP() {
                return (this.form.material || 0) +
                    (this.form.production || 0) +
                    (this.form.packaging || 0) +
                    (this.form.operational || 0);
            },

            calculatePrice() {
                const hpp = this.calculateHPP();
                const profit = (hpp * (this.form.profit_percent || 0)) / 100;
                return hpp + profit;
            },

            calculateMargin() {
                return this.calculatePrice() - this.calculateHPP();
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            },

            exportToPDF() {
                const element = document.getElementById('hpp-export-layout');
                window.html2canvas(element).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const {
                        jsPDF
                    } = window.jspdf;
                    const pdf = new jsPDF();

                    const imgProps = pdf.getImageProperties(imgData);
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                    pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                    pdf.save('HPP-Calculator-SemestaAI.pdf');
                });
            },

            exportToPNG() {
                const element = document.getElementById('hpp-export-layout');
                window.html2canvas(element).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'HPP-Calculator-SemestaAI.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            }
        }));
    });
</script>