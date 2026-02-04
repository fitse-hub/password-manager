<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordGeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $length = $request->input('length', 16);
        $includeUppercase = $request->boolean('uppercase', true);
        $includeLowercase = $request->boolean('lowercase', true);
        $includeNumbers = $request->boolean('numbers', true);
        $includeSymbols = $request->boolean('symbols', true);

        $characters = '';
        
        if ($includeLowercase) {
            $characters .= 'abcdefghijklmnopqrstuvwxyz';
        }
        
        if ($includeUppercase) {
            $characters .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        
        if ($includeNumbers) {
            $characters .= '0123456789';
        }
        
        if ($includeSymbols) {
            $characters .= '!@#$%^&*()_+-=[]{}|;:,.<>?';
        }

        if (empty($characters)) {
            return response()->json(['error' => 'At least one character type must be selected'], 400);
        }

        $password = '';
        $charactersLength = strlen($characters);
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $charactersLength - 1)];
        }

        // Calculate strength
        $strength = $this->calculateStrength($password);

        return response()->json([
            'password' => $password,
            'strength' => $strength,
            'length' => strlen($password),
        ]);
    }

    private function calculateStrength(string $password): string
    {
        $score = 0;
        $length = strlen($password);

        // Length score
        if ($length >= 12) $score += 2;
        elseif ($length >= 8) $score += 1;

        // Character variety
        if (preg_match('/[a-z]/', $password)) $score += 1;
        if (preg_match('/[A-Z]/', $password)) $score += 1;
        if (preg_match('/[0-9]/', $password)) $score += 1;
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $score += 1;

        if ($score >= 6) return 'very_strong';
        if ($score >= 5) return 'strong';
        if ($score >= 3) return 'medium';
        return 'weak';
    }
}
