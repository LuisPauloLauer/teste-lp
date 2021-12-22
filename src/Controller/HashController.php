<?php

namespace App\Controller;

use App\Entity\Hashes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

class HashController extends AbstractController
{
    /**
     * @param $textHash
     * @return array
     */
    public function getHash($textHash) : array
    {
        $key = substr(md5(uniqid(mt_Rand(), true)), 0, 8);
        $hash = '0000'.md5( $textHash.$key );

        return array(
            'key'  => $key,
            'hash' => $hash
        );
    }

    /**
     * @param $request
     */
    public function startSesion(Request $request)
    {
        session_start();
        if (!isset($_SESSION['userSession'])) {
            $_SESSION['userSession'] =  array(
                'ip' => $request->getClientIp(),
                'nBloco' => 1,
                'nAttempts' => 1
            );
        } else {
            $_SESSION['userSession']['nBloco'] ++;
            $_SESSION['userSession']['nAttempts'] ++;
        }
    }

    public function destroySession()
    {
        session_start();
        unset($_SESSION['userSession']);
    }

    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

        return $this->render('home.html.twig', [
            'listHash' => $hashes
        ]);
    }

    /**
     * @Route("/dohash", name="app_dohash", methods="POST")
     */
    public function generateHash(Request $request, RateLimiterFactory $anonymousApiLimiter): Response
    {
        $this->startSesion($request);
        $limiter = $anonymousApiLimiter->create($request->getClientIp());

        // the argument of consume() is the number of tokens to consume
        // and returns an object of type Limit
        if (false === $limiter->consume(1)->isAccepted()) {
            $_SESSION['userSession']['nBloco'] = 0;
            throw new TooManyRequestsHttpException();
        } else {
            $data = $request->request->all();
            $textHash = $data['texthash'];
            $dataHash = $this->getHash($textHash);

            $oHash = new Hashes();
            $oHash->setBatch(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $oHash->setNBloco($_SESSION['userSession']['nBloco']);
            $oHash->setInputString($textHash);
            $oHash->setKey($dataHash['key']);
            $oHash->setHash($dataHash['hash']);
            $oHash->setNAttempts($_SESSION['userSession']['nAttempts']);

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($oHash);
            $doctrine->flush();

            $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

            return $this->render('home.html.twig', [
                'listHash' => $hashes
            ]);
        }
    }

    /**
     * @Route("api/dohash/{text}", name="api_dohash", methods="get")
     */
    public function generatehashByapi($text, Request $request, RateLimiterFactory $anonymousApiLimiter): Response
    {
        $this->startSesion($request);
        $limiter = $anonymousApiLimiter->create($request->getClientIp());

        // the argument of consume() is the number of tokens to consume
        // and returns an object of type Limit
        if (false === $limiter->consume(1)->isAccepted()) {
            $_SESSION['userSession']['nBloco'] = 0;
            return $this->json(['error' => 'Too ManyAttempts'], 429);
        } else {
            $textHash = $text;
            $dataHash = $this->getHash($textHash);

            $oHash = new Hashes();
            $oHash->setBatch(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $oHash->setNBloco($_SESSION['userSession']['nBloco']);
            $oHash->setInputString($textHash);
            $oHash->setKey($dataHash['key']);
            $oHash->setHash($dataHash['hash']);
            $oHash->setNAttempts($_SESSION['userSession']['nAttempts']);

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($oHash);
            $doctrine->flush();

            $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

            return $this->json(['listHash' => $hashes]);

        }
    }
}
