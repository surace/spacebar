<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 30/07/2018
 * Time: 21:00
 */

namespace App\Security;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var RouterInterface
     */
    private $router;

    function __construct(UserRepository $repository, RouterInterface $router)
    {
        $this->repository = $repository;
        $this->router = $router;
    }


    /**
     * Get the authentication credentials from the request and return them
     *
     * @param Request $request
     * @return mixed Any non-null value
     * @throws \UnexpectedValueException If null is returned
     */
    public function getCredentials(Request $request)
    {
//        $isLoginSubmit = $request->getPathInfo() == '/login' &&  $request->isMethod('POST');
//        if(!$isLoginSubmit)
//            return;
        return [
               'username' => $request->request->get('_username'),
               'password' => $request->request->get('_password'),
           ];
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @throws AuthenticationException
     * @return UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $this->repository
            ->getByUserName($credentials['username']);
    }

    /**
     * Returns true if the credentials are valid.
     *
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $credentials['password'] == $user->getPassword();
    }


    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }

    /**
     * Does the authenticator support the given Request?
     *
     * If this returns false, the authenticator will be skipped.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
       return $request->getPathInfo() == '/login' &&  $request->isMethod('POST');
    }

    /**
     * Called when authentication executed and was successful!
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        $targetPath  = $this->getTargetPath($request->getSession(), $providerKey);
        if(!$targetPath)
            $targetPath = $this->router->generate('app_homepage');
        return new RedirectResponse($targetPath);
    }
}