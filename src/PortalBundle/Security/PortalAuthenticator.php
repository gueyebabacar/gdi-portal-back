<?php

namespace PortalBundle\Security;

use FOS\UserBundle\Security\UserProvider;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class PortalAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
    /**
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function createToken(Request $request, $providerKey)
    {
        $gaiaId = 'BM5265';
        if($request->headers->get('gaiaId') !== null){
            $gaiaId = $request->headers->get('gaiaId');
        }

        if (!$gaiaId) {
            throw new BadCredentialsException('No GaiaID found');
        }

        return new PreAuthenticatedToken(
            'anon.',
            $gaiaId,
            $providerKey
        );
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return PreAuthenticatedToken
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof UserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of EntityUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }

        $gaiaId = $token->getCredentials();

        $user = $userProvider->loadUserByUsername($gaiaId);

        if (!$user) {
            throw new AuthenticationException(
                sprintf('GaiaId "%s" does not exist.', $gaiaId)
            );
        }
        if (!$user->isEnabled()) {
            throw new DisabledException('L\'utilisateur "%s" est désactivé.');
        }
        return new PreAuthenticatedToken(
            $user,
            $gaiaId,
            $providerKey,
            $user->getRoles()
        );
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response("Authentication Failed.", 401);
    }
}