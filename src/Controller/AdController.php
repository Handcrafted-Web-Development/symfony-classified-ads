<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdController extends AbstractController
{
    #[Route('/admin/ad', name: 'app_ad')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $ad = new Ad();
        $ad->setTitle('iPhone X en parfait état, à vendre à un bon prix !');
        $ad->setDescription('Un iPhone X, comme neuf, avec une capacité de 64 Go, aucune rayure ni problème. Livré avec un étui de protection en cuir.');
        $ad->setPrice(350);
        $ad->setYear(2017);
        $ad->setSize(6);
        $ad->setBrand('Apple');
        $ad->setDueDate(new \DateTimeImmutable('tomorrow'));
        $ad->setGuarantee('Garantie 6 mois');

        $form = $this->createFormBuilder($ad)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('price', IntegerType::class)
            ->add('year', IntegerType::class)
            ->add('size', IntegerType::class)
            ->add('brand', TextType::class)
            ->add('due_date', DateType::class, ['widget' => 'single_text'])
            ->add('guarantee', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Ad'])
            ->getForm();

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

        return $this->render('ad/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ad/{id}', name: 'ad_show')]
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $ad = $entityManager->getRepository(Ad::class)->find($id);

        if (!$ad) {
            throw $this->createNotFoundException(
                'No classified ad found for id ' . $id
            );
        }

        return new Response('Check out this great product: ' . $ad->getTitle());
    }
}
