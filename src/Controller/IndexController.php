<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Form\TeamCompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'title' => 'Embed forms with collections',
        ]);
    }

    #[Route('/companies', name: 'app_companies')]
    public function companies(CompanyRepository $companyRepository): Response
    {
        return $this->render('index/companies.html.twig', [
            'title' => 'Companies',
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/company/{id}', name: 'app_company')]
    public function company(Request $request, EntityManagerInterface $entityManager, Company $company): Response
    {
        $form = $this->createForm(TeamCompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach ($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_companies', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/company.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/form-list', name: 'app_form_list')]
    public function formList(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach ($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/form-list.html.twig', [
            'title' => 'Form collection - List format',
            'form' => $form,
        ]);
    }

    #[Route('/form-table', name: 'app_form_table')]
    public function formTable(Request $request, EntityManagerInterface $entityManager): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($company);

            foreach ($company->getTeams() as $team) {
                $team->setCompany($company);
                $entityManager->persist($team);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('index/form-table.html.twig', [
            'title' => 'Form collection - Table format',
            'form' => $form,
        ]);
    }
}
