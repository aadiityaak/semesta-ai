<?php
if (! defined('ABSPATH')) {
    exit;
}

$api_url = get_rest_url(null, 'semesta-ai/v1/generate');
$nonce = wp_create_nonce('wp_rest');
?>

<div x-data="captionGenerator()" class="semesta-ai-container p-6 bg-white rounded-xl border border-gray-200 w-full mx-auto my-8 relative">
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

    <!-- Modal Notification -->
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showModal = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="modalTitle"></h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" x-text="modalMessage"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                        Mengerti
                    </button>
                </div>
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
            showModal: false,
            modalTitle: '',
            modalMessage: '',

            openModal(title, message) {
                this.modalTitle = title;
                this.modalMessage = message;
                this.showModal = true;
            },

            async generateCaption() {
                if (!this.form.product) {
                    this.openModal('Peringatan', 'Mohon isi nama produk terlebih dahulu!');
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
                        // Handle specific API error structure if needed, or fallback to general message
                        const msg = data.message || 'Gagal membuat caption. Silakan coba lagi.';
                        this.openModal('Gagal', 'Error: ' + msg);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.openModal('Koneksi Error', 'Terjadi kesalahan koneksi. Pastikan internet Anda lancar.');
                } finally {
                    this.loading = false;
                }
            },

            copyToClipboard() {
                if (!this.result) return;

                // Fallback for browsers/contexts where navigator.clipboard is not available (e.g. HTTP)
                if (!navigator.clipboard) {
                    const textArea = document.createElement("textarea");
                    textArea.value = this.result;

                    // Avoid scrolling to bottom
                    textArea.style.top = "0";
                    textArea.style.left = "0";
                    textArea.style.position = "fixed";

                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();

                    try {
                        const successful = document.execCommand('copy');
                        if (successful) {
                            this.copied = true;
                            setTimeout(() => this.copied = false, 2000);
                        } else {
                            this.openModal('Gagal Copy', 'Browser Anda tidak mendukung fitur copy otomatis.');
                        }
                    } catch (err) {
                        console.error('Fallback: Oops, unable to copy', err);
                        this.openModal('Gagal Copy', 'Gagal menyalin teks.');
                    }

                    document.body.removeChild(textArea);
                    return;
                }

                navigator.clipboard.writeText(this.result).then(() => {
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                }).catch(err => {
                    console.error('Could not copy text: ', err);
                    this.openModal('Gagal Copy', 'Gagal menyalin teks ke clipboard.');
                });
            }
        }));
    });
</script>