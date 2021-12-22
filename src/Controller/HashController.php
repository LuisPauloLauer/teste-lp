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
        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

        if(count($hashes) == 0){
            $nBloco = 1;
            //dd('teste1');
        } else {
            //dd('teste2');
            $nBloco = $hashes[count($hashes)-1]->getNAttempts() + 1;
            //dd($nBloco);
        }

        // the argument of consume() is the number of tokens to consume
        // and returns an object of type Limit
        if (false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException();
        } else {
            $data = $request->request->all();
            $textHash = $data['texthash'];
            $dataHash = $this->getHash($textHash);

            $oHash = new Hashes();
            $oHash->setBatch(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $oHash->setNBloco(1);
            $oHash->setInputString($textHash);
            $oHash->setKey($dataHash['key']);
            $oHash->setHash($dataHash['hash']);
            $oHash->setNAttempts($nBloco);

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($oHash);
            dd($doctrine->flush());

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
        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

        if(count($hashes) == 0){
            $nBloco = 1;
            //dd('teste1');
        } else {
            //dd('teste2');
            $nBloco = $hashes[count($hashes)-1]->getNAttempts() + 1;
            //dd($nBloco);
        }

        // the argument of consume() is the number of tokens to consume
        // and returns an object of type Limit
        if (false === $limiter->consume(1)->isAccepted()) {
            //throw new TooManyRequestsHttpException();
            return $this->json(['error' => 'Too ManyAttempts'], 429);
        } else {
            $textHash = $text;
            $dataHash = $this->getHash($textHash);

            $oHash = new Hashes();
            $oHash->setBatch(new \DateTime('now', new \DateTimeZone('America/Sao_Paulo')));
            $oHash->setNBloco(1);
            $oHash->setInputString($textHash);
            $oHash->setKey($dataHash['key']);
            $oHash->setHash($dataHash['hash']);
            $oHash->setNAttempts($nBloco);

            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($oHash);
            $doctrine->flush();

            $hashes = $this->getDoctrine()->getRepository(Hashes::class)->findAll();

            return $this->json(['listHash' => $hashes]);

        }
    }
}
