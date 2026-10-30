<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use RuntimeException;

class SupabaseStorageService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        $url = rtrim(config('services.supabase.url'), '/');
        $key = config('services.supabase.storage_key');
        $bucket = config('services.supabase.bucket');

        $extension = $file->extension();
        $filename = Str::uuid() . '.' . $extension;
        $path = trim($folder, '/') . '/' . $filename;

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
            'Content-Type' => $file->getMimeType(),
            'x-upsert' => 'false',
        ])->withBody(
            file_get_contents($file->getRealPath()),
            $file->getMimeType()
        )->post(
            "{$url}/storage/v1/object/{$bucket}/{$path}"
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'Supabase upload gagal: ' . $response->body()
            );
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if (!$path) {
            return;
        }

        $url = rtrim(config('services.supabase.url'), '/');
        $key = config('services.supabase.storage_key');
        $bucket = config('services.supabase.bucket');

        $response = Http::withHeaders([
            'apikey' => $key,
            'Authorization' => 'Bearer ' . $key,
        ])->delete(
            "{$url}/storage/v1/object/{$bucket}/{$path}"
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'Supabase delete gagal: ' . $response->body()
            );
        }
    }

    public function publicUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return rtrim(config('services.supabase.url'), '/')
            . '/storage/v1/object/public/'
            . config('services.supabase.bucket')
            . '/'
            . implode('/', array_map('rawurlencode', explode('/', $path)));
    }
}
