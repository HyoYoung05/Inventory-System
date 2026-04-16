<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Cloudinary extends BaseConfig
{
    public string $cloudName = '';
    public string $apiKey = '';
    public string $apiSecret = '';
    public string $folder = 'inventory-system/products';

    public function __construct()
    {
        parent::__construct();

        $cloudinaryUrl = trim((string) env('CLOUDINARY_URL', ''));

        $this->cloudName = (string) env('cloudinary.cloudName', $this->cloudName);
        $this->apiKey = (string) env('cloudinary.apiKey', $this->apiKey);
        $this->apiSecret = (string) env('cloudinary.apiSecret', $this->apiSecret);
        $this->folder = (string) env('cloudinary.folder', $this->folder);

        if ($cloudinaryUrl !== '') {
            $parsedUrl = parse_url($cloudinaryUrl);

            if (is_array($parsedUrl)) {
                if ($this->cloudName === '' && ! empty($parsedUrl['host'])) {
                    $this->cloudName = (string) $parsedUrl['host'];
                }

                if ($this->apiKey === '' && ! empty($parsedUrl['user'])) {
                    $this->apiKey = (string) $parsedUrl['user'];
                }

                if ($this->apiSecret === '' && ! empty($parsedUrl['pass'])) {
                    $this->apiSecret = (string) $parsedUrl['pass'];
                }
            }
        }
    }
}
