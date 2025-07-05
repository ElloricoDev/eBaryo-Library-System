<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WampSslHelper
{
    /**
     * Configure HTTP client for WAMP environment
     */
    public static function configureHttpClient()
    {
        if (app()->environment('local')) {
            // Common WAMP SSL certificate paths
            $possiblePaths = [
                'C:\wamp64\bin\php\php8.2.26\extras\ssl\cacert.pem',
                'C:\wamp\bin\php\php8.2.26\extras\ssl\cacert.pem',
                'C:\wamp64\bin\php\php8.1.26\extras\ssl\cacert.pem',
                'C:\wamp\bin\php\php8.1.26\extras\ssl\cacert.pem',
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    Http::withOptions(['verify' => $path]);
                    return true;
                }
            }

            // Fallback: disable SSL verification for development
            Http::withOptions(['verify' => false]);
            return false;
        }

        return true; // Production environment
    }

    /**
     * Download and setup SSL certificates for WAMP
     */
    public static function setupSslCertificates()
    {
        $wampPath = 'C:\wamp64\bin\php\php8.2.26\extras\ssl';
        $certPath = $wampPath . '\cacert.pem';

        // Create directory if it doesn't exist
        if (!is_dir($wampPath)) {
            mkdir($wampPath, 0755, true);
        }

        // Download certificates if they don't exist
        if (!file_exists($certPath)) {
            $certUrl = 'https://curl.se/ca/cacert.pem';
            $certContent = file_get_contents($certUrl);
            
            if ($certContent !== false) {
                file_put_contents($certPath, $certContent);
                return true;
            }
        }

        return file_exists($certPath);
    }
} 