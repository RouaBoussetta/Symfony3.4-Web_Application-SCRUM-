<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26/03/2018
 * Time: 02:06
 */

namespace UserBundle\Redirection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    private $router;

    /**
     * AfterLoginRedirection constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request        $request
     *
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $roles = $token->getRoles();

        $rolesTab = array_map(function ($role) {
            return $role->getRole();
        }, $roles);


            if (in_array('ROLE_MASTER', $rolesTab, true)) {
                $redirection = new RedirectResponse($this->router->generate('Master_home'));
            }
            else {
                if (in_array('ROLE_DEVELOPER', $rolesTab, true)) {
                    $redirection = new RedirectResponse($this->router->generate('Developer_home'));
                }
                else {
                    if (in_array('ROLE_PRODUCT_OWNER', $rolesTab, true)) {
                        $redirection = new RedirectResponse($this->router->generate('ProductOwner_home'));
                    }
                    else{
                        $redirection = new RedirectResponse($this->router->generate('DashAdmin'));
                    }

            }}
        return $redirection;
    }

}