<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LanguageFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Initialize UserModel to check for user preferences
        $userModel = new UserModel();
        $userId = session()->get('user_id'); // Adjust according to how you store the user ID in the session

        // Get the default language from settings or use 'en' as fallback
        $preferredLanguage = get_setting('default_language', 'en'); // Ensure default is always 'en'

        // Check if the user is logged in
        if ($userId) {
            // Fetch the user by ID
            $user = $userModel->find($userId);

            // If user has a preferred language, use it
            if (!empty($user['lang'])) {
                $preferredLanguage = $user['lang'];
            }
        } else {
            // If user is not logged in, check if the session has a language set
            if (session()->has('lang')) {
                $preferredLanguage = session()->get('lang');
            }
        }

        // Ensure the language is not null or invalid
        if (empty($preferredLanguage)) {
            $preferredLanguage = 'en'; // Fallback to 'en' if no valid language is set
        }

        // Set the locale to the preferred language
        service('request')->setLocale($preferredLanguage);
    }


    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action required after response for language filter
    }
}
