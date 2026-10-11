<?php

namespace App\Services;

use Cloudinary\Api\ApiUtils;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CloudinaryService
{
    /**
     * Check if Cloudinary credentials are provided.
     */
    public static function isConfigured(): bool
    {
        $url = config('services.cloudinary.url');
        if (! empty($url)) {
            return true;
        }

        $cloudName = config('services.cloudinary.cloud_name');
        $apiKey = config('services.cloudinary.api_key');
        $apiSecret = config('services.cloudinary.api_secret');

        return ! empty($cloudName) && ! empty($apiKey) && ! empty($apiSecret);
    }

    /**
     * Initialize Cloudinary configuration.
     */
    public static function init(): void
    {
        $url = config('services.cloudinary.url');

        if (! empty($url)) {
            Configuration::instance($url);

            return;
        }

        Configuration::instance([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);
    }

    /**
     * Upload an image/general file and return its secure URL.
     */
    public static function upload(UploadedFile|string $file, string $folder = 'courses', array $options = []): ?string
    {
        $result = self::uploadRaw($file, $folder, $options);

        return $result['secure_url'] ?? null;
    }

    /**
     * Upload a video to Cloudinary with video-specific optimizations and duration extraction.
     *
     * @return array{secure_url: ?string, public_id: ?string, duration_seconds: float, duration_minutes: int, format: ?string, bytes: ?int, driver: string}
     */
    public static function uploadVideo(UploadedFile|string $file, string $folder = 'courses/videos', array $options = []): array
    {
        if (! self::isConfigured()) {
            return self::fallbackLocalVideoUpload($file, $folder);
        }

        try {
            self::init();

            $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

            $params = array_merge([
                'folder' => $folder,
                'resource_type' => 'video',
            ], $options);

            $uploadApi = new UploadApi;
            $response = $uploadApi->upload($filePath, $params);

            $durationSeconds = (float) ($response['duration'] ?? 0);
            $durationMinutes = $durationSeconds > 0 ? (int) max(1, ceil($durationSeconds / 60)) : 10;

            return [
                'secure_url' => $response['secure_url'] ?? $response['url'] ?? null,
                'public_id' => $response['public_id'] ?? null,
                'duration_seconds' => $durationSeconds,
                'duration_minutes' => $durationMinutes,
                'format' => $response['format'] ?? null,
                'bytes' => $response['bytes'] ?? null,
                'driver' => 'cloudinary',
            ];
        } catch (Throwable $e) {
            Log::warning('Cloudinary video upload failed, falling back to local disk: '.$e->getMessage());

            return self::fallbackLocalVideoUpload($file, $folder);
        }
    }

    /**
     * Upload a file and return the complete payload from Cloudinary (or local fallback).
     *
     * @return array<string, mixed>
     */
    public static function uploadRaw(UploadedFile|string $file, string $folder = 'courses', array $options = []): array
    {
        if (! self::isConfigured()) {
            return self::fallbackLocalUpload($file, $folder);
        }

        try {
            self::init();

            $filePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

            $params = array_merge([
                'folder' => $folder,
                'resource_type' => 'auto',
            ], $options);

            $uploadApi = new UploadApi;
            $response = $uploadApi->upload($filePath, $params);

            return [
                'secure_url' => $response['secure_url'] ?? $response['url'] ?? null,
                'public_id' => $response['public_id'] ?? null,
                'format' => $response['format'] ?? null,
                'bytes' => $response['bytes'] ?? null,
                'driver' => 'cloudinary',
            ];
        } catch (Throwable $e) {
            Log::warning('Cloudinary upload failed, falling back to local disk: '.$e->getMessage());

            return self::fallbackLocalUpload($file, $folder);
        }
    }

    /**
     * Get configured Cloudinary Cloud Name.
     */
    public static function getCloudName(): string
    {
        $cloudName = config('services.cloudinary.cloud_name');
        if (! empty($cloudName)) {
            return $cloudName;
        }

        if (! empty(config('services.cloudinary.url'))) {
            $parsed = parse_url(config('services.cloudinary.url'));

            return $parsed['host'] ?? '';
        }

        return '';
    }

    /**
     * Get configured Cloudinary API Key.
     */
    public static function getApiKey(): string
    {
        $apiKey = config('services.cloudinary.api_key');
        if (! empty($apiKey)) {
            return $apiKey;
        }

        if (! empty(config('services.cloudinary.url'))) {
            $parsed = parse_url(config('services.cloudinary.url'));

            return $parsed['user'] ?? '';
        }

        return '';
    }

    /**
     * Get configured Cloudinary API Secret.
     */
    public static function getApiSecret(): string
    {
        $apiSecret = config('services.cloudinary.api_secret');
        if (! empty($apiSecret)) {
            return $apiSecret;
        }

        if (! empty(config('services.cloudinary.url'))) {
            $parsed = parse_url(config('services.cloudinary.url'));

            return $parsed['pass'] ?? '';
        }

        return '';
    }

    /**
     * Sign arbitrary parameters dynamically for the Cloudinary Upload Widget.
     *
     * @param  array<string, mixed>  $params
     */
    public static function signParameters(array $params): string
    {
        $apiSecret = self::getApiSecret();

        if (empty($apiSecret)) {
            return '';
        }

        return ApiUtils::signParameters($params, $apiSecret);
    }

    /**
     * Generate parameters for Cloudinary Upload Widget (for direct browser-to-Cloudinary upload).
     *
     * @return array<string, mixed>
     */
    public static function getWidgetConfig(string $folder = 'courses/videos'): array
    {
        return [
            'cloud_name' => self::getCloudName(),
            'api_key' => self::getApiKey(),
            'folder' => $folder,
            'is_configured' => self::isConfigured(),
        ];
    }

    /**
     * Delete an asset by its public_id.
     */
    public static function delete(string $publicId, array $options = []): bool
    {
        if (! self::isConfigured()) {
            return false;
        }

        try {
            self::init();
            $uploadApi = new UploadApi;
            $result = $uploadApi->destroy($publicId, $options);

            return ($result['result'] ?? '') === 'ok';
        } catch (Throwable $e) {
            Log::error('Cloudinary asset deletion failed: '.$e->getMessage());

            return false;
        }
    }

    /**
     * Fallback to store file in Laravel local public storage.
     *
     * @return array<string, mixed>
     */
    protected static function fallbackLocalUpload(UploadedFile|string $file, string $folder): array
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store("uploads/{$folder}", 'public');
            $url = Storage::disk('public')->url($path);

            return [
                'secure_url' => $url,
                'public_id' => $path,
                'driver' => 'local',
            ];
        }

        return [
            'secure_url' => $file,
            'public_id' => null,
            'driver' => 'direct_url',
        ];
    }

    /**
     * Fallback to store video file in Laravel local public storage.
     *
     * @return array{secure_url: string, public_id: ?string, duration_seconds: float, duration_minutes: int, format: ?string, bytes: ?int, driver: string}
     */
    protected static function fallbackLocalVideoUpload(UploadedFile|string $file, string $folder): array
    {
        if ($file instanceof UploadedFile) {
            $path = $file->store("uploads/{$folder}", 'public');
            $url = Storage::disk('public')->url($path);

            return [
                'secure_url' => $url,
                'public_id' => $path,
                'duration_seconds' => 600,
                'duration_minutes' => 10,
                'format' => $file->getClientOriginalExtension(),
                'bytes' => $file->getSize(),
                'driver' => 'local',
            ];
        }

        return [
            'secure_url' => $file,
            'public_id' => null,
            'duration_seconds' => 600,
            'duration_minutes' => 10,
            'format' => null,
            'bytes' => null,
            'driver' => 'direct_url',
        ];
    }
}
