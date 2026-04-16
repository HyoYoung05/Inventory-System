<?php

namespace App\Libraries;

use Config\Cloudinary;

class CloudinaryUploader
{
    private Cloudinary $config;

    public function __construct(?Cloudinary $config = null)
    {
        $this->config = $config ?? config('Cloudinary');
    }

    public function isConfigured(): bool
    {
        return $this->config->cloudName !== ''
            && $this->config->apiKey !== ''
            && $this->config->apiSecret !== '';
    }

    public function upload(string $filePath, ?string $originalName = null): string
    {
        if (! $this->isConfigured()) {
            throw new \RuntimeException('Cloudinary is not configured yet.');
        }

        if (! is_file($filePath)) {
            throw new \RuntimeException('The uploaded file could not be found.');
        }

        $endpoint = sprintf(
            'https://api.cloudinary.com/v1_1/%s/auto/upload',
            rawurlencode($this->config->cloudName)
        );

        $postFields = [
            'file' => curl_file_create($filePath),
            'folder' => $this->config->folder,
            'use_filename' => 'true',
            'unique_filename' => 'true',
        ];

        if ($originalName !== null && trim($originalName) !== '') {
            $postFields['public_id'] = pathinfo($originalName, PATHINFO_FILENAME);
        }

        $curl = curl_init($endpoint);
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_USERPWD => $this->config->apiKey . ':' . $this->config->apiSecret,
        ]);

        $response = curl_exec($curl);
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($response === false || $curlError !== '') {
            throw new \RuntimeException('Cloudinary upload failed: ' . $curlError);
        }

        $payload = json_decode($response, true);
        if ($httpCode >= 400 || ! is_array($payload) || empty($payload['secure_url'])) {
            $message = $payload['error']['message'] ?? 'Cloudinary did not return a file URL.';
            throw new \RuntimeException('Cloudinary upload failed: ' . $message);
        }

        return (string) $payload['secure_url'];
    }
}
