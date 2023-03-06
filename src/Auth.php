<?php 

namespace Core;

use Carbon\Carbon;
use Core\Models\User;
use Core\Models\Session;

class Auth 
{
    private array $error = [];

    public function __construct(private User $user, private Session $session)
    {
    }

    public function login($email, $password, $remeber = false)
    {
        $email    = strtolower($email);
        $user     = $this->user->getAll('id, password', ['where' => ['email' => $email]])[0];
        $password = trim($password);

        if (!$user) {
            $this->error[] = "Email and password combination is incorrect";
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            $this->error[] = "Email and password combination is incorrect";
            return false;
        }

        $sessionData = $this->addSession($user['id']);

        if (!$sessionData) {
            $this->error[] = 'System error: Unable to login';
            return false;
        }

        // Add last login time
        $this->user->update(['id' => $user['id']], ['last_login' => Carbon::now()]);

        return true;
    }

    public function register()
    {

    }

    public function logout($hash)
    {
        if (strlen($hash) != 40) {
            return false;
        }

        return $this->deleteSession($hash);
    }

    protected function addSession($userId)
    {
        global $config;

        $ip = Utility::getIpAddress();
        $user = $this->user->get('*', $userId);

        if (!$user) {
            $this->error[] = 'Invalid Action';
            return false;
        }

        $hash = sha1($config->site->key . microtime());
        $agent = $_SERVER['HTTP_USER_AGENT'];

        $expire = $config->cookie->login['expire'];

        $cookieValue = sha1($hash . $config->site->key);

        // If there is a session with this IP delete it
        if (!empty($this->session->getAll('ip', ['where' => ['ip' => $ip]]))) {
            $this->session->delete(['ip' => $ip]);
        }

        if (!$this->session->create([
            'user_id'      => $userId,
            'hash'         => $hash,
            'expire_date'  => Carbon::createFromTimestamp($config->cookie->login['expire'])->format('Y-m-d H:i:s'),
            'ip'           => $ip,
            'agent'        => $agent,
            'cookie_value' => $cookieValue
        ])) {
            return false;
        }

        $this->addCookie($hash, $expire);

        return true;
    }

    protected function deleteSession($hash)
    {
        global $config;

        $delete = $this->session->delete(['hash' => $hash]);

        $loginCookie = $config->cookie->login['name'];
        $cookiePath = preg_replace('|https?://[^/]+|i', '', $config->site->url . '/');

        setcookie($loginCookie, '', time() - 7000, $cookiePath);

        return (bool) $delete;
    }

    public function isLogged()
    {
        global $config;

        return (isset($_COOKIE[$config->cookie->login['name']]) && $this->checkSession($_COOKIE[$config->cookie->login['name']]));
    }

    public function checkSession($hash)
    {
        global $config;

        $ip = Utility::getIpAddress();

        $result = $this->session->getAll('expire_date, ip, cookie_value', ['where' => ['hash' => $hash]]);

        if (empty($result)) {
            return false;
        }

        $result = $result[0];
        
        $expireDate   = Carbon::parse($result['expire_date']);
        $currentDate  = Carbon::parse('now');
        $dbIp         = $result['ip'];
        $dbCookie     = $result['cookie_value'];
        
        if ($currentDate->greaterThan($expireDate)) {
            $this->session->delete(['ip' => $dbIp]);

            return false;
        }

        // if ($ip != $dbIp) {
        //     return false;
        // }

        if ($dbCookie == sha1($hash . $config->site->key)) {
            return true;
        }

        return false;
    }

    public function addCookie($hash, $expire)
    {
        global $config;

        $cookieName = $config->cookie->login['name'];
        $cookieVal  = trim($hash);
        $cookieExp  = trim($expire);

        // TODO: make hardcoded cookie data configurable
        $cookieOptions = [
            'expires'   =>  $cookieExp,
            'path'      =>  '/',
            'domain'    =>  null,
            'secure'    =>  1,
            'httponly'  =>  1,
            'samesite'  =>  'Lax' // None || Lax  || Strict
        ];

        // Set cookie for the logged user
        return setcookie($cookieName, $cookieVal, $cookieOptions);
    }

    public function currentUserId()
    {
        global $config;

        $hash = isset($_COOKIE[$config->cookie->login['name']]) ? $_COOKIE[$config->cookie->login['name']] : '';

        $result = $this->session->getAll('user_id', ['where' => ['hash' => $hash]]);

        if (empty($result)) {
            return false;
        }

        return $result[0]['user_id'];
    }
}