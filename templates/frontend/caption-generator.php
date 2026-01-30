<?php
if (! defined('ABSPATH')) {
    exit;
}

$api_url = get_rest_url(null, 'semesta-ai/v1/generate');
$nonce = wp_create_nonce('wp_rest');
?>

<div x-data="captionGenerator()" class="semesta-ai-container p-6 bg-white rounded-xl border border-gray-200 w-full mx-auto my-8">
    <!-- Banner -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg text-blue-700 p-4 mb-6 flex items-start space-x-3">
        <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <p class="font-semibold">Info</p>
            <p class="text-sm">Free Beta sampai Lebaran! 🌙</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6 text-gray-900 tracking-tight">Caption Generator UMKM</h2>

    <div class="space-y-5">
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-2">Nama Produk</label>
            <input type="text" x-model="form.product" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Contoh: Sambal Cumi Judes">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Jenis Usaha</label>
                <input type="text" x-model="form.business_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Contoh: Kuliner">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Target Market</label>
                <input type="text" x-model="form.target" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" placeholder="Contoh: Mahasiswa, Ibu Rumah Tangga">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Platform</label>
                <select x-model="form.platform" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors bg-white">
                    <option value="Instagram">Instagram</option>
                    <option value="TikTok">TikTok</option>
                    <option value="Facebook">Facebook</option>
                    <option value="WhatsApp">WhatsApp</option>
                    <option value="Twitter">Twitter/X</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-2">Tone</label>
                <select x-model="form.tone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors bg-white">
                    <option value="Casual & Fun">Casual & Fun</option>
                    <option value="Professional">Professional</option>
                    <option value="Persuasive (Hard Sell)">Persuasive (Hard Sell)</option>
                    <option value="Storytelling">Storytelling</option>
                    <option value="Educational">Educational</option>
                </select>
            </div>
        </div>

        <button @click="generateCaption" :disabled="loading" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition duration-200 flex justify-center items-center disabled:opacity-70 disabled:cursor-not-allowed">
            <span x-show="loading" class="mr-2">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
            <span x-text="loading ? 'Sedang Membuat...' : 'Generate Caption'"></span>
        </button>

        <!-- Result Area -->
        <div x-show="result" class="mt-8 pt-6 border-t border-gray-100">
            <label class="block text-gray-700 text-sm font-medium mb-2">Hasil Caption:</label>
            <textarea x-model="result" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 text-gray-800" readonly></textarea>

            <div class="flex space-x-3 mt-4">
                <button @click="copyToClipboard" class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    <span x-text="copied ? 'Tersalin!' : 'Copy Caption'"></span>
                </button>
                <button @click="generateCaption" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
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
                    const response = await fetch('<?php echo esc_url($api_url); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-WP-Nonce': '<?php echo esc_js($nonce); ?>'
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