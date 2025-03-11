<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class HybridAuth extends BaseConfig
{
    public $config;

    public function __construct()
    {
        $baseCallbackUrl = base_url('social_login/callback?provider=');

        $this->config = [
            // General callback URL for HybridAuth
            'callback' => base_url('auth/callback'),

            // Providers configuration
            'providers' => [
                'Google' => [
                    'enabled' => true,
                    'keys' => [
                        'id' => get_setting('google_client_id'),
                        'secret' => get_setting('google_client_secret'),
                    ],
                    'scope' => 'email', // Optional scope
                    'callback' => $baseCallbackUrl . 'Google'
                ],
                'Facebook' => [
                    'enabled' => true,
                    'keys' => [
                        'id' =>  get_setting('facebook_client_id'),
                        'secret' => get_setting('facebook_client_secret')
                    ],
                    'scope' => 'email, public_profile', // Optional scope
                    'callback' => $baseCallbackUrl . 'Facebook'
                ],
                'Twitter' => [
                    'enabled' => true,
                    'keys' => [
                        'key' => 'YOUR_TWITTER_API_KEY', // Replace with your Twitter API key
                        'secret' => 'YOUR_TWITTER_API_SECRET' // Replace with your Twitter API secret
                    ],
                    'callback' => $baseCallbackUrl . 'Twitter'
                ],
                'LinkedIn' => [
                    'enabled' => true,
                    'keys' => [
                        'id' => '776oavy63s2oyb', // Replace with LinkedIn Client ID
                        'secret' => 'Np2UAC3sKOFR6VOm' // Replace with LinkedIn Client Secret
                    ],
                    'scope' => 'r_liteprofile r_emailaddress',
                    'callback' => $baseCallbackUrl . 'LinkedIn'
                ]
                // Add other social providers as needed
            ],

            // Additional HybridAuth configuration options
            'debug_mode' => false, // Set to true to enable debugging
            'debug_file' => WRITEPATH . 'logs/hybridauth.log', // Log file for debugging
            'curl_options' => [
                CURLOPT_SSL_VERIFYPEER => false,
            ],
        ];
    }
}
