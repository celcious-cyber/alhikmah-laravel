<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Crypt;
use Exception;

class TokenService
{
    /**
     * Generate an encrypted token for an Admin ID.
     */
    public static function generate(int $adminId): string
    {
        $payload = [
            'id' => $adminId,
            'expires_at' => time() + (24 * 60 * 60) // Valid for 24 hours
        ];

        return Crypt::encrypt($payload);
    }

    /**
     * Verify an encrypted token and return the Admin model if valid.
     */
    public static function verify(string $token): ?Admin
    {
        try {
            $payload = Crypt::decrypt($token);

            if (!is_array($payload) || !isset($payload['id'], $payload['expires_at'])) {
                return null;
            }

            // Check if token has expired
            if (time() > $payload['expires_at']) {
                return null;
            }

            return Admin::find($payload['id']);
        } catch (Exception $e) {
            return null; // Invalid token format or signature
        }
    }
}
