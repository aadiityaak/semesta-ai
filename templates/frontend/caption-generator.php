<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$api_url = get_rest_url( null, 'semesta-ai/v1/generate' );
$nonce = wp_create_nonce( 'wp_rest' );
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

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('captionGenerator', () => ({
        form: {
            product: '',
            business_type: '',
            target: '',
            platform: 'Instagram',
            tone: 'Casual & Fun'
        },
        loading: false,
        result: '',
        copied: false,

        async generateCaption() {
            if (!this.form.product) {
                alert('Mohon isi nama produk!');
                return;
            }

            this.loading = true;
            this.result = '';
            this.copied = false;

            try {
                const response = await fetch('<?php echo esc_url( $api_url ); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': '<?php echo esc_js( $nonce ); ?>'
                    },
                    body: JSON.stringify({
                        type: 'caption',
                        ...this.form
                    })
                });

                const data = await response.json();

                if (data.success) {
                    this.result = data.data;
                } else {
                    alert('Error: ' + (data.message || 'Gagal membuat caption.'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
            } finally {
                this.loading = false;
            }
        },

        copyToClipboard() {
            if (!this.result) return;
            navigator.clipboard.writeText(this.result).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }));
});
</script>
