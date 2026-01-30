<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
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
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
        },

        exportToPDF() {
            const element = document.getElementById('hpp-calculator-card');
            window.html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();
                
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                
                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('HPP-Calculator-SemestaAI.pdf');
            });
        },

        exportToPNG() {
            const element = document.getElementById('hpp-calculator-card');
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
