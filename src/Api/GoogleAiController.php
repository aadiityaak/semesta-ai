<?php

namespace SemestaAi\Api;

if (! defined('ABSPATH')) {
    exit;
}

class GoogleAiController
{

    public function __construct()
    {
        add_action('rest_api_init', array($this, 'register_rest_route'));
    }

    public function register_rest_route()
    {
        register_rest_route('semesta-ai/v1', '/generate', array(
            'methods' => 'POST',
            'callback' => array($this, 'generate_content'),
            'permission_callback' => '__return_true', // You might want to restrict this to logged-in users or specific nonces
        ));
    }

    public function generate_content($request)
    {
        // Retrieve the API key from WordPress options
        $api_key = get_option('semesta_ai_google_api_key');

        if (empty($api_key)) {
            return new \WP_Error('no_api_key', 'API Key Google AI belum disetting.', array('status' => 500));
        }

        $params = $request->get_json_params();
        $type = isset($params['type']) ? $params['type'] : 'caption';

        $prompt = '';

        if ($type === 'caption') {
            $product = isset($params['product']) ? sanitize_text_field($params['product']) : '';
            $business_type = isset($params['business_type']) ? sanitize_text_field($params['business_type']) : '';
            $target = isset($params['target']) ? sanitize_text_field($params['target']) : '';
            $platform = isset($params['platform']) ? sanitize_text_field($params['platform']) : '';
            $tone = isset($params['tone']) ? sanitize_text_field($params['tone']) : '';

            $prompt = "Bertindaklah sebagai copywriter profesional. Buatkan caption menarik untuk sosial media dengan detail berikut:\n";
            $prompt .= "- Nama Produk: $product\n";
            $prompt .= "- Jenis Usaha: $business_type\n";
            $prompt .= "- Target Market: $target\n";
            $prompt .= "- Platform: $platform\n";
            $prompt .= "- Tone of Voice: $tone\n";
            $prompt .= "Buatkan caption yang persuasif, gunakan emoji yang relevan, dan sertakan beberapa hashtag yang cocok. Berikan output langsung berupa caption tanpa kata pengantar.";
        } else {
            return new \WP_Error('invalid_type', 'Invalid request type.', array('status' => 400));
        }

        // Call Google AI Studio API (Gemini)
        $api_url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $api_key;

        $body = array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt)
                    )
                )
            )
        );

        $response = wp_remote_post($api_url, array(
            'headers' => array('Content-Type' => 'application/json'),
            'body'    => json_encode($body),
            'timeout' => 30
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $response_body = wp_remote_retrieve_body($response);
        $data = json_decode($response_body, true);

        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return array(
                'success' => true,
                'data' => $data['candidates'][0]['content']['parts'][0]['text']
            );
        } else {
            return new \WP_Error('api_error', 'Gagal mendapatkan respons dari Google AI.', array('status' => 500, 'details' => $data));
        }
    }
}
