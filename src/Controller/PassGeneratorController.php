<?php


namespace App\Controller;


use App\Service\PassGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PassGeneratorController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $symbolsNum = (int)$request->get('symbolsNum', 1);
        $allowNumbers = (bool)$request->get('numbers', false);
        $allowUppercase = (bool)$request->get('uppercase', false);
        $allowLowercase = (bool)$request->get('lowercase', false);

        $pass = new PassGenerator($symbolsNum, $allowNumbers, $allowUppercase, $allowLowercase);
        $result = $pass->generatePassword();

        $forRender['title'] = 'Pass generator';
        $forRender['symbolsNum'] = $symbolsNum;
        $forRender['result'] = $result;

        return $this->render('index.html.twig', $forRender);
    }



}