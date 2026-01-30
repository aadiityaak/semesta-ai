<?php
if (! defined('ABSPATH')) {
    exit;
}

$args = array(
    'post_type'      => 'semesta_template',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);
$templates = new WP_Query($args);
?>
<div x-data="{ activeTab: 'excel' }" class="semesta-ai-container p-6 bg-white rounded-xl border border-gray-200 max-w-4xl mx-auto my-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 tracking-tight">Template Konten & Kalender</h2>

    <div class="flex mb-6 border-b border-gray-200">
        <button class="py-2.5 px-5 font-medium text-sm transition-colors relative" :class="activeTab === 'excel' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" @click="activeTab = 'excel'">Excel / Google Sheet</button>
        <button class="py-2.5 px-5 font-medium text-sm transition-colors relative" :class="activeTab === 'guide' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700'" @click="activeTab = 'guide'">Panduan Cara Pakai</button>
    </div>

    <div x-show="activeTab === 'excel'" class="space-y-6">
        <?php if ($templates->have_posts()) : ?>
            <?php while ($templates->have_posts()) : $templates->the_post(); ?>
                <?php
                $file_url = get_post_meta(get_the_ID(), '_semesta_template_file_url', true);
                $type = get_post_meta(get_the_ID(), '_semesta_template_type', true);
                $btn_text = get_post_meta(get_the_ID(), '_semesta_template_btn_text', true);

                if (empty($btn_text)) {
                    $btn_text = 'Download Template';
                }

                // Default styles (Excel)
                $bg_class = 'bg-green-50';
                $border_class = 'border-green-100';
                $text_class = 'text-green-700';
                $btn_class = 'bg-green-600 hover:bg-green-700';
                $icon_path = 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'; // Spreadsheet

                // Styles based on type
                if ($type === 'google_sheet') {
                    $bg_class = 'bg-blue-50';
                    $border_class = 'border-blue-100';
                    $text_class = 'text-blue-700';
                    $btn_class = 'bg-blue-600 hover:bg-blue-700';
                    $icon_path = 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'; // Generic doc/sheet
                } elseif ($type === 'pdf') {
                    $bg_class = 'bg-red-50';
                    $border_class = 'border-red-100';
                    $text_class = 'text-red-700';
                    $btn_class = 'bg-red-600 hover:bg-red-700';
                    $icon_path = 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z'; // Document
                } elseif ($type === 'doc') {
                    $bg_class = 'bg-blue-50';
                    $border_class = 'border-blue-100';
                    $text_class = 'text-blue-700';
                    $btn_class = 'bg-blue-600 hover:bg-blue-700';
                    $icon_path = 'M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13'; // Paperclip/Doc
                }
                ?>
                <div class="border border-gray-200 rounded-xl p-5 flex flex-col md:flex-row items-center md:items-start space-y-4 md:space-y-0 md:space-x-6 hover:bg-gray-50 transition-colors">
                    <div class="w-full md:w-1/3 <?php echo esc_attr($bg_class); ?> h-32 flex flex-col items-center justify-center rounded-lg border <?php echo esc_attr($border_class); ?> <?php echo esc_attr($text_class); ?>">
                        <svg class="w-10 h-10 mb-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="<?php echo esc_attr($icon_path); ?>"></path>
                        </svg>
                        <span class="font-semibold text-sm"><?php echo esc_html(strtoupper(str_replace('_', ' ', $type))); ?></span>
                    </div>
                    <div class="w-full md:w-2/3">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2"><?php the_title(); ?></h3>
                        <div class="text-gray-600 text-sm mb-4 leading-relaxed prose prose-sm max-w-none">
                            <?php the_content(); ?>
                        </div>
                        <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="inline-flex items-center <?php echo esc_attr($btn_class); ?> text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            <?php echo esc_html($btn_text); ?>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 font-medium">Belum ada template yang tersedia.</p>
                <p class="text-gray-400 text-sm mt-1">Silakan tambahkan template melalui Dashboard Admin.</p>
            </div>
        <?php endif; ?>
    </div>

    <div x-show="activeTab === 'guide'" class="prose prose-sm max-w-none text-gray-600">
        <h3 class="text-gray-900 font-semibold text-lg">Cara Menggunakan Template</h3>
        <ol class="list-decimal pl-5 space-y-2 mt-4">
            <li>Download file template yang diinginkan pada tab "Excel / Google Sheet".</li>
            <li>Buka file menggunakan Microsoft Excel atau Google Sheets.</li>
            <li>Isi kolom tanggal sesuai bulan berjalan.</li>
            <li>Tulis ide konten di kolom "Ide Utama".</li>
            <li>Gunakan fitur <a href="<?php echo esc_url(site_url('/caption')); ?>" class="text-blue-600 hover:underline">Caption Generator</a> di plugin ini untuk mengisi kolom Caption dengan cepat.</li>
        </ol>
    </div>
</div>