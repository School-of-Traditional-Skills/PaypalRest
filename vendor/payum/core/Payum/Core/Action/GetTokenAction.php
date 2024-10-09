<?php

namespace Payum\Core\Action;

use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Request\GetToken;
use Payum\Core\Storage\StorageInterface;

class GetTokenAction implements ActionInterface
{
    private StorageInterface $tokenStorage;

    public function __construct(StorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param GetToken $request
     */
    public function execute($request): void
    {
        RequestNotSupportedException::assertSupports($this, $request);

        if (! $token = $this->tokenStorage->find($request->getHash())) {
            throw new LogicException(sprintf('The token %s could not be found', $request->getHash()));
        }

        $request->setToken($token);
    }

    public function supports($request)
    {
        return $request instanceof GetToken;
    }
}
