<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to redirect to Google. Please try again.'
            ]);
        }
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            // Log the incoming request for debugging
            Log::info('Google OAuth Callback Received', [
                'query_params' => request()->query(),
                'has_code' => request()->has('code'),
                'has_state' => request()->has('state'),
                'state_match' => session('state') === request()->get('state')
            ]);

            // Check for OAuth errors from Google
            if (request()->has('error')) {
                $error = request()->get('error');
                $errorDescription = request()->get('error_description', '');
                
                Log::error('Google OAuth Error Response', [
                    'error' => $error,
                    'description' => $errorDescription
                ]);
                
                $errorMessage = match($error) {
                    'access_denied' => 'Access denied. Please grant permission to sign in with Google.',
                    'invalid_request' => 'Invalid request. Please try again.',
                    'unauthorized_client' => 'Unauthorized client configuration.',
                    'unsupported_response_type' => 'Unsupported response type.',
                    'invalid_scope' => 'Invalid scope requested.',
                    'server_error' => 'Google server error. Please try again later.',
                    'temporarily_unavailable' => 'Google service temporarily unavailable.',
                    default => 'Google authentication failed: ' . ($errorDescription ?: $error)
                };
                
                return redirect()->route('login')->withErrors(['email' => $errorMessage]);
            }

            // Validate required parameters
            if (!request()->has('code')) {
                Log::error('Google OAuth Missing Code Parameter');
                return redirect()->route('login')->withErrors([
                    'email' => 'Missing authorization code from Google. Please try again.'
                ]);
            }

            // Get the Google user
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Google User Retrieved Successfully', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'id' => $googleUser->getId()
            ]);
            
            // Check if user with this email already exists
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                // Check if existing user is admin or rider
                $role = strtolower($existingUser->role ?? '');
                if ($role === 'admin' || $role === 'rider') {
                    Log::warning('Social login blocked for non-customer role', [
                        'email' => $googleUser->getEmail(),
                        'role' => $role
                    ]);
                    
                    return redirect()->route('login')->withErrors([
                        'email' => 'This email is already registered as ' . ucfirst($role) . '. Social login is only available for customers.'
                    ]);
                }
                
                // Update provider info if not already set
                if (!$existingUser->provider || !$existingUser->provider_id) {
                    $existingUser->update([
                        'provider' => 'google',
                        'provider_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                }
                
                // Login existing customer
                Auth::login($existingUser, true);
                Log::info('Existing customer logged in via Google', [
                    'user_id' => $existingUser->id,
                    'email' => $existingUser->email
                ]);
                
                return redirect()->intended('/customer/home');
            }
            
            // Create new customer user
            $newUser = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(uniqid()), // Random password for social users
                'role' => 'customer', // Force customer role
                'status' => 'active',
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);
            
            // Login new user
            Auth::login($newUser, true);
            
            Log::info('New customer created and logged in via Google', [
                'user_id' => $newUser->id,
                'email' => $newUser->email
            ]);
            
            return redirect()->intended('/customer/home');
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            
            Log::error('Google OAuth HTTP Client Error', [
                'status_code' => $statusCode,
                'response_body' => $body,
                'exception' => $e->getMessage()
            ]);
            
            $errorMessage = 'Google authentication service error. ';
            if ($statusCode === 400) {
                $errorMessage .= 'Invalid request or configuration.';
            } elseif ($statusCode === 401) {
                $errorMessage .= 'Unauthorized. Check your Google OAuth credentials.';
            } elseif ($statusCode === 403) {
                $errorMessage .= 'Access forbidden. Check your OAuth configuration.';
            } else {
                $errorMessage .= 'Please try again later.';
            }
            
            return redirect()->route('login')->withErrors(['email' => $errorMessage]);
            
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            Log::error('Google OAuth Server Error', [
                'exception' => $e->getMessage(),
                'status_code' => $e->getResponse()->getStatusCode()
            ]);
            
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication service is temporarily unavailable. Please try again later.'
            ]);
            
        } catch (Exception $e) {
            // Log the actual exception with full details
            Log::error('Google OAuth Callback Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'previous' => $e->getPrevious() ? $e->getPrevious()->getMessage() : null
            ]);
            
            // Show detailed error in local development
            if (app()->environment('local') && config('app.debug')) {
                $detailedMessage = 'Google OAuth Error: ' . $e->getMessage() . 
                                 ' in ' . $e->getFile() . ' on line ' . $e->getLine();
                
                return redirect()->route('login')->withErrors([
                    'email' => $detailedMessage
                ]);
            }
            
            // Generic message for production
            return redirect()->route('login')->withErrors([
                'email' => 'Failed to login with Google. Please try again.'
            ]);
        }
    }
}