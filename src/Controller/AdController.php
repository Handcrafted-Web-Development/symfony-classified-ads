<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route(path: '/{_locale}', requirements: ['_locale' => 'en|fr'], defaults: ['_locale' => 'en'])]
class AdController extends AbstractController
{
    #[Route('/admin/ad/create', name: 'ad_new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $ad = new Ad();
//        $ad->setTitle('iPhone X en parfait état, à vendre à un bon prix !');
//        $ad->setDescription('Un iPhone X, comme neuf, avec une capacité de 64 Go, aucune rayure ni problème. Livré avec un étui de protection en cuir.');
//        $ad->setPrice(350);
//        $ad->setYear(2017);
//        $ad->setSize(6);
//        $ad->setBrand('Apple');
//        $ad->setDueDate(new \DateTimeImmutable('tomorrow'));
//        $ad->setGuarantee('Garantie 6 mois');

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // $ad = $form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Success!'
            );
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/ad', name: 'ad_index')]
    #[Route('')]
    public function index(EntityManagerInterface $entityManager, Request $request, AdRepository $repository): Response
    {
        $page = $request->query->get('page', 1);
        $perPage = 6;
        $paginator = $repository->findPaginated($page, $perPage);
        $ads = $paginator->getQuery()->getResult();
        $totalAds = count($paginator);
        $totalPages = ceil($totalAds / $perPage);

        return $this->render('ad/index.html.twig', ['ads' => $ads, 'page' => $page, 'totalPages' => $totalPages]);
    }

    #[Route(path: '/ad/{id}', name: 'ad_show')]
    public function show(Ad $ad): Response
    {
        return $this->render('ad/show.html.twig', ['ad' => $ad]);
    }
}

